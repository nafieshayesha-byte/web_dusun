<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak & Lokasi - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .kontak-container {
            max-width: 1200px;
            margin: 60px auto 100px;
            padding: 0 20px;
        }
        .hubungi-badge {
            display: inline-block;
            background-color: #E2EAC7;
            padding: 8px 25px;
            border-radius: 50px;
            color: #12361A;
            font-weight: 800;
            font-size: 14px;
            margin-bottom: 40px;
        }
        .header-kontak {
            text-align: center;
            margin-bottom: 60px;
        }
        .header-kontak h1 {
            font-size: 42px;
            font-weight: 900;
            color: #12361A;
            margin-bottom: 10px;
        }
        .header-kontak p {
            color: #62836b;
            font-size: 16px;
            font-weight: 600;
        }
        .kontak-grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 40px;
            align-items: start;
        }
        .info-card {
            background-color: #E2EAC7;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 20px;
        }
        .info-card h2 {
            font-size: 24px;
            font-weight: 900;
            color: #12361A;
            margin-bottom: 15px;
        }
        .info-card p {
            font-size: 14px;
            line-height: 1.8;
            color: #526146;
            font-weight: 600;
        }
        .info-card .detail-row {
            margin-bottom: 10px;
            font-size: 14px;
            color: #526146;
            font-weight: 600;
        }
        .btn-maps {
            background-color: #12361A;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 18px 30px;
            font-size: 18px;
            font-weight: 800;
            width: 100%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-maps:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(18, 54, 26, 0.2);
        }
        .map-frame {
            background-color: #f5f5f5;
            border-radius: 30px;
            height: 550px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .map-frame iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        @media (max-width: 991px) {
            .kontak-grid { grid-template-columns: 1fr; }
            .map-frame { height: 400px; }
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="index.php" class="logo"><img src="https://ui-avatars.com/api/?name=DP&background=1E3B20&color=fff&rounded=true" alt="Logo"> Dusun Pilang</a>
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li class="has-dropdown">
                    <a href="#">Profil Dusun <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
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
                <li><a href="kontak.php" class="active">Kontak</a></li>
            </ul>
            <a href="pengaduan.php" class="btn-primary">Pengaduan &rarr;</a>
        </div>
    </header>

    <main class="kontak-container">
        <div class="hubungi-badge">Hubungi Kami</div>
        
        <div class="header-kontak">
            <h1>Lokasi Dusun</h1>
            <p>Kunjungi dan rasakan langsung suasana dusun kami yang asri dan penuh kehangatan.</p>
        </div>

        <div class="kontak-grid">
            <div class="kontak-info">
                <div class="info-card">
                    <h2>Lokasi</h2>
                    <p>Dusun Pilang, Kecamatan Boja Kabupaten Kendal, Provinsi Jawa Tengah, Kode Pos 51381.</p>
                </div>
                <div class="info-card">
                    <h2>Kontak Info</h2>
                    <div class="detail-row">Telepon: <b>(082) 1234567</b></div>
                    <div class="detail-row">Email: <b>dusunpilang06@gmail.id</b></div>
                </div>
                <a href="https://maps.google.com" target="_blank" class="btn-maps">Buka di Google Maps &rarr;</a>
            </div>
            
            <div class="map-frame">
                <!-- Replace with real embed link if available -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15837.755047805212!2d110.285493!3d-7.075059!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDQnMzAuMiJTIDExMMKwMTcnMDcuOCJF!5e0!3m2!1sen!2sid!4v1620560000000!5m2!1sen!2sid" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </main>

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
                        <span><b>EMAIL RESMI</b><br>dusunpilang06@gmail.id</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Dusun Pilang</p>
        </div>
    </footer>
    
        <a href="admin/login.php" class="floating-admin">
        <i class="fas fa-user-shield"></i>
        <span>Portal Admin</span>
    </a>
</body>
</html>
