<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$edit_id = isset($_GET['edit_id']) ? $_GET['edit_id'] : null;
$edit_data = null;

if ($edit_id) {
    $q_edit = mysqli_query($conn, "SELECT * FROM t_nasabah WHERE id_nasabah = '$edit_id'");
    $edit_data = mysqli_fetch_array($q_edit);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Nasabah</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #bacc98;
            --main-bg: #ffffff;
            --text-dark: #12361A;
            --input-bg: #e9f0df;
            --btn-green: #06331a;
            --btn-active: #4a6d41;
            --btn-inactive: #c62828;
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

        /* Nasabah Section */
        h1.page-title { font-size: 28px; font-weight: 900; color: #12361A; margin-bottom: 25px; }
        
        /* Form Section */
        .nasabah-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 40px;
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
        textarea.input-box { min-height: 100px; resize: none; padding-top: 15px; }

        .status-group { display: flex; gap: 15px; }
        .status-btn {
            padding: 12px 35px;
            border-radius: 15px;
            border: none;
            font-size: 14px;
            font-weight: 800;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .status-btn.aktif { background: #4a6d41; }
        .status-btn.non-aktif { background: #d32f2f; }
        .status-btn:not(.active) { opacity: 0.5; }

        .form-actions {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            margin-left: 210px;
            justify-content: center;
            max-width: 300px;
        }
        .btn-submit {
            padding: 15px 45px;
            border-radius: 15px;
            border: none;
            font-size: 16px;
            font-weight: 800;
            color: white;
            background: #0d2a14;
            cursor: pointer;
            transition: 0.3s;
            min-width: 120px;
        }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }

        /* Table Section */
        .table-container {
            width: 100%;
            overflow-x: auto;
            border: 2px solid #bacc98;
            border-radius: 15px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th {
            background: #e9f0df;
            padding: 18px 15px;
            font-size: 14px;
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
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
            color: white;
            display: inline-block;
            min-width: 100px;
        }
        .status-badge.aktif { background: #4a6d41; }
        .status-badge.non-aktif { background: #d32f2f; }

        /* Custom Scrollbar for sidebar-like feel */
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
            <li><a href="nasabah.php" class="active"><i class="fas fa-users"></i> Nasabah</a></li>
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
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search-bar" placeholder="Cari..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </form>
            <div class="top-icons">
                <div style="position:relative;">
                    <i class="fas fa-bell"></i>
                    <div style="position:absolute; top:-2px; right:-2px; background:#4ade80; height:12px; width:12px; border-radius:50%; border:2px solid white;"></div>
                </div>
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>

        <h1 class="page-title">Nasabah</h1>

        <!-- Form Nasabah -->
        <form action="proses_nasabah.php" method="POST" class="nasabah-form">
            <input type="hidden" name="id_nasabah" value="<?php echo $edit_data ? $edit_data['id_nasabah'] : ''; ?>">
            <input type="hidden" name="act" value="<?php echo $edit_data ? 'edit' : 'add'; ?>">
            
            <div class="form-row">
                <label>Nama</label>
                <span class="colon">:</span>
                <input type="text" name="nama" class="input-box" placeholder="Pilih Nasabah" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama']) : ''; ?>" required>
            </div>
            
            <div class="form-row">
                <label>Alamat</label>
                <span class="colon">:</span>
                <textarea name="alamat" class="input-box" placeholder="Masukkan Alamat"><?php echo $edit_data ? htmlspecialchars($edit_data['alamat']) : ''; ?></textarea>
            </div>
            
            <div class="form-row">
                <label>No. Telp</label>
                <span class="colon">:</span>
                <input type="text" name="telp" class="input-box" placeholder="Pilih Jenis Sampah" value="<?php echo $edit_data ? htmlspecialchars($edit_data['telp']) : ''; ?>">
            </div>
            
            <div class="form-row">
                <label>Tanggal Bergabung</label>
                <span class="colon">:</span>
                <input type="date" name="tgl_bergabung" class="input-box" value="<?php echo $edit_data ? $edit_data['tgl_bergabung'] : ''; ?>" placeholder="dd/mm/yyyy">
            </div>
            
            <div class="form-row">
                <label>Status</label>
                <span class="colon">:</span>
                <div class="status-group">
                    <button type="button" class="status-btn aktif <?php echo (!$edit_data || $edit_data['status'] == 'aktif') ? 'active' : ''; ?>" onclick="setStatus('aktif', this)">Aktif</button>
                    <button type="button" class="status-btn non-aktif <?php echo ($edit_data && $edit_data['status'] == 'non_aktif') ? 'active' : ''; ?>" onclick="setStatus('non_aktif', this)">Non Aktif</button>
                    <input type="hidden" name="status" id="status-input" value="<?php echo $edit_data ? $edit_data['status'] : 'aktif'; ?>">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="edit_mode" value="1" class="btn-submit" style="background:#0d2a14;">Edit</button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>

        <!-- Table Nasabah -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Nama Nasabah</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Tgl Bergabung</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                    $where = $search ? " WHERE nama LIKE '%$search%' OR alamat LIKE '%$search%'" : "";
                    $q = mysqli_query($conn, "SELECT * FROM t_nasabah $where ORDER BY id_nasabah ASC");
                    if (mysqli_num_rows($q) > 0) {
                        while ($row = mysqli_fetch_array($q)) {
                            $status_label = ($row['status'] == 'aktif') ? 'Aktif' : 'Non Aktif';
                            $status_class = ($row['status'] == 'aktif') ? 'aktif' : 'non-aktif';
                            echo "<tr>";
                            echo "<td>{$row['id_nasabah']}</td>";
                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['telp']) . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['tgl_bergabung'])) . "</td>";
                            echo "<td><span class='status-badge $status_class'>$status_label</span></td>";
                            echo "<td>
                                <a href='?edit_id={$row['id_nasabah']}' style='color: #4a6d41; margin-right: 10px;' title='Edit'><i class='fas fa-edit'></i></a>
                                <a href='proses_nasabah.php?act=del&id={$row['id_nasabah']}' style='color: #c62828;' onclick=\"return confirm('Hapus nasabah ini?')\" title='Hapus'><i class='fas fa-trash'></i></a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Belum ada data nasabah.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function setStatus(val, btn) {
            document.querySelectorAll('.status-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('status-input').value = val;
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
