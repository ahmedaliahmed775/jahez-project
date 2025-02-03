<?php
session_start();
require_once('../config.php');
include_once 'sidebar.php';
include_once 'header.php';

// التحقق من صلاحيات المدير
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// استعلام آمن لاسترجاع الحجوزات
$query = "SELECT 
            b.id,
            u.u_name AS user_name,
            h.name AS hotel_name,
            b.check_in,
            b.check_out,
            b.number_of_guests,
            b.status,
            b.price
          FROM bookings b
          JOIN users u ON b.user_id = u.id
          JOIN hotels h ON b.hotel_id = h.id
          ORDER BY b.check_in DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>


<body class="page-bookings">
    <div class="main-content">
        <div class="bookings-container">
            <!-- عرض الرسائل -->
            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['message']; unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <h1 class="page-title">
                <i class="fas fa-calendar-alt"></i>
                إدارة الحجوزات
            </h1>
            
            <?php if($result->num_rows > 0): ?>
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>رقم الحجز</th>
                            <th>اسم العميل</th>
                            <th>اسم الفندق</th>
                            <th>تاريخ الوصول</th>
                            <th>تاريخ المغادرة</th>
                            <th>عدد الضيوف</th>
                            <th>الحالة</th>
                            <th>السعر</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                            <td><?= htmlspecialchars($row['hotel_name']) ?></td>
                            <td><?= date('Y/m/d', strtotime($row['check_in'])) ?></td>
                            <td><?= date('Y/m/d', strtotime($row['check_out'])) ?></td>
                            <td><?= htmlspecialchars($row['number_of_guests']) ?></td>
                            <td>
                                <span class="status-badge status-<?= htmlspecialchars($row['status']) ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td class="price-cell">
                                <?= number_format($row['price']) ?> ر.ي
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <form method="post" action="cancel_booking.php" 
                                          onsubmit="return confirm('هل أنت متأكد من الإلغاء؟')">
                                        <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="cancel">إلغاء</button>
                                    </form>
                                    <form method="get" action="edit_booking.php">
                                        <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                                        <button type="submit" class="edit">تعديل</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-calendar-times"></i>
                    لا توجد حجوزات لعرضها
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
