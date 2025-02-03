<?php
session_start(); // بدء الجلسة
include 'config.php'; // استدعاء ملف الاتصال

// تأكد من أن لديك user_id من الجلسة
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'لم يتم تسجيل الدخول.']);
    exit();
}

$user_id = $_SESSION['user_id'];

// معالجة طلب إلغاء الحجز
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // استعلام للتحقق من الحجز
    $stmt = mysqli_prepare($conn, "SELECT id FROM bookings WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $booking_id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // تحقق من وجود الحجز
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);

        // استعلام لحذف الحجز
        $stmt = mysqli_prepare($conn, "DELETE FROM bookings WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $booking_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'هذا الحجز غير موجود أو لا يخصك.']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit(); // إنهاء السكربت بعد المعالجة
} else {
    echo json_encode(['success' => false, 'message' => 'طلب غير صحيح.']);
}