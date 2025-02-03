<?php
require_once('header.php');
require_once('nav.php');
?>

<!-- إضافة رابط لملف CSS -->
<link rel="stylesheet" href="css/styles.css">

<!-- Hero Section -->
<!-- Hero Section -->
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title animate__animated animate__fadeInDown">اصنع ذكريات لا تُنسى</h1>
        <p class="hero-subtitle animate__animated animate__fadeInUp">اكتشف أفضل تجارب الإقامة في اليمن</p>
        
        <div class="cta-buttons">
            <a href="hotels.php" class="cta-btn">
                <i class="fas fa-hotel"></i>
                <span>استعرض الفنادق</span>
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>حجوزات آمنة</h3>
                <p>نظام دفع إلكتروني موثوق</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>دعم فني 24/7</h3>
                <p>خدمة عملاء على مدار الساعة</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3>دليل سياحي تفاعلي</h3>
                <p>اكتشف المعالم السياحية القريبة</p>
            </div>
        </div>
    </div>
</section>

<!-- Special Offers Section -->
<section class="offers-section">
    <div class="container">
        <h2 class="section-title">عروض مميزة</h2>
        <div class="offers-grid">
            <div class="offer-card">
                <div class="offer-badge">خصم 40%</div>
                <img src="images/hotel1.jpg" alt="عرض خاص">
                <div class="offer-content">
                    <h3>عروض شهر العسل</h3>
                    <p>إقامة فاخرة مع وجبة إفطار مجانية</p>
                    <a href="#" class="offer-btn">احجز الآن</a>
                </div>
            </div>
            
            <div class="offer-card">
                <div class="offer-badge">عرض محدود</div>
                <img src="images/hotel2.jpg" alt="عرض خاص">
                <div class="offer-content">
                    <h3>عطلة نهاية الأسبوع</h3>
                    <p>احصل على ليلة مجانية عند الحجز لـ 3 ليالي</p>
                    <a href="#" class="offer-btn">احجز الآن</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once('footer.php');
?>

<script>
// إضافة تأثير التمرير السلس
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
