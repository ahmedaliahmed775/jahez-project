// ملف dashboard.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('صفحة لوحة التحكم جاهزة!');

    // مثال: إضافة تفاعل للأزرار
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            if (!confirm('هل تريد تسجيل الخروج؟')) {
                e.preventDefault();
            }
        });
    }
});