<?php 
require_once 'config.php'; 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($conn, "SELECT * FROM t_kegiatan_dusun WHERE id_kegiatan = $id");
if(!$query || mysqli_num_rows($query) == 0) {
    header("Location: index.php");
    exit;
}
$k = mysqli_fetch_array($query);

$mo = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
$bulan = date('m', strtotime($k['tanggal']));
$tgl_fmt_full = date('d', strtotime($k['tanggal'])) . ' ' . strtoupper($mo[$bulan]) . ' ' . date('Y', strtotime($k['tanggal']));

$waktu_mulai = !empty($k['waktu_mulai']) ? date('H.i', strtotime($k['waktu_mulai'])) : '00.00';
$waktu_selesai = !empty($k['waktu_selesai']) ? date('H.i', strtotime($k['waktu_selesai'])) : '00.00';
$jam_pelaksanaan = $waktu_mulai . ' - ' . $waktu_selesai;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($k['judul']) ?> - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .detail-container { max-width: 900px; margin: 40px auto; padding: 0 20px; color: #1e3b20; }
        .breadcrumb { font-size: 13px; color: #4e8357; font-weight: 600; margin-bottom: 20px; }
        .breadcrumb a { color: #4e8357; text-decoration: none; }
        .breadcrumb a:hover { color: #0b3018; }
        .detail-badge { display: inline-block; background: #e0eee0; color: #1f4d29; font-weight: 700; font-size: 11px; padding: 6px 16px; border-radius: 5px; margin-bottom: 15px; text-transform: uppercase; }
        .detail-title { font-size: 38px; font-weight: 800; color: #0b3018; line-height: 1.3; margin-bottom: 25px; letter-spacing: -0.5px; }
        .detail-meta-wrapper { display: flex; justify-content: flex-start; gap: 50px; margin-bottom: 35px; border-top: 1px solid #eaede5; border-bottom: 1px solid #eaede5; padding: 20px 0; }
        .meta-item { display: flex; align-items: flex-start; gap: 12px; }
        .meta-icon { font-size: 24px; color: #5b7962; margin-top: 2px; }
        .meta-info { display: flex; flex-direction: column; }
        .meta-label { font-size: 13px; font-weight: 600; color: #62836b; margin-bottom: 4px; }
        .meta-value { font-size: 14px; font-weight: 800; color: #0b3018; }
        
        .detail-image { width: 100%; border-radius: 16px; margin-bottom: 35px; object-fit: cover; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .detail-content { font-size: 15.5px; line-height: 1.8; color: #35533e; font-weight: 500; margin-bottom: 40px; }
        .detail-content p { margin-bottom: 20px; }
        
        .btn-status { display: inline-block; background: #ff8c00; color: white; padding: 10px 24px; font-weight: 700; border-radius: 50px; font-size: 14px; margin-bottom: 30px; text-transform: capitalize; }
        
        .share-section { display: flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid #eaede5; margin-bottom: 40px; }
        .share-icons { display: flex; align-items: center; gap: 12px; font-weight: 700; color: #0b3018; font-size: 14px; }
        .share-icon { width: 32px; height: 32px; display: inline-flex; justify-content: center; align-items: center; border-radius: 8px; color: white; text-decoration: none; font-size: 16px; }
        .share-ig { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
        .share-wa { background: #25d366; }
        .btn-lainnya { background: #0b3018; color: white; padding: 10px 24px; font-weight: 600; border-radius: 8px; text-decoration: none; font-size: 13px; transition: 0.3s; }
        .btn-lainnya:hover { opacity: 0.9; }
        
        .nav-footer-spacer { margin-top: 20px; text-align: center; }
        .nav-footer-spacer a { color: #1e3b20; text-decoration: none; font-weight: 600; font-size: 14px; }
    </style>
</head>
<body>
    <header style="background: white; position: sticky; top: 0; padding-bottom: 20px; border-bottom: 1px solid #eaede5;">
        <div class="navbar" style="box-shadow: none; border: 1px solid #eaede5; margin-top: 10px;">
            <a href="index.php" class="logo"><img src="https://ui-avatars.com/api/?name=DP&background=1E3B20&color=fff&rounded=true" alt="Logo" style="height: 32px; width: 32px; border-radius: 50%;"> Dusun Pilang</a>
            <!-- Keep minimal nav for detail -->
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="index.php#informasi" class="active">Informasi</a></li>
                <li><a href="index.php#bisnis">Bisnis Warga</a></li>
                <li><a href="index.php#kontak">Kontak</a></li>
            </ul>
        </div>
    </header>

    <div class="detail-container">
        <div class="breadcrumb">
            <a href="index.php">Beranda</a> &rsaquo; <a href="index.php#informasi">Informasi</a> &rsaquo; <span style="color:#0b3018;">Baca Artikel</span>
        </div>
        
        <div class="detail-badge"><?= htmlspecialchars($k['jenis_kegiatan']) ?></div>
        
        <h1 class="detail-title"><?= htmlspecialchars($k['judul']) ?></h1>
        
        <div class="detail-meta-wrapper">
            <div class="meta-item">
                <i class="fas fa-calendar-alt meta-icon"></i>
                <div class="meta-info">
                    <span class="meta-label">Tanggal Terbit</span>
                    <span class="meta-value"><?= $tgl_fmt_full ?></span>
                </div>
            </div>
            <div class="meta-item">
                <i class="far fa-clock meta-icon"></i>
                <div class="meta-info">
                    <span class="meta-label">Jam Pelaksanaan</span>
                    <span class="meta-value"><?= $jam_pelaksanaan ?></span>
                </div>
            </div>
        </div>
        
        <img src="<?= htmlspecialchars(strpos($k['foto'], 'http') === 0 ? $k['foto'] : 'assets/'.$k['foto']) ?>" alt="<?= htmlspecialchars($k['judul']) ?>" class="detail-image" onerror="this.src='https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'">
        
        <div class="detail-content">
            <?= nl2br(htmlspecialchars($k['keterangan'] ?: 'Tidak ada keterangan detail yang tersedia untuk kegiatan ini.')) ?>
        </div>
        
        <div class="btn-status">Status : <?= str_replace('_', ' ', htmlspecialchars($k['status'])) ?></div>
        
        <div class="share-section">
            <div class="share-icons">
                Bagikan : 
                <a href="#" class="share-icon share-ig"><i class="fab fa-instagram"></i></a>
                <a href="#" class="share-icon share-wa"><i class="fab fa-whatsapp"></i></a>
            </div>
            <a href="index.php#informasi" class="btn-lainnya">Lihat informasi lainnya</a>
        </div>
        
        <div class="nav-footer-spacer">
            <a href="index.php">&lsaquo; Eksplorasi Web Desa</a>
        </div>
    </div>
    
    <footer style="margin-top: 0;">
        <div class="footer-grid">
            <div class="footer-col">
                <div style="display:flex; align-items:center; gap: 10px; margin-bottom: 20px;">
                    <img src="https://ui-avatars.com/api/?name=DP&background=fff&color=1E3B20&rounded=true" style="height: 40px; width:40px; border-radius:50%;" alt="Logo">
                    <h3 style="margin-bottom:0; color:#fff;">Dusun Pilang</h3>
                </div>
                <p>Mewujudkan masyarakat yang mandiri, berkarakter, dan sejahtera.</p>
            </div>
        </div>
    </footer>
</body>
</html>
