<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dusun Pilang - Profil, Kegiatan, Business & Pengaduan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            padding: 20px;
        }
        .modal-content {
            background: white;
            width: 100%;
            max-width: 800px;
            max-height: 90vh;
            border-radius: 24px;
            position: relative;
            overflow-y: auto;
            padding: 30px;
            text-align: left;
            animation: modalIn 0.4s ease;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .btn-close {
            position: absolute;
            top: 20px;
            left: 20px;
            background: none;
            border: none;
            font-size: 24px;
            color: #12361A;
            cursor: pointer;
            z-index: 10;
        }
        .modal-header-flex {
            display: flex;
            gap: 30px;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .modal-img {
            width: 350px;
            height: 250px;
            border-radius: 16px;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }
        .modal-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .card-badge-modal {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #ffffff;
            color: #12361A;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 14px;
            z-index: 2;
        }
        .modal-info {
            flex: 1;
        }
        .modal-info h2 {
            font-size: 24px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 15px;
        }
        .info-row {
            font-size: 14px;
            font-weight: 700;
            color: #12361A;
            margin-bottom: 8px;
        }
        .info-row span {
            font-weight: 500;
        }
        .modal-actions-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }
        .btn-icon-outline {
            background: none;
            border: none;
            font-size: 18px;
            color: #ef4444;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn-icon-outline:active { transform: scale(1.2); }
        .btn-icon-outline.liked i { font-weight: 900; color: #ef4444; }
        
        /* Information Section Styles from List Page */
        .activity-card-mini {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            background: #e9f0df;
            border-radius: 20px;
            padding: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            flex: 1 1 250px;
            max-width: calc(25% - 15px);
        }
        .activity-card-mini:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        }
        .card-img-mini {
            position: relative;
            width: 100%;
            height: 160px;
        }
        .badge-left-mini {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #12361A;
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            z-index: 2;
        }
        .card-body-mini {
            padding: 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .meta-row-mini {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .meta-date-mini {
            font-size: 11px;
            font-weight: 800;
            color: #12361A;
            text-transform: uppercase;
        }
        .status-badge-mini {
            font-size: 8px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 50px;
            text-transform: uppercase;
            color: white;
        }
        .card-title-mini {
            font-size: 15px;
            color: #12361A;
            font-weight: 900;
            line-height: 1.3;
            margin-bottom: 8px;
            letter-spacing: -0.2px;
        }
        .card-desc-mini {
            font-size: 12px;
            color: #526f58;
            line-height: 1.5;
            margin-bottom: 15px;
            flex: 1;
            font-weight: 500;
        }
        .read-more-mini {
            font-size: 11px;
            font-weight: 800;
            color: #12361A;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        @media (max-width: 991px) {
            .activity-card-mini { max-width: calc(50% - 10px); }
        }
        @media (max-width: 600px) {
            .activity-card-mini { max-width: 100%; }
        }

        .btn-wa {
            background: #064e3b;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        .modal-desc {
            font-size: 14px;
            color: #12361A;
            line-height: 1.8;
            margin-bottom: 30px;
            padding: 20px;
            border: 2px dashed #e9f0df;
            border-radius: 16px;
        }
        .btn-location {
            background: #547c54;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        @media (max-width: 768px) {
            .modal-header-flex { flex-direction: column; }
            .modal-img { width: 100%; }
        }
        /* Bank Sampah Homepage Styles */
        .category-grid-home {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-top: 40px;
        }
        .category-card-premium {
            background: #ffffff;
            border-radius: 28px;
            padding: 24px;
            text-align: left;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid rgba(18, 54, 26, 0.02);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .category-card-premium:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(18, 54, 26, 0.08);
        }
        .category-card-premium img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 24px;
        }
        .category-card-premium h3 {
            font-size: 20px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .category-card-premium .desc {
            font-size: 13px;
            color: #62836b;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 12px;
            height: 38px;
            overflow: hidden;
        }
        .category-card-premium .cat {
            font-size: 13px;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .category-card-premium .cat span {
            color: #7DA67D;
        }
        .category-card-premium .price {
            font-size: 20px;
            font-weight: 900;
            color: #f58400;
            margin-top: auto;
        }

        @media (max-width: 1100px) {
            .category-grid-home { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 850px) {
            .category-grid-home { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 500px) {
            .category-grid-home { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="index.php" class="logo"><img src="https://ui-avatars.com/api/?name=DP&background=1E3B20&color=fff&rounded=true" alt="Logo" style="height: 32px; width: 32px; border-radius: 50%;"> Dusun Pilang</a>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Beranda</a></li>
                <li class="has-dropdown">
                    <a href="#profil">Profil Dusun <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="tentang_dusun.php">Tentang Dusun</a></li>
                        <li><a href="fasilitas.php">Fasilitas</a></li>
                    </ul>
                </li>
                <li><a href="informasi_kegiatan.php">Informasi</a></li>
                <li><a href="bisnis_warga.php">Bisnis Warga</a></li>
                <li class="has-dropdown">
                    <a href="#">Bank Sampah <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="bank_sampah.php">Pelayanan Sampah</a></li>
                        <li><a href="nasabah.php">Nasabah</a></li>
                    </ul>
                </li>
                <li><a href="kontak.php">Kontak</a></li>
            </ul>
            <a href="pengaduan.php" class="btn-primary">Pengaduan &rarr;</a>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <div class="tag">Terbuka, Informatif, dan Terpercaya. Bersama membangun dusun yang lebih baik.</div>
            <h1>Dusun<br>Pilang</h1>
            <p>Dusun Pilang, yang terletak di wilayah administrasi Desa Boja, Kecamatan Boja, Kabupaten Kendal, merupakan salah satu wilayah yang memiliki nilai historis, ditandai dengan keberadaan situs makam leluhur (pepunden) yang dihormati warga setempat.</p>
            <div class="hero-buttons">
                <a href="tentang_dusun.php" class="btn-primary" style="background-color: #052c13; padding: 12px 30px; font-size: 15px; border-radius: 10px;">Tentang Dusun</a>
            </div>
        </div>
    </section>

    <!-- Pengumuman Kegiatan -->
    <section id="informasi" class="section">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px;">
            <div class="section-header-title">
                <h2 style="font-size: 36px; font-weight: 800; color: #0b3018; margin-bottom: 2px; letter-spacing: -0.5px; font-family: 'Inter', sans-serif;">Pengumuman Kegiatan</h2>
                <p style="font-size: 15px; font-weight: 600; color: #62836b;">Informasi dan update terkini dari Dusun Pilang</p>
            </div>
            <a href="informasi_kegiatan.php" style="font-size: 14px; font-weight: 700; color: #5b8798; text-decoration: none; padding-bottom: 6px;">Lihat Semua</a>
        </div>
        
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <?php
            try {
                $query = mysqli_query($conn, "SELECT * FROM t_kegiatan_dusun ORDER BY tanggal DESC LIMIT 4");
                if($query && mysqli_num_rows($query) > 0) {
                    while($k = mysqli_fetch_array($query)) {
                        $kategori = isset($k['jenis_kegiatan']) && !empty($k['jenis_kegiatan']) ? $k['jenis_kegiatan'] : 'Berita Dusun';
                        
                        $mo = ['01'=>'JANUARI','02'=>'FEBRUARI','03'=>'MARET','04'=>'APRIL','05'=>'MEI','06'=>'JUNI','07'=>'JULI','08'=>'AGUSTUS','09'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'];
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
                        
                        $keterangan_snippet = !empty($k['keterangan']) ? mb_strimwidth(strip_tags($k['keterangan']), 0, 80, "...") : '-';
                        $status_kegiatan = str_replace('_', ' ', $k['status']);
                        $status_raw = $k['status'];
                        
                        $bg_status = '#49634b'; 
                        if($status_raw == 'akan_datang') $bg_status = '#f58400';
                        elseif($status_raw == 'selesai') $bg_status = '#49634b';
                        elseif($status_raw == 'dibatalkan') $bg_status = '#B42336';
                        
                        echo '<a href="detail_kegiatan.php?id='.intval($k['id_kegiatan']).'" class="activity-card-mini">';
                        echo '  <div class="card-img-mini">';
                        echo '      <span class="badge-left-mini">'.htmlspecialchars($kategori).'</span>';
                        echo '      <img src="assets/'.($k['foto']?$k['foto']:'placeholder.jpg').'" alt="'.htmlspecialchars($k['judul']).'" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src=\'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80\'">';
                        echo '  </div>';
                        
                        echo '  <div class="card-body-mini">';
                        echo '      <div class="meta-row-mini">';
                        echo '          <div class="meta-date-mini">'.$tgl_fmt.'</div>';
                        echo '          <div class="status-badge-mini" style="background: '.$bg_status.';">'.htmlspecialchars($status_kegiatan).'</div>';
                        echo '      </div>';
                        
                        echo '      <h3 class="card-title-mini">'.htmlspecialchars($k['judul']).'</h3>';
                        echo '      <p class="card-desc-mini">'.htmlspecialchars($keterangan_snippet).'</p>';
                        echo '      <div class="read-more-mini">Baca selengkapnya <i class="fas fa-arrow-right"></i></div>';
                        echo '  </div>';
                        echo '</a>';
                    }
                } else {
                    echo '<p style="color:#94a3b8; grid-column: span 4;">Belum ada kegiatan/pengumuman terbaru.</p>';
                }
            } catch (Exception $e) {
                echo '<p style="color:#94a3b8; grid-column: span 4;">Tidak dapat mengambil data kegiatan.</p>';
            }
            ?>
        </div>
    </section>

    <!-- Fasilitas Dusun -->
    <section id="fasilitas" class="section" style="background-color: #f8fafaf0;">
        <div class="section-header" style="margin-bottom: 30px;">
            <div class="section-header-title">
                <h2 style="font-size: 36px; font-weight: 800; color: #0b3018; margin-bottom: 2px; letter-spacing: -0.5px; font-family: 'Inter', sans-serif;">Fasilitas Dusun</h2>
                <p style="font-size: 15px; font-weight: 600; color: #62836b;">Sarana prasarana penunjang warga Dusun Pilang</p>
            </div>
        </div>
        
        <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
            <?php
            try {
                $query_fasilitas = mysqli_query($conn, "SELECT * FROM t_fasilitas_dusun ORDER BY id_fasilitas DESC LIMIT 3");
                if($query_fasilitas && mysqli_num_rows($query_fasilitas) > 0) {
                    while($f = mysqli_fetch_array($query_fasilitas)) {
                        echo '<div class="card interactive-card" style="box-shadow: none; border: none; text-align: center;" onclick="window.location.href=\'fasilitas.php\'">';
                        echo '<div class="card-img-wrap" style="height: 180px; margin-bottom: 12px; position:relative;">';
                        echo '<div style="position:absolute; top:10px; left:10px; background:white; width:30px; height:30px; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#12361A; z-index:2;"><i class="fas fa-building"></i></div>';
                        echo '<img src="assets/'.($f['foto'] ? $f['foto'] : 'placeholder.jpg').'" alt="'.htmlspecialchars($f['nama_fasilitas']).'" onerror="this.src=\'https://via.placeholder.com/400x300/e2e8f0/64748b?text=Fasilitas\'" style="width:100%; height:100%; object-fit:cover; border-radius:16px;">';
                        echo '</div>';
                        echo '<h3 class="card-title" style="font-size: 16px;">'.htmlspecialchars($f['nama_fasilitas']).'</h3>';
                        echo '<p style="font-size:13px; color:#62836b; margin-top:5px; font-weight:600;">PJ: '.htmlspecialchars($f['penanggung_jawab']).'</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="color:#94a3b8; grid-column: 1 / -1; text-align:center;">Belum ada data fasilitas dusun.</p>';
                }
            } catch (Exception $e) {
                echo '<p style="color:#94a3b8; grid-column: 1 / -1; text-align:center;">Tidak dapat mengambil data fasilitas.</p>';
            }
            ?>
        </div>
        <div class="text-center" style="margin-top: 40px;">
            <a href="fasilitas.php" class="btn-primary" style="padding: 12px 32px;">Lihat Semua Fasilitas &rarr;</a>
        </div>
    </section>

    <!-- Bisnis Warga -->
    <section id="bisnis" class="section">
        <div class="section-header" style="margin-bottom: 30px;">
            <div class="section-header-title">
                <h2 style="font-size: 36px; font-weight: 800; color: #0b3018; margin-bottom: 2px; letter-spacing: -0.5px; font-family: 'Inter', sans-serif;">Bisnis Warga</h2>
                <p style="font-size: 15px; font-weight: 600; color: #62836b;">Daftar bisnis usaha di wilayah dusun Pilang</p>
            </div>
        </div>
        
        <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
            <?php
            try {
                $query_bisnis = mysqli_query($conn, "SELECT * FROM t_bisnis_desa ORDER BY id_bisnis DESC LIMIT 6");
                if($query_bisnis && mysqli_num_rows($query_bisnis) > 0) {
                    while($b = mysqli_fetch_array($query_bisnis)) {
                        echo '<div class="card interactive-card" style="box-shadow: none; border: none; text-align: center;" onclick="openBisnisModal('.$b['id_bisnis'].')">';
                        echo '<div class="card-img-wrap" style="height: 180px; margin-bottom: 12px;">';
                        echo '<img src="assets/'.($b['foto'] ? $b['foto'] : 'placeholder_bisnis.jpg').'" alt="'.htmlspecialchars($b['nama_usaha']).'" onerror="this.src=\'https://via.placeholder.com/400x300/e2e8f0/64748b?text=Usaha\'">';
                        echo '</div>';
                        echo '<h3 class="card-title" style="font-size: 16px;">'.htmlspecialchars($b['nama_usaha']).'</h3>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="color:#94a3b8; grid-column: 1 / -1;">Belum ada data bisnis warga.</p>';
                }
            } catch (Exception $e) {
                echo '<p style="color:#94a3b8; grid-column: 1 / -1;">Tidak dapat mengambil data bisnis.</p>';
            }
            ?>
        </div>
        <div class="text-center" style="margin-top: 40px;">
            <a href="bisnis_warga.php" class="btn-primary" style="padding: 12px 32px;">Lihat Semua Bisnis &rarr;</a>
        </div>
    </section>

    <!-- Bank Sampah Section -->
    <section id="bank-sampah" style="background-color: white; padding-top: 80px;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div class="section-header" style="text-align: left; margin-bottom: 40px; display: block;">
                <h2 style="font-size: 36px; font-weight: 900; color: #12361A; margin-bottom: 8px;">Bank Sampah</h2>
                <p style="font-size: 16px; color: #62836b; font-weight: 500; letter-spacing: 0.2px;">Program Pelayanan lingkungan sehat bagi masyarakat</p>
            </div>
        </div>
        
        <div style="background-color: #DCE4C9; padding: 60px 0 100px;">
            <div class="container" style="max-width: 1200px; margin: 0 auto;">
                <div class="category-grid-home">
                    <?php
                    $sampah_list = [
                        ['nama' => 'Botol Plastik Tipe A', 'desc' => 'Tipe A (Sampah Dalam Keadaan Bersih)', 'kat' => 'Plastik', 'harga' => '3,000', 'img' => 'assets/botol_plastik_tipe_a.png'],
                        ['nama' => 'Botol Plastik Tipe B', 'desc' => 'Tipe B (Sampah Dalam Keadaan Tidak Bersih)', 'kat' => 'Plastik', 'harga' => '1,500', 'img' => 'assets/botol_plastik_tipe_b.png'],
                        ['nama' => 'Kardus', 'desc' => '&nbsp;', 'kat' => 'Kertas', 'harga' => '1,000', 'img' => 'assets/kardus.png'],
                        ['nama' => 'Kaleng', 'desc' => '&nbsp;', 'kat' => 'Logam', 'harga' => '5,000', 'img' => 'assets/kaleng.png'],
                        ['nama' => 'Buku Bekas - HVS', 'desc' => '&nbsp;', 'kat' => 'Kertas', 'harga' => '1,500', 'img' => 'assets/buku_bekas.png'],
                        ['nama' => 'Botol kaca', 'desc' => 'Botol kaca yang diterima meliputi botol dalam kondisi bersih dan tidak pecah.', 'kat' => 'Kaca', 'harga' => '1,500', 'img' => 'assets/botol_kaca.png'],
                        ['nama' => 'Besi', 'desc' => 'Besi yang diterima dalam kondisi kering, bersih, dan aman.', 'kat' => 'Logam', 'harga' => '4,500', 'img' => 'assets/besi.png'],
                        ['nama' => 'Koran', 'desc' => '&nbsp;', 'kat' => 'Kertas', 'harga' => '1,000', 'img' => 'assets/koran.png']
                    ];
                    foreach($sampah_list as $s):
                    ?>
                    <div class="category-card-premium">
                        <img src="<?php echo $s['img']; ?>" alt="<?php echo $s['nama']; ?>">
                        <h3><?php echo $s['nama']; ?></h3>
                        <?php if($s['desc'] != '&nbsp;'): ?>
                            <p class="desc"><?php echo $s['desc']; ?></p>
                        <?php endif; ?>
                        <div class="cat">Kategori : <span><?php echo $s['kat']; ?></span></div>
                        <div class="price">Rp. <?php echo $s['harga']; ?>/Kg</div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div style="text-align: right; margin-top: 30px;">
                    <a href="bank_sampah.php" class="section-link" style="font-weight: 800; color: #12361A;">Informasi selengkapnya &rarr;</a>
                </div>
            </div>
        </div>

    <!-- Pengaduan Section -->
    <section id="kontak" class="section" style="padding: 80px 0;">
        <div class="container">
            <div class="section-header">
                <div class="section-header-title">
                    <h2 class="section-title">Pengaduan</h2>
                    <p class="section-desc">Sampaikan keluhan, kritik, atau saran Anda untuk kemajuan dusun kami !</p>
                </div>
            </div>
        
        <form action="proses_pengaduan.php" method="POST" enctype="multipart/form-data" style="max-width: 900px;">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama">
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="hp" class="form-control" placeholder="Masukkan No. Telp">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <div class="category-pills">
                    <button type="button" class="category-pill active">Fasilitas</button>
                    <button type="button" class="category-pill">Keamanan</button>
                    <button type="button" class="category-pill">Saran</button>
                    <button type="button" class="category-pill">DLL</button>
                    <input type="hidden" name="kategori" id="input_kategori" value="Fasilitas">
                </div>
            </div>
            <div class="form-group">
                <label>Judul Pengaduan</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul">
            </div>
            <div class="form-group" style="align-items: flex-start;">
                <label style="margin-top: 15px;">Pengaduan</label>
                <textarea name="isi" class="form-control" placeholder="Masukkan pengaduan Anda."></textarea>
            </div>
            <div class="form-group" style="align-items: flex-start; margin-top: 20px;">
                <label style="margin-top: 30px;">Foto</label>
                <div style="flex: 1;">
                    <div style="position: relative; width: 300px; height: 180px; border-radius: 12px; overflow: hidden; background: #ddd;">
                        <div style="position: absolute; bottom: 15px; left: 0; right: 0; text-align: center;">
                            <label class="btn-secondary" style="font-size: 13px; padding: 8px 16px; background: rgba(255,255,255,0.8); backdrop-filter: blur(4px); cursor: pointer; border: none;">
                                Pilih Foto
                                <input type="file" name="foto" style="display: none;">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label></label>
                <div style="flex: 1;">
                    <button type="submit" class="btn-primary" style="margin-top: 20px;">Kirim aduan &rarr;</button>
                </div>
            </div>
        </form>
    </section>

    <footer>
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
                    <li><a href="#profil">• Tentang Dusun</a></li>
                    <li><a href="#informasi">• Informasi Kegiatan</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>LAYANAN</h3>
                <ul>
                    <li><a href="#bisnis">• Bisnis Warga</a></li>
                    <li><a href="#">• Bank Sampah</a></li>
                    <li><a href="#">• Pendaftaran Nasabah</a></li>
                    <li><a href="pengaduan.php">• Pengaduan Publik</a></li>
                    <li><a href="kontak.php">• Hubungi Kami</a></li>
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
        <div class="footer-bottom">
            <p>&copy; 2026 Dusun Pilang</p>
        </div>
    </footer>
    
    <!-- Modal Detail Bisnis -->
    <div class="modal-overlay" id="bisnisModalOverlay">
        <div class="modal-content">
            <button class="btn-close" onclick="closeBisnisModal()"><i class="fas fa-times"></i></button>
            <div id="bisnisModalBody">
                <!-- Content will be injected by JS -->
            </div>
        </div>
    </div>

    <script>
        // Data Bisnis untuk Modal
        <?php
        $all_bisnis = [];
        $q_all = mysqli_query($conn, "SELECT * FROM t_bisnis_desa");
        while($row = mysqli_fetch_assoc($q_all)) { $all_bisnis[] = $row; }
        ?>
        const allBisnis = <?php echo json_encode($all_bisnis); ?>;

        function openBisnisModal(id) {
            const b = allBisnis.find(item => item.id_bisnis == id);
            if(!b) return;

            let icon = 'fas fa-store';
            const jenis = b.jenis_usaha.toLowerCase();
            if (jenis.includes('tani') || jenis.includes('padi')) icon = 'fas fa-seedling';
            else if (jenis.includes('ternak')) icon = 'fas fa-truck';
            else if (jenis.includes('jasa')) icon = 'fas fa-concierge-bell';

            const modalBody = document.getElementById('bisnisModalBody');
            modalBody.innerHTML = `
                <div class="modal-header-flex">
                    <div class="modal-img">
                        <div class="card-badge-modal"><i class="${icon}"></i></div>
                        <img src="assets/${b.foto ? b.foto : 'placeholder.jpg'}" alt="Foto">
                    </div>
                    <div class="modal-info">
                        <h2>${b.nama_usaha}</h2>
                        <div class="info-row">Jenis Usaha : <span>${b.jenis_usaha}</span></div>
                        <div class="info-row">Pemilik : <span>${b.nama_pengusaha}</span></div>
                        <div class="modal-actions-top">
                            <button class="btn-icon-outline" onclick="toggleLike(this)"><i class="far fa-heart"></i></button>
                            <button class="btn-icon-outline" style="color: #62836b;" onclick="copyLink()"><i class="far fa-clone"></i></button>
                            <a href="https://wa.me/${b.no_telp.replace(/\D/g, '')}" class="btn-wa" target="_blank">
                                <i class="fab fa-whatsapp"></i> Hubungi Penjual
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-desc">
                    ${b.keterangan}
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(b.alamat)}" class="btn-location" target="_blank">
                    <i class="fas fa-map-marker-alt"></i> Lihat Lokasi Usaha
                </a>
            `;

            document.getElementById('bisnisModalOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeBisnisModal() {
            document.getElementById('bisnisModalOverlay').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function toggleLike(btn) {
            btn.classList.toggle('liked');
            const icon = btn.querySelector('i');
            if(btn.classList.contains('liked')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link disalin ke clipboard!');
            });
        }

        document.getElementById('bisnisModalOverlay').addEventListener('click', function(e) {
            if(e.target === this) closeBisnisModal();
        });

        // Kategori pill selection logic
        const pills = document.querySelectorAll('.category-pill');
        const inputKategori = document.getElementById('input_kategori');
        
        pills.forEach(pill => {
            pill.addEventListener('click', () => {
                pills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
                inputKategori.value = pill.textContent;
            });
        });
    </script>

    <!-- Keren Floating Admin Login Button -->
    <a href="admin/login.php" class="floating-admin">
        <i class="fas fa-user-shield"></i>
        <span>Portal Admin</span>
    </a>
</body>
</html>