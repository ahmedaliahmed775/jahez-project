<?php
session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('يجب تسجيل الدخول أولاً'); window.location.href='login.php';</script>";
    exit();
}

require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $user_id = $_POST['id'];
        
        try {
            $conn->begin_transaction();

            // التحقق من الحجوزات
            $check_stmt = $conn->prepare("SELECT COUNT(*) AS booking_count FROM bookings WHERE user_id = ?");
            $check_stmt->bind_param("i", $user_id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['booking_count'] > 0) {
                throw new Exception("لا يمكن حذف المستخدم لوجود حجوزات مرتبطة به");
            }

            // عملية الحذف
            $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $delete_stmt->bind_param("i", $user_id);
            $delete_stmt->execute();

            if ($delete_stmt->affected_rows === 0) {
                throw new Exception("لم يتم العثور على المستخدم");
            }

            $conn->commit();
            echo "<script>
                alert('تم حذف المستخدم بنجاح');
                window.location.href = 'users.php';
            </script>";

        } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            $errorMessage = (strpos($e->getMessage(), 'foreign key constraint') !== false)
                ? "لا يمكن حذف المستخدم لوجود بيانات مرتبطة (حجوزات)"
                : "خطأ في قاعدة البيانات: " . $e->getMessage();
            
            echo "<script>
                alert('$errorMessage');
                window.history.back();
            </script>";

        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>
                alert('{$e->getMessage()}');
                window.history.back();
            </script>";
        } finally {
            $check_stmt->close();
            if (isset($delete_stmt)) $delete_stmt->close();
            $conn->close();
            exit(); // إيقاف التنفيذ بعد إرسال الجافاسكريبت
        }
        
    } else {
        echo "<script>
            alert('لم يتم تحديد مستخدم للحذف');
            window.location.href = 'users.php';
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('طريقة الطلب غير مسموحة');
        window.location.href = 'users.php';
    </script>";
    exit();
}