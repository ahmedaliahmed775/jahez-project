<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-section">
                <h4 class="footer-title">روابط سريعة</h4>
                <ul class="footer-links">
                    <li><a href="about.php">عن المنصة</a></li>
                    <li><a href="about.php#team">فريق التطوير </a></li>

                </ul>
            </div>

            <div class="footer-section">
                <h4 class="footer-title">معلومات الاتصال</h4>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> اليمن، صنعاء، جامعة العلوم والتكنولوجيا</p>
                    <p><i class="fas fa-building"></i> كلية الحاسبات وتكنولوجيا المعلومات</p>
                    <p><i class="fas fa-phone"></i> +967 775052259</p>
                </div>
            </div>

            <div class="footer-section">
                <h4 class="footer-title">تواصل معنا</h4>
                <div class="social-links">
                    <a href="https://wa.me/00967775052259" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="about.php#contact" class="contact-btn">
                        <i class="fas fa-envelope"></i> ارسل رسالة
                    </a>
                </div>
            </div>
        </div>

        <div class="copyright-section">
            <p class="copyright-text">
                &copy;   جميع الحقوق محفوظة<br>
                <span> اليمن، صنعاء، جامعة العلوم والتكنولوجيا</span><br>
                <span> كلية الحاسبات وتكنولوجيا المعلومات</span><br>
             
            </p>
        </div>
    </div>
</footer>

<style>
:root {
    --primary-gold: #CC8C18;
    --dark-bg: #2c3e50;
    --text-light: #f8f9fa;
    --hover-gold: #e0a800;
}

.site-footer {
    background: linear-gradient(145deg, var(--dark-bg) 60%, #1a252f 100%);
    color: var(--text-light);
    padding: 4rem 0 2rem;
    margin-top: 5rem;
    border-top: 3px solid var(--primary-gold);
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 3rem;
    margin-bottom: 3rem;
}

.footer-section {
    text-align: right;
}

.footer-title {
    color: var(--primary-gold);
    font-size: 1.4rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid rgba(204, 140, 24, 0.3);
}

.footer-links li {
    margin-bottom: 0.8rem;
}

.footer-links a {
    color: var(--text-light);
    transition: all 0.3s ease;
    text-decoration: none;
}

.footer-links a:hover {
    color: var(--primary-gold);
    padding-right: 0.5rem;
}

.contact-info p {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.contact-info i {
    color: var(--primary-gold);
    min-width: 25px;
    text-align: center;
}

.social-links {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.social-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-light);
    transition: all 0.3s ease;
}

.social-icon:hover {
    background: var(--primary-gold);
    transform: translateY(-3px);
}

.contact-btn {
    background: var(--primary-gold);
    color: var(--text-light) !important;
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.contact-btn:hover {
    background: var(--hover-gold);
    transform: scale(1.05);
}

.copyright-section {
    text-align: center;
    padding-top: 2rem;
    border-top: 1px solid rgba(255,255,255,0.1);
    margin-top: 3rem;
}

.copyright-text {
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .footer-section {
        text-align: center;
    }
    
    .contact-info p {
        justify-content: center;
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>