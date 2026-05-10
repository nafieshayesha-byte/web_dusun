<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$page_title = 'Fasilitas Dusun';
if ($action == 'tambah') $page_title = 'Tambah Fasilitas';
if ($action == 'edit') $page_title = 'Edit Fasilitas';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fasilitas Dusun</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #bfd5a3;
            --main-bg: #fff;
            --text-dark: #223f20;
            --input-bg: #dce5ce;
            --btn-green: #032b13;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--main-bg); color: var(--text-dark); overflow-x: hidden; }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #bacc98;
            padding: 25px 0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar::-webkit-scrollbar { display: none; }
        .sidebar { -ms-overflow-style: none; scrollbar-width: none; }

        .sidebar-header { padding: 0 20px; margin-bottom: 20px; }
        .sidebar-header h2 { font-size: 20px; font-weight: 800; color: #164024; margin-bottom: 20px; letter-spacing: 0.5px;}
        
        .profile { display: flex; align-items: center; gap: 12px; margin-bottom: 25px; }
        .profile img { width: 64px; height: 64px; border-radius: 50%; object-fit: cover; }
        .profile-info { display: flex; flex-direction: column; gap: 3px; }
        .profile-info .name { font-size: 13.5px; font-weight: 500; color: #1a4220; }
        .profile-info .role { font-size: 13.5px; font-weight: 500; color: #1a4220; }
        
        .menu { list-style: none; flex-grow: 1; }
        .menu li { margin-bottom: 4px; padding-left: 15px; }
        .menu li a {
            display: flex; align-items: center; gap: 12px; padding: 10px 18px;
            text-decoration: none; color: #3b523f; font-weight: 800; font-size: 14px;
            transition: all 0.2s;
            border-radius: 50px 0 0 50px;
        }
        .menu li a i { font-size: 18px; color: #3b523f; width: 22px; text-align: center; }
        .menu li a.active { 
            background: #ffffff; 
            color: #1a4220; 
        }
        .menu li a.active i { color: #1a4220; }
        .menu li a:hover:not(.active) { background: rgba(255,255,255,0.1); }

        /* Sidebar Submenu */
        .menu-parent > a .chevron { font-size: 10px; margin-left: auto; transition: transform 0.3s ease; }
        .menu-parent.open > a .chevron { transform: rotate(180deg); }
        .submenu {
            list-style: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, opacity 0.3s ease;
            opacity: 0;
            padding-left: 15px;
        }
        .menu-parent.open .submenu {
            max-height: 200px;
            opacity: 1;
        }
        .submenu li { margin-bottom: 2px; padding-left: 0; }
        .submenu li a {
            font-size: 13px;
            font-weight: 700;
            padding: 8px 18px 8px 34px;
            color: #4a6550;
            border-radius: 50px 0 0 50px;
        }
        .submenu li a.active {
            background: #ffffff;
            color: #1a4220;
            font-weight: 800;
        }
        .submenu li a:hover:not(.active) {
            background: rgba(255,255,255,0.15);
        }

        .sidebar-footer-menu { list-style: none; margin-top: auto; padding-bottom: 15px; }
        .sidebar-footer-menu li { margin-bottom: 2px; padding-left: 15px; }
        .sidebar-footer-menu li a { 
            display: flex; align-items: center; gap: 12px; padding: 10px 18px;
            text-decoration: none; color: #3b523f; font-weight: 800; font-size: 14px;
        }
        .sidebar-footer-menu li a i { font-size: 18px; color: #3b523f; width: 22px; text-align: center; }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Topbar */
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .search-container { position: relative; width: 100%; max-width: 600px; }
        .search-container i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #4e6353; font-size: 18px; }
        .search-bar {
            width: 100%; background: #e0ddd8; padding: 15px 20px 15px 50px;
            border: none; border-radius: 50px; font-size: 15px; font-weight: 600; color: #4e6353;
            outline: none;
        }
        .search-bar::placeholder { color: #7f8c82; }
        .top-icons { display: flex; align-items: center; gap: 20px; font-size: 22px; cursor: pointer; }
        .bell-wrap { position: relative; }
        .bell-dot { position: absolute; top: -2px; right: -2px; background: #4ade80; height: 12px; width: 12px; border-radius: 50%; border: 2px solid white; }

        /* Sections */
        .section-box { margin-bottom: 50px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        h1.page-title { font-size: 28px; font-weight: 900; color: #072210; letter-spacing: -0.5px; margin-bottom: 0; }

        /* Cards Grid */
        .cards-row { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 20px; }
        .info-card { background: #dce5ce; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 5px 15px rgba(0,0,0,0.03); }
        .card-img { position: relative; height: 180px; width: 100%; }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }
        .card-badge-left { position: absolute; top: 15px; left: 15px; background: white; color: #28442a; font-size: 10px; font-weight: 800; padding: 4px 12px; border-radius: 50px; }
        
        .card-body { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
        .card-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .meta-unit { color: #53775b; font-size: 12px; font-weight: 800; }
        
        .info-card h3 { font-size: 18px; font-weight: 800; color: #0d2a14; margin-bottom: 12px; line-height: 1.3; }
        .info-card p { font-size: 12px; color: #526f58; font-weight: 500; line-height: 1.6; margin-bottom: 20px; flex-grow: 1; }
        
        .card-actions { display: flex; gap: 10px; }
        .btn-card { flex: 1; padding: 10px; text-align: center; font-size: 12px; font-weight: 700; border-radius: 10px; cursor: pointer; border: none; transition: 0.3s; }
        .btn-edit { background: white; color: #0b2512; border: 2px solid #0b2512; }
        .btn-delete { background: #032b13; color: white; }
        .btn-card:hover { opacity: 0.8; transform: translateY(-2px); }

        /* Buttons */
        .btn-add { background: #dce5ce; color: #0e2914; border: none; padding: 12px 24px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; text-decoration: none; }
        .btn-add:hover { background: #c5d3af; }
        
        .lihat-semua { text-align: right; color: #5d7561; font-weight: 700; font-size: 14px; text-decoration: none; display: block; margin-bottom: 40px; }

        /* Form Area */
        .form-table { width: 100%; border-collapse: separate; border-spacing: 0 20px; }
        .form-table td { vertical-align: top; }
        .form-table td.label-col { width: 180px; font-size: 15px; font-weight: 800; color: #0b2512; padding-top: 15px; }
        .form-table td.colon-col { width: 20px; font-size: 16px; font-weight: 800; color: #0b2512; padding-top: 15px; text-align: center; }
        
        .input-box { background: var(--input-bg); border: none; padding: 15px 20px; border-radius: 12px; width: 100%; font-size: 14px; color: #0b2512; font-weight: 600; outline: none; }
        .input-box.w-auto { width: auto; min-width: 200px; display: inline-block; }
        textarea.input-box { min-height: 100px; resize: none; }
        .img-placeholder { width: 100%; height: 200px; background: var(--input-bg); border-radius: 12px; }

        .submit-wrap { text-align: center; margin-top: 40px; margin-bottom: 60px; }
        .btn-submit { background: #032b13; color: white; padding: 14px 40px; border-radius: 10px; font-weight: 700; font-size: 15px; border: none; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background: #083c1d; transform: translateY(-2px); }

        .btn-kembali { background: #032b13; color: white; display: inline-flex; align-items: center; padding: 8px 16px; border-radius: 50px; text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
        .btn-kembali i { margin-right: 8px; font-size: 10px; }

        
        

        /* Empty State */
        .empty-state { text-align: center; padding: 60px 20px; color: #7f8c82; }
        .empty-state i { font-size: 48px; margin-bottom: 15px; color: #c5d3af; }
        .empty-state p { font-size: 15px; font-weight: 600; }
    
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
            <li><a href="fasilitas.php" class="active"><i class="fas fa-building"></i> Fasilitas Dusun</a></li>
            <li><a href="bisnis.php"><i class="fas fa-briefcase"></i> Bisnis Warga</a></li>
            <li><a href="nasabah.php"><i class="fas fa-users"></i> Nasabah</a></li>
            <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi BSP</a></li>
            <li><a href="laporan.php"><i class="fas fa-file-alt"></i> Laporan BSP</a></li>
            <li><a href="pengaduan.php"><i class="fas fa-bullhorn"></i> Pengaduan</a></li>
        </ul>
        
        <ul class="sidebar-footer-menu menu">
            <li><a href="pengaturan.php"><i class="fas fa-cog"></i> Pengaturan</a></li>
            <li><a href="#" onclick="showLogoutModalFinal()"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Topbar -->
        <div class="topbar">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="search-bar" placeholder="Cari fasilitas...">
            </div>
            <div class="top-icons">
                <div class="bell-wrap">
                    <i class="fas fa-bell"></i>
                    <div class="bell-dot"></div>
                </div>
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>

        <?php if ($action == 'list'): ?>
        <!-- Section: Fasilitas Dusun List -->
        <div class="section-box">
            <div class="section-header">
                <h1 class="page-title">Fasilitas Dusun</h1>
                <a href="?action=tambah" class="btn-add" style="text-decoration:none;"><i class="fas fa-plus"></i> Tambah Fasilitas</a>
            </div>
            
            <div class="cards-row">
                <?php
                $q = mysqli_query($conn, "SELECT * FROM t_fasilitas_dusun ORDER BY created_at DESC");
                if($q && mysqli_num_rows($q) > 0) {
                    while($f = mysqli_fetch_array($q)) {
                        $unit_text = $f['unit'] ? $f['unit'] . ' Unit' : '-';
                        
                        echo '<div class="info-card">';
                        echo '  <div class="card-img">';
                        if($f['penanggung_jawab']) {
                            echo '      <span class="card-badge-left">PJ: '.htmlspecialchars($f['penanggung_jawab']).'</span>';
                        }
                        echo '      <img src="../assets/'.($f['foto']?$f['foto']:'placeholder.jpg').'" alt="Foto" onerror="this.src=\'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80\'">';
                        echo '  </div>';
                        echo '  <div class="card-body">';
                        echo '      <div class="card-meta">';
                        echo '          <span class="meta-unit"><i class="fas fa-building" style="margin-right:5px;"></i> '.$unit_text.'</span>';
                        echo '      </div>';
                        echo '      <h3>'.htmlspecialchars($f['nama_fasilitas']).'</h3>';
                        echo '      <p>'.htmlspecialchars(substr($f['keterangan'] ?: 'Tidak ada keterangan.', 0, 150)).'</p>';
                        echo '      <div class="card-actions">';
                        echo '          <a href="?action=edit&id='.$f['id_fasilitas'].'" class="btn-card btn-edit" style="text-decoration:none;">Edit Fasilitas</a>';
                        echo '          <a href="proses_fasilitas.php?act=del&id='.$f['id_fasilitas'].'" class="btn-card btn-delete" style="text-decoration:none;" onclick="return confirm(\'Hapus fasilitas ini?\')">Hapus Fasilitas</a>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="empty-state" style="grid-column: 1/-1;"><i class="fas fa-building"></i><p>Belum ada data fasilitas.</p></div>';
                }
                ?>
            </div>
        </div>
        <?php else: ?>
        
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $edit = null;
        if($action == 'edit' && $id) {
            $q_edit = mysqli_query($conn, "SELECT * FROM t_fasilitas_dusun WHERE id_fasilitas='$id'");
            $edit = mysqli_fetch_array($q_edit);
        }
        ?>
        <!-- Section: Tambah/Edit Fasilitas Form -->
        <div class="section-box">
            <a href="?action=list" class="btn-kembali"><i class="fas fa-chevron-left"></i> Kembali</a>
            <div style="text-align: center; margin-bottom: 40px; margin-top:20px;">
                <h1 class="page-title" style="margin-bottom:0;"><?php echo $action == 'edit' ? 'Edit ' : 'Tambah '; ?>Fasilitas Dusun</h1>
            </div>
            
            <form action="proses_fasilitas.php?act=<?php echo $action == 'edit' ? 'edit' : 'add'; ?>" method="POST" enctype="multipart/form-data">
                <?php if($action == 'edit'): ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="foto_lama" value="<?php echo $edit['foto']; ?>">
                <?php endif; ?>

                <table class="form-table">
                    <tr>
                        <td class="label-col">Nama Fasilitas</td>
                        <td class="colon-col">:</td>
                        <td><input type="text" name="nama_fasilitas" class="input-box" placeholder="Masukkan nama fasilitas" value="<?php echo $edit ? htmlspecialchars($edit['nama_fasilitas']) : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-col">Foto</td>
                        <td class="colon-col">:</td>
                        <td>
                            <div class="img-placeholder" style="position: relative; display: flex; align-items: center; justify-content: center; overflow:hidden;">
                                <?php if($edit && $edit['foto']): ?>
                                <img src="../assets/<?php echo $edit['foto']; ?>" style="width:100%;height:100%;object-fit:cover;position:absolute;">
                                <label style="position:relative; z-index:10; background:rgba(255,255,255,0.7); padding:8px 16px; border-radius:50px; cursor:pointer; font-weight:700; font-size:12px;">Ubah File <input type="file" name="foto" style="display:none"></label>
                                <?php else: ?>
                                <label style="cursor:pointer; font-weight:700; font-size:12px; color:#5d7561;">Pilih File <input type="file" name="foto" style="display:none" required></label>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-col">Jumlah Unit</td>
                        <td class="colon-col">:</td>
                        <td><input type="number" name="unit" class="input-box w-auto" placeholder="Contoh: 1" min="0" value="<?php echo $edit ? $edit['unit'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td class="label-col">Penanggung Jawab</td>
                        <td class="colon-col">:</td>
                        <td><input type="text" name="penanggung_jawab" class="input-box" placeholder="Nama penanggung jawab" value="<?php echo $edit ? htmlspecialchars($edit['penanggung_jawab']) : ''; ?>"></td>
                    </tr>
                    <tr>
                        <td class="label-col">Keterangan</td>
                        <td class="colon-col">:</td>
                        <td><textarea name="keterangan" class="input-box" placeholder="Deskripsi fasilitas"><?php echo $edit ? htmlspecialchars($edit['keterangan']) : ''; ?></textarea></td>
                    </tr>
                </table>

                <div class="submit-wrap">
                    <button type="submit" class="btn-submit"><?php echo $action == 'edit' ? 'Simpan' : 'Tambah'; ?> Fasilitas</button>
                </div>
            </form>
        </div>
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
