
<div class="sidebar">
    <div class="logo">ادمن موقع جاهز</div>
    <ul class="nav-links">
        <li>
            <a href="index.php">
                <i class="fas fa-home"></i>
                <span>الرئيسية</span>
            </a>
        </li>
        <li>
            <a href="booking.php">
                <i class="fas fa-calendar-alt"></i>
                <span>الحجوزات</span>
            </a>
        </li>
        <li>
            <a href="hotels.php">
                <i class="fas fa-hotel"></i>
                <span>الفنادق</span>
            </a>
        </li>
        <li>
            <a href="users.php">
                <i class="fas fa-user"></i>
                <span>العملاء</span>
            </a>
        </li>
        <li>
            <a href="add_hotel.php">
                <i class="fas fa-door-open"></i>
                <span>اضافه فندق</span>
            </a>
        </li>
        <li>
            <a href="add_user.php">
                <i class="fas fa-users"></i>
                <span>اضافة عميل</span>
            </a>
        </li>
        <li>
    <a href="add_booking.php">
        <i class="fas fa-plus"></i>
        إضافة حجز جديد
    </a>
</li>
        <li>
            <a href="contact.php">
                <i class="fas fa-comments"></i>
                <span>تعليقات</span>
            </a>
        </li>
    </ul>
</div>
<style>   .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(195deg, #1a237e, #0d47a1);
            position: fixed;
            padding: 25px;
            color: white;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .logo {
            font-size: 28px;
            margin-bottom: 50px;
            text-align: center;
            font-weight: 700;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .nav-links {
            list-style: none;
        }

        .nav-links li {
            margin: 18px 0;
            padding: 14px;
            border-radius: 12px;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
        }

        .nav-links li::before {
            content: '';
            position: absolute;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            transition: 0.4s;
        }

        .nav-links li:hover::before {
            right: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 17px;
            position: relative;
            z-index: 1;
        }

        .nav-links i {
            margin-left: 15px;
            width: 30px;
            font-size: 20px;
            color: rgba(255,255,255,0.9);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: #f8fafc;
        }

        </style>