<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$page_title = 'Bisnis Warga';
if ($action == 'tambah') $page_title = 'Tambah Bisnis Warga';
if ($action == 'edit') $page_title = 'Edit Bisnis Warga';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo $page_title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #bacc98;
            --main-bg: #ffffff;
            --text-dark: #12361A;
            --input-bg: #e9f0df;
            --btn-green: #06331a;
            --btn-light-green: #dce5ce;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--main-bg); color: var(--text-dark); overflow-x: hidden; }

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
            overflow-y: auto;
        }
        .sidebar::-webkit-scrollbar { display: none; }
        .sidebar { -ms-overflow-style: none; scrollbar-width: none; }
        .sidebar-header { padding: 0 20px; margin-bottom: 20px; }
        .sidebar-header h2 { font-size: 20px; font-weight: 800; color: #164024; margin-bottom: 20px; }
        
        .profile { display: flex; align-items: center; gap: 12px; margin-bottom: 25px; }
        .profile img { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; }
        .profile-info { display: flex; flex-direction: column; }
        .profile-info .name { font-size: 13.5px; font-weight: 500; color: #1a4220; }
        .profile-info .role { font-size: 13.5px; font-weight: 500; color: #1a4220; }
        
        .menu { list-style: none; flex-grow: 1; }
        .menu li { margin-bottom: 4px; padding-left: 15px; }
        .menu li a {
            display: flex; align-items: center; gap: 12px; padding: 10px 18px;
            text-decoration: none; color: #3b523f; font-weight: 800; font-size: 14px;
            border-radius: 50px 0 0 50px;
            transition: 0.2s;
        }
        .menu li a.active { background: #ffffff; color: #1a4220; }
        .menu li a i { font-size: 18px; width: 22px; text-align: center; }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .search-container { position: relative; width: 100%; max-width: 600px; }
        .search-container i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #4e6353; }
        .search-bar {
            width: 100%; background: #e0ddd8; padding: 15px 20px 15px 50px;
            border: none; border-radius: 50px; font-size: 15px; font-weight: 600; color: #4e6353;
            outline: none;
        }
        .top-icons { display: flex; align-items: center; gap: 20px; color: #324c3a; font-size: 22px; }

        /* List View (Photo 2) */
        .section-box { margin-bottom: 50px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        h1.page-title { font-size: 28px; font-weight: 900; color: #072210; letter-spacing: -0.5px; margin-bottom: 0; }
        .btn-add { background: var(--btn-light-green); color: #0e2914; padding: 12px 24px; border-radius: 50px; font-weight: 800; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: 0.3s; }

        .cards-row { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 20px; }
        .info-card { background: var(--btn-light-green); border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; }
        .card-img { position: relative; height: 220px; }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }
        .card-badge-left { position: absolute; top: 15px; left: 15px; background: white; color: #28442a; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
        
        .card-body { padding: 25px; flex-grow: 1; }
        .info-card h3 { font-size: 20px; font-weight: 800; margin-bottom: 6px; }
        .info-card .owner-name { font-size: 13px; font-weight: 800; margin-bottom: 4px; }
        .info-card .address { font-size: 11px; color: #526f58; font-weight: 700; margin-bottom: 15px; }
        .info-card p { font-size: 12px; color: #526f58; line-height: 1.6; margin-bottom: 25px; }
        
        .card-actions { display: flex; gap: 12px; }
        .btn-card { flex: 1; padding: 12px; text-align: center; font-size: 13px; font-weight: 800; border-radius: 12px; text-decoration: none; transition: 0.3s; }
        .btn-edit-card { background: white; color: #0b2512; border: 2px solid #0b2512; }
        .btn-delete-card { background: #032b13; color: white; border: 2px solid #032b13; }

        /* Form View (Photo 1) */
        .form-container { width: 100%; max-width: 900px; margin: 0 auto; text-align: center; }
        .btn-back { position: absolute; top: 0; left: 0; background: #032b13; color: white; padding: 8px 16px; border-radius: 50px; text-decoration: none; font-size: 12px; font-weight: 700; }
        .form-title { font-size: 32px; font-weight: 900; color: #072210; margin-bottom: 60px; }
        
        .form-table { width: 100%; border-collapse: separate; border-spacing: 0 20px; text-align: left; }
        .form-table td { vertical-align: top; padding: 5px 0; }
        .label-col { width: 180px; font-size: 16px; font-weight: 800; color: #072210; padding-top: 15px !important; }
        .colon-col { width: 30px; font-size: 16px; font-weight: 800; color: #072210; padding-top: 15px !important; }
        
        .input-box { background: var(--input-bg); border: none; padding: 18px 25px; border-radius: 20px; width: 100%; font-size: 15px; font-weight: 600; color: #072210; outline: none; }
        textarea.input-box { min-height: 120px; resize: none; }
        
        .pill-group { display: flex; gap: 15px; }
        .form-pill { background: var(--input-bg); color: #43644a; padding: 12px 25px; border-radius: 50px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; transition: 0.3s; }
        .form-pill.active { background: #a6b98b; color: #0b2512; }
        
        .upload-area { background: var(--input-bg); border-radius: 25px; width: 100%; height: 350px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
        .upload-area img { width: 100%; height: 100%; object-fit: cover; }
        .btn-upload { background: #032b13; color: white; padding: 12px 30px; border-radius: 50px; font-weight: 700; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 10px; border: none; position: relative; z-index: 2; }
        
        .btn-submit { background: #032b13; color: white; padding: 18px 60px; border-radius: 12px; font-weight: 800; font-size: 18px; border: none; cursor: pointer; margin-top: 40px; transition: 0.3s; }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }

        .pagination { display: flex; justify-content: flex-end; gap: 8px; margin-top: 40px; }
        .page-btn { background: var(--btn-light-green); color: #37543f; padding: 8px 12px; border-radius: 8px; font-weight: 800; font-size: 13px; text-decoration: none; border: none; }
        .page-btn.active { background: #c5d3af; }
    
        
        .logout-modal {
            background: white; padding: 40px; border-radius: 20px; width: 400px;
            text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transform: scale(0.8); transition: 0.3s;
        }
        .modal-overlay.active { display: flex; }
        .modal-overlay.active .logout-modal { transform: scale(1); }
        .logout-modal i { font-size: 50px; color: #12361A; margin-bottom: 20px; }
        .logout-modal h3 { font-size: 20px; font-weight: 800; color: #12361A; margin-bottom: 15px; }
        .logout-modal p { font-size: 15px; color: #4a6d41; margin-bottom: 30px; font-weight: 500; }
        .modal-btns { display: flex; gap: 15px; justify-content: center; }
        .btn-modal {
            padding: 12px 35px; border-radius: 50px; border: none; font-weight: 800; cursor: pointer; transition: 0.2s; font-size: 14px;
        }
        .btn-ya { background: #12361A; color: white; }
        .btn-ya:hover { background: #0d2a14; transform: translateY(-2px); }
        .btn-tidak { background: #e9f0df; color: #12361A; }
        .btn-tidak:hover { background: #d9e6cc; transform: translateY(-2px); }

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
<body>

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
            <li><a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="index.php?action=list"><i class="fas fa-newspaper"></i> Informasi Kegiatan</a></li>
            <li><a href="fasilitas.php"><i class="fas fa-building"></i> Fasilitas Dusun</a></li>
            <li><a href="bisnis.php" class="active"><i class="fas fa-briefcase"></i> Bisnis Warga</a></li>
            <li><a href="nasabah.php"><i class="fas fa-users"></i> Nasabah</a></li>
            <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi BSP</a></li>
            <li><a href="laporan.php"><i class="fas fa-file-alt"></i> Laporan BSP</a></li>
            <li><a href="pengaduan.php"><i class="fas fa-bullhorn"></i> Pengaduan</a></li>
        </ul>
        
        <ul class="sidebar-footer-menu menu" style="margin-top: auto; padding-bottom: 20px;">
            <li><a href="pengaturan.php"><i class="fas fa-cog"></i> Pengaturan</a></li>
            <li><a href="javascript:void(0)" onclick="showLogoutModalFinal()" class="logout-sidebar-link"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Topbar -->
        <div class="topbar">
            <form action="" method="GET" class="search-container">
                <input type="hidden" name="action" value="list">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search-bar" placeholder="Cari bisnis..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </form>
            <div class="top-icons">
                <div style="position:relative;">
                    <i class="fas fa-bell" style="color: #43644a;"></i>
                    <div style="position:absolute; top:-2px; right:-2px; background:#4ade80; height:12px; width:12px; border-radius:50%; border:2px solid white;"></div>
                </div>
                <i class="fas fa-ellipsis-v" style="color: #43644a;"></i>
            </div>
        </div>

        <?php if ($action == 'list'): ?>
        <!-- Section: Bisnis Warga (Photo 2) -->
        <div class="section-box">
            <div class="section-header">
                <h1 class="page-title">Bisnis Warga</h1>
                <a href="?action=tambah" class="btn-add"><i class="fas fa-plus"></i> Tambah Bisnis</a>
            </div>
            
            <div class="cards-row">
                <?php
                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                $where = "";
                if ($search != "") {
                    $where = " WHERE nama_usaha LIKE '%$search%' OR nama_pengusaha LIKE '%$search%' OR jenis_usaha LIKE '%$search%' ";
                }
                $q = mysqli_query($conn, "SELECT * FROM t_bisnis_desa $where ORDER BY created_at DESC");
                if (mysqli_num_rows($q) == 0) {
                    echo '<p style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #526f58; font-weight: 600;">Data tidak ditemukan.</p>';
                }
                while($b = mysqli_fetch_array($q)) {
                    $icon = 'fas fa-store';
                    $jenis = strtolower($b['jenis_usaha']);
                    if (strpos($jenis, 'tani') !== false || strpos($jenis, 'padi') !== false) $icon = 'fas fa-seedling';
                    else if (strpos($jenis, 'ternak') !== false) $icon = 'fas fa-truck'; // Matching photo 2 icon
                    else if (strpos($jenis, 'jasa') !== false) $icon = 'fas fa-concierge-bell';

                    echo '<div class="info-card">';
                    echo '  <div class="card-img">';
                    echo '      <div class="card-badge-left"><i class="'.$icon.'"></i></div>';
                    echo '      <img src="../assets/'.($b['foto']?$b['foto']:'placeholder.jpg').'" alt="Foto">';
                    echo '  </div>';
                    echo '  <div class="card-body">';
                    echo '      <h3>'.htmlspecialchars($b['nama_usaha']).'</h3>';
                    echo '      <div class="owner-name">'.htmlspecialchars($b['nama_pengusaha']).'</div>';
                    echo '      <div class="address">'.htmlspecialchars($b['alamat']).'</div>';
                    echo '      <p>'.htmlspecialchars(substr($b['keterangan'], 0, 160)).'...</p>';
                    echo '      <div class="card-actions">';
                    echo '          <a href="?action=edit&id='.$b['id_bisnis'].'" class="btn-card btn-edit-card">Edit Informasi</a>';
                    echo '          <a href="proses_bisnis.php?act=del&id='.$b['id_bisnis'].'" class="btn-card btn-delete-card" onclick="return confirm(\'Hapus bisnis ini?\')">Hapus Bisnis</a>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
                ?>
            </div>
            
            <a href="#" style="text-align:right; color:#5d7561; font-weight:700; text-decoration:none; display:block; margin-top:20px;">Lihat semua ></a>
        </div>

        <?php else: 
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $edit = null;
            if($action == 'edit' && $id) {
                $q_edit = mysqli_query($conn, "SELECT * FROM t_bisnis_desa WHERE id_bisnis='$id'");
                $edit = mysqli_fetch_array($q_edit);
            }
        ?>
        <!-- Section: Tambah/Edit Bisnis (Photo 1) -->
        <div class="section-box" style="position:relative;">
            <div class="form-container">
                <a href="?action=list" class="btn-back"><i class="fas fa-chevron-left"></i> Kembali</a>
                <h1 class="form-title"><?php echo $action == 'edit' ? 'Edit' : 'Tambah'; ?> Bisnis Warga</h1>
                
                <form action="proses_bisnis.php?act=<?php echo $action == 'edit' ? 'edit' : 'add'; ?>" method="POST" enctype="multipart/form-data">
                    <?php if($action == 'edit'): ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="foto_lama" value="<?php echo $edit['foto']; ?>">
                    <?php endif; ?>

                    <table class="form-table">
                        <tr>
                            <td class="label-col">Nama Usaha</td>
                            <td class="colon-col">:</td>
                            <td><input type="text" name="nama_usaha" class="input-box" value="<?php echo $edit ? $edit['nama_usaha'] : ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td class="label-col">Nama Pengusaha</td>
                            <td class="colon-col">:</td>
                            <td><input type="text" name="nama_pengusaha" class="input-box" value="<?php echo $edit ? $edit['nama_pengusaha'] : ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td class="label-col">Jenis Usaha</td>
                            <td class="colon-col">:</td>
                            <td>
                                <div class="pill-group">
                                    <?php 
                                    $jenis_list = ['Pertanian', 'Peternakan', 'Jasa', 'DLL'];
                                    $current_jenis = $edit ? $edit['jenis_usaha'] : 'Pertanian';
                                    foreach($jenis_list as $j) {
                                        $active = ($current_jenis == $j) ? 'active' : '';
                                        echo '<button type="button" class="form-pill '.$active.'" onclick="setJenis(\''.$j.'\', this)">'.$j.'</button>';
                                    }
                                    ?>
                                    <input type="hidden" name="jenis_usaha" id="jenis_usaha" value="<?php echo $current_jenis; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Keterangan</td>
                            <td class="colon-col">:</td>
                            <td><textarea name="keterangan" class="input-box" required><?php echo $edit ? $edit['keterangan'] : ''; ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="label-col">Alamat</td>
                            <td class="colon-col">:</td>
                            <td><textarea name="alamat" class="input-box" style="min-height:100px;" required><?php echo $edit ? $edit['alamat'] : ''; ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="label-col">No. Telp</td>
                            <td class="colon-col">:</td>
                            <td><input type="text" name="no_telp" class="input-box" value="<?php echo $edit ? $edit['no_telp'] : ''; ?>" required></td>
                        </tr>
                        <tr>
                            <td class="label-col">Foto</td>
                            <td class="colon-col">:</td>
                            <td>
                                <div class="upload-area">
                                    <div id="preview-container" style="width:100%; height:100%; position:absolute; top:0; left:0; display:<?php echo ($edit && $edit['foto']) ? 'block' : 'none'; ?>;">
                                        <img id="preview-img" src="<?php echo ($edit && $edit['foto']) ? '../assets/'.$edit['foto'] : ''; ?>">
                                    </div>
                                    <button type="button" class="btn-upload" onclick="document.getElementById('foto-input').click()">
                                        Pilih Foto <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <input type="file" name="foto" id="foto-input" style="display:none;" onchange="previewFile()">
                                </div>
                            </td>
                        </tr>
                    </table>

                    <button type="submit" class="btn-submit"><?php echo $action == 'edit' ? 'Simpan' : 'Tambah'; ?> Bisnis</button>
                </form>
            </div>
        </div>

        <script>
            function setJenis(val, btn) {
                document.querySelectorAll('.form-pill').forEach(p => p.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('jenis_usaha').value = val;
            }

            function previewFile() {
                const preview = document.getElementById('preview-img');
                const container = document.getElementById('preview-container');
                const file = document.getElementById('foto-input').files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                    container.style.display = 'block';
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                    container.style.display = 'none';
                }
            }
        </script>
        <?php endif; ?>

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