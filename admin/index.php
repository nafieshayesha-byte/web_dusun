<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$page_title = 'Informasi Kegiatan';
if ($action == 'tambah') $page_title = 'Tambah Informasi Kegiatan';
if ($action == 'edit') $page_title = 'Edit Informasi Kegiatan';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Informasi Kegiatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #bfd5a3; /* Updated to match image light green */
            --main-bg: #fff;
            --text-dark: #223f20; /* Dark green text */
            --input-bg: #dce5ce;
            --btn-green: #032b13;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--main-bg); color: var(--text-dark); overflow-x: hidden; }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #bacc98; /* Exact matched olive green */
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
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }

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
        .search-container {
            position: relative; width: 100%; max-width: 600px;
        }
        .search-container i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #4e6353; font-size: 18px; }
        .search-bar {
            width: 100%; background: #e0ddd8; padding: 15px 20px 15px 50px;
            border: none; border-radius: 50px; font-size: 15px; font-weight: 600; color: #4e6353;
            outline: none;
        }
        .search-bar::placeholder { color: #7f8c82; }
        .top-icons { display: flex; align-items: center; gap: 20px; color: #324c3a; font-size: 22px; cursor: pointer; }
        .bell-wrap { position: relative; }
        .bell-dot { position: absolute; top: -2px; right: -2px; background: #4ade80; height: 12px; width: 12px; border-radius: 50%; border: 2px solid white; }

        /* Sections */
        .section-box { margin-bottom: 50px; }
        h1.page-title { font-size: 28px; font-weight: 900; color: #072210; margin-bottom: 25px; display: inline-block; letter-spacing: -0.5px;}

        /* Cards Grid */
        .cards-row { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 20px;}
        .info-card { background: #dce5ce; border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 5px 15px rgba(0,0,0,0.03);}
        .card-img { position: relative; height: 180px; width: 100%; }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }
        .card-badge-left { position: absolute; top: 15px; left: 15px; background: white; color: #28442a; font-size: 10px; font-weight: 800; padding: 4px 12px; border-radius: 50px; }
        
        .card-body { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
        .card-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .meta-date { color: #53775b; font-size: 11px; font-weight: 800; line-height: 1.3;}
        .meta-status { font-size: 9px; font-weight: 800; padding: 3px 10px; border-radius: 50px; color: white; }
        .bg-orange { background: #f58400; }
        .bg-green { background: #49634b; }
        
        .info-card h3 { font-size: 18px; font-weight: 800; color: #0d2a14; margin-bottom: 12px; line-height: 1.3; }
        .info-card p { font-size: 12px; color: #526f58; font-weight: 500; line-height: 1.6; margin-bottom: 20px; flex-grow: 1; }
        
        .card-actions { display: flex; gap: 10px; }
        .btn-card { flex: 1; padding: 10px; text-align: center; font-size: 12px; font-weight: 700; border-radius: 10px; cursor: pointer; border: none; transition: 0.3s; }
        .btn-edit { background: white; color: #0b2512; border: 2px solid #0b2512; }
        .btn-delete { background: #032b13; color: white; }
        .btn-card:hover { opacity: 0.8; transform: translateY(-2px);}

        /* Buttons & Utility */
        .btn-add { float: right; background: #dce5ce; color: #0e2914; border: none; padding: 12px 24px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.3s; margin-top: -65px;}
        .btn-add:hover { background: #c5d3af; }
        
        .lihat-semua { text-align: right; color: #5d7561; font-weight: 700; font-size: 14px; text-decoration: none; display: block; margin-bottom: 40px; }

        /* Form Area */
        .form-table { width: 100%; border-collapse: separate; border-spacing: 0 20px; }
        .form-table td { vertical-align: top; }
        .form-table td.label-col { width: 140px; font-size: 15px; font-weight: 800; color: #0b2512; padding-top: 15px; }
        .form-table td.colon-col { width: 20px; font-size: 16px; font-weight: 800; color: #0b2512; padding-top: 15px; text-align: center; }
        
        .input-box { background: var(--input-bg); border: none; padding: 15px 20px; border-radius: 12px; width: 100%; font-size: 14px; color: #0b2512; font-weight: 600; outline: none; }
        .input-box.w-auto { width: auto; min-width: 200px; display: inline-block;}
        textarea.input-box { min-height: 100px; resize: none; }
        .img-placeholder { width: 100%; height: 200px; background: var(--input-bg); border-radius: 12px; }
        
        .pill-group { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
        .form-pill { background: #dce5ce; color: #43644a; padding: 8px 16px; border-radius: 50px; font-size: 12px; font-weight: 700; cursor: pointer; border: none; }
        .form-pill.active { background: #a6b98b; color: #0b2512; }

        .submit-wrap { text-align: center; margin-top: 40px; margin-bottom: 60px; }
        .btn-submit { background: #032b13; color: white; padding: 14px 40px; border-radius: 10px; font-weight: 700; font-size: 15px; border: none; cursor: pointer; transition: 0.3s;}
        .btn-submit:hover { background: #083c1d; transform: translateY(-2px);}

        .pagination { display: flex; justify-content: flex-end; gap: 5px; }
        .page-btn { background: #dce5ce; color: #37543f; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; border-radius: 6px; cursor: pointer; border: none; }
        .page-btn.active { background: #c5d3af; }

        .btn-kembali { background: #032b13; color: white; display: inline-flex; align-items: center; padding: 8px 16px; border-radius: 50px; text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 20px;}
        .btn-kembali i { margin-right: 8px; font-size: 10px;}

        /* Logout Modal */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(4px);
            display: none; justify-content: center; align-items: center; z-index: 10000;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: white; border-radius: 20px; padding: 40px; text-align: center;
            max-width: 400px; width: 90%; box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: modalFadeIn 0.3s ease;
        }
        @keyframes modalFadeIn { from { transform: translateY(20px); opacity: 0;} to { transform: translateY(0); opacity: 1;} }
        .modal-icon { font-size: 40px; color: #f58400; margin-bottom: 20px; }
        .modal-box h3 { font-size: 20px; color: #0b2512; margin-bottom: 30px; font-weight: 800; }
        .modal-actions { display: flex; gap: 15px; justify-content: center; }
        .modal-btn { padding: 12px 30px; border-radius: 12px; font-weight: 700; cursor: pointer; border: none; font-size: 15px; transition: 0.3s;}
        .modal-btn.btn-ya { background: #032b13; color: white; }
        .modal-btn.btn-tidak { background: #dce5ce; color: #0b2512; }
        .modal-btn:hover { opacity: 0.9; transform: translateY(-2px); }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Hallo Admin1</h2>
            <div class="profile">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" alt="Profile">
                <div class="profile-info">
                    <span class="name">Karina</span>
                    <span class="role">Cahya Kirana</span>
                </div>
            </div>
        </div>
        
        <ul class="menu">
            <li><a href="#"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="#" class="active"><i class="fas fa-info-circle"></i> Informasi</a></li>
            <li><a href="#"><i class="fas fa-briefcase"></i> Bisnis Warga</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Nasabah</a></li>
            <li><a href="#"><i class="fas fa-hand-holding-heart"></i> Transaksi BSP</a></li>
            <li><a href="#"><i class="fas fa-file-alt"></i> Laporan BSP</a></li>
            <li><a href="#"><i class="fas fa-bullhorn"></i> Pengaduan</a></li>
        </ul>
        
        <ul class="sidebar-footer-menu menu">
            <li><a href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
            <li><a href="#" onclick="openLogoutModal(); return false;"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
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
                <div class="bell-wrap">
                    <i class="fas fa-bell"></i>
                    <div class="bell-dot"></div>
                </div>
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>

        <?php if ($action == 'list'): ?>
        <!-- Section: Informasi Kegiatan -->
        <div class="section-box" style="position: relative;">
            <h1 class="page-title">Informasi Kegiatan</h1>
            <a href="?action=tambah" class="btn-add" style="text-decoration:none;"><i class="fas fa-plus"></i> Tambah Informasi</a>
            
            <div class="cards-row">
                <?php
                $q = mysqli_query($conn, "SELECT * FROM t_kegiatan_dusun ORDER BY tanggal DESC");
                if(mysqli_num_rows($q) > 0) {
                    while($k = mysqli_fetch_array($q)) {
                        $tanggal = date('d M Y', strtotime($k['tanggal']));
                        $waktu_mulai = !empty($k['waktu_mulai']) ? date('H.i', strtotime($k['waktu_mulai'])) : '00.00';
                        $waktu_selesai = !empty($k['waktu_selesai']) ? date('H.i', strtotime($k['waktu_selesai'])) : '00.00';
                        $waktu = $waktu_mulai . '-' . $waktu_selesai;
                        $status_class = 'bg-green';
                        if($k['status'] == 'akan_datang') $status_class = 'bg-orange';
                        
                        echo '<div class="info-card">';
                        echo '  <div class="card-img">';
                        echo '      <span class="card-badge-left">'.htmlspecialchars($k['jenis_kegiatan']).'</span>';
                        echo '      <img src="../assets/'.($k['foto']?$k['foto']:'placeholder.jpg').'" alt="Foto">';
                        echo '  </div>';
                        echo '  <div class="card-body">';
                        echo '      <div class="card-meta">';
                        echo '          <span class="meta-date">'.$tanggal.'<br><span style="font-size: 9px;">'.$waktu.'</span></span>';
                        echo '          <span class="meta-status '.$status_class.'">'.ucfirst(str_replace('_', ' ', $k['status'])).'</span>';
                        echo '      </div>';
                        echo '      <h3>'.htmlspecialchars($k['judul']).'</h3>';
                        echo '      <p>'.htmlspecialchars(substr($k['keterangan'], 0, 150)).'...</p>';
                        echo '      <div class="card-actions">';
                        echo '          <a href="?action=edit&id='.$k['id_kegiatan'].'" class="btn-card btn-edit" style="text-decoration:none;">Edit Kegiatan</a>';
                        echo '          <a href="proses_kegiatan.php?act=del&id='.$k['id_kegiatan'].'" class="btn-card btn-delete" style="text-decoration:none;" onclick="return confirm(\'Hapus kegiatan?\')">Hapus Kegiatan</a>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Belum ada kegiatan.</p>';
                }
                ?>
            </div>
            
            <?php if(mysqli_num_rows($q) > 2): ?>
            <a href="#" class="lihat-semua">Lihat semua ></a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $edit = null;
        if($action == 'edit' && $id) {
            $q_edit = mysqli_query($conn, "SELECT * FROM t_kegiatan_dusun WHERE id_kegiatan='$id'");
            $edit = mysqli_fetch_array($q_edit);
        }
        ?>
        <!-- Section: Tambah/Edit Informasi Kegiatan Form -->
        <div class="section-box">
            <a href="?action=list" class="btn-kembali"><i class="fas fa-chevron-left"></i> Kembali</a>
            <div style="text-align: center; margin-bottom: 40px; margin-top:20px;">
                <h1 class="page-title" style="margin-bottom:0;"><?php echo $action == 'edit' ? 'Edit ' : 'Tambah '; ?>Informasi Kegiatan</h1>
            </div>
            
            <form action="proses_kegiatan.php?act=<?php echo $action == 'edit' ? 'edit' : 'add'; ?>" method="POST" enctype="multipart/form-data">
                <?php if($action == 'edit'): ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="foto_lama" value="<?php echo $edit['foto']; ?>">
                <?php endif; ?>

                <table class="form-table">
                    <tr>
                        <td class="label-col">Judul</td>
                        <td class="colon-col">:</td>
                        <td><input type="text" name="judul" class="input-box" value="<?php echo $edit ? $edit['judul'] : ''; ?>" required></td>
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
                        <td class="label-col">Keterangan</td>
                        <td class="colon-col">:</td>
                        <td><textarea name="keterangan" class="input-box" required><?php echo $edit ? $edit['keterangan'] : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <td class="label-col">Tanggal</td>
                        <td class="colon-col">:</td>
                        <td><input type="date" name="tanggal" class="input-box w-auto" value="<?php echo $edit ? $edit['tanggal'] : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-col">Lokasi</td>
                        <td class="colon-col">:</td>
                        <td><input type="text" name="lokasi" class="input-box" value="<?php echo $edit ? $edit['lokasi'] : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-col">Penyelenggara</td>
                        <td class="colon-col">:</td>
                        <td><input type="text" name="penyelenggara" class="input-box" style="width: 60%;" value="<?php echo $edit ? $edit['penyelenggara'] : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-col">Waktu mulai</td>
                        <td class="colon-col">:</td>
                        <td><input type="time" name="waktu_mulai" class="input-box w-auto" value="<?php echo $edit ? date('H:i', strtotime($edit['waktu_mulai'])) : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-col">Waktu selesai</td>
                        <td class="colon-col">:</td>
                        <td><input type="time" name="waktu_selesai" class="input-box w-auto" value="<?php echo $edit ? date('H:i', strtotime($edit['waktu_selesai'])) : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td class="label-col">Jenis Kegiatan</td>
                        <td class="colon-col">:</td>
                        <td>
                            <div class="pill-group">
                                <?php 
                                $jenis = ['Berita dusun', 'Kegiatan warga', 'Pengumuman', 'Agenda dusun', 'Potensi dusun'];
                                $sel_jenis = $edit ? $edit['jenis_kegiatan'] : 'Berita dusun';
                                foreach($jenis as $j) {
                                    $active = ($sel_jenis == $j) ? 'active' : '';
                                    echo '<button type="button" class="form-pill btn-jenis '.$active.'" data-val="'.$j.'">'.$j.'</button>';
                                }
                                ?>
                                <input type="hidden" name="jenis_kegiatan" id="jenis_kegiatan" value="<?php echo $sel_jenis; ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-col">Status</td>
                        <td class="colon-col">:</td>
                        <td>
                            <div class="pill-group">
                                <?php 
                                $status_arr = ['akan_datang'=>'Akan datang', 'dimulai'=>'Dimulai', 'ditunda'=>'Ditunda', 'selesai'=>'Selesai', 'dibatalkan'=>'Dibatalkan'];
                                $sel_status = $edit ? $edit['status'] : 'akan_datang';
                                foreach($status_arr as $val => $lbl) {
                                    $active = ($sel_status == $val) ? 'active' : '';
                                    echo '<button type="button" class="form-pill btn-status '.$active.'" data-val="'.$val.'">'.$lbl.'</button>';
                                }
                                ?>
                                <input type="hidden" name="status" id="status" value="<?php echo $sel_status; ?>">
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="submit-wrap">
                    <button type="submit" class="btn-submit"><?php echo $action == 'edit' ? 'Simpan' : 'Tambah'; ?> Kegiatan</button>
                </div>
            </form>
            
            <script>
                document.querySelectorAll('.btn-jenis').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.btn-jenis').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        document.getElementById('jenis_kegiatan').value = this.getAttribute('data-val');
                    });
                });
                document.querySelectorAll('.btn-status').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.btn-status').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        document.getElementById('status').value = this.getAttribute('data-val');
                    });
                });
            </script>
        </div>
        <?php endif; ?>

    </div>

    <!-- Modal Logout -->
    <div class="modal-overlay" id="logoutModal">
        <div class="modal-box">
            <div class="modal-icon"><i class="fas fa-sign-out-alt"></i></div>
            <h3>Apakah anda yakin ingin logout?</h3>
            <div class="modal-actions">
                <button class="modal-btn btn-ya" onclick="window.location.href='logout.php'">Ya</button>
                <button class="modal-btn btn-tidak" onclick="closeLogoutModal()">Tidak</button>
            </div>
        </div>
    </div>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.add('active');
        }
        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
        }
        
        // Optional: close modal when clicking outside
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });
    </script>
</body>
</html>
