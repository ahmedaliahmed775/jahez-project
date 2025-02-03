<?php
require_once('header.php');
require_once('nav.php');

// استدعاء ملف الاتصال
include 'config.php';

// استعلام لجلب نبذة عن المنصة
$sql = "SELECT About_site FROM about LIMIT 1"; 
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $about_site = $row['About_site'];
} else {
    $about_site = "لا توجد بيانات للعرض.";
}

// استعلام لجلب معلومات المطورين
$sql_developers = "SELECT developer_name, developer_email, developer_phone FROM developer_team";
$result_developers = $conn->query($sql_developers);

$developers = [];
if ($result_developers && $result_developers->num_rows > 0) {
    while ($row = $result_developers->fetch_assoc()) {
        $developers[] = [
            'name' => $row['developer_name'],
            'developer_email' => $row['developer_email'],
            'developer_phone' => $row['developer_phone']
        ];
    }
} else {
    $developers[] = ["name" => "لا توجد أسماء للفريق.", "developer_email" => "", "developer_phone" => ""];
}

// استعلام لجلب أسماء المشرفين
$sql_supervisors = "SELECT Project_Supervisors FROM project_supervisors";
$result_supervisors = $conn->query($sql_supervisors);

$supervisors = [];
if ($result_supervisors && $result_supervisors->num_rows > 0) {
    while ($row = $result_supervisors->fetch_assoc()) {
        $supervisors[] = $row['Project_Supervisors'];
    }
} else {
    $supervisors[] = "لا توجد أسماء للمشرفين.";
}

// إغلاق الاتصال
$conn->close();

// معالجة بيانات النموذج
$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $message = $_POST['message'];

    // التحقق من البيانات
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message)) {
        // استدعاء ملف الاتصال مرة أخرى
        include 'config.php';

        // إعداد استعلام الإدخال
        $stmt = $conn->prepare("INSERT INTO contact_messages (email, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $message);

        // تنفيذ الاستعلام
        if ($stmt->execute()) {
            $message_sent = true; // تعيين علامة النجاح
        }

        // إغلاق البيان والاتصال
        $stmt->close();
        $conn->close();
    }
}
?>




<main>
    <section class="about-section">
        <h2 class="section-title">نبذة عن المنصة</h2>
        <p class="about-content"><?php echo htmlspecialchars($about_site); ?></p>
    </section>

    <section class="about-section"  id="team">
        <h2 class="section-title" id="team">فريق التطوير</h2>
        <div class="team-grid">
            <?php foreach ($developers as $developer): ?>
                <div class="team-card">
                    <div class="developer-avatar">
                        <i class="fas fa-user-circle fa-3x" style="color: #7f8c8d;"></i>
                    </div>
                    <h3 class="developer-name"><?php echo htmlspecialchars($developer['name']); ?></h3>
                    <div class="developer-info">
                        <a href="mailto:<?php echo htmlspecialchars($developer['developer_email']); ?>">
                            <i class="fas fa-envelope"></i> 
                            <?php echo htmlspecialchars($developer['developer_email']); ?>
                        </a>
                    </div>
                    <div class="developer-info">
                        <i class="fas fa-phone"></i> 
                        <?php echo htmlspecialchars($developer['developer_phone']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="about-section">
        <h2 class="section-title">المشرفون على المشروع</h2>
        <div class="supervisors-list">
            <?php foreach ($supervisors as $supervisor): ?>
                <div class="supervisor-badge">
                    <?php echo htmlspecialchars($supervisor); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="contact-section" id="contact">
        <h2 class="section-title">تواصل معنا</h2>
        <form class="contact-form" method="POST" onsubmit="return confirmSubmission()">
            <div class="form-group">
                <label class="form-label" for="email">البريد الإلكتروني</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input"
                    placeholder="example@domain.com"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="message">رسالتك</label>
                <textarea 
                    id="message" 
                    name="message" 
                    class="form-textarea" 
                    rows="5"
                    placeholder="أكتب رسالتك هنا..."
                    required
                ></textarea>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-paper-plane"></i> إرسال الرسالة
            </button>
        </form>
        
        <div class="success-message" id="successMessage">
            تم إرسال رسالتك بنجاح! سنقوم بالرد خلال 24 ساعة.
        </div>
    </section>
</main>

<script>
    function confirmSubmission() {
        const confirmation = confirm("هل أنت متأكد من رغبتك في إرسال الرسالة؟");
        if (confirmation) {
            document.getElementById('successMessage').style.display = 'block';
        }
        return confirmation;
    }
</script>

<?php
require_once('footer.php');
?>