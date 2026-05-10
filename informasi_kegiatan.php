<?php 
require_once 'config.php'; 

// Pagination setup
$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$where_clause = "";
if($kategori_filter && $kategori_filter !== 'Semua') {
    $where_clause = " WHERE jenis_kegiatan = '" . mysqli_real_escape_string($conn, $kategori_filter) . "'";
}

// Count total
$query_count = "SELECT COUNT(*) as total FROM t_kegiatan_dusun" . $where_clause;
$result_count = mysqli_query($conn, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total = $row_count['total'];
$pages = ceil($total / $limit);

// Fetch data
$query = "SELECT * FROM t_kegiatan_dusun" . $where_clause . " ORDER BY tanggal DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

// Array kategori (hardcoded for the UI representation based on image)
$kategories = ['Semua', 'Berita Dusun', 'Kegiatan Warga', 'Pengumuman', 'Agenda Dusun', 'Potensi Dusun'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Kegiatan - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: var(--white);
        }
        body {
            background-color: #fbfdf9;
        }
        .header-section {
            text-align: center;
            padding: 30px 20px 40px;
        }
        .badge-top {
            display: inline-block;
            background: #e7ece2;
            color: #356345;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .breadcrumb {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 35px;
            color: #8fa696;
            gap: 10px;
        }
        .breadcrumb a {
            text-decoration: none;
            color: #12361A;
        }
        .breadcrumb i {
            font-size: 10px;
        }
        .informasi-title {
            font-size: 42px;
            font-weight: 900;
            color: #12361A;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .informasi-subtitle {
            font-size: 15px;
            color: #62836b;
            max-width: 650px;
            margin: 0 auto 35px;
            line-height: 1.6;
            font-weight: 500;
        }
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 50px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }
        .filter-pill {
            padding: 10px 22px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            background: #e9f0df;
            color: #356345;
            border: none;
        }
        .filter-pill.active {
            background: #12361A;
            color: #ffffff;
        }
        .filter-pill:hover:not(.active) {
            background: #dce5ce;
        }
        .kegiatan-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .activity-card {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            background: #e9f0df;
            border-radius: 20px;
            padding: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .activity-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        }
        .card-img-container {
            position: relative;
            width: 100%;
            height: 220px;
        }
        .card-badge-left {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #12361A;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 50px;
            z-index: 2;
        }
        .card-body {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .date-time {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .meta-date {
            font-size: 12px;
            font-weight: 800;
            color: #12361A;
            text-transform: uppercase;
        }
        .meta-time {
            font-size: 11px;
            font-weight: 600;
            color: #62836b;
        }
        .status-badge {
            font-size: 9px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 50px;
            text-transform: uppercase;
            color: white;
        }
        .card-title {
            font-size: 20px;
            color: #12361A;
            font-weight: 900;
            line-height: 1.3;
            margin-bottom: 15px;
            letter-spacing: -0.3px;
        }
        .card-desc {
            font-size: 13px;
            color: #526f58;
            line-height: 1.6;
            margin-bottom: 25px;
            flex: 1;
            font-weight: 500;
        }
        .read-more {
            font-size: 12px;
            font-weight: 800;
            color: #12361A;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 60px auto 80px;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 700;
            color: #12361A;
        }
        .pagination-links {
            display: flex;
            gap: 10px;
        }
        .page-link {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #e9f0df;
            color: #12361A;
            text-decoration: none;
            font-weight: 800;
            font-size: 12px;
            transition: all 0.3s;
        }
        .page-link.active {
            background: #c5d3af;
        }
        .page-link:hover:not(.active) {
            background: #dce5ce;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="index.php" class="logo"><img src="https://ui-avatars.com/api/?name=DP&background=1E3B20&color=fff&rounded=true" alt="Logo" style="height: 32px; width: 32px; border-radius: 50%;"> Dusun Pilang</a>
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li class="has-dropdown">
                    <a href="#">Profil Dusun <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="tentang_dusun.php">Tentang Dusun</a></li>
                        <li><a href="fasilitas.php">Fasilitas</a></li>
                    </ul>
                </li>
                <li><a href="informasi_kegiatan.php" class="active">Informasi</a></li>
                <li><a href="bisnis_warga.php">Bisnis Warga</a></li>
                <li class="has-dropdown">
                    <a href="#">Bank Sampah <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="bank_sampah.php">Pelayanan Sampah</a></li>
                        <li><a href="nasabah.php">Nasabah</a></li>
                    </ul>
                </li>
                <li><a href="index.php#kontak">Kontak</a></li>
            </ul>
            <a href="index.php#kontak" class="btn-primary">Pengaduan &rarr;</a>
        </div>
    </header>

    <div class="header-section">
        <span class="badge-top">Warta Desa</span>
        <h1 class="informasi-title">Informasi Kegiatan</h1>
        <p class="informasi-subtitle">Update informasi, pengumuman Dusun, dan ragam kegiatan inspiratif dari warga Kampung.</p>
        
        <div class="breadcrumb">
            <a href="index.php">Beranda</a> <i class="fas fa-chevron-right"></i> Informasi
        </div>

        <div class="filter-container">
            <?php foreach($kategories as $kat): ?>
                <?php 
                    $isActive = ($kategori_filter == $kat) || (empty($kategori_filter) && $kat == 'Semua');
                    $activeClass = $isActive ? 'active' : '';
                    $katUrl = ($kat == 'Semua') ? 'informasi_kegiatan.php' : 'informasi_kegiatan.php?kategori=' . urlencode($kat);
                ?>
                <a href="<?php echo htmlspecialchars($katUrl); ?>" class="filter-pill <?php echo $activeClass; ?>">
                    <?php echo htmlspecialchars($kat); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="kegiatan-grid">
        <?php
        if($result && mysqli_num_rows($result) > 0) {
            $mo = ['01'=>'JANUARI','02'=>'FEBRUARI','03'=>'MARET','04'=>'APRIL','05'=>'MEI','06'=>'JUNI','07'=>'JULI','08'=>'AGUSTUS','09'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'];
            
            while($k = mysqli_fetch_array($result)) {
                $kategori = isset($k['jenis_kegiatan']) && !empty($k['jenis_kegiatan']) ? $k['jenis_kegiatan'] : 'Berita Dusun';
                
                $tgl_fmt = '';
                if($k['tanggal']) {
                    $time_parts = explode('-', $k['tanggal']);
                    if(count($time_parts) == 3) {
                        $tgl_fmt = (int)$time_parts[2] . ' ' . (isset($mo[$time_parts[1]]) ? $mo[$time_parts[1]] : $time_parts[1]) . ' ' . $time_parts[0];
                    } else {
                        $tgl_fmt = date('d M Y', strtotime($k['tanggal']));
                    }
                } else {
                    $tgl_fmt = 'AKAN DATANG';
                }
                
                $w_mulai = !empty($k['waktu_mulai']) ? date('H.i', strtotime($k['waktu_mulai'])) : '00.00';
                $w_selesai = !empty($k['waktu_selesai']) ? date('H.i', strtotime($k['waktu_selesai'])) : '00.00';
                $waktu_str = $w_mulai . '-' . $w_selesai;
                $keterangan_snippet = !empty($k['keterangan']) ? mb_strimwidth(strip_tags($k['keterangan']), 0, 130, "...") : '-';
                $status_kegiatan = str_replace('_', ' ', $k['status']);
                $status_raw = $k['status'];
                
                $bg_status = '#49634b'; 
                if($status_raw == 'akan_datang') $bg_status = '#f58400';
                elseif($status_raw == 'selesai') $bg_status = '#49634b';
                elseif($status_raw == 'dibatalkan') $bg_status = '#B42336';
                
                echo '<a href="detail_kegiatan.php?id='.intval($k['id_kegiatan']).'" class="activity-card">';
                echo '  <div class="card-img-container">';
                echo '      <span class="card-badge-left">'.htmlspecialchars($kategori).'</span>';
                echo '      <img src="assets/'.($k['foto']?$k['foto']:'placeholder.jpg').'" alt="'.htmlspecialchars($k['judul']).'" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src=\'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80\'">';
                echo '  </div>';
                
                echo '  <div class="card-body">';
                echo '      <div class="meta-row">';
                echo '          <div class="date-time">';
                echo '              <div class="meta-date">'.$tgl_fmt.'</div>';
                echo '              <div class="meta-time">'.$waktu_str.'</div>';
                echo '          </div>';
                echo '          <div class="status-badge" style="background: '.$bg_status.';">'.htmlspecialchars($status_kegiatan).'</div>';
                echo '      </div>';
                
                echo '      <h3 class="card-title">'.htmlspecialchars($k['judul']).'</h3>';
                echo '      <p class="card-desc">'.htmlspecialchars($keterangan_snippet).'</p>';
                echo '      <div class="read-more">Baca artikel selengkapnya <i class="fas fa-arrow-right"></i></div>';
                echo '  </div>';
                echo '</a>';
            }
        } else {
            echo '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #6b7280; font-weight: 500;">Tidak ada data kegiatan di kategori ini.</div>';
        }
        ?>
    </div>

    <?php if($total > 0): ?>
    <div class="pagination-container">
        <?php 
            $end_item = min($start + $limit, $total);
            echo "<div>Menampilkan hingga {$end_item} dari {$total} berita</div>";
        ?>
        <div class="pagination-links">
            <?php 
            $url_base = '?';
            if($kategori_filter && $kategori_filter !== 'Semua') {
                $url_base .= 'kategori=' . urlencode($kategori_filter) . '&';
            }
            
            // Previous button
            $prev_page = max(1, $page - 1);
            echo '<a href="'.$url_base.'page='.$prev_page.'" class="page-link"><i class="fas fa-chevron-left"></i></a>';

            for($i = 1; $i <= $pages; $i++) {
                $activeClass = ($i == $page) ? 'active' : '';
                echo '<a href="'.$url_base.'page='.$i.'" class="page-link '.$activeClass.'">'.$i.'</a>';
            }
            
            // Next button
            $next_page = min($pages, $page + 1);
            echo '<a href="'.$url_base.'page='.$next_page.'" class="page-link"><i class="fas fa-chevron-right"></i></a>';
            ?>
        </div>
    </div>
    <?php endif; ?>

    <footer style="margin-top: 0;">
        <div class="footer-grid">
            <div class="footer-col" style="flex: 2; min-width: 300px;">
                <a href="#" class="logo" style="color: var(--white); margin-bottom: 15px; display: inline-flex;"><img src="https://ui-avatars.com/api/?name=DP&background=fff&color=1E3B20&rounded=true" alt="Logo" style="height: 32px; width: 32px; border-radius: 50%;"> Dusun Pilang</a>
                <p style="margin-top: 5px; max-width: 280px;">Mewujudkan masyarakat yang mandiri, berkarakter, dan sejahtera</p>
                <div class="social-links">
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3>MENU UTAMA</h3>
                <ul>
                    <li><a href="index.php">• Beranda</a></li>
                    <li><a href="tentang_dusun.php">• Tentang Dusun</a></li>
                    <li><a href="informasi_kegiatan.php">• Informasi Kegiatan</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>LAYANAN</h3>
                <ul>
                    <li><a href="bisnis_warga.php">• Bisnis Warga</a></li>
                    <li><a href="bank_sampah.php">• Bank Sampah</a></li>
                    <li><a href="admin/login.php">• Pendaftaran Nasabah</a></li>
                    <li><a href="index.php#kontak">• Pengaduan Publik</a></li>
                    <li><a href="index.php#kontak">• Hubungi Kami</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>INFORMASI KONTAK</h3>
                <ul style="color: #a1a1aa;">
                    <li style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <i class="fas fa-map-marker-alt" style="margin-top: 5px; color: var(--primary-color);"></i> 
                        <span><b>ALAMAT UTAMA</b><br>Dusun Pilang RW 06, Kecamatan Boja, Kabupaten Kendal, Provinsi Jawa Tengah, Kode Pos 51381.</span>
                    </li>
                    <li style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <i class="fas fa-phone-alt" style="margin-top: 5px; color: var(--primary-color);"></i> 
                        <span><b>TELEPON</b><br>(082) 1234567</span>
                    </li>
                    <li style="display: flex; gap: 10px;">
                        <i class="fas fa-envelope" style="margin-top: 5px; color: var(--primary-color);"></i> 
                        <span><b>EMAIL RESMI</b><br>dusunpilang06@gmail.com</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; flex-wrap: wrap; padding-top: 20px;">
            <p>&copy; 2026 Dusun Pilang</p>
            <a href="admin/login.php" style="color: rgba(255,255,255,0.5); text-decoration: none; font-size: 13px; transition: all 0.3s; padding: 6px 12px; border-radius: 50px; background: rgba(0,0,0,0.2);"><i class="fas fa-lock" style="font-size: 10px; margin-right: 5px;"></i> Login Admin</a>
        </div>
    </footer>
    <a href="admin/login.php" class="floating-admin">
        <i class="fas fa-user-shield"></i>
        <span>Portal Admin</span>
    </a>
</body>
</html>
