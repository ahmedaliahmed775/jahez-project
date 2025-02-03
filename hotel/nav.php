<header class="header">
    <div class="container">
        <nav class="navbar flex1">
            <ul class="nav-menu">
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="hotels.php">الفنادق</a></li>
                <li><a href="basket.php">السلة</a></li>
                <li><a href="about.php">حول</a></li>
            </ul>

            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>

            <div class="head_contact">
                <i class="fas fa-phone-volume"></i>
                <span>+967 775052259</span>
            </div>
        </nav>
    </div>
</header>



<script>
    // إضافة تفاعلية للقائمة المنسدلة
    document.querySelector('.hamburger').addEventListener('click', () => {
        document.querySelector('.nav-menu').classList.toggle('active');
    });
</script>