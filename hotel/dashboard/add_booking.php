<?php
session_start();
include_once 'sidebar.php';
include_once 'header.php';
require_once('../config.php');

// معالجة إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $hotel_id = $_POST['hotel_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $number_of_guests = $_POST['number_of_guests'];
    
    // حساب السعر بناءً على الفندق وعدد الأيام
    $hotel_query = "SELECT price FROM hotels WHERE id = $hotel_id";
    $hotel_result = mysqli_query($conn, $hotel_query);
    $hotel = mysqli_fetch_assoc($hotel_result);
    
    $start = new DateTime($check_in);
    $end = new DateTime($check_out);
    $nights = $end->diff($start)->days;
    
    $total_price = $hotel['price'] * $nights * $number_of_guests;
    
    // إدخال الحجز في قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, check_in, check_out, number_of_guests, price, status) VALUES (?, ?, ?, ?, ?, ?, 'confirmed')");
    $stmt->bind_param("iissid", $user_id, $hotel_id, $check_in, $check_out, $number_of_guests, $total_price);
    
    if ($stmt->execute()) {
        $success = "تم إضافة الحجز بنجاح!";
    } else {
        $error = "حدث خطأ أثناء إضافة الحجز: " . $conn->error;
    }
}

// استرجاع قائمة المستخدمين والفنادق
$users = mysqli_query($conn, "SELECT id, u_name FROM users");
$hotels = mysqli_query($conn, "SELECT id, name, price FROM hotels");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة حجز جديد</title>
    <link rel="stylesheet" href="style.css"> <!-- تضمين ملف CSS -->
</head>
<body class="add-booking-page">
    <div class="main-content">
        <div class="booking-form">
            <h2 class="form-title"><i class="fas fa-plus-circle"></i> إضافة حجز جديد</h2>
            
            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>اختر العميل:</label>
                    <select name="user_id" required>
                        <?php while($user = mysqli_fetch_assoc($users)): ?>
                            <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['u_name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>اختر الفندق:</label>
                    <select name="hotel_id" required>
                        <?php while($hotel = mysqli_fetch_assoc($hotels)): ?>
                            <option value="<?= $hotel['id'] ?>">
                                <?= htmlspecialchars($hotel['name']) ?> - <?= $hotel['price'] ?> ر.ي/ليلة
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>تاريخ الوصول:</label>
                    <input type="date" name="check_in" required min="<?= date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label>تاريخ المغادرة:</label>
                    <input type="date" name="check_out" required>
                </div>

                <div class="form-group">
                    <label>عدد الضيوف:</label>
                    <input type="number" name="number_of_guests" min="1" max="10" required>
                </div>

                <button type="submit" class="submit-btn">إضافة الحجز</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>