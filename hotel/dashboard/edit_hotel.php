<?php
session_start();
require_once('../config.php');

// التحقق من وجود معرف الفندق
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "معرف الفندق غير مقدم.";
    header("Location: add_hotel.php");
    exit();
}

$id = (int)$_GET['id'];

// جلب بيانات الفندق المحدد
$sql = "SELECT * FROM hotels WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "الفندق غير موجود.";
    header("Location: add_hotel.php");
    exit();
}

$hotel = $result->fetch_assoc();

// معالجة التعديل
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['hotelName'];
    $city = $_POST['city'];
    $location = $_POST['location'];
    $rating = $_POST['rating'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // تحديث بيانات الفندق
    $sql = "UPDATE hotels SET name=?, city=?, location=?, rating=?, price=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdsi", $name, $city, $location, $rating, $price, $description, $id);

    if ($stmt->execute()) {
        echo "<script>alert('تم تحديث البيانات بنجاح');</script>";
        echo "<script>window.location.href = 'hotels.php';</script>";
        exit();
    } else {
        echo "<script>alert('خطأ في تحديث الفندق:');</script>";
    }
    header("Location: add_hotel.php");
    exit();
}

include('sidebar.php');  
include('header.php'); 
?>


<body class="hotel-edit-page">
    <div class="form-container">
        <h2>تعديل الفندق</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="hotelName">اسم الفندق:</label>
                <input type="text" id="hotelName" name="hotelName" value="<?= htmlspecialchars($hotel['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="city">المدينة:</label>
                <input type="text" id="city" name="city" value="<?= htmlspecialchars($hotel['city']) ?>" required>
            </div>
            <div class="form-group">
                <label for="location">الموقع:</label>
                <input type="text" id="location" name="location" value="<?= htmlspecialchars($hotel['location']) ?>" required>
            </div>
            <div class="form-group">
                <label for="rating">التقييم:</label>
                <input type="number" id="rating" name="rating" step="0.1" min="0" max="5" value="<?= htmlspecialchars($hotel['rating']) ?>" required>
            </div>
            <div class="form-group">
                <label for="price">السعر:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($hotel['price']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">الوصف:</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($hotel['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">صورة الفندق:</label>
                <input type="file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            <a href="hotels.php" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>