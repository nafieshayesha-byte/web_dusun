<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Dusun - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header style="background: var(--white); border-bottom: 1px solid #eaeaea; padding-bottom: 20px;">
        <div class="navbar">
            <a href="index.php" class="logo"><img src="https://ui-avatars.com/api/?name=DP&background=1E3B20&color=fff&rounded=true" alt="Logo" style="height: 32px; width: 32px; border-radius: 50%;"> Dusun Pilang</a>
            <ul class="nav-links">
                <li><a href="index.php">Beranda</a></li>
                <li class="has-dropdown">
                    <a href="#" class="active">Profil Dusun <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="tentang_dusun.php">Tentang Dusun</a></li>
                        <li><a href="fasilitas.php">Fasilitas</a></li>
                    </ul>
                </li>
                <li><a href="index.php#informasi">Informasi <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a></li>
                <li><a href="index.php#bisnis">Bisnis Warga</a></li>
                <li><a href="bank_sampah.php">Bank Sampah <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a></li>
                <li><a href="index.php#kontak">Kontak</a></li>
            </ul>
            <a href="index.php#kontak" class="btn-primary">Pengaduan &rarr;</a>
        </div>
    </header>

    <div class="hero" style="padding: 60px 20px;">
        <div class="hero-content">
            <div class="tag">Sejarah & Profil</div>
            <h1 style="font-size: 48px;">Tentang Dusun Pilang</h1>
            <p style="max-width: 800px; margin: 0 auto; line-height: 1.8; text-align: left; color: var(--text-dark);">
                Dusun Pilang, yang terletak di wilayah administrasi Desa Boja, Kecamatan Boja, Kabupaten Kendal, merupakan salah satu wilayah yang memiliki nilai historis, ditandai dengan keberadaan situs makam leluhur (pepunden) yang dihormati warga setempat. Dusun ini dikenal karena warganya yang rukun, lingkungan yang asri, serta letaknya yang strategis dalam mendukung pertumbuhan ekonomi lokal.
            </p>
            <br>
            <p style="max-width: 800px; margin: 0 auto; line-height: 1.8; text-align: left; color: var(--text-dark);">
                Selain melestarikan budaya dan tradisi lokal, Dusun Pilang terus berupaya menjadi lingkungan yang mandiri dan berdaya saing tinggi. Melalui partisipasi aktif seluruh warga, kami menginisiasi program inovatif seperti Bank Sampah Dusun yang tidak hanya menjaga kebersihan lingkungan tetapi juga memberikan nilai tambah ekonomi.
            </p>
        </div>
    </div>

    <!-- Visi Misi Section -->
    <section class="section" style="padding-top: 0;">
        <div class="card-grid" style="max-width: 900px; margin: 0 auto; grid-template-columns: 1fr 1fr;">
            <div class="card has-bg" style="background: var(--secondary-light); border: 1px solid var(--secondary-color);">
                <div class="card-content">
                    <h3 class="card-title" style="font-size: 24px; margin-bottom: 15px;"><i class="fas fa-eye" style="color: var(--primary-color);"></i> Visi</h3>
                    <p class="card-text" style="color: var(--text-dark);">Mewujudkan Dusun Pilang yang Terbuka, Informatif, dan Terpercaya serta mandiri dalam menjaga kerukunan warga dan pengelolaan lingkungan demi kesejahteraan bersama.</p>
                </div>
            </div>
            <div class="card has-bg" style="background: var(--secondary-light); border: 1px solid var(--secondary-color);">
                <div class="card-content">
                    <h3 class="card-title" style="font-size: 24px; margin-bottom: 15px;"><i class="fas fa-bullseye" style="color: var(--primary-color);"></i> Misi</h3>
                    <ul style="color: var(--text-dark); padding-left: 20px; font-size: 15px; margin-bottom: 15px;">
                        <li style="margin-bottom: 8px;">Meningkatkan kualitas pelayanan warga melalui sistem informasi digital.</li>
                        <li style="margin-bottom: 8px;">Membangun semangat gotong royong dan kepedulian terhadap lingkungan.</li>
                        <li style="margin-bottom: 8px;">Memberdayakan potensi ekonomi warga, termasuk UMKM dan program Bank Sampah.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

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
                    <li><a href="index.php#informasi">• Informasi Kegiatan</a></li>
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
