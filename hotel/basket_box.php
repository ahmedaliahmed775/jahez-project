<?php
// استدعاء ملف الاتصال
include 'config.php';

// تأكد من أن لديك user_id من الجلسة
if (!isset($_SESSION['user_id'])) {
    require_once('required.php');
    exit(); // إنهاء السكربت بعد عرض الرسالة
}

$user_id = $_SESSION['user_id'];

// استعلام لاسترجاع جميع الحجوزات المرتبطة بالمستخدم
$stmt = mysqli_prepare($conn, "
    SELECT b.id, b.check_in, b.check_out, b.number_of_guests, h.name, h.image, b.status, h.price 
    FROM bookings b 
    JOIN hotels h ON b.hotel_id = h.id 
    WHERE b.user_id = ?
");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// التحقق من وجود حجوزات
if (mysqli_num_rows($result) == 0) {
    require_once('basket_no.php');
    exit(); // إنهاء السكربت بعد عرض صفحة basket_no.php
}
?>

<section class="bookings">
    <h2>حجوزاتك</h2>

    <?php while ($booking = mysqli_fetch_assoc($result)): ?>
        <div class="booking-item" id="booking-<?php echo $booking['id']; ?>">
            <div class="booking-details">
                <h3><?php echo htmlspecialchars($booking['name']); ?></h3>
                <p>تاريخ الحجز: <?php echo htmlspecialchars($booking['check_in']); ?></p>
                <p>تاريخ المغادرة: <?php echo htmlspecialchars($booking['check_out']); ?></p>
                <p>عدد النزلاء: <?php echo htmlspecialchars($booking['number_of_guests']); ?></p>
                <p>سعر الليلة: <?php echo htmlspecialchars($booking['price']); ?> ريال</p>
                
                <?php
                // حساب عدد الليالي
                $check_in = new DateTime($booking['check_in']);
                $check_out = new DateTime($booking['check_out']);
                $nights = $check_out->diff($check_in)->days;

                // حساب السعر الإجمالي
                $total_price = $booking['price'] * $nights;
                ?>
                
                <p>عدد الليالي: <?php echo $nights; ?> ليالي</p>
                <p>السعر الإجمالي: <?php echo htmlspecialchars($total_price); ?> ريال</p>
                
                <?php
                // تحويل حالة الحجز إلى نص عربي
                $status = htmlspecialchars($booking['status']);
                switch ($status) {
                    case 'pending':
                        $statusText = 'قيد الانتظار';
                        break;
                    case 'confirmed':
                        $statusText = 'تم التأكيد';
                        break;
                    case 'canceled':
                        $statusText = 'ملغى';
                        break;
                    default:
                        $statusText = 'حالة غير معروفة';
                }
                ?>
                <p>حالة الحجز: <strong><?php echo $statusText; ?></strong></p>
                <div class="button-container">
                    <button class="button cancel-button" onclick="cancelBooking(<?php echo $booking['id']; ?>)">إلغاء</button>
                    <?php if ($booking['status'] === 'pending'): ?>
                        <button class="button confirm-button" onclick="askForConfirmation(<?php echo $booking['id']; ?>, {
                            hotelName: '<?php echo addslashes(htmlspecialchars($booking['name'])); ?>',
                            checkIn: '<?php echo htmlspecialchars($booking['check_in']); ?>',
                            checkOut: '<?php echo htmlspecialchars($booking['check_out']); ?>',
                            numberOfGuests: <?php echo $booking['number_of_guests']; ?>,
                            totalPrice: <?php echo $total_price; ?>
                        })">تأكيد</button>
                    <?php endif; ?>
                </div>
            </div>
            <img src="<?php echo htmlspecialchars($booking['image']); ?>" alt="<?php echo htmlspecialchars($booking['name']); ?>">
        </div>
    <?php endwhile; ?>
</section>

<script>
    function cancelBooking(bookingId) {
        if (confirm("هل أنت متأكد من إلغاء هذا الحجز؟")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "cancel_booking.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("تم إلغاء الحجز بنجاح.");
                        document.getElementById("booking-" + bookingId).remove();
                    } else {
                        alert("خطأ: " + response.message);
                    }
                } else {
                    alert("حدث خطأ في الاتصال بالسيرفر.");
                }
            };
            xhr.send("booking_id=" + bookingId);
        }
    }

    function askForConfirmation(bookingId, bookingDetails) {
        if (confirm("هل أنت متأكد من أنك تريد تأكيد الحجز؟")) {
            confirmBooking(bookingId, bookingDetails);
        }
    }

    function confirmBooking(bookingId, bookingDetails) {
        // عرض نموذج الدفع مع تفاصيل الحجز
        const paymentForm = `
            <div id="paymentModal" style="display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
                <div style="background: white; margin: auto; padding: 20px; width: 400px; border-radius: 8px; position: relative; top: 100px;">
                    <h3>تفاصيل الحجز</h3>
                    <p><strong>اسم الفندق:</strong> ${bookingDetails.hotelName}</p>
                    <p><strong>تاريخ الحجز:</strong> ${bookingDetails.checkIn}</p>
                    <p><strong>تاريخ المغادرة:</strong> ${bookingDetails.checkOut}</p>
                    <p><strong>عدد النزلاء:</strong> ${bookingDetails.numberOfGuests}</p>
                    <p><strong>السعر الإجمالي:</strong> ${bookingDetails.totalPrice} ريال</p>

                    <label for="paymentCode">أدخل كود الشراء:</label>
                    <input type="text" id="paymentCode" placeholder="أدخل كود الشراء" />
                    
                    <br><br>
                    <button onclick="submitPayment(${bookingId})">تأكيد الدفع</button>
                    <button onclick="closePaymentModal()">إلغاء</button>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', paymentForm);
    }

    function closePaymentModal() {
        const modal = document.getElementById("paymentModal");
        if (modal) {
            modal.remove();
        }
    }

    function submitPayment(bookingId) {
        const paymentCode = document.getElementById("paymentCode").value;

        if (!paymentCode) {
            alert("يرجى إدخال كود الشراء.");
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "confirm_booking.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("تم تأكيد الدفع بنجاح.");
                    closePaymentModal();
                } else {
                    alert("خطأ: " + response.message);
                }
            } else {
                alert("حدث خطأ في الاتصال بالسيرفر.");
            }
        };
        xhr.send("booking_id=" + bookingId + "&payment_code=" + encodeURIComponent(paymentCode));
    }
</script>
<?php
require_once('footer.php');
?>