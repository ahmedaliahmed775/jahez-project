<?php
session_start(); // بدء الجلسة
require_once('header.php');
require_once('nav.php');

// استدعاء ملف الاتصال
include 'config.php';

// تأكد من أن لديك user_id من الجلسة
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // استخدم user_id من الجلسة

// معالجة طلب إلغاء الحجز
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // استعلام لحذف الحجز
    $stmt = mysqli_prepare($conn, "DELETE FROM bookings WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $booking_id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit(); // إنهاء السكربت بعد المعالجة
}

// معالجة عملية تأكيد الحجز
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking_id'])) {
    $confirm_booking_id = $_POST['confirm_booking_id'];

    $stmt = mysqli_prepare($conn, "UPDATE bookings SET status = 'confirmed' WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $confirm_booking_id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit(); // إنهاء السكربت بعد المعالجة
}

// استعلام لاسترجاع جميع الحجوزات المرتبطة بالمستخدم
$stmt = mysqli_prepare($conn, "
    SELECT b.id, b.check_in, b.check_out, b.number_of_guests, h.name, h.image, b.status 
    FROM bookings b 
    JOIN hotels h ON b.hotel_id = h.id 
    WHERE b.user_id = ?
");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<section class="bookings">
    <h2>حجوزاتك</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($booking = mysqli_fetch_assoc($result)): ?>
            <div class="booking-item" id="booking-<?php echo $booking['id']; ?>">
                <div class="booking-details">
                    <h3><?php echo htmlspecialchars($booking['name']); ?></h3>
                    <p>تاريخ الحجز: <?php echo htmlspecialchars($booking['check_in']); ?></p>
                    <p>تاريخ المغادرة: <?php echo htmlspecialchars($booking['check_out']); ?></p>
                    <p>عدد النزلاء: <?php echo htmlspecialchars($booking['number_of_guests']); ?></p>
                    <p>السعر: <?php echo htmlspecialchars($total_price); ?></p>

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
                            <button class="button confirm-button" onclick="confirmBooking(<?php echo $booking['id']; ?>)">تأكيد</button>
                        <?php endif; ?>
                    </div>
                </div>
                <img src="<?php echo htmlspecialchars($booking['image']); ?>" alt="<?php echo htmlspecialchars($booking['name']); ?>">
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>لا توجد حجوزات.</p>
    <?php endif; ?>
</section>

<script>
    function confirmBooking(bookingId) {
        if (confirm("هل أنت متأكد من تأكيد هذا الحجز؟")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // إرسال الطلب إلى نفس الصفحة
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("تم تأكيد الحجز بنجاح.");
                        location.reload(); // إعادة تحميل الصفحة
                    } else {
                        alert("فشل تأكيد الحجز: " + response.message);
                    }
                }
            };
            xhr.send("confirm_booking_id=" + bookingId);
        }
    }

    function cancelBooking(bookingId) {
        if (confirm("هل أنت متأكد من إلغاء هذا الحجز؟")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // إرسال الطلب إلى نفس الصفحة
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("تم إلغاء الحجز بنجاح.");
                        document.getElementById("booking-" + bookingId).remove(); // حذف العنصر من الصفحة
                    } else {
                        alert("فشل إلغاء الحجز: " + response.message);
                    }
                }
            };
            xhr.send("booking_id=" + bookingId);
        }
    }
</script>

<?php
require_once('footer.php');
?>