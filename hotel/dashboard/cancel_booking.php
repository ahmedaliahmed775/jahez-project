<?php
session_start();
require_once('../config.php');

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "يجب تسجيل الدخول أولاً";
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    
    try {
        // التحقق من وجود الحجز
        $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("الحجز غير موجود");
        }
        
        // حذف الحجز
        $delete_stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
        $delete_stmt->bind_param("i", $booking_id);
        
        if ($delete_stmt->execute()) {
            $_SESSION['message'] = "تم حذف الحجز بنجاح";
        } else {
            throw new Exception("حدث خطأ أثناء الحذف");
        }
        
    } catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = "خطأ في قاعدة البيانات: " . $e->getMessage();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    } finally {
        $stmt->close();
        if (isset($delete_stmt)) $delete_stmt->close();
        header("Location: booking.php");
        exit();
    }
} else {
    $_SESSION['error'] = "طلب غير صحيح";
    header("Location: booking.php");
    exit();
}