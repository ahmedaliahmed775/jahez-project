<?php
session_start();
require_once('../config.php');

// التحقق من صلاحيات المستخدم
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['error'] = "غير مصرح بالوصول";
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotel_id = (int)$_POST['hotel_id'];
    
    try {
        // التحقق من وجود حجوزات مرتبطة
        $check_booking = $conn->prepare("SELECT COUNT(*) AS total FROM bookings WHERE hotel_id = ?");
        $check_booking->bind_param("i", $hotel_id);
        $check_booking->execute();
        $result = $check_booking->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['total'] > 0) {
            throw new Exception("لا يمكن الحذف لوجود حجوزات مرتبطة");
        }
        
        // حذف بيانات الفندق
        $delete_stmt = $conn->prepare("DELETE FROM hotels WHERE id = ?");
        $delete_stmt->bind_param("i", $hotel_id);
        
        if ($delete_stmt->execute()) {
            $_SESSION['message'] = "تم حذف الفندق بنجاح";
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء الحذف";
        }
        
    } catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = "خطأ في قاعدة البيانات: " . $e->getMessage();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    } finally {
        $check_booking->close();
        if (isset($delete_stmt)) $delete_stmt->close();
        header("Location: hotels.php");
        exit();
    }
} else {
    $_SESSION['error'] = "طلب غير صحيح";
    header("Location: hotels.php");
    exit();
}