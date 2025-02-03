<?php
session_start();

require_once('header.php');
require_once('nav.php');

$host = 'localhost';
$dbname = 'jahez';
$username = 'root';
$password = '';

// إنشاء اتصال آمن
$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("خطأ في الاتصال: " . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');

$error = '';
$success = '';

// معالجة تسجيل الخروج المحسنة
if (isset($_POST['logout'])) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Location: login.php");
    exit();
}

// معالجة تسجيل الدخول
if (isset($_POST['send'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);   
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, 
        "SELECT id, u_name, u_password, user_role 
        FROM users 
        WHERE u_email = ?");
    
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $u_name, $hashed_password, $user_role);
        mysqli_stmt_fetch($stmt);
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $u_name;
            $_SESSION['user_role'] = $user_role;
            if ($_SESSION['user_role'] === 'admin') {
                header("Location: dashboard/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "كلمة المرور غير صحيحة";
        }
    } else {
        $error = "البريد الإلكتروني غير مسجل";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
<br>
<center>
<div class="login-container">
    <div class="logo">
        <h1>فندقي</h1>
    </div>

    <?php if (isset($_SESSION['username'])): ?>
        <div class="alert alert-success">
            مرحبًا، <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>!
            <form method="POST" style="margin-top: 15px;">
                <button type="submit" name="logout" class="btn" onclick="return confirm('هل أنت متأكد؟')">
                    <i class="fas fa-sign-out-alt"></i>
                    تسجيل الخروج
                </button>
            </form>
        </div>
    <?php else: ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>البريد الإلكتروني</label>

                    <i class="fas fa-envelope"></i>
                    <input type="email" 
                           name="email" 
                           required
                           placeholder="example@domain.com"
                           value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>">

            </div>

            <div class="form-group">
                <label>كلمة المرور</label>

                    <i class="fas fa-lock"></i>
                    <input type="password" 
                           name="password" 
                           required
                           placeholder="••••••••">
            
            </div>

            <button type="submit" name="send">
                <i class="fas fa-sign-in-alt"></i>
                تسجيل دخول
            </button>
        </form>

        <div class="links">
            <a href="singup.php">إنشاء حساب جديد</a>
        </div>
    <?php endif; ?>
</div>
</center>

<!-- أكواد CSS مفصولة -->
<link rel="stylesheet" href="styles.css">

<script>
function confirmLogout() {
    return confirm("هل أنت متأكد أنك تريد تسجيل الخروج؟");
}
</script>

<?php
require_once('footer.php');
?>