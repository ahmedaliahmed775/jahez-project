<?php
require_once('header.php');
require_once('nav.php');
?>
<?php
// استدعاء ملف الاتصال
include 'config.php';

// استعلام لاسترجاع بيانات الفندق
$stmt = $pdo->query("SELECT name, location, rating, description, image FROM hotels WHERE id = 3"); 
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

// تعيين المتغيرات أو القيم الافتراضية
$hotelName = $hotel['name'] ?? 'اسم الفندق غير متوفر';
$hotelLocation = $hotel['location'] ?? 'الموقع غير متوفر';
$hotelRating = $hotel['rating'] ?? 'غير متوفر';
$hotelDescription = $hotel['description'] ?? 'الوصف غير متوفر';
$hotelImage = $hotel['image'] ?? 'default_image.jpg'; 
?>

<style>
    /* تنسيق تفاصيل الفندق */
    .hotel-image img {
        width: 50%;
        height: auto;
        max-height: 300px;
        border-radius: 50px;
        object-fit: cover;
    }

    .hotel-details {
        margin-top: 20px;
        text-align: right;
    }

    .hotel-details h2 {
        font-size: 28px;
        color: #333;
    }

    .hotel-details p {
        font-size: 16px;
        color: #666;
        margin: 10px 0;
    }

    .rating {
        font-size: 18px;
        color: #f39c12;
    }

    #btnn {
        padding: 12px 20px;
        background-color: #12c444;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
        margin: 0 10px;
    }

    .btn-return {
        padding: 12px 20px;
        background-color: #c10d0d;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
        margin: 0 10px;
    }

    .reservation-form {
        margin-top: 30px;
        text-align: right;
    }

    .reservation-form label {
        display: block;
        margin: 10px 0 5px;
    }

    .reservation-form input, .reservation-form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .price-info {
        margin-top: 20px;
        font-size: 18px;
        color: #333;
    }

    .night-price {
        font-size: 20px;
        color: #007bff;
        margin-top: 10px;
    }
</style>

<br>
<div class="container">
    <div class="hotel-image">
        <img src="<?php echo htmlspecialchars($hotelImage); ?>" alt="<?php echo htmlspecialchars($hotelName); ?>">
    </div>
    <div class="hotel-details">
        <h2><?php echo htmlspecialchars($hotelName); ?></h2>
        <p><strong>الموقع:</strong> <?php echo htmlspecialchars($hotelLocation); ?></p>
        <p><strong>الوصف:</strong> <?php echo htmlspecialchars($hotelDescription); ?></p>
        <p class="rating"><strong>التقييم:</strong> ⭐⭐⭐⭐⭐ (<?php echo htmlspecialchars($hotelRating); ?>/5)</p>
        <p class="night-price"><strong>سعر الليلة:</strong> <span id="nightPriceValue">100</span> ريال</p>
    </div>

    <div class="reservation-form">
        <h3>احجز إقامتك</h3>
        <form id="reservationForm">
            <label for="checkin">تاريخ الوصول:</label>
            <input type="date" id="checkin" name="checkin" required>

            <label for="checkout">تاريخ المغادرة:</label>
            <input type="date" id="checkout" name="checkout" required>

            <label for="nights">عدد الليالي:</label>
            <select id="nights" name="nights" required>
                <option value="1">ليلة واحدة</option>
                <option value="2">ليلتين</option>
                <option value="3">3 ليالي</option>
                <option value="4">4 ليالي</option>
                <option value="5">5 ليالي</option>
            </select>

            <label for="guests">عدد الأشخاص:</label>
            <select id="guests" name="guests" required>
                <option value="1">شخص واحد</option>
                <option value="2">شخصان</option>
                <option value="3">3 أشخاص</option>
                <option value="4">4 أشخاص</option>
            </select>
        </form>
        <div class="price-info" id="priceInfo"></div>
    </div>
    
    <div class="button-group" style="text-align: center; margin-top: 20px;">
        <a href="javascript:history.back()" class="btn-return">عودة</a>
        <a href="#" id="btnn">أضف إلى السلة</a>
    </div>
</div>
<br>
<?php
require_once('footer.php');
?>

<script>
    let pricePerNight = 100; 
    function updatePrice(newPrice) {
        pricePerNight = newPrice; 
        document.getElementById('nightPriceValue').innerText = pricePerNight; 
    }

    updatePrice(150); 
    document.getElementById('reservationForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        const nights = parseInt(document.getElementById('nights').value);
        const guests = parseInt(document.getElementById('guests').value);

        const totalPrice = nights * pricePerNight;

        document.getElementById('priceInfo').innerText = `السعر الإجمالي لإقامة ${nights} ليلة(ليالي) لعدد ${guests} شخص هو: ${totalPrice} ريال.`;
    });
</script>