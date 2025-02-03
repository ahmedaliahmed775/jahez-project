<?php
session_start();
require_once('../config.php');

// معالجة إضافة الفندق
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotelName = $conn->real_escape_string($_POST['hotelName']);
    $location = $conn->real_escape_string($_POST['location']);
    $description = $conn->real_escape_string($_POST['description']);
    $rating = (float)$_POST['rating'];
    $price = (float)$_POST['price'];
    $city = $conn->real_escape_string($_POST['city']);
    $image = $_FILES['image'];

    // التحقق من الصورة
    $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($image['type'], $allowed_types)) {
        die("نوع الملف غير مدعوم");
    }

    // إنشاء اسم فريد للصورة
    $image_name = uniqid() . '_' . basename($image["name"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        $sql = "INSERT INTO hotels (name, location, description, rating, price, image, city) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdsss", $hotelName, $location, $description, $rating, $price, $image_name, $city);
        
        if ($stmt->execute()) {
            $success = "تمت إضافة الفندق بنجاح!";
        } else {
            $error = "خطأ في الإضافة: " . $stmt->error;
        }
    } else {
        $error = "فشل في رفع الصورة";
    }
}
?>


<body class="add-hotel-page">
    <?php include 'sidebar.php'; ?>
    <?php include_once 'header.php'; ?>

    <div class="form-container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">اسم الفندق</label>
                    <input type="text" name="hotelName" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">المدينة</label>
                    <select name="city" class="form-input" required>
                        <option value="">اختر المدينة</option>
                        <option value="صنعاء">صنعاء</option>
                        <option value="عدن">عدن</option>
                        <option value="تعز">تعز</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">الموقع</label>
                    <input type="text" name="location" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">التقييم (1-5)</label>
                    <input type="number" name="rating" min="1" max="5" step="0.1" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">السعر لليلة</label>
                    <input type="number" name="price" step="0.01" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">صورة الفندق</label>
                    <div class="file-input">
                        <input type="file" name="image" accept="image/*" required>
                        <div class="file-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            اختر صورة
                        </div>
                    </div>
                </div>

                <div class="form-group" style="grid-column: span 2">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-input" rows="4" required></textarea>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-plus-circle"></i>
                إضافة الفندق
            </button>
        </form>
    </div>

    <script>
        // عرض اسم الصورة المختارة
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const fileName = e.target.files[0].name;
            document.querySelector('.file-label').innerHTML = 
                `<i class="fas fa-check-circle"></i> ${fileName}`;
        });
    </script>
</body>
</html>