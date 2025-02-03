<?php
session_start(); // بدء الجلسة
include 'config.php';

// تأكد من أن لديك user_id من الجلسة
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'يرجى تسجيل الدخول.']);
    exit();
}

// معالجة طلب تأكيد الحجز
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // استعلام لتحديث حالة الحجز
    $stmt = mysqli_prepare($conn, "UPDATE bookings SET status = 'confirmed' WHERE id = ?");
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