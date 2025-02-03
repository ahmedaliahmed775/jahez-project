<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // بدء الجلسة فقط إذا لم تكن هناك جلسة نشطة
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>موقع حجز الفنادق</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"  href="css/mystyle.css">

    <script src="js/js.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script>
        function confirmLogout() {
            return confirm("هل أنت متأكد أنك تريد تسجيل الخروج؟");
        }
    </script>
</head>
<body>

    <section class="head">
        <div class="header-content">
            <div class="logo">
                <img src="image/logo.png" alt="شعار الموقع">
            </div>
            <div class="address">
                <span class="location">صنعاء، اليمن.</span>
            </div>
            <div class="register-button">
                <?php
                // معالجة تسجيل الخروج
                if (isset($_POST['logout'])) {
                    session_destroy();
                    header("Location: index.php"); // إعادة توجيه المستخدم إلى الصفحة الرئيسية
                    exit();
                }

                // التحقق من تسجيل الدخول
                if (isset($_SESSION['username'])) {
                    echo "<span>مرحبًا، " . htmlspecialchars($_SESSION['username']) . "!</span>";
                    echo '<form method="POST" style="display:inline;" onsubmit="return confirmLogout();">';
                    echo '<button type="submit" name="logout" class="btn">تسجيل الخروج</button>';
                    echo '</form>';
                } else {
                    echo '<a href="login.php" class="btn">تسجيل</a>';
                }
                ?>
            </div>
        </div>
    </section>



</body>
</html>