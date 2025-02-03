
    <div class="login-message">
        <p>يجب تسجيل الدخول لرؤيه الحجز. <span role="img" aria-label="warning">⚠️</span></p>
        <center>
            <a href="login.php" class="login-button">تسجيل الدخول</a>
        </center>
    </div>
    ';


<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f0f4f8;
    }
    
    .login-message {
        background: #ffffff; /* لون الخلفية */
        padding: 30px;
        text-align: center;
        margin: 40px auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px; /* عرض أقصى */
    }
    
    .login-message p {
        font-size: 18px;
        color: #333;
        margin-bottom: 20px;
    }

    .emoji {
        font-size: 50px; /* حجم الإيموجي */
        margin-top: 20px; /* مسافة من الأعلى */
    }

    .login-button {
        display: inline-block;
        margin: 20px auto;
        padding: 15px 30px;
        background-color: #4CAF50; /* لون خلفية الزر */
        color: white; /* لون النص */
        font-size: 18px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .login-button:hover {
        background-color: #45a049; /* لون خلفية الزر عند التمرير */
    }
</style>
<?php
require_once('footer.php');
?>