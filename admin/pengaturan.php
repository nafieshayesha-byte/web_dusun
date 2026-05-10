<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$admin_id = $_SESSION['admin_id'] ?? 1;
$q = mysqli_query($conn, "SELECT * FROM t_admin WHERE id_admin = '$admin_id'");
$admin = mysqli_fetch_assoc($q);

// Theme persistence
$current_theme = $admin['tema'] ?? 'light';
$_SESSION['admin_theme'] = $current_theme;

// Language persistence
$current_lang = $admin['bahasa'] ?? 'id';
$_SESSION['admin_lang'] = $current_lang;

$trans = [
    'id' => [
        'settings' => 'Pengaturan',
        'profile' => 'Profil',
        'username' => 'Username',
        'fullname' => 'Nama Lengkap',
        'password' => 'Kata Sandi',
        'change_profile' => 'Ubah Profil',
        'security' => 'Keamanan Akun',
        'old_password' => 'Kata Sandi Lama',
        'new_password' => 'Kata Sandi Baru',
        'confirm_password' => 'Konfirmasi Kata Sandi Baru',
        'update_password' => 'Update Kata Sandi',
        '2fa' => 'Aktifkan Verifikasi Dua Langkah',
        'preferences' => 'Preferensi Website',
        'theme' => 'Tema',
        'light' => 'Mode Terang',
        'dark' => 'Mode Gelap',
        'language' => 'Bahasa',
        'notif' => 'Notifikasi',
        'notif_biz' => 'Update Bisnis Desa',
        'notif_msg' => 'Pesan Nasabah',
        'save_changes' => 'Simpan Semua Perubahan',
        'search' => 'Cari',
        'dashboard' => 'Dashboard',
        'activities' => 'Informasi Kegiatan',
        'facilities' => 'Fasilitas Dusun',
        'business' => 'Bisnis Warga',
        'nasabah' => 'Nasabah',
        'transaksi' => 'Transaksi BSP',
        'laporan' => 'Laporan BSP',
        'pengaduan' => 'Pengaduan',
        'logout' => 'Log Out'
    ],
    'en' => [
        'settings' => 'Settings',
        'profile' => 'Profile',
        'username' => 'Username',
        'fullname' => 'Full Name',
        'password' => 'Password',
        'change_profile' => 'Change Profile',
        'security' => 'Account Security',
        'old_password' => 'Old Password',
        'new_password' => 'New Password',
        'confirm_password' => 'Confirm New Password',
        'update_password' => 'Update Password',
        '2fa' => 'Enable Two-Factor Authentication',
        'preferences' => 'Website Preferences',
        'theme' => 'Theme',
        'light' => 'Light Mode',
        'dark' => 'Dark Mode',
        'language' => 'Language',
        'notif' => 'Notifications',
        'notif_biz' => 'Village Business Updates',
        'notif_msg' => 'Customer Messages',
        'save_changes' => 'Save All Changes',
        'search' => 'Search',
        'dashboard' => 'Dashboard',
        'activities' => 'Activity Information',
        'facilities' => 'Village Facilities',
        'business' => 'Village Business',
        'nasabah' => 'Customers',
        'transaksi' => 'BSP Transactions',
        'laporan' => 'BSP Reports',
        'pengaduan' => 'Complaints',
        'logout' => 'Log Out'
    ]
];

function __($key) {
    global $trans, $current_lang;
    return $trans[$current_lang][$key] ?? $key;
}

?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo __('settings'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #bacc98;
            --main-bg: #ffffff;
            --text-dark: #12361A;
            --section-bg: #d9ded4;
            --input-bg: #ffffff;
            --btn-green: #06331a;
            --accent-green: #0d2a14;
            --card-bg: #f9fbf2;
        }

        body.dark-mode {
            --sidebar-bg: #1a2a1d;
            --main-bg: #0d140e;
            --text-dark: #e9f0df;
            --section-bg: #1e2e21;
            --input-bg: #2a3d2e;
            --card-bg: #1a2a1d;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--main-bg); color: var(--text-dark); overflow-x: hidden; transition: 0.3s; }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: var(--sidebar-bg);
            padding: 25px 0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .sidebar-header { padding: 0 20px; margin-bottom: 20px; }
        .sidebar-header h2 { font-size: 20px; font-weight: 800; color: var(--text-dark); margin-bottom: 20px; }
        
        .profile { display: flex; align-items: center; gap: 12px; margin-bottom: 25px; }
        .profile img { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; }
        .profile-info { display: flex; flex-direction: column; }
        .profile-info .name { font-size: 13.5px; font-weight: 800; color: var(--text-dark); }
        .profile-info .role { font-size: 12px; font-weight: 500; color: var(--text-dark); opacity: 0.8; }
        
        .menu { list-style: none; flex-grow: 1; }
        .menu li { margin-bottom: 4px; padding-left: 15px; }
        .menu li a {
            display: flex; align-items: center; gap: 12px; padding: 10px 18px;
            text-decoration: none; color: var(--text-dark); opacity: 0.7; font-weight: 800; font-size: 14px;
            border-radius: 50px 0 0 50px;
            transition: 0.2s;
        }
        .menu li a.active { background: var(--main-bg); color: var(--text-dark); opacity: 1; }
        .menu li a i { font-size: 18px; width: 22px; text-align: center; }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .search-container { position: relative; width: 100%; max-width: 600px; }
        .search-container i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #4e6353; }
        .search-bar {
            width: 100%; background: #e1e3e1; padding: 15px 20px 15px 50px;
            border: none; border-radius: 50px; font-size: 15px; font-weight: 600; color: #4e6353;
            outline: none;
        }
        .top-icons { display: flex; align-items: center; gap: 20px; color: var(--text-dark); font-size: 22px; }

        h1.page-title { font-size: 28px; font-weight: 900; color: var(--text-dark); margin-bottom: 30px; }

        /* Settings Grid */
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .settings-section {
            background: var(--section-bg);
            border-radius: 15px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .settings-section.full-width { grid-column: 1 / span 2; }

        .section-title { font-size: 22px; font-weight: 900; color: var(--text-dark); margin-bottom: 10px; }

        .profile-form-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
        }
        .form-fields { flex: 1; display: flex; flex-direction: column; gap: 15px; }
        
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group label { font-size: 14px; font-weight: 800; color: var(--text-dark); }
        .input-box {
            background: var(--input-bg);
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            outline: none;
        }

        .profile-pic-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            width: 200px;
        }
        .profile-pic-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: white;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid var(--main-bg);
        }
        .profile-pic-circle img { width: 100%; height: 100%; object-fit: cover; }
        
        .btn-action {
            background: #ffffff;
            color: #12361A;
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 800;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .btn-action:hover { background: #f0f0f0; transform: translateY(-2px); }

        .btn-update {
            background: #ffffff;
            color: #12361A;
            padding: 12px 30px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 800;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        /* Options */
        .option-group { display: flex; flex-direction: column; gap: 15px; }
        .option-label { font-size: 14px; font-weight: 800; color: var(--text-dark); }
        
        .radio-group, .checkbox-group { display: flex; flex-direction: column; gap: 12px; }
        .radio-item, .checkbox-item {
            display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 700; cursor: pointer;
        }
        .radio-circle, .check-box {
            width: 24px; height: 24px; border-radius: 50%; background: white;
            display: flex; align-items: center; justify-content: center;
            transition: 0.2s;
        }
        .check-box { border-radius: 5px; }
        .radio-circle i, .check-box i {
            font-size: 14px; color: #12361A; display: none;
        }
        
        input[type="radio"]:checked + .radio-circle i,
        input[type="checkbox"]:checked + .check-box i { display: block; }
        
        .select-box {
            background: white; border: none; padding: 12px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 800; color: #12361A; text-align: center;
            appearance: none; cursor: pointer;
        }

        .btn-save-all {
            background: var(--section-bg);
            color: var(--text-dark);
            padding: 15px 60px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 800;
            border: 2px solid var(--sidebar-bg);
            cursor: pointer;
            align-self: flex-end;
            margin-top: 30px;
            transition: 0.3s;
        }
        .btn-save-all:hover { background: var(--sidebar-bg); color: white; }

        /* Responsive */
        @media (max-width: 1000px) {
            .settings-grid { grid-template-columns: 1fr; }
            .settings-section.full-width { grid-column: auto; }
            .profile-form-container { flex-direction: column; align-items: center; }
            .form-fields { width: 100%; }
        }
    
        /* Special style for Logout menu item */
        .sidebar-footer-menu li a[onclick*='showLogoutModal'] {
            color: #12361A !important; /* Soft red for logout */
        }
        .sidebar-footer-menu li a[onclick*='showLogoutModal']:hover {
            background: #fdf2f2 !important;
            color: #c9302c !important;
        }
</style>

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
        color: #12361A !important;
        font-weight: 800 !important;
    }
    .logout-sidebar-link:hover {
        background: rgba(18, 54, 26, 0.1) !important;
    }
</style>
</head>
<body class="<?php echo ($current_theme == 'dark') ? 'dark-mode' : ''; ?>">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Hallo Admin</h2>
            <div class="profile">
                <img src="../assets/<?php echo $_SESSION['admin_foto'] ?? 'placeholder.jpg'; ?>" alt="Profile">
                <div class="profile-info">
                    <span class="name" style="font-weight: bold;"><?php 
                        $name_parts = explode(' ', $_SESSION['admin_name'] ?? 'Admin User');
                        echo htmlspecialchars($name_parts[0]); 
                    ?></span>
                    <span class="role" style="font-weight: bold;"><?php 
                        echo htmlspecialchars(implode(' ', array_slice($name_parts, 1))); 
                    ?></span>
                </div>
            </div>
        </div>
        
        <ul class="menu">
            <li><a href="index.php"><i class="fas fa-th-large"></i> <?php echo __('dashboard'); ?></a></li>
            <li><a href="index.php?action=list"><i class="fas fa-newspaper"></i> <?php echo __('activities'); ?></a></li>
            <li><a href="fasilitas.php"><i class="fas fa-building"></i> <?php echo __('facilities'); ?></a></li>
            <li><a href="bisnis.php"><i class="fas fa-briefcase"></i> <?php echo __('business'); ?></a></li>
            <li><a href="nasabah.php"><i class="fas fa-users"></i> <?php echo __('nasabah'); ?></a></li>
            <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> <?php echo __('transaksi'); ?></a></li>
            <li><a href="laporan.php"><i class="fas fa-file-alt"></i> <?php echo __('laporan'); ?></a></li>
            <li><a href="pengaduan.php"><i class="fas fa-bullhorn"></i> <?php echo __('pengaduan'); ?></a></li>
        </ul>
        
        <ul class="sidebar-footer-menu menu" style="margin-top: auto; padding-bottom: 20px;">
            <li><a href="pengaturan.php" class="active"><i class="fas fa-cog"></i> <?php echo __('settings'); ?></a></li>
            <li><a href="javascript:void(0)" onclick="showLogoutModalFinal()" class="logout-sidebar-link"><i class="fas fa-sign-out-alt"></i> <?php echo __('logout'); ?></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Topbar -->
        <div class="topbar">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="search-bar" placeholder="<?php echo __('search'); ?>">
            </div>
            <div class="top-icons">
                <div style="position:relative;">
                    <i class="fas fa-bell"></i>
                    <div style="position:absolute; top:-2px; right:-2px; background:#4ade80; height:12px; width:12px; border-radius:50%; border:2px solid white;"></div>
                </div>
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>

        <h1 class="page-title"><?php echo __('settings'); ?></h1>

        <form action="proses_pengaturan.php" method="POST" enctype="multipart/form-data">
            <div class="settings-grid">
                <!-- Profile Section -->
                <div class="settings-section full-width">
                    <h2 class="section-title"><?php echo __('profile'); ?></h2>
                    <div class="profile-form-container">
                        <div class="form-fields">
                            <div class="form-group">
                                <label><?php echo __('username'); ?></label>
                                <input type="text" name="username" class="input-box" value="<?php echo htmlspecialchars($admin['username'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo __('fullname'); ?></label>
                                <input type="text" name="nama_lengkap" class="input-box" value="<?php echo htmlspecialchars($admin['nama_lengkap'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo __('password'); ?></label>
                                <input type="password" name="password_profil" class="input-box" placeholder="••••••••">
                            </div>
                        </div>
                        <div class="profile-pic-area">
                            <div class="profile-pic-circle">
                                <img id="preview-photo" src="../assets/<?php echo ($admin['foto_profil'] ? $admin['foto_profil'] : 'placeholder.jpg'); ?>" alt="Profile Picture">
                            </div>
                            <input type="file" name="foto_profil" id="foto-input" style="display:none;" onchange="previewImage()">
                            <button type="button" class="btn-action" onclick="document.getElementById('foto-input').click()"><?php echo __('change_profile'); ?></button>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="settings-section">
                    <h2 class="section-title"><?php echo __('security'); ?></h2>
                    <div class="form-group">
                        <label><?php echo __('old_password'); ?></label>
                        <input type="password" name="old_password" class="input-box">
                    </div>
                    <div class="form-group">
                        <label><?php echo __('new_password'); ?></label>
                        <input type="password" name="new_password" class="input-box">
                    </div>
                    <div class="form-group">
                        <label><?php echo __('confirm_password'); ?></label>
                        <input type="password" name="confirm_password" class="input-box">
                    </div>
                    <button type="button" class="btn-update"><?php echo __('update_password'); ?></button>
                    
                    <label class="checkbox-item" style="margin-top:10px;">
                        <input type="checkbox" name="two_factor" style="display:none;">
                        <div class="check-box"><i class="fas fa-check"></i></div>
                        <?php echo __('2fa'); ?>
                    </label>
                </div>

                <!-- Preferences Section -->
                <div class="settings-section">
                    <h2 class="section-title"><?php echo __('preferences'); ?></h2>
                    <div class="option-group">
                        <span class="option-label"><?php echo __('theme'); ?></span>
                        <div class="radio-group">
                            <label class="radio-item">
                                <input type="radio" name="tema" value="light" <?php echo ($current_theme == 'light') ? 'checked' : ''; ?> style="display:none;">
                                <div class="radio-circle"><i class="fas fa-check"></i></div>
                                <?php echo __('light'); ?>
                            </label>
                            <label class="radio-item">
                                <input type="radio" name="tema" value="dark" <?php echo ($current_theme == 'dark') ? 'checked' : ''; ?> style="display:none;">
                                <div class="radio-circle"><i class="fas fa-check"></i></div>
                                <?php echo __('dark'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="option-group">
                        <span class="option-label"><?php echo __('language'); ?></span>
                        <select name="bahasa" class="select-box">
                            <option value="id" <?php echo ($current_lang == 'id') ? 'selected' : ''; ?>>Bahasa Indonesia</option>
                            <option value="en" <?php echo ($current_lang == 'en') ? 'selected' : ''; ?>>English</option>
                        </select>
                    </div>
                    <div class="option-group">
                        <span class="option-label"><?php echo __('notif'); ?></span>
                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="notif_bisnis" checked style="display:none;">
                                <div class="check-box"><i class="fas fa-check"></i></div>
                                <?php echo __('notif_biz'); ?>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="notif_pesan" checked style="display:none;">
                                <div class="check-box"><i class="fas fa-check"></i></div>
                                <?php echo __('notif_msg'); ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" class="btn-save-all"><?php echo __('save_changes'); ?></button>
            </div>
        </form>

    </div>

    

<!-- Final Logout Modal -->
<div class="modal-overlay-final" id="logoutOverlayFinal">
    <div class="modal-content-final">
        <i class="fas fa-sign-out-alt"></i>
        <h3>Konfirmasi Log Out</h3>
        <p>Apakah anda yakin ingin logout dari panel admin?</p>
        <div class="modal-footer-final">
            <button class="btn-final btn-tidak-final" onclick="hideLogoutModalFinal()">Tidak</button>
            <button class="btn-final btn-ya-final" onclick="window.location.href='logout.php'">Ya</button>
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
</body>
</html>
