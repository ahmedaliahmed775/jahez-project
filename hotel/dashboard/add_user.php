<?php
session_start();
require_once('../config.php');

// معالجة إضافة المستخدم
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['u_name']);
    $address = $conn->real_escape_string($_POST['u_address']);
    $password = password_hash($_POST['u_password'], PASSWORD_DEFAULT);
    $email = $conn->real_escape_string($_POST['u_email']);
    $phone = $conn->real_escape_string($_POST['u_phone']);
    $user_role = $conn->real_escape_string($_POST['user_role']);

    // التحقق من الحقول المطلوبة
    if (empty($name) || empty($password) || empty($email) || empty($phone) || empty($user_role)) {
        $error = "الحقول المميزة ب * مطلوبة";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "صيغة البريد الإلكتروني غير صحيحة";
    } elseif (!in_array($user_role, ['admin', 'user'])) {
        $error = "صلاحية مستخدم غير صالحة";
    } else {
        // التحقق من عدم وجود ايميل مكرر
        $check_sql = "SELECT u_email FROM users WHERE u_email = '$email'";
        $result = $conn->query($check_sql);
        
        if ($result->num_rows > 0) {
            $error = "البريد الإلكتروني مسجل مسبقاً";
        } else {
            // إدخال البيانات
            $sql = "INSERT INTO users (u_name, u_address, u_password, u_email, u_phone, user_role) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $name, $address, $password, $email, $phone, $user_role);
            
            if ($stmt->execute()) {
                $success = "تمت إضافة المستخدم بنجاح!";
                $_POST = array();
            } else {
                $error = "خطأ في الإضافة: " . $stmt->error;
            }
        }
    }
}
?>

<?php include 'sidebar.php'; ?>
<?php include 'header.php'; ?>

<div class="main-content add-user-page">
    <div class="form-container">
        <h2 class="form-title"><i class="fas fa-user-plus"></i> إضافة عميل جديد</h2>
        
        <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label class="form-label">
                    <span class="required">*</span>الاسم الكامل
                </label>
                <input type="text" 
                       class="form-input" 
                       name="u_name" 
                       required
                       value="<?php echo isset($_POST['u_name']) ? htmlspecialchars($_POST['u_name']) : ''; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">العنوان</label>
                <input type="text" 
                       class="form-input" 
                       name="u_address"
                       value="<?php echo isset($_POST['u_address']) ? htmlspecialchars($_POST['u_address']) : ''; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="required">*</span>البريد الإلكتروني
                </label>
                <input type="email" 
                       class="form-input" 
                       name="u_email" 
                       required
                       value="<?php echo isset($_POST['u_email']) ? htmlspecialchars($_POST['u_email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="required">*</span>كلمة المرور
                </label>
                <input type="password" 
                       class="form-input" 
                       name="u_password" 
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="required">*</span>رقم الهاتف
                </label>
                <input type="tel" 
                       class="form-input" 
                       name="u_phone" 
                       required
                       pattern="[0-9]{10}"
                       value="<?php echo isset($_POST['u_phone']) ? htmlspecialchars($_POST['u_phone']) : ''; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="required">*</span>صلاحية المستخدم
                </label>
                <select class="form-input form-select" name="user_role" required>
                    <option value="">اختر الصلاحية</option>
                    <option value="admin" <?= isset($_POST['user_role']) && $_POST['user_role'] === 'admin' ? 'selected' : '' ?>>مدير النظام</option>
                    <option value="user" <?= isset($_POST['user_role']) && $_POST['user_role'] === 'user' ? 'selected' : '' ?>>مستخدم عادي</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i>
                حفظ المستخدم
            </button>
        </form>
    </div>
</div>

