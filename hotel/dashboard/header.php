<?php


// التحقق من صحة الجلسة
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// الهروب الآمن للبيانات
$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الحجوزات الفندقية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
   
</head>
<body>
    <div class="main-content">
        <div class="header">
            <h2>مرحبًا، <?php echo $username; ?></h2>
            <div class="user-info">
                <form method="POST" action="logout.php">
                    <button type="submit" class="logout-btn" onclick="return confirm('هل تريد تسجيل الخروج؟')">
                        <i class="fas fa-sign-out-alt fa-2x"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- بقية المحتوى -->
</body>
</html>

<style>
        /* تنسيقات عامة */

       

        /* المحتوى الرئيسي */
        .main-content {
            margin-right: 280px;
            padding: 30px;
            transition: 0.3s;
        }

        /* الهيدر */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            background: rgba(255,255,255,0.95);
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .header h2 {
            color: #1a237e;
            font-size: 26px;
            font-weight: 700;
        }

        .logout-btn {
            color: #1a237e;
            transition: 0.3s;
            padding: 10px;
            border-radius: 50%;
        }

        .logout-btn:hover {
            background: #f0f4f8;
            transform: rotate(-15deg);
        }

        /* تأثيرات إضافية */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .main-content > * {
            animation: fadeIn 0.6s ease-out;
        }
</style>