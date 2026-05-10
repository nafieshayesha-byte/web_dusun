<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? $_GET['id'] : null;
$data = null;

if ($id) {
    $id = mysqli_real_escape_string($conn, $id);
    $q = mysqli_query($conn, "SELECT p.*, a.nama_lengkap as admin_name FROM t_pengaduan p LEFT JOIN t_admin a ON p.id_admin = a.id_admin WHERE id_pengaduan = '$id'");
    $data = mysqli_fetch_assoc($q);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pengaduan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #bacc98;
            --main-bg: #ffffff;
            --text-dark: #12361A;
            --input-bg: #e9f0df;
            --btn-green: #06331a;
            --accent-green: #0d2a14;
            --blue: #426cf5;
            --orange: #ff8c00;
            --green: #4a6d41;
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
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .search-container { position: relative; width: 100%; max-width: 600px; }
        .search-container i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #4e6353; }
        .search-bar {
            width: 100%; background: #e1e3e1; padding: 15px 20px 15px 50px;
            border: none; border-radius: 50px; font-size: 15px; font-weight: 600; color: #4e6353;
            outline: none;
        }
        .top-icons { display: flex; align-items: center; gap: 20px; color: #324c3a; font-size: 22px; }

        /* Section */
        h1.page-title { font-size: 28px; font-weight: 900; color: #12361A; margin-bottom: 35px; }
        
        /* Form Pengaduan */
        .pengaduan-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 800px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 180px 30px 1fr;
            align-items: center;
        }
        .form-row label { font-size: 16px; font-weight: 800; color: #12361A; }
        .form-row .colon { font-weight: 800; color: #12361A; }
        
        .input-box {
            background: #e9f0df;
            border: none;
            padding: 15px 25px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 700;
            color: #4a6550;
            outline: none;
            width: 100%;
        }
        .input-box::placeholder { color: #a5b9a8; }
        textarea.input-box { min-height: 150px; resize: none; padding-top: 15px; line-height: 1.6; }

        .pill-group { display: flex; gap: 15px; flex-wrap: wrap; }
        .pill-btn {
            padding: 10px 25px;
            border-radius: 50px;
            border: none;
            font-size: 14px;
            font-weight: 800;
            color: #4a6550;
            background: #e9f0df;
            cursor: pointer;
            transition: 0.3s;
        }
        .pill-btn.active { background: var(--green); color: white; }
        
        .status-btn {
            padding: 10px 25px;
            border-radius: 12px;
            border: none;
            font-size: 14px;
            font-weight: 800;
            color: white;
            cursor: pointer;
            transition: 0.3s;
            opacity: 0.5;
        }
        .status-btn.diterima { background: var(--blue); }
        .status-btn.diproses { background: var(--orange); }
        .status-btn.selesai { background: var(--green); }
        .status-btn.active { opacity: 1; }

        .foto-area {
            width: 100%;
            max-width: 500px;
            border-radius: 20px;
            overflow: hidden;
            border: 2px solid #e9f0df;
        }
        .foto-area img { width: 100%; display: block; }

        .btn-simpan {
            background: #06331a;
            color: white;
            padding: 15px 50px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 18px;
            border: none;
            cursor: pointer;
            align-self: center;
            margin-top: 30px;
            transition: 0.3s;
        }
        .btn-simpan:hover { opacity: 0.9; transform: translateY(-2px); }

        /* Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
            border: 2px solid #bacc98;
            border-radius: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th {
            background: #e9f0df;
            padding: 18px 15px;
            font-size: 13px;
            font-weight: 800;
            color: #12361A;
            text-align: center;
            border: 1px solid #bacc98;
        }
        td {
            padding: 15px;
            font-size: 13px;
            font-weight: 700;
            color: #12361A;
            text-align: center;
            border: 1px solid #bacc98;
        }
        .status-badge {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            color: white;
            display: inline-block;
        }
        .status-badge.diterima { background: var(--blue); }
        .status-badge.diproses { background: var(--orange); }
        .status-badge.selesai { background: var(--green); }

        /* Complaint Cards */
        .cards-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .complaint-card {
            background: #f9fbf2;
            border: 2px solid #e9f0df;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: 0.3s;
        }
        .complaint-card:hover { border-color: var(--sidebar-bg); transform: translateY(-5px); }
        .complaint-card h3 { font-size: 18px; font-weight: 800; color: var(--text-dark); }
        .complaint-card .meta { font-size: 13px; font-weight: 700; color: #62836b; display: flex; justify-content: space-between; }
        .complaint-card .reporter { font-size: 14px; font-weight: 800; color: #12361A; }
        .complaint-card .footer { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 10px; }
        .btn-view-card {
            background: var(--btn-green);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c5d3af; border-radius: 10px; }
    
        
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
            <li><a href="bisnis.php"><i class="fas fa-briefcase"></i> Bisnis Warga</a></li>
            <li><a href="nasabah.php"><i class="fas fa-users"></i> Nasabah</a></li>
            <li><a href="transaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi BSP</a></li>
            <li><a href="laporan.php"><i class="fas fa-file-alt"></i> Laporan BSP</a></li>
            <li><a href="pengaduan.php" class="active"><i class="fas fa-bullhorn"></i> Pengaduan</a></li>
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
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="search-bar" placeholder="Cari">
            </div>
            <div class="top-icons">
                <div style="position:relative;">
                    <i class="fas fa-bell"></i>
                    <div style="position:absolute; top:-2px; right:-2px; background:#4ade80; height:12px; width:12px; border-radius:50%; border:2px solid white;"></div>
                </div>
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>

        <?php if ($action == 'list'): ?>
        <h1 class="page-title">Daftar Pengaduan</h1>
        
        <!-- Summary Cards (Boxes) -->
        <div class="cards-row">
            <?php
            $q_cards = mysqli_query($conn, "SELECT * FROM t_pengaduan ORDER BY created_at DESC LIMIT 6");
            while ($c = mysqli_fetch_assoc($q_cards)) {
                $status = strtolower($c['status'] ?? 'diterima');
                $kategori = strtoupper($c['kategori'] ?? 'DLL');
                echo '<div class="complaint-card">';
                echo '  <div class="meta">';
                echo '      <span>'.date('d M Y', strtotime($c['created_at'])).'</span>';
                echo '      <span style="color:'.($status=='selesai'?'#4a6d41':'#ff8c00').'">'.strtoupper($status).'</span>';
                echo '  </div>';
                echo '  <h3>'.htmlspecialchars($c['judul_pengaduan'] ?? '').'</h3>';
                echo '  <div class="reporter"><i class="fas fa-user-circle"></i> '.htmlspecialchars($c['nama_pelapor'] ?? '').'</div>';
                echo '  <div class="footer">';
                echo '      <span style="font-size:11px; font-weight:800; color:#8fa696;">'.htmlspecialchars($kategori ?? '').'</span>';
                echo '      <a href="?action=edit&id='.$c['id_pengaduan'].'" class="btn-view-card">Detail &rarr;</a>';
                echo '  </div>';
                echo '</div>';
            }
            ?>
        </div>

        <h2 class="table-title">Tabel Semua Pengaduan</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>Judul Pengaduan</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM t_pengaduan ORDER BY created_at DESC");
                    $no = 1;
                    if (mysqli_num_rows($q) > 0) {
                        while ($row = mysqli_fetch_assoc($q)) {
                            $status = strtolower($row['status'] ?? 'diterima');
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['created_at'])) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_pelapor'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['judul_pengaduan'] ?? '') . "</td>";
                            echo "<td>" . strtoupper(htmlspecialchars($row['kategori'] ?? '')) . "</td>";
                            echo "<td><span class='status-badge $status'>" . ucfirst($status) . "</span></td>";
                            echo "<td><a href='?action=edit&id={$row['id_pengaduan']}' style='color: #4a6d41;' title='Detail/Edit'><i class='fas fa-eye'></i> Lihat</a></td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>Belum ada pengaduan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($action == 'edit' && $data): ?>
        <h1 class="page-title">Pengaduan</h1>

        <form action="proses_pengaduan.php" method="POST" enctype="multipart/form-data" class="pengaduan-form">
            <input type="hidden" name="id_pengaduan" value="<?php echo $data['id_pengaduan']; ?>">
            
            <div class="form-row">
                <label>Nama Pelapor</label>
                <span class="colon">:</span>
                <input type="text" name="nama_pelapor" class="input-box" value="<?php echo htmlspecialchars($data['nama_pelapor'] ?? ''); ?>" readonly>
            </div>
            
            <div class="form-row">
                <label>No. Telp</label>
                <span class="colon">:</span>
                <input type="text" name="no_telp" class="input-box" value="<?php echo htmlspecialchars($data['no_telp'] ?? ''); ?>" readonly>
            </div>
            
            <div class="form-row">
                <label>Judul Pengaduan</label>
                <span class="colon">:</span>
                <input type="text" name="judul_pengaduan" class="input-box" value="<?php echo htmlspecialchars($data['judul_pengaduan'] ?? ''); ?>" readonly>
            </div>
            
            <div class="form-row">
                <label>Kategori</label>
                <span class="colon">:</span>
                <div class="pill-group">
                    <?php $cat = strtolower($data['kategori'] ?? ''); ?>
                    <button type="button" class="pill-btn <?php echo ($cat == 'fasilitas') ? 'active' : ''; ?>">Fasilitas</button>
                    <button type="button" class="pill-btn <?php echo ($cat == 'keamanan') ? 'active' : ''; ?>">Keamanan</button>
                    <button type="button" class="pill-btn <?php echo ($cat == 'saran') ? 'active' : ''; ?>">Saran</button>
                    <button type="button" class="pill-btn <?php echo ($cat == 'dll') ? 'active' : ''; ?>">DLL</button>
                </div>
            </div>
            
            <div class="form-row" style="align-items: flex-start;">
                <label style="margin-top: 15px;">Pengaduan</label>
                <span class="colon" style="margin-top: 15px;">:</span>
                <textarea name="pengaduan" class="input-box" readonly><?php echo htmlspecialchars($data['pengaduan'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-row" style="align-items: flex-start;">
                <label style="margin-top: 15px;">Foto Bukti</label>
                <span class="colon" style="margin-top: 15px;">:</span>
                <div class="foto-area">
                    <img src="../assets/<?php echo ($data['foto_bukti'] ? $data['foto_bukti'] : 'placeholder.jpg'); ?>" alt="Bukti">
                </div>
            </div>
            
            <div class="form-row">
                <label>Status</label>
                <span class="colon">:</span>
                <div class="pill-group">
                    <?php $status = strtolower($data['status'] ?? 'diterima'); ?>
                    <input type="hidden" name="status" id="status-input" value="<?php echo $status; ?>">
                    <button type="button" class="status-btn diterima <?php echo ($status == 'diterima') ? 'active' : ''; ?>" onclick="setStatus('diterima', this)">Diterima</button>
                    <button type="button" class="status-btn diproses <?php echo ($status == 'diproses') ? 'active' : ''; ?>" onclick="setStatus('diproses', this)">Diproses</button>
                    <button type="button" class="status-btn selesai <?php echo ($status == 'selesai') ? 'active' : ''; ?>" onclick="setStatus('selesai', this)">Selesai</button>
                </div>
            </div>
            
            <div class="form-row" style="align-items: flex-start;">
                <label style="margin-top: 15px;">Respon Admin</label>
                <span class="colon" style="margin-top: 15px;">:</span>
                <textarea name="respon_admin" class="input-box" placeholder="Ketikkan respon atau tanggapan admin di sini..."><?php echo htmlspecialchars($data['respon_admin'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-row" style="align-items: flex-start;">
                <label style="margin-top: 15px;">Foto Respon</label>
                <span class="colon" style="margin-top: 15px;">:</span>
                <div class="foto-area" style="position: relative; height: 300px; display: flex; align-items: center; justify-content: center; background: #e9f0df;">
                    <img id="preview-respon" src="../assets/<?php echo (!empty($data['foto_respon']) ? $data['foto_respon'] : ''); ?>" style="<?php echo empty($data['foto_respon']) ? 'display:none;' : ''; ?> width: 100%; height: 100%; object-fit: cover; position: absolute;">
                    <button type="button" class="btn-view-card" onclick="document.getElementById('foto-respon-input').click()" style="position:relative; z-index: 2;">Pilih Foto Respon</button>
                    <input type="file" name="foto_respon" id="foto-respon-input" style="display:none;" onchange="previewRespon()">
                </div>
            </div>
            
            <div class="form-row">
                <label>Diupdate oleh</label>
                <span class="colon">:</span>
                <?php 
                    $display_name = !empty($data['admin_name']) ? $data['admin_name'] : ($_SESSION['admin_name'] ?? 'Admin');
                ?>
                <input type="text" name="admin_name" class="input-box" value="<?php echo htmlspecialchars($display_name); ?>" readonly>
                <input type="hidden" name="id_admin" value="<?php echo $_SESSION['admin_id'] ?? 1; ?>">
            </div>

            <button type="submit" class="btn-simpan">Simpan</button>
        </form>
        <?php endif; ?>

    </div>

    <script>
        function setStatus(val, btn) {
            document.querySelectorAll('.status-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('status-input').value = val;
        }

        function previewRespon() {
            const preview = document.getElementById('preview-respon');
            const file = document.getElementById('foto-respon-input').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

    

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
