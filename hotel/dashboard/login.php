<?php
session_start();

$host = 'localhost';
$dbname = 'jahez';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("خطأ في الاتصال: " . mysqli_connect_error());
}

$error = '';
$success = '';

// معالجة تسجيل الخروج
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// معالجة تسجيل الدخول
if (isset($_POST['send'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);   
    $pass = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT id, u_name, u_password FROM users WHERE u_email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $u_name, $hashed_password);
        mysqli_stmt_fetch($stmt);
        
        if (password_verify($pass, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $u_name;
            $success = "تم تسجيل الدخول بنجاح!";
            header("Refresh: 2; URL=index.php");
        } else {
            $error = "كلمة المرور غير صحيحة";
        }
    } else {
        $error = "البريد الإلكتروني غير مسجل";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - فندقي</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a237e, #0d47a1);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease-out;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #1a237e;
            font-size: 28px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #1a237e;
            font-weight: 500;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #1a237e;
            font-size: 18px;
        }

        input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #1a237e;
            box-shadow: 0 0 8px rgba(26, 35, 126, 0.2);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(45deg, #1a237e, #0d47a1);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-success {
            background: #e8f5e9;
            color: #4CAF50;
            border: 1px solid #c8e6c9;
        }

        .alert-error {
            background: #ffebee;
            color: #d32f2f;
            border: 1px solid #ffcdd2;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #1a237e;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .links a:hover {
            color: #0d47a1;
            text-decoration: underline;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 25px;
            }

            input {
                padding: 10px 12px 10px 40px;
                font-size: 14px;
            }

            button {
                padding: 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>فندقي</h1>
        </div>

        <?php if (isset($_SESSION['username'])): ?>
            <div class="alert alert-success">
                مرحبًا، <?= htmlspecialchars($_SESSION['username']) ?>!
                <form method="POST" style="margin-top: 15px;">
                    <button type="submit" name="logout" class="btn">
                        <i class="fas fa-sign-out-alt"></i>
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" 
                               name="email" 
                               required
                               placeholder="example@domain.com"
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               name="password" 
                               required
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" name="send">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل دخول
                </button>
            </form>


        <?php endif; ?>
    </div>

    <script>
        function confirmLogout() {
            return confirm('هل أنت متأكد من تسجيل الخروج؟');
        }
    </script>
</body>
</html>