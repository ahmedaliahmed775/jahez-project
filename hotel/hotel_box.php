<?php
include 'config.php';

// التحقق مما إذا كانت نتائج البحث تم تمريرها
if (isset($hotels) && !empty($hotels)) {
    $hotelsToDisplay = $hotels; // استخدام نتائج البحث
} else {
    // إذا لم يتم البحث، استرجاع جميع الفنادق
    $query = "SELECT * FROM hotels";
    $result = mysqli_query($conn, $query);
    $hotelsToDisplay = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $hotelsToDisplay[] = $row;
    }
}

// تحويل المدن إلى نص عربي
$cityMapping = [
    'sa' => 'صنعاء',
    'ta' => 'تعز',
    'ad' => 'عدن'
];

// عرض الفنادق
if (!empty($hotelsToDisplay)) {
    foreach ($hotelsToDisplay as $row) {
        $hotelName = $row['name'];
        $hotelLocation = $row['location'];
        $hotelRating = $row['rating'];
        $hotelDescription = $row['description'];
        $hotelPrice = $row['price'];
        $hotelCity = $row['city'];
        $hotelImage = $row['image'];

        // تحويل المدينة إلى النص العربي
        if (array_key_exists($hotelCity, $cityMapping)) {
            $hotelCity = $cityMapping[$hotelCity];
        } else {
            $hotelCity = 'مدينة غير معروفة';
        }

        echo '<div class="hotel-page">'; // إضافة فئة خاصة للصفحة
        echo '<div class="hotel-container grid">';
        echo '<div class="hotel-box">';
        echo '<div class="hotel-details">';
        echo '<h3>' . htmlspecialchars($hotelName) . '</h3>';
        echo '<p>الموقع: ' . htmlspecialchars($hotelLocation) . '</p>';
        echo '<p>التقييم: ' . htmlspecialchars($hotelRating) . '/5</p>';
        echo '<p>الوصف: ' . htmlspecialchars($hotelDescription) . '</p>';
        echo '<p>السعر: ' . htmlspecialchars($hotelPrice) . ' لليلة</p>';
        echo '<p>المدينة: ' . htmlspecialchars($hotelCity) . '</p>';
        echo '<a href="hotel_info.php?id=' . $row['id'] . '" class="flex1">';
        echo '<button class="book-button">احجز الآن</button>';
        echo '</a>';
        echo '</div>';
        echo '<div class="hotel-image">';
        echo '<img src="' . htmlspecialchars($hotelImage) . '" alt="' . htmlspecialchars($hotelName) . '">';
        echo '</div>';
        echo '</div>'; // .hotel-box
        echo '</div>'; // .hotel-container
        echo '</div>'; // .hotel-page
        echo "<br>";
    }
} else {
    echo "<p>لا توجد فنادق متاحة.</p>";
}

mysqli_close($conn);
?>