<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$page_title = 'Laporan Transaksi BSP';

// Filter logic
$where = " WHERE 1=1 ";
if (!empty($_GET['nasabah'])) {
    $nasabah = mysqli_real_escape_string($conn, $_GET['nasabah']);
    $where .= " AND t.id_nasabah = '$nasabah' ";
}
if (!empty($_GET['sampah'])) {
    $sampah = mysqli_real_escape_string($conn, $_GET['sampah']);
    $where .= " AND t.id_sampah = '$sampah' ";
}
if (!empty($_GET['tanggal'])) {
    $tanggal = mysqli_real_escape_string($conn, $_GET['tanggal']);
    $where .= " AND t.tgl_transaksi = '$tanggal' ";
}
if (!empty($_GET['status'])) {
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    $where .= " AND t.status = '$status' ";
}

// Pagination
$limit = 10;
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($page < 1) $page = 1;
$start = ($page - 1) * $limit;

$q_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM t_transaksi t $where");
$total_data = mysqli_fetch_assoc($q_count)['total'];
$total_pages = ceil($total_data / $limit);

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
            --filter-bg: #e9f0df;
            --btn-green: #06331a;
            --badge-green: #4a6d41;
            --badge-orange: #ff8c00;
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
        h1.page-title { font-size: 28px; font-weight: 900; color: #12361A; margin-bottom: 25px; }
        
        /* Filter Box */
        .filter-box {
            background: var(--filter-bg);
            border-radius: 25px;
            padding: 30px 40px;
            margin-bottom: 40px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            position: relative;
        }
        .filter-row {
            display: grid;
            grid-template-columns: 180px 30px 1fr;
            align-items: center;
            max-width: 700px;
        }
        .filter-row label { font-size: 16px; font-weight: 800; color: #12361A; }
        .filter-row .colon { font-weight: 800; color: #12361A; }
        
        .input-box {
            background: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #4a6550;
            outline: none;
            width: 100%;
        }
        
        .btn-filter {
            position: absolute;
            right: 40px;
            bottom: 30px;
            background: var(--btn-green);
            color: white;
            padding: 15px 50px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-filter:hover { opacity: 0.9; transform: translateY(-2px); }

        /* Table Section */
        h2.table-title { font-size: 24px; font-weight: 900; color: #12361A; margin-bottom: 20px; }
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
            min-width: 80px;
        }
        .status-badge.ditarik { background: var(--badge-green); }
        .status-badge.masuk { background: var(--badge-orange); }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-bottom: 40px;
        }
        .page-info { font-size: 13px; color: #62836b; font-weight: 600; }
        .pagination { display: flex; gap: 8px; list-style: none; background: #e9f0df; padding: 6px; border-radius: 10px; }
        .pagination a {
            display: flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; text-decoration: none;
            color: #12361A; font-weight: 800; font-size: 13px;
            border-radius: 8px; transition: 0.2s;
        }
        .pagination a.active { background: white; }
        .pagination a:hover:not(.active) { background: rgba(255,255,255,0.5); }

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
            <li><a href="laporan.php" class="active"><i class="fas fa-file-alt"></i> Laporan BSP</a></li>
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

        <h1 class="page-title">Laporan Transaksi BSP</h1>

        <!-- Filter Box -->
        <form action="" method="GET" class="filter-box">
            <div class="filter-row">
                <label>Nama Nasabah</label>
                <span class="colon">:</span>
                <select name="nasabah" class="input-box">
                    <option value="">Pilih Nasabah</option>
                    <?php
                    $q_n = mysqli_query($conn, "SELECT id_nasabah, nama FROM t_nasabah ORDER BY nama ASC");
                    while($n = mysqli_fetch_array($q_n)) {
                        $sel = (isset($_GET['nasabah']) && $_GET['nasabah'] == $n['id_nasabah']) ? 'selected' : '';
                        echo "<option value='{$n['id_nasabah']}' $sel>{$n['nama']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="filter-row">
                <label>Sampah</label>
                <span class="colon">:</span>
                <select name="sampah" class="input-box">
                    <option value="">Pilih Jenis Sampah</option>
                    <?php
                    $q_s = mysqli_query($conn, "SELECT id_sampah, nama_sampah FROM t_sampah ORDER BY nama_sampah ASC");
                    while($s = mysqli_fetch_array($q_s)) {
                        $sel = (isset($_GET['sampah']) && $_GET['sampah'] == $s['id_sampah']) ? 'selected' : '';
                        echo "<option value='{$s['id_sampah']}' $sel>{$s['nama_sampah']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="filter-row">
                <label>Tanggal</label>
                <span class="colon">:</span>
                <input type="date" name="tanggal" class="input-box" value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>">
            </div>
            <div class="filter-row">
                <label>Status</label>
                <span class="colon">:</span>
                <select name="status" class="input-box">
                    <option value="">Pilih Status</option>
                    <option value="masuk_tabungan" <?php echo (isset($_GET['status']) && $_GET['status'] == 'masuk_tabungan') ? 'selected' : ''; ?>>Masuk Tabungan</option>
                    <option value="ditarik" <?php echo (isset($_GET['status']) && $_GET['status'] == 'ditarik') ? 'selected' : ''; ?>>Ditarik Tunai</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">Filter</button>
        </form>

        <h2 class="table-title">Tabel Laporan Transaksi BSP</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nama Nasabah</th>
                        <th>Jenis Sampah</th>
                        <th>Berat Sampah</th>
                        <th>Total Harga</th>
                        <th style="width: 120px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT t.*, n.nama, s.nama_sampah 
                            FROM t_transaksi t 
                            JOIN t_nasabah n ON t.id_nasabah = n.id_nasabah 
                            JOIN t_sampah s ON t.id_sampah = s.id_sampah 
                            $where 
                            ORDER BY t.tgl_transaksi DESC 
                            LIMIT $start, $limit";
                    $q = mysqli_query($conn, $sql);
                    $no = $start + 1;
                    if (mysqli_num_rows($q) > 0) {
                        while ($row = mysqli_fetch_array($q)) {
                            $status_label = ($row['status'] == 'ditarik') ? 'ditarik' : 'masuk';
                            $status_class = ($row['status'] == 'ditarik') ? 'ditarik' : 'masuk';
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['tgl_transaksi'])) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_sampah']) . "</td>";
                            echo "<td>" . number_format($row['berat_sampah'], 1, ',', '.') . " kg</td>";
                            echo "<td>Rp. " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                            echo "<td><span class='status-badge $status_class'>$status_label</span></td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>Data tidak ditemukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <div class="page-info">
                Menampilkan <?php echo min($total_data, $start + 1); ?> hingga <?php echo min($total_data, $start + $limit); ?> dari <?php echo $total_data; ?> transaksi
            </div>
            <div class="pagination">
                <?php if($page > 1): ?>
                    <a href="?p=<?php echo $page-1; ?>&nasabah=<?php echo @$_GET['nasabah']; ?>&sampah=<?php echo @$_GET['sampah']; ?>&tanggal=<?php echo @$_GET['tanggal']; ?>&status=<?php echo @$_GET['status']; ?>"><i class="fas fa-chevron-left"></i></a>
                <?php endif; ?>
                
                <?php for($i=1; $i<=$total_pages; $i++): ?>
                    <a href="?p=<?php echo $i; ?>&nasabah=<?php echo @$_GET['nasabah']; ?>&sampah=<?php echo @$_GET['sampah']; ?>&tanggal=<?php echo @$_GET['tanggal']; ?>&status=<?php echo @$_GET['status']; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                
                <?php if($page < $total_pages): ?>
                    <a href="?p=<?php echo $page+1; ?>&nasabah=<?php echo @$_GET['nasabah']; ?>&sampah=<?php echo @$_GET['sampah']; ?>&tanggal=<?php echo @$_GET['tanggal']; ?>&status=<?php echo @$_GET['status']; ?>"><i class="fas fa-chevron-right"></i></a>
                <?php endif; ?>
            </div>
        </div>

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
