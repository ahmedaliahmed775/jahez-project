<?php
require_once('header.php');
require_once('nav.php');

// الاتصال بقاعدة البيانات
require_once('config.php');

// معالجة البحث
$search_query = "";
$city = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search_query']; // قد يكون فارغًا
    $city = $_GET['city'];

    // استعلام البحث
    if (!empty($search_query)) {
        // إذا تم إدخال اسم الفندق
        $sql = "SELECT * FROM hotels WHERE name LIKE ? AND city = ?";
        $stmt = mysqli_prepare($conn, $sql);
        $search_param = "%$search_query%";
        mysqli_stmt_bind_param($stmt, "ss", $search_param, $city);
    } else {
        // إذا لم يتم إدخال اسم الفندق، عرض جميع الفنادق في المدينة المختارة
        $sql = "SELECT * FROM hotels WHERE city = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $city);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $hotels = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // عرض جميع الفنادق إذا لم يتم البحث
    $sql = "SELECT * FROM hotels";
    $result = mysqli_query($conn, $sql);
    $hotels = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<section class="search-section" id="search">
    <div class="container">
        <div class="search-header">
            <h1 class="search-title">ابحث عن فنادقك المفضلة</h1>
            <p class="search-subtitle">اكتشف أفضل خيارات الإقامة في اليمن</p>
        </div>
        
        <form action="hotels.php" method="GET" class="search-form">
            <div class="form-grid">
                <!-- City Select Box -->
                <div class="form-group city-select">
                    <label class="form-label">اختر المدينة</label>
                    <div class="custom-select">
                        <select name="city" required class="select-input">
                            <option value="" disabled selected>اختر المدينة...</option>
                            <option value="sa">صنعاء</option>
                            <option value="ad">عدن</option>
                            <option value="ta">تعز</option>
                        </select>
                        <i class="fas fa-map-marker-alt select-icon"></i>
                    </div>
                </div>

                <!-- Hotel Search Input -->
                <div class="form-group hotel-search">
                    <label class="form-label">اسم الفندق</label>
                    <div class="search-input-group">
                        <input 
                            type="text" 
                            name="search_query" 
                            placeholder="ابحث باسم الفندق (اختياري)" 
                            value="<?php echo htmlspecialchars($search_query); ?>"
                            class="search-input"
                        >
                        <i class="fas fa-hotel input-icon"></i>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-group button-group">
                    <button type="submit" name="search" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        <span>ابحث الآن</span>
                    </button>
                    <a href="hotels.php" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i>
                        <span>إعادة الضبط</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="results-section" id="hotels">
    <div class="container">
        <?php
        // تمرير نتائج البحث إلى hotel_box.php
        require('hotel_box.php');
        ?>
    </div>
</section>

<?php
require('footer.php');
?>