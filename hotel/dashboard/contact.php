<?php 
session_start();
include_once 'sidebar.php';  
include_once 'header.php'; 
require_once('../config.php');

// استرجاع التعليقات من قاعدة البيانات
$query = "SELECT email, message, created_at FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>


<body class="comments-page">
    <div class="main-content">
        <div class="comments-container">
            <h1><i class="fas fa-comments"></i> تعليقات العملاء</h1>
            
            <?php if(mysqli_num_rows($result) > 0): ?>
                <table class="comments-table">
                    <thead>
                        <tr>
                            <th>البريد الإلكتروني</th>
                            <th>الرسالة</th>
                            <th>تاريخ الإرسال</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td class="message-cell"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                            <td class="date-cell"><?= date('Y/m/d H:i', strtotime($row['created_at'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align:center; padding:20px; color:#666">
                    لا توجد تعليقات لعرضها
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
// إغلاق الاتصال
mysqli_close($conn);
?>