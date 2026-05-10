<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Dusun - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #ffffff;
        }
        /* Top Header */
        .tentang-header {
            text-align: center;
            padding: 30px 20px 60px;
        }
        .tentang-title {
            font-size: 48px;
            font-weight: 900;
            color: #12361A;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .tentang-subtitle {
            font-size: 15px;
            color: #4a6d41;
            max-width: 700px;
            margin: 0 auto 25px;
            line-height: 1.7;
            font-weight: 500;
        }
        .breadcrumb {
            font-size: 13px;
            font-weight: 600;
            color: #8fa696;
        }
        .breadcrumb a {
            color: #62836b;
            text-decoration: none;
        }
        .breadcrumb span {
            color: #12361A;
            font-weight: 800;
        }

        /* Sections Grid */
        .tentang-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            max-width: 1100px;
            margin: 0 auto 80px;
            padding: 0 20px;
            align-items: start;
        }
        .tentang-img-left img {
            width: 100%;
            height: auto;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .tag-profil {
            display: inline-block;
            background: #e9f0df;
            color: #4a6d41;
            font-size: 13px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 20px;
        }
        .tentang-text h2 {
            font-size: 32px;
            font-weight: 900;
            color: #12361A;
            margin-bottom: 25px;
            letter-spacing: -0.5px;
        }
        .tentang-text p {
            font-size: 15px;
            color: #4a6d41;
            line-height: 1.8;
            font-weight: 500;
            text-align: justify;
        }

        .kadus-profile {
            margin-top: 30px;
            text-align: left;
        }
        .kadus-profile img {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 20px;
        }
        .kadus-desc {
            font-size: 13px !important;
            line-height: 1.6 !important;
            color: #62836b !important;
        }
        .kadus-desc b {
            color: #12361A;
        }

        /* Lokasi Section */
        .lokasi-section {
            text-align: center;
            max-width: 1100px;
            margin: 0 auto 100px;
            padding: 0 20px;
        }
        .lokasi-section h2 {
            font-size: 32px;
            font-weight: 900;
            color: #12361A;
            margin-bottom: 10px;
        }
        .lokasi-subtitle {
            font-size: 15px;
            color: #4a6d41;
            margin-bottom: 50px;
            font-weight: 500;
        }

        .lokasi-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            text-align: left;
        }
        .info-box {
            background: #e9f0df;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 20px;
        }
        .info-box h3 {
            font-size: 18px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 15px;
        }
        .info-box p {
            font-size: 14px;
            color: #4a6d41;
            line-height: 1.6;
            font-weight: 500;
            margin-bottom: 5px;
        }
        .btn-maps {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #0b3018;
            color: white;
            padding: 16px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-maps:hover {
            background: #12361A;
            transform: translateY(-2px);
        }
        .lokasi-map {
            border-radius: 16px;
            overflow: hidden;
            height: 450px;
            background: #f1f5f9;
        }
        
        @media (max-width: 900px) {
            .tentang-section { grid-template-columns: 1fr; gap: 40px; }
            .lokasi-grid { grid-template-columns: 1fr; }
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
                    <a href="#" class="active">Profil Dusun <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="tentang_dusun.php" class="active">Tentang Dusun</a></li>
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

    <div class="tentang-header">
        <h1 class="tentang-title">Dusun<br>Pilang</h1>
        <p class="tentang-subtitle">Mengenal lebih dekat potensi dan progresivitas Dusun Pilang dalam membangun masyarakat yang mandiri dan sejahtera untuk kita semua.</p>
        <div class="breadcrumb">
            <a href="index.php">Beranda</a> <span style="margin: 0 10px; font-size: 10px;"><i class="fas fa-chevron-right"></i></span> <span>Tentang Dusun</span>
        </div>
    </div>

    <!-- Section 1: Mengenal Dusun Pilang -->
    <div class="tentang-section">
        <div class="tentang-img-left">
            <img src="assets/dusun.png" alt="Gerbang Dusun Pilang" onerror="this.src='https://via.placeholder.com/800x600/e2e8f0/64748b?text=Gerbang+Dusun'">
        </div>
        <div class="tentang-text">
            <div class="tag-profil">Profil Singkat</div>
            <h2>Mengenal Dusun Pilang</h2>
            <p>Dusun Pilang merupakan salah satu dusun di Desa Boja, Kecamatan Boja, Kabupaten Kendal, yang sejarahnya berkaitan dengan asal-usul Desa Boja serta penyebaran agama Islam oleh Ki Wonosari, pengikut Nyai Pandansari (Ni Dhapu), yang menetap dan dimakamkan di wilayah ini, kemudian berkembang dari kawasan hutan yang dibuka pada masa kolonisasi sekitar tahun 1937-1939 hingga menjadi permukiman masyarakat yang tetap menjunjung tinggi nilai gotong royong, kebersamaan, serta pelestarian budaya lokal.</p>
        </div>
    </div>

    <!-- Section 2: Sejarah Singkat -->
    <div class="tentang-section">
        <div class="tentang-text">
            <h2>Sejarah Singkat</h2>
            <div class="kadus-profile">
                <!-- Foto Kadus Placeholder -->
                <img src="assets/kepala.png" alt="Kepala Dusun" onerror="this.src='https://ui-avatars.com/api/?name=Kadus&background=e9f0df&color=12361A&size=250&rounded=true'">
                <p class="kadus-desc">
                    Sosok Kepala Dusun Pilang saat ini diemban oleh figur yang peduli untuk terus membangun komunikasi efektif dan memajukan dusun. Keberadaan Kadus berperan krusial dalam menjaga kondusivitas warga Dusun Pilang. <br><b>Kepala Dusun Pilang saat ini : Bpk. Riyanto</b>
                </p>
            </div>
        </div>
        <div class="tentang-text">
            <p>Dusun Pilang merupakan wajah nyata sebuah peradaban masa lalu, kendati hal ini diakui dan terbukti dari keberadaannya makam dari pendahulu (pepunden) Desa Boja yang sekarang ada dan ditandai peninggalannya yakni Makam Ki Wonosari. Tokoh masyarakat ini yang dulu diyakini memang dipusarakan hingga saat ini memang di wilayah ini, makamnya dapat dikunjungi hingga saat ini, seringkali menjadi tempat bersejarah bagi warga.</p>
            <br>
            <p>Dulu masyarakat wilayah Dusun Pilang dominasinya adalah sebagai kawasan lahan garapan sawah dan kebun dari warga sekitarnya. Seiring bergantinya waktu, wilayah dusun ini bertransformasi dari sekadar lahan pertanian menjadi area perumahan bagi warga pendatang maupun warga lokal yang terus membesar. Dusun ini terus tumbuh menjadi kompleks perumahan modern yang menetap, warganya pun beragam latar belakangnya, namun tetap senantiasa menjaga tradisi rukun bertetangga, gotong royong, serta melestarikan budaya lokal Dusun Pilang.</p>
        </div>
    </div>

    <!-- Section 3: Lokasi Dusun -->
    <div class="lokasi-section">
        <h2>Lokasi Dusun</h2>
        <p class="lokasi-subtitle">Kunjungi dan temukan langsung pesona dusun kami melalui peta di bawah ini</p>
        
        <div class="lokasi-grid">
            <div class="lokasi-info">
                <div class="info-box">
                    <h3>Lokasi</h3>
                    <p>Dusun Pilang, Desa Boja, Kecamatan Boja, Kabupaten Kendal, Jawa Tengah 51381</p>
                </div>
                <div class="info-box">
                    <h3>Kontak Info</h3>
                    <p>Telepon: <b>(082) 1234567</b></p>
                    <p>Email: <b>dusunpilang06@gmail.com</b></p>
                </div>
                <a href="https://maps.google.com" target="_blank" class="btn-maps">Buka di Google Maps <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="lokasi-map">
                <!-- Embed Google Maps here -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15837.96541285493!2d110.2662!3d-7.0988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e707bc2909470f1%3A0xb71e16fdf942730a!2sBoja%2C%20Kendal%20Regency%2C%20Central%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

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
</body>
</html>
