<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .header-bank {
            text-align: center;
            padding: 40px 20px 60px;
            background: linear-gradient(180deg, #F0F4E8 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
        }
        .header-bank::before {
            content: '🍃';
            position: absolute;
            top: 20px;
            left: 5%;
            font-size: 40px;
            opacity: 0.1;
            transform: rotate(-15deg);
        }
        .header-bank::after {
            content: '♻️';
            position: absolute;
            bottom: 20px;
            right: 5%;
            font-size: 40px;
            opacity: 0.1;
            transform: rotate(15deg);
        }
        .header-bank h1 {
            font-size: 48px;
            font-weight: 900;
            color: #12361A;
            margin: 0 0 40px 0;
            letter-spacing: -1px;
        }
        .header-bank p {
            color: #62836b;
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }
        .breadcrumb {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
            color: #8fa696;
            gap: 10px;
        }
        .breadcrumb a { text-decoration: none; color: #8fa696; }
        .breadcrumb i { font-size: 10px; }

        .about-section {
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        .about-section h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #12361A;
        }
        .about-section p {
            max-width: 1000px;
            margin: 0 auto;
            line-height: 2;
            color: #526146;
            font-size: 15px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1100px;
            margin: 40px auto 80px;
            padding: 0 20px;
        }
        .stat-card {
            background: #ffffff;
            padding: 40px 20px;
            border-radius: 24px;
            text-align: center;
            border: 2px solid #F0F4E8;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            border-color: #7DA67D;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .stat-card i {
            font-size: 40px;
            color: #12361A;
            margin-bottom: 20px;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: 900;
            color: #12361A;
            margin-bottom: 5px;
            display: block;
        }
        .stat-card .label {
            font-size: 16px;
            font-weight: 700;
            color: #12361A;
        }

        .steps-section {
            padding: 80px 20px;
            background-color: #ffffff;
            text-align: center;
        }
        .steps-section h2 {
            font-size: 36px;
            margin-bottom: 50px;
            color: #12361A;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Back to 4 columns */
            gap: 20px;
            max-width: 1300px; /* Slightly wider container to help landscape feel */
            margin: 0 auto;
        }
        .step-card {
            background: #F0F4E8;
            padding: 0 30px 45px; /* Removed top padding to push image to top */
            border-radius: 32px;
            text-align: center;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            border: 1px solid rgba(18, 54, 26, 0.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            overflow: hidden; /* Ensure image doesn't overflow rounded corners */
        }
        .step-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(18, 54, 26, 0.12);
            background: #ffffff;
            border-color: #F0F4E8;
        }

        .step-card img {
            width: calc(100% + 60px); /* Fill the entire width including card padding */
            margin-left: -30px;
            margin-right: -30px;
            height: 180px; /* Adjusted height for better rectangular look with no gaps */
            margin-bottom: 25px;
            object-fit: cover;
            transition: all 0.4s ease;
        }
        .step-card:hover img {
            transform: scale(1.05) translateY(-8px);
        }
        .step-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #12361A;
            letter-spacing: -0.5px;
        }
        .step-card p {
            font-size: 14px;
            line-height: 1.6;
            color: #12361A;
            font-weight: 500;
            max-width: 90%;
        }

        .categories-section {
            padding: 80px 5%;
            background-color: #e2eac7; /* Matching the olive background in the image */
            text-align: left;
        }
        .categories-section h2 {
            font-size: 36px;
            font-weight: 900;
            color: #12361A;
            margin-bottom: 8px;
        }
        .categories-section .subtitle {
            color: #526146;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 40px;
        }
        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .category-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            text-align: left;
            padding: 24px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            user-select: none;
        }
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(18, 54, 26, 0.1);
        }
        .category-card:active {
            transform: scale(0.95) translateY(-4px); /* Press effect */
            background-color: #f9fbf2;
        }
        .category-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 20px;
            transition: transform 0.6s ease;
        }
        .category-card:hover img {
            transform: scale(1.05);
        }
        .category-card h3 {
            font-size: 18px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 6px;
        }
        .category-card .desc {
            font-size: 11px;
            font-weight: 800;
            color: #12361A;
            line-height: 1.4;
            margin-bottom: 8px;
        }
        .category-card .cat-label {
            font-size: 11px;
            font-weight: 700;
            color: #8fa696;
            margin-bottom: 20px;
            display: block;
        }
        .category-card .price {
            font-size: 16px;
            font-weight: 800;
            color: #f58400;
            margin-top: auto;
        }

        .schedule-banner {
            max-width: 1200px;
            margin: 80px auto;
            background: #ffffff;
            border: 2px solid #F0F4E8;
            border-radius: 40px;
            padding: 40px;
            display: flex;
            align-items: center;
            gap: 50px;
            position: relative;
            overflow: hidden;
        }
        .schedule-banner::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/leaf.png');
            opacity: 0.05;
        }
        .schedule-img {
            flex-shrink: 0;
            width: 400px;
        }
        .schedule-content {
            flex: 1;
        }
        .schedule-content h2 {
            font-size: 32px;
            color: #12361A;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .schedule-info {
            background: #F0F4E8;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 20px;
        }
        .schedule-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 15px;
            font-weight: 700;
            color: #12361A;
        }
        .schedule-row i {
            color: #7DA67D;
            width: 20px;
        }
        .schedule-footer {
            font-size: 14px;
            color: #62836b;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 991px) {
            .steps-grid, .category-grid { grid-template-columns: repeat(2, 1fr); }
            .schedule-banner { flex-direction: column; text-align: center; }
            .schedule-img { width: 100%; max-width: 300px; }
            .schedule-content h2 { justify-content: center; }
        }
        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .steps-grid, .category-grid { grid-template-columns: 1fr; }
            .header-bank h1 { font-size: 32px; }
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
                    <a href="#" class="active">Bank Sampah <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
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

    <div class="header-bank">
        <h1>Pelayanan Sampah</h1>
        <p>Satu wadah pengelolaan sampah masyarakat di Dusun Pilang yang lebih bersih dan berkelanjutan.</p>
        <div class="breadcrumb">
            <a href="index.php">Beranda</a> <i class="fas fa-chevron-right"></i> Bank Sampah
        </div>
    </div>

    <section class="about-section">
        <h2>Apa itu Pelayanan Sampah?</h2>
        <p>Pelayanan Bank Sampah di Dusun Pilang merupakan salah satu upaya dalam menjaga kebersihan lingkungan dengan menyediakan tempat pembuangan dan pengelolaan sampah bagi masyarakat. Melalui layanan ini, warga dapat menabung atau mengumpulkan sampah sesuai jenisnya pada waktu yang telah ditentukan. Informasi mengenai jenis sampah, jadwal pembuangan, serta tata cara pengelolaan dikomunikasikan melalui media dusun agar lebih mudah diakses oleh warga desa. Dengan adanya layanan ini, diharapkan kesadaran warga terhadap pentingnya menjaga kebersihan lingkungan dapat meningkat.</p>
    </section>

    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <span class="number">751</span>
            <span class="label">Pelanggan Aktif</span>
        </div>
        <div class="stat-card">
            <i class="fas fa-exchange-alt"></i>
            <span class="number">952</span>
            <span class="label">Transaksi</span>
        </div>
        <div class="stat-card">
            <i class="fas fa-trash-alt"></i>
            <span class="number">6</span>
            <span class="label">Kategori Sampah</span>
        </div>
    </div>

    <section class="steps-section">
        <h2>🍃 Cara Kerja Bank Sampah 🍃</h2>
        <div class="steps-grid">
            <div class="step-card">
                <img src="assets/daftar.png" alt="Daftar">
                <h3>Daftar & Verifikasi</h3>
                <p>Daftar sebagai nasabah dengan melalui petugas / pengelola Bank Sampah Dusun Pilang terlebih dahulu.</p>
            </div>
            <div class="step-card">
                <img src="assets/pemilahan.png" alt="Pilah">
                <h3>Pemilahan Sampah</h3>
                <p>Nasabah memilah sampah dari rumah sesuai dengan jenisnya selama 1 bulan. Sampah organik akan diangkut oleh petugas, sedangkan sampah anorganik dibawa ke tempat pengumpulan sampah untuk diproses lebih lanjut.</p>
            </div>
            <div class="step-card">
                <img src="assets/pengumpulan_sampah.png" alt="Timbang">
                <h3>Pengumpulan Sampah</h3>
                <p>Nasabah membawa sampah yang telah dipilah dari rumah ke lokasi Bank Sampah sesuai jadwal yang telah ditentukan. Sampah akan diterima, dicatat, dan ditimbang sebelum diproses lebih lanjut.</p>
            </div>
            <div class="step-card">
                <img src="assets/penimbangan.png" alt="Catat">
                <h3>Proses Penimbangan</h3>
                <p>Petugas menimbang sampah yang dibawa nasabah sesuai jenisnya. Hasil penimbangan digunakan sebagai dasar untuk menentukan nilai transaksi yang akan diperoleh nasabah.</p>
            </div>
        </div>
        <div class="steps-grid" style="margin-top: 30px; justify-content: center; grid-template-columns: repeat(2, 450px);">
            <div class="step-card">
                <img src="assets/pencatatan_hasil.png" alt="Konversi">
                <h3>Pencatatan Hasil</h3>
                <p>Data sampah dari nasabah akan dicatat dan diganti menggunakan nilai saldo tabungan pada buku Tabungan Dusun Pilang.</p>
            </div>
            <div class="step-card">
                <img src="assets/cek_saldo.png" alt="Saldo">
                <h3>Cek Saldo Tabungan</h3>
                <p>Nasabah dapat melihat riwayat transaksi dan saldo tabungan melalui website Dusun Pilang. Cukup login menggunakan ID, nomor telepon, dan nama lengkap.</p>
            </div>
        </div>
    </section>

    <section class="categories-section">
        <h2>Kategori Sampah yang diterima</h2>
        <p class="subtitle">Program Pelayanan lingkungan sehat bagi masyarakat</p>
        
        <div class="category-grid">
            <div class="category-card">
                <img src="assets/botol_plastik_tipe_a.png" alt="Botol Plastik">
                <h3>Botol Plastik Tipe A</h3>
                <p class="desc">Tipe A (Sampah Dalam Keadaan Bersih)</p>
                <span class="cat-label">Kategori : Plastik</span>
                <span class="price">Rp. 2,500/Kg</span>
            </div>
            <div class="category-card">
                <img src="assets/botol_plastik_tipe_b.png" alt="Botol Plastik B">
                <h3>Botol Plastik Tipe B</h3>
                <p class="desc">Tipe B (Sampah Dalam Keadaan Tidak Bersih)</p>
                <span class="cat-label">Kategori : Plastik</span>
                <span class="price">Rp. 1,500/Kg</span>
            </div>
            <div class="category-card">
                <img src="assets/kardus.png" alt="Kardus">
                <h3>Kardus</h3>
                <p class="desc">&nbsp;</p>
                <span class="cat-label">Kategori : Kertas</span>
                <span class="price">Rp. 1,000/Kg</span>
            </div>
            <div class="category-card">
                <img src="assets/kaleng.png" alt="Kaleng">
                <h3>Kaleng</h3>
                <p class="desc">&nbsp;</p>
                <span class="cat-label">Kategori : Logam</span>
                <span class="price">Rp. 3,500/Kg</span>
            </div>
        </div>
        <div class="category-grid" style="margin-top: 25px;">
            <div class="category-card">
                <img src="assets/buku_bekas.png" alt="Buku">
                <h3>Buku Bekas - HVS</h3>
                <p class="desc">&nbsp;</p>
                <span class="cat-label">Kategori : Kertas</span>
                <span class="price">Rp. 1,500/Kg</span>
            </div>
            <div class="category-card">
                <img src="assets/botol_kaca.png" alt="Botol Kaca">
                <h3>Botol kaca</h3>
                <p class="desc">Botol kaca yang diterima meliputi botol dalam kondisi bersih dan tidak pecah.</p>
                <span class="cat-label">Kategori : Kaca</span>
                <span class="price">Rp. 1,500/Kg</span>
            </div>
            <div class="category-card">
                <img src="assets/besi.png" alt="Besi">
                <h3>Besi</h3>
                <p class="desc">Besi yang diterima dalam kondisi kering, bersih, dan aman.</p>
                <span class="cat-label">Kategori : Logam</span>
                <span class="price">Rp. 4,500/Kg</span>
            </div>
            <div class="category-card">
                <img src="assets/koran.png" alt="Koran">
                <h3>Koran</h3>
                <p class="desc">&nbsp;</p>
                <span class="cat-label">Kategori : Kertas</span>
                <span class="price">Rp. 1,000/Kg</span>
            </div>
        </div>
    </section>

    <div class="schedule-banner">
        <div class="schedule-img">
            <img src="assets/bank_sampah.png" alt="Jadwal" style="width: 100%; border-radius: 20px;">
        </div>
        <div class="schedule-content">
            <h2>Jadwal Pelaksanaan Bank Sampah</h2>
            <div class="schedule-info">
                <div class="schedule-row">
                    <i class="fas fa-leaf"></i>
                    <span>Bersama Kita Kelola Sampah 🍃</span>
                </div>
                <p style="font-size: 13px; color: #62836b; margin-bottom: 20px;">Pastikan sampah yang anda bawa sudah dalam kondisi dipilah untuk mempermudah proses di Bank Sampah.</p>
                <div class="schedule-row">
                    <i class="far fa-calendar-alt"></i>
                    <span>Hari : Minggu ke-2 setiap bulan</span>
                </div>
                <div class="schedule-row">
                    <i class="far fa-clock"></i>
                    <span>Pukul : 08.00 - 12.00 WIB</span>
                </div>
                <div class="schedule-row">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Lokasi : Dusun Pilang RW 06</span>
                </div>
            </div>
            <div class="schedule-footer">
                Kami tunggu kehadirannya ya 😊 🍃
                <span style="margin-left: auto; color: #7DA67D; font-weight: 800;">Salam Bebas Sampah ♻️</span>
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
        <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; flex-wrap: wrap; padding-top: 20px;">
            <p>&copy; 2026 Dusun Pilang</p>
            <a href="admin/login.php" style="color: rgba(255,255,255,0.5); text-decoration: none; font-size: 13px; transition: all 0.3s; padding: 6px 12px; border-radius: 50px; background: rgba(0,0,0,0.2);"><i class="fas fa-lock" style="font-size: 10px; margin-right: 5px;"></i> Login Admin</a>
        </div>
    </footer>
</body>
</html>
