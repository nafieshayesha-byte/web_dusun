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
$kategories = ['Semua', 'Pengumuman', 'Kegiatan warga', 'Agenda dusun', 'Bank Sampah', 'Kegiatan Lomba', 'Kerja Bakti'];
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
        .header-section {
            text-align: center;
            padding: 40px 20px 20px;
        }
        .breadcrumb {
            display: inline-flex;
            align-items: center;
            background: #e7ece2;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #356345;
        }
        .breadcrumb .dot {
            margin: 0 8px;
            color: #8fa696;
            font-size: 8px;
        }
        .informasi-title {
            font-size: 36px;
            font-weight: 800;
            color: #0b3018;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
            font-family: 'Inter', sans-serif;
            text-transform: capitalize;
        }
        .informasi-subtitle {
            font-size: 15px;
            color: #62836b;
            max-width: 600px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 40px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
        .filter-pill {
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: #fbfdf9;
            border: 1px solid #e7ece2;
            color: #356345;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            -webkit-tap-highlight-color: transparent;
        }
        .filter-pill.active {
            background: #113620;
            color: #ffffff;
            border-color: #113620;
            box-shadow: 0 4px 12px rgba(17, 54, 32, 0.25);
            transform: translateY(-1px);
        }
        .filter-pill:hover:not(.active) {
            background: #e7ece2;
            border-color: #d1dacb;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }
        .filter-pill:active {
            transform: scale(0.94);
        }
        .kegiatan-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .activity-card {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            background: #e7ece2;
            border-radius: 16px;
            padding: 15px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            transform-origin: center;
            opacity: 0;
            animation: fadeInUp 0.6s cubic-bezier(0.25, 0.8, 0.25, 1) forwards;
            -webkit-tap-highlight-color: transparent;
        }
        .activity-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            background: #eef2ea;
        }
        .activity-card:active {
            transform: translateY(-2px) scale(0.98);
            box-shadow: 0 5px 12px rgba(0,0,0,0.05);
            transition: all 0.1s;
        }
        .activity-card .card-img-container img {
            transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .activity-card:hover .card-img-container img {
            transform: scale(1.08);
        }
        .activity-card .read-more i {
            transition: transform 0.3s ease;
        }
        .activity-card:hover .read-more i {
            transform: translateX(4px);
        }
        @media (max-width: 991px) {
            .kegiatan-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .kegiatan-grid {
                grid-template-columns: 1fr;
            }
        }
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 40px auto 60px;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 600;
            color: #62836b;
        }
        .pagination-links {
            display: flex;
            gap: 10px;
        }
        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #fbfdf9;
            border: 1px solid #e7ece2;
            color: #356345;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            -webkit-tap-highlight-color: transparent;
        }
        .page-link.active {
            background: #e7ece2;
            border-color: #d1dacb;
        }
        .page-link:hover:not(.active) {
            background: #eef2ea;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .page-link:active {
            transform: scale(0.92);
            transition: all 0.1s;
        }
    </style>
</head>
<body>
    <header style="background: var(--white); border-bottom: 1px solid #eaeaea; padding-bottom: 20px;">
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
                <li><a href="index.php#informasi" class="active">Informasi <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a></li>
                <li><a href="index.php#bisnis">Bisnis Warga</a></li>
                <li><a href="bank_sampah.php">Bank Sampah <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a></li>
                <li><a href="index.php#kontak">Kontak</a></li>
            </ul>
            <a href="index.php#kontak" class="btn-primary">Pengaduan &rarr;</a>
        </div>
    </header>

    <div class="header-section">
        <div class="breadcrumb">
            Beranda <span class="dot"><i class="fas fa-circle"></i></span> Informasi
        </div>
        <h1 class="informasi-title">Informasi Kegiatan</h1>
        <p class="informasi-subtitle">Informasi Resmi dari pemerintah dusun, dan update kegiatan masyarakat serta informasi agenda penting dari wilayah dusun Pilang.</p>
        
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
            $mo = ['01'=>'Januari','02'=>'FEB','03'=>'MAR','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
            
            $index = 0;
            while($k = mysqli_fetch_array($result)) {
                $kategori = isset($k['jenis_kegiatan']) && !empty($k['jenis_kegiatan']) ? $k['jenis_kegiatan'] : 'Kegiatan';
                $kategori_badge = $kategori;
                
                $tgl_fmt = '';
                if($k['tanggal']) {
                    $time_parts = explode('-', $k['tanggal']);
                    if(count($time_parts) == 3) {
                        $tgl_fmt = (int)$time_parts[2] . ' ' . (isset($mo[$time_parts[1]]) ? $mo[$time_parts[1]] : $time_parts[1]) . ' ' . $time_parts[0];
                    } else {
                        $tgl_fmt = date('d M Y', strtotime($k['tanggal']));
                    }
                } else {
                    $tgl_fmt = 'Akan datang';
                }
                
                $w_mulai = !empty($k['waktu_mulai']) ? date('H.i', strtotime($k['waktu_mulai'])) : '00.00';
                $w_selesai = !empty($k['waktu_selesai']) ? date('H.i', strtotime($k['waktu_selesai'])) : '00.00';
                $waktu_str = $w_mulai . '-' . $w_selesai;
                $keterangan_snippet = !empty($k['keterangan']) ? mb_strimwidth(strip_tags($k['keterangan']), 0, 100, "...") : '-';
                $status_kegiatan = str_replace('_', ' ', $k['status']);
                $status_raw = $k['status'];
                $bg_status = '#fff0d4'; 
                $txt_status = '#b45309';
                if($status_raw == 'akan_datang') { $bg_status = '#4A65ED'; $txt_status = '#ffffff'; }
                elseif($status_raw == 'selesai') { $bg_status = '#546B41'; $txt_status = '#ffffff'; }
                elseif($status_raw == 'dimulai') { $bg_status = '#FF8409'; $txt_status = '#ffffff'; }
                elseif($status_raw == 'dibatalkan') { $bg_status = '#B42336'; $txt_status = '#ffffff'; }
                
                $delay = $index * 0.1;
                echo '<a href="detail_kegiatan.php?id='.intval($k['id_kegiatan']).'" class="activity-card" style="animation-delay: '.$delay.'s;">';
                echo '  <div class="card-img-container" style="position: relative; width: 100%; height: 200px; border-radius: 12px; overflow: hidden; margin-bottom: 12px;">';
                echo '      <span style="position: absolute; top: 12px; left: 12px; background: #ffffff; color: #356345; font-size: 11px; font-weight: 700; padding: 4px 14px; border-radius: 50px; z-index: 2; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">'.htmlspecialchars($kategori_badge).'</span>';
                echo '      <img src="assets/'.($k['foto']?$k['foto']:'placeholder.jpg').'" alt="'.htmlspecialchars($k['judul']).'" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src=\'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80\'">';
                echo '  </div>';
                
                echo '  <div style="display: flex; flex-direction: column; flex: 1;">';
                echo '      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">';
                echo '          <div style="display: flex; flex-direction: column; gap: 4px;">';
                echo '              <div style="font-size: 12px; color: #4e8357; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right:4px;"></i>'.$tgl_fmt.'</div>';
                echo '              <div style="font-size: 12px; color: #62836b; font-weight: 600;"><i class="far fa-clock" style="margin-right:4px;"></i>'.$waktu_str.'</div>';
                echo '          </div>';
                echo '          <div style="background: '.$bg_status.'; color: '.$txt_status.'; font-size: 9px; font-weight: 800; padding: 4px 12px; border-radius: 50px; text-transform: uppercase; white-space: nowrap;">'.htmlspecialchars($status_kegiatan).'</div>';
                echo '      </div>';
                
                echo '      <h3 style="font-size: 16px; color: #1f4228; font-weight: 800; line-height: 1.4; margin-bottom: 8px;">'.htmlspecialchars($k['judul']).'</h3>';
                echo '      <p style="font-size: 13px; color: #5a6660; line-height: 1.5; margin-bottom: 15px; flex: 1;">'.htmlspecialchars($keterangan_snippet).'</p>';
                echo '      <div class="read-more" style="font-size: 12px; font-weight: 800; color: #4e8357; display: flex; align-items: center; gap: 5px; margin-top: auto;">Baca artikel selengkapnya <i class="fas fa-arrow-right" style="font-size: 10px;"></i></div>';
                
                echo '  </div>';
                echo '</a>';
                
                $index++;
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
            echo "<div>Menampilkan ".($start + 1)."-{$end_item} dari total {$total} Kegiatan</div>";
        ?>
        <div class="pagination-links">
            <?php 
            $url_base = '?';
            if($kategori_filter && $kategori_filter !== 'Semua') {
                $url_base .= 'kategori=' . urlencode($kategori_filter) . '&';
            }
            
            for($i = 1; $i <= $pages; $i++) {
                $activeClass = ($i == $page) ? 'active' : '';
                echo '<a href="'.$url_base.'page='.$i.'" class="page-link '.$activeClass.'">'.$i.'</a>';
            }
            
            if($page < $pages) {
                echo '<a href="'.$url_base.'page='.($page+1).'" class="page-link"><i class="fas fa-chevron-right" style="font-size: 12px;"></i></a>';
            }
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
                    <li><a href="index.php#bisnis">• Bisnis Warga</a></li>
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
</body>
</html>
