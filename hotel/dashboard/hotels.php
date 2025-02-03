<?php
session_start();
require_once('../config.php');
include_once 'sidebar.php';
include_once 'header.php';

// جلب بيانات الفنادق
$hotels = [];
$sql = "SELECT * FROM hotels ORDER BY id DESC";
$result = $conn->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $hotels[] = $row;
    }
}
?>

<div class="content">
    <!-- عرض الرسائل -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <h1 class="page-title">
                <i class="fas fa-calendar-alt"></i>
                إدارة الحجوزات
            </h1>
    <table class="hotels-table">
        <thead>
            <tr>
                <th>الصورة</th>
                <th>الاسم</th>
                <th>المدينة</th>
                <th>التقييم</th>
                <th>سعر الليله</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($hotels as $hotel): ?>
            <tr>
                <td><img src="uploads/<?= $hotel['image'] ?>" alt="<?= $hotel['name'] ?>" style="width:80px;height:60px;object-fit:cover;"></td>
                <td><?= htmlspecialchars($hotel['name']) ?></td>
                <td><?= htmlspecialchars($hotel['city']) ?></td>
                <td><?= $hotel['rating'] ?></td>
                <td><?= number_format($hotel['price'], 2) ?> ريال</td>
                <td>
                    <div class="action-buttons">
                        <a href="edit_hotel.php?id=<?= $hotel['id'] ?>" class="btn btn-edit">
                            <i class="fas fa-edit"></i>
                            تعديل
                        </a>
                        <form method="POST" action="delete_hotel.php" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
                            <button type="submit" class="btn btn-delete">
                                <i class="fas fa-trash"></i>
                                حذف
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $conn->close(); ?>

    <!-- ... [الجزء السابق من الhead] ... -->
    <style>
        /* أنماط الجدول */
        .hotels-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            max-width: 70%; /* تحديد العرض الأقصى للبطاقة */
        margin: auto; /* توسيط البطاقة */
        }

        .hotels-table th,
        .hotels-table td {
            padding: 1rem;
            text-align: right;
            border-bottom: 1px solid #f1f1f1;
        }

        .hotels-table th {
            background: var(--primary-color);
            color: black;
            font-weight: 500;
        }
        
        .hotels-table tr:hover {
            background: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #4CAF50;
            color: white;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* نافذة التعديل */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 600px;
        }
    </style>