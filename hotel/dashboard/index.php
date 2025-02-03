<?php
session_start();
include_once 'sidebar.php';
include_once 'header.php';
?>


<body class="page-dashboard">

<div class="main-content">
    <!-- قسم الترحيب -->
    <div class="welcome-section">
        <h1>مرحبًا بك في نظام جاهز للإدارة</h1>
        <p class="text-muted">نظام إدارة الحجوزات الفندقية المتكامل</p>
    </div>

    <!-- الإحصائيات التمثيلية -->
    <div class="system-stats">
        <div class="dashboard-card bg-light">
            <h3>الميزات الأساسية</h3>
            <ul class="mt-3">
                <li>إدارة الحجوزات</li>
                <li>تحليل الإيرادات</li>
                <li>تقارير الأداء</li>
                <li>إدارة العملاء</li>
            </ul>
        </div>



    <!-- قسم الرسوم التوضيحية -->
    <div class="dashboard-card mt-4">
        <h4>حالة النظام</h4>
        <div class="system-status">
            <div class="alert alert-success mt-3">
                <i class="fas fa-check-circle"></i>
                جميع الخدمات تعمل بشكل طبيعي
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5><i class="fas fa-tasks"></i> الإصدار الحالي</h5>
                            <p class="stat-number">v1.0</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5><i class="fas fa-shield-alt"></i> الحماية</h5>
                            <p class="text-success">
                                <i class="fas fa-lock"></i>
                                نظام آمن
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5><i class="fas fa-clock"></i> وقت النظام</h5>
                            <p><?php echo date('Y-m-d H:i:s'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>

    <!-- Additional CSS -->
