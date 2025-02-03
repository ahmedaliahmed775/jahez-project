<?php
require_once('header.php');
require_once('nav.php');

// استدعاء ملف الاتصال
include 'config.php';

// استعلام لاسترجاع بيانات الفندق
$stmt = mysqli_prepare($conn, "SELECT name, location, rating, description, price, image, city FROM hotels WHERE id = ?");
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; 
mysqli_stmt_bind_param($stmt, 'i', $id); // ربط المعاملات
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$hotel = mysqli_fetch_assoc($result);

// تعيين المتغيرات أو القيم الافتراضية
$hotelName = $hotel['name'] ?? 'اسم الفندق غير متوفر';
$hotelLocation = $hotel['location'] ?? 'الموقع غير متوفر';
$hotelRating = $hotel['rating'] ?? 'غير متوفر';
$hotelDescription = $hotel['description'] ?? 'الوصف غير متوفر';
$hotelPrice = $hotel['price'] ?? 'السعر غير متوفر'; // السعر
$hotelImage = $hotel['image'] ?? 'default_image.jpg'; 
$hotelcity = $hotel['city'] ?? 'h';

// تحويل المدينة
$cityMapping = [
    'sa' => 'صنعاء',
    'ta' => 'تعز',
    'ad' => 'عدن'
];

if (array_key_exists($hotelcity, $cityMapping)) {
    $hotelcity = $cityMapping[$hotelcity];
} else {
    $hotelcity = 'مدينة غير معروفة';
}

// معالجة البيانات عند إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // استلام البيانات من النموذج
    $user_id = $_SESSION['user_id'] ?? 0; // استخدم user_id من الجلسة
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $number_of_guests = $_POST['guests'];
    $nights = $_POST['nights'];

    // تحقق من تسجيل الدخول
    if ($user_id <= 0) {
        echo "<script>alert('يرجى تسجيل الدخول لحجز الإقامة.');</script>";
    } else {
        // حساب السعر الإجمالي
        $total_price = $hotelPrice * $nights;
        $_SESSION['total_price'] = $total_price;

        $stmt = mysqli_prepare($conn, "INSERT INTO bookings (user_id, hotel_id, check_in, check_out, number_of_guests, price, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
        mysqli_stmt_bind_param($stmt, 'iisssd', $user_id, $id, $check_in, $check_out, $number_of_guests, $total_price);

        if (mysqli_stmt_execute($stmt)) {
            $booking_id = mysqli_insert_id($conn); // الحصول على معرف الحجز
            echo "<script>
                    if (confirm('تم الحجز بنجاح! هل تريد الانتقال إلى السلة؟')) {
                        window.location.href = 'basket.php?booking_id={$booking_id}'; // إضافة معرف الحجز إلى رابط السلة
                    } else {
                        window.location.href = 'javascript:history.back()';
                    }
                  </script>";
        } else {
            echo "<script>alert('حدث خطأ أثناء الحجز: " . mysqli_error($conn) . "');</script>";
        }

        // اغلق الاتصال
        mysqli_stmt_close($stmt);
    }
}

// إغلاق الاتصال بعد الانتهاء من العمليات
mysqli_close($conn);
?>



<br>
<div class="hotel-details-page"> <!-- إضافة فئة خاصة للصفحة -->
    <div class="container">
        <div class="hotel-image">
            <img src="<?php echo htmlspecialchars($hotelImage); ?>" alt="<?php echo htmlspecialchars($hotelName); ?>">
        </div>
        <div class="hotel-details">
            <h2><?php echo htmlspecialchars($hotelName); ?></h2>
            <p><strong>المدينة:</strong> <?php echo htmlspecialchars($hotelcity); ?></p>
            <p><strong>الموقع:</strong> <?php echo htmlspecialchars($hotelLocation); ?></p>
            <p><strong>الوصف:</strong> <?php echo htmlspecialchars($hotelDescription); ?></p>
            <p class="rating"><strong>التقييم:</strong> ⭐⭐⭐⭐⭐ (<?php echo htmlspecialchars($hotelRating); ?>/5)</p>
            <p class="night-price"><strong>سعر الليلة:</strong> <?php echo htmlspecialchars($hotelPrice); ?> ريال</p>
        </div>

        <div class="reservation-form">
            <h3>احجز إقامتك</h3>
            <form id="reservationForm" method="POST" action="">
                <label for="checkin">تاريخ الوصول:</label>
                <input type="date" id="checkin" name="checkin" required>

                <label for="checkout">تاريخ المغادرة:</label>
                <input type="date" id="checkout" name="checkout" required>

                <label for="nights">عدد الليالي:</label>
                <select id="nights" name="nights" required>
                    <option value="1">ليلة واحدة</option>
                    <option value="2">ليلتين</option>
                    <option value="3">3 ليالي</option>
                    <option value="4">4 ليالي</option>
                    <option value="5">5 ليالي</option>
                </select>

                <label for="guests">عدد الأشخاص:</label>
                <select id="guests" name="guests" required>
                    <option value="1">شخص واحد</option>
                    <option value="2">شخصان</option>
                    <option value="3">3 أشخاص</option>
                    <option value="4">4 أشخاص</option>
                </select>
                
                <button type="submit"> اضافه الى السله</button>
            </form>
        </div>
        
        <div class="button-group" style="text-align: center; margin-top: 20px;">
            <a href="javascript:history.back()" class="btn-return">عودة</a>
        </div>
    </div>
</div>
<br>

<?php
require_once('footer.php');
?>