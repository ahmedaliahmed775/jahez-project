<?php 
session_start();
include_once 'sidebar.php';
include_once 'header.php';
require_once('../config.php');

// جلب بيانات المستخدمين
$sql = "SELECT id, u_name, u_address, u_password, u_email, u_phone FROM users";
$result = $conn->query($sql);

// عرض رسائل النجاح
if (isset($_GET['success'])) {
    echo '<div class="alert alert-success text-center">'.$_GET['success'].'</div>';
}
?>

<section class="content users-management">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">ادارة العملاء</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="customersTable" class="table table-hover table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>الاسم</th>
                                        <th>العنوان</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>الهاتف</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): 
                                        $counter = 1;
                                        while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $counter++ ?></td>
                                            <td><?= htmlspecialchars($row["u_name"]) ?></td>
                                            <td><?= htmlspecialchars($row["u_address"]) ?></td>
                                            <td><?= htmlspecialchars($row["u_email"]) ?></td>
                                            <td><?= htmlspecialchars($row["u_phone"]) ?></td>
                                            <td>
                                                <a href="edit_users.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> تعديل
                                                </a>
                                                <form action="delete_user.php" method="POST" style="display:inline-block;">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">لا توجد بيانات متاحة</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
$conn->close();
?>