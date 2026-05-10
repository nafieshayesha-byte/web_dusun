<?php
$files = [
    'index.php', 'nasabah.php', 'pengaduan.php', 'transaksi.php', 
    'fasilitas.php', 'bisnis.php', 'laporan.php', 'pengaturan.php'
];

$styled_modal_css = "
<style>
    /* Final Robust Logout Modal Style */
    .modal-overlay-final {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(0, 0, 0, 0.6) !important;
        backdrop-filter: blur(8px) !important;
        display: none !important;
        justify-content: center !important;
        align-items: center !important;
        z-index: 999999 !important;
        transition: all 0.3s ease !important;
    }
    .modal-overlay-final.active {
        display: flex !important;
    }
    .modal-content-final {
        background: #ffffff !important;
        padding: 45px 40px !important;
        border-radius: 24px !important;
        width: 420px !important;
        text-align: center !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        border: 1px solid rgba(18, 54, 26, 0.1) !important;
    }
    .modal-content-final i {
        font-size: 56px !important;
        color: #12361A !important;
        margin-bottom: 25px !important;
        display: block !important;
    }
    .modal-content-final h3 {
        font-size: 22px !important;
        font-weight: 800 !important;
        color: #12361A !important;
        margin-bottom: 12px !important;
        letter-spacing: -0.5px !important;
    }
    .modal-content-final p {
        font-size: 16px !important;
        color: #4a6d41 !important;
        margin-bottom: 35px !important;
        font-weight: 500 !important;
        line-height: 1.5 !important;
    }
    .modal-footer-final {
        display: flex !important;
        gap: 16px !important;
        justify-content: center !important;
    }
    .btn-final {
        padding: 14px 35px !important;
        border-radius: 14px !important;
        border: none !important;
        font-weight: 800 !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        font-size: 15px !important;
        flex: 1 !important;
    }
    .btn-ya-final {
        background: #12361A !important;
        color: #ffffff !important;
    }
    .btn-ya-final:hover {
        background: #0d2a14 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(18, 54, 26, 0.3) !important;
    }
    .btn-tidak-final {
        background: #f0f4e8 !important;
        color: #12361A !important;
    }
    .btn-tidak-final:hover {
        background: #e1e9d5 !important;
        transform: translateY(-2px) !important;
    }
    .logout-sidebar-link {
        color: #d9534f !important;
        font-weight: 800 !important;
    }
    .logout-sidebar-link:hover {
        background: rgba(217, 83, 79, 0.1) !important;
    }
</style>
";

$modal_html_final = "
<!-- Final Logout Modal -->
<div class=\"modal-overlay-final\" id=\"logoutOverlayFinal\">
    <div class=\"modal-content-final\">
        <i class=\"fas fa-sign-out-alt\"></i>
        <h3>Konfirmasi Log Out</h3>
        <p>Apakah anda yakin ingin logout dari panel admin?</p>
        <div class=\"modal-footer-final\">
            <button class=\"btn-final btn-tidak-final\" onclick=\"hideLogoutModalFinal()\">Tidak</button>
            <button class=\"btn-final btn-ya-final\" onclick=\"window.location.href='logout.php'\">Ya</button>
        </div>
    </div>
</div>

<script>
    function showLogoutModalFinal() {
        document.getElementById('logoutOverlayFinal').classList.add('active');
    }
    function hideLogoutModalFinal() {
        document.getElementById('logoutOverlayFinal').classList.remove('active');
    }
</script>
";

foreach ($files as $file) {
    $path = "admin/" . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        // 1. Remove ANY existing logout modal content (HTML & CSS & Scripts)
        $content = preg_replace('/<!-- Logout Modal -->.*?<\/script>/s', '', $content);
        $content = preg_replace('/\/\* Logout Modal \*\/.*?\}/s', '', $content);
        $content = preg_replace('/<!-- Final Logout Modal -->.*?<\/script>/s', '', $content);
        
        // 2. Add Final CSS before </head>
        $content = str_replace("</head>", $styled_modal_css . "</head>", $content);
        
        // 3. Add Final Modal before </body>
        $content = str_replace("</body>", $modal_html_final . "</body>", $content);
        
        // 4. Fix Sidebar Link
        $content = preg_replace('/<a href=\"logout\.php\"[^>]*>/', '<a href=\"javascript:void(0)\" onclick=\"showLogoutModalFinal()\" class=\"logout-sidebar-link\">', $content);
        $content = preg_replace('/onclick=\"showLogoutModal\(\)\"/', 'onclick=\"showLogoutModalFinal()\"', $content);
        $content = preg_replace('/onclick=\"openLogoutModal\(\); return false;\"/', 'onclick=\"showLogoutModalFinal()\"', $content);
        
        file_put_contents($path, $content);
        echo "Cleaned and Fixed $file\n";
    }
}
?>
