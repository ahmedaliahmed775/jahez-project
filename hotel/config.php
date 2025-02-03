<?php
$host = 'localhost'; // تأكد من استخدام المنفذ الصحيح
$dbname = 'jahez';
$username = 'root';
$password = ''; // إذا كان لديك كلمة مرور، يرجى إضافتها هنا

// إنشاء اتصال بقاعدة البيانات
$conn = mysqli_connect($host, $username, $password, $dbname);

// التحقق من الاتصال
if (!$conn) {
    die("خطأ في الاتصال: " . mysqli_connect_error());
}
?>