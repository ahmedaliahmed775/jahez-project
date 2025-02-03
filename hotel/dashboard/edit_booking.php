<?php
session_start();
require_once('../config.php');

// تحقق من وجود booking_id في الرابط
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    $query = "SELECT * FROM bookings WHERE id = $booking_id";
    $result = mysqli_query($conn, $query);

    // تحقق من وجود بيانات الحجز
    if ($result && mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        die("الحجز غير موجود.");
    }
} else {
    die("معرف الحجز غير موجود في الرابط.");
}

// معالجة طلب التعديل
if (isset($_POST['update_booking'])) {
    $booking_id = $_POST['booking_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $number_of_guests = $_POST['number_of_guests'];
    $price = $_POST['price'];
    $status = $_POST['status']; // حالة الحجز

    // تحقق من صحة البيانات قبل تنفيذ الاستعلام
    if (!empty($booking_id) && !empty($check_in) && !empty($check_out) && !empty($number_of_guests) && !empty($price) && !empty($status)) {
        $query = "UPDATE bookings SET check_in = '$check_in', check_out = '$check_out', number_of_guests = $number_of_guests, price = $price, status = '$status' WHERE id = $booking_id";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('تم تحديث البيانات بنجاح');</script>";
            echo "<script>window.location.href = 'booking.php';</script>";
            exit();
        } else {
            die("حدث خطأ أثناء تحديث الحجز: " . mysqli_error($conn));
        }
    } else {
        die("البيانات المطلوبة غير مكتملة.");
    }
}

include('sidebar.php');  
include('header.php'); 
?>

<body class="booking-edit-page">
    <div class="main-content">
        <div class="form-container">
            <h1>تعديل الحجز</h1>
            <form method="post" action="">
                <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
                <div class="form-group">
                    <label for="check_in">تاريخ الوصول</label>
                    <input type="date" name="check_in" value="<?= htmlspecialchars($booking['check_in']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="check_out">تاريخ المغادرة</label>
                    <input type="date" name="check_out" value="<?= htmlspecialchars($booking['check_out']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="number_of_guests">عدد الضيوف</label>
                    <input type="number" name="number_of_guests" value="<?= htmlspecialchars($booking['number_of_guests']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">السعر</label>
                    <input type="number" name="price" value="<?= htmlspecialchars($booking['price']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">حالة الحجز</label>
                    <select name="status" required>
                        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>في الانتظار (Pending)</option>
                        <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>تم التأكيد (Confirmed)</option>
                        <option value="canceled" <?= $booking['status'] == 'canceled' ? 'selected' : '' ?>>ملغى (Canceled)</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="update_booking">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>