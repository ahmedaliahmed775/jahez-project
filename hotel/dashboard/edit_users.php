<?php
session_start();
include_once 'sidebar.php';
include_once 'header.php';
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // عملية التحديث
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    $stmt = $conn->prepare("UPDATE users SET 
        u_name = ?, 
        u_address = ?, 
        u_email = ?, 
        u_phone = ? 
        WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $address, $email, $phone, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('تم تحديث البيانات بنجاح');</script>";
        echo "<script>window.location.href = 'users.php';</script>";
        exit();
    } else {
        echo "حدث خطأ أثناء التحديث: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<div class="content-wrapper user-edit-page">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">تعديل بيانات المستخدم</h3>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>الاسم الكامل</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="name" 
                                        value="<?= htmlspecialchars($user['u_name']) ?>" 
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>العنوان</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="address" 
                                        value="<?= htmlspecialchars($user['u_address']) ?>"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>البريد الإلكتروني</label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        name="email" 
                                        value="<?= htmlspecialchars($user['u_email']) ?>"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>رقم الهاتف</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="phone" 
                                        value="<?= htmlspecialchars($user['u_phone']) ?>"
                                        required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                <a href="users.php" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
$conn->close();
?>