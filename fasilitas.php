<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas - Dusun Pilang</title>
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

    <div class="hero" style="padding: 60px 20px 40px;">
        <div class="hero-content">
            <div class="tag">Infrastruktur Warga</div>
            <h1 style="font-size: 48px;">Fasilitas Dusun</h1>
            <p style="max-width: 600px; margin: 0 auto;">Daftar fasilitas pelayanan dan fasilitas umum yang beroperasi secara aktif di wilayah Dusun Pilang.</p>
        </div>
    </div>

    <!-- Fasilitas Grid -->
    <section class="section" style="padding-top: 0;">
        <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
            
            <div class="card has-bg">
                <div class="card-img-wrap" style="height: 200px;">
                    <span class="card-badge">Buka</span>
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Bank Sampah" style="object-fit: cover;">
                </div>
                <div class="card-content text-left">
                    <h3 class="card-title" style="font-size: 20px;">Bank Sampah Dusun</h3>
                    <p class="card-text" style="color: var(--text-light); text-align: left; margin-bottom: 20px;">Pusat pengelolaan daur ulang sampah yang dioperasikan bersama warga secara komunal.</p>
                    <a href="bank_sampah.php" class="btn-secondary" style="width: 100%; text-align: center; padding: 10px; font-size: 14px;">Kunjungi Halaman</a>
                </div>
            </div>

            <div class="card has-bg">
                <div class="card-img-wrap" style="height: 200px;">
                    <img src="https://images.unsplash.com/photo-1577416954359-54b9f2eb5ec5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Balai Dusun" style="object-fit: cover;">
                </div>
                <div class="card-content text-left">
                    <h3 class="card-title" style="font-size: 20px;">Balai Dusun / Balai Pertemuan</h3>
                    <p class="card-text" style="color: var(--text-light); text-align: left; margin-bottom: 20px;">Tempat pertemuan resmi warga, posyandu rutin, serta pusat pengelolaan administrasi Dusun.</p>
                </div>
            </div>
            
            <div class="card has-bg">
                <div class="card-img-wrap" style="height: 200px;">
                    <img src="https://images.unsplash.com/photo-1540324155974-7523202daa3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Masjid Warga" style="object-fit: cover;">
                </div>
                <div class="card-content text-left">
                    <h3 class="card-title" style="font-size: 20px;">Tempat Ibadah</h3>
                    <p class="card-text" style="color: var(--text-light); text-align: left; margin-bottom: 20px;">Fasilitas peribadatan dan pusat pendidikan kerohanian bagi masyarakat setempat secara berdampingan.</p>
                </div>
            </div>

            <div class="card has-bg">
                <div class="card-img-wrap" style="height: 200px;">
                    <img src="https://images.unsplash.com/photo-1519331379826-f10be5486c6f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Taman" style="object-fit: cover;">
                </div>
                <div class="card-content text-left">
                    <h3 class="card-title" style="font-size: 20px;">Area Publik & Taman Dusun</h3>
                    <p class="card-text" style="color: var(--text-light); text-align: left; margin-bottom: 20px;">Ruang terbuka hijau untuk edukasi anak-anak dan area bersantai yang nyaman untuk warga Dusun.</p>
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
