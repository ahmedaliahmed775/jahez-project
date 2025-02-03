<?php
require_once('header.php');
require_once('nav.php');
?>

<section id="o">
<div class="container">
    <h2>تسجيل</h2>
    <form id="registrationForm" method="POST" action="">
        <div class="form-group">
            <label for="name">الاسم:<span class="required">*</span></label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="address">العنوان:<span class="required">*</span></label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="password">كلمة المرور:<span class="required">*</span></label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm-password">إعادة كلمة المرور:<span class="required">*</span></label>
            <input type="password" id="confirm-password" name="confirm-password" required>
        </div>
        <div class="form-group">
            <label for="email">البريد الإلكتروني:<span class="required">*</span></label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">رقم الهاتف:<span class="required">*</span></label>
            <input type="tel" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="agreement" name="agreement" required>
                <label for="agreement">أوافق على الشروط والأحكام</label>
            </div>
        </div>

        <div class="button-group">
            <button type="button" class="btn" onclick="window.history.back();">عودة</button>
            <input type="submit" class="btn" value="إرسال" name="send">
            <button type="reset" class="btn secondary">إعادة</button>
        </div>
    </form>
    </section>
    <?php
if (isset($_POST['send'])) {
    require_once('config.php');

    // استلام البيانات
    $name = $_POST['name'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // التحقق من تطابق كلمتي المرور
    if ($password !== $confirm_password) {
        echo "<script>alert('كلمة المرور غير متطابقة!');</script>";
        exit;
    }

    // تشفير كلمة المرور باستخدام bcrypt
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // إعداد الاستعلام
    $sql = "INSERT INTO users (u_name, u_address, u_password, u_email, u_phone) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $address, $hashed_password, $email, $phone);

    if (mysqli_stmt_execute($stmt)) {
        $user_id = mysqli_insert_id($conn);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $name;

        echo "<script>
                alert('تم التسجيل بنجاح!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "خطأ في التسجيل: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>
</div>
<style >

    #o {
        max-width: 600px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        color: #333;
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        display: block;
        margin-bottom: 5px;
        color: #555;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .required {
        color: red;
    }
    .checkbox-group {
        margin: 10px 0;
    }
    .button-group {
        display: flex;
        justify-content: space-between;
    }
    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn.secondary {
        background-color: #6c757d;
    }
    .btn:hover {
        background-color: #0056b3;
    }
</style>
<?php
require_once('footer.php');


?>