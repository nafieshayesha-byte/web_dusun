<?php 
require_once 'config.php'; 

// Fetch data
$query = "SELECT * FROM t_bisnis_desa ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

// Array to store all businesses for JS modal
$businesses = [];
if($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $businesses[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bisnis Warga - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #fbfdf9;
        }
        .header-section {
            text-align: left;
            padding: 40px 5% 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .breadcrumb {
            display: inline-flex;
            align-items: center;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #8fa696;
            gap: 10px;
        }
        .breadcrumb a {
            text-decoration: none;
            color: #8fa696;
        }
        .breadcrumb i {
            font-size: 10px;
        }
        .informasi-title {
            font-size: 32px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 20px;
        }
        .informasi-subtitle {
            font-size: 15px;
            color: #62836b;
            max-width: 1000px;
            line-height: 1.8;
            margin-bottom: 40px;
        }
        
        .search-container {
            max-width: 400px;
            margin-bottom: 40px;
            position: relative;
        }
        .search-container i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8fa696;
        }
        .search-input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            background: #e9f0df;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #12361A;
            outline: none;
        }
        .search-input::placeholder {
            color: #8fa696;
        }

        .bisnis-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 5% 60px;
        }
        .bisnis-card {
            background: #e9f0df;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .bisnis-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .card-img {
            position: relative;
            height: 200px;
        }
        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .card-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #ffffff;
            color: #12361A;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 14px;
        }
        .card-body {
            padding: 20px;
        }
        .card-body h3 {
            font-size: 18px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 6px;
        }
        .owner-name {
            font-size: 13px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 4px;
        }
        .address {
            font-size: 11px;
            color: #62836b;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .desc-snippet {
            font-size: 12px;
            color: #62836b;
            line-height: 1.6;
        }

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
        .modal-img .card-badge {
            top: 15px;
            left: 15px;
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

        @media (max-width: 991px) {
            .bisnis-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .modal-header-flex { flex-direction: column; }
            .modal-img { width: 100%; }
        }
        @media (max-width: 600px) {
            .bisnis-grid { grid-template-columns: 1fr; }
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
                <li><a href="informasi_kegiatan.php">Informasi</a></li>
                <li><a href="bisnis_warga.php" class="active">Bisnis Warga</a></li>
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

    <div style="text-align: center; padding: 30px 20px 20px;">
        <div style="display: inline-block; background: #e9f0df; padding: 8px 24px; border-radius: 50px; font-size: 12px; font-weight: 700; color: #4a6d41; margin-bottom: 25px;">
            Bisnis desa pelayanan jasa, dari usaha warga untuk para pengguna
        </div>
        <h1 style="font-size: 42px; font-weight: 900; color: #12361A; margin-bottom: 15px; letter-spacing: -0.5px;">Dusun Mandiri</h1>
        <p style="font-size: 15px; color: #62836b; max-width: 700px; margin: 0 auto 30px; line-height: 1.7; font-weight: 500;">
            Dusun Mandiri hadir sebagai wadah usaha masyarakat untuk mendorong kemandirian ekonomi desa melalui produk dan layanan terbaik dari warga untuk semua.
        </p>
        <div style="font-size: 13px; font-weight: 600; color: #8fa696; margin-bottom: 50px;">
            <a href="index.php" style="color: #62836b; text-decoration: none;">Beranda</a> <span style="margin: 0 10px; font-size: 10px;"><i class="fas fa-chevron-right"></i></span> <span style="color: #12361A; font-weight: 800;">Bisnis Warga</span>
        </div>
    </div>

    <div class="header-section" style="padding-top: 0;">
        <h2 class="informasi-title" style="margin-bottom: 20px; font-size: 28px;">Mengenal Usaha Warga</h2>
        <p class="informasi-subtitle" style="color: #4a6d41; font-weight: 500; font-size: 14px; text-align: justify; letter-spacing: 0.2px;">
            Usaha warga Dusun Pilang merupakan wujud nyata kemandirian masyarakat. Berbagai jenis usaha tumbuh dari potensi dan keterampilan warga, mulai dari perdagangan, jasa, hingga produksi lokal yang berkembang bersama. Semua usaha dijalankan dengan semangat kebersamaan dan gotong royong, sehingga menjadi kekuatan dalam meningkatkan kualitas hidup masyarakat. Selain itu, usaha warga juga turut mendukung kemajuan dan perkembangan dusun menuju masyarakat yang mandiri dan sejahtera. Dengan adanya usaha-usaha ini, peluang kerja bagi warga sekitar semakin terbuka dan perekonomian lokal semakin berkembang. Inovasi dan kreativitas masyarakat juga terus didorong agar mampu mengikuti perkembangan zaman dan kebutuhan pasar.
        </p>
        
        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Cari bisnis/usaha di sekitar dusun">
        </div>
    </div>

    <div class="bisnis-grid" id="bisnisGrid">
        <?php foreach($businesses as $b): 
            $icon = 'fas fa-store';
            $jenis = strtolower($b['jenis_usaha']);
            if (strpos($jenis, 'tani') !== false || strpos($jenis, 'padi') !== false) $icon = 'fas fa-seedling';
            else if (strpos($jenis, 'ternak') !== false) $icon = 'fas fa-truck';
            else if (strpos($jenis, 'jasa') !== false) $icon = 'fas fa-concierge-bell';
        ?>
            <div class="bisnis-card" onclick="openModal(<?php echo $b['id_bisnis']; ?>)">
                <div class="card-img">
                    <div class="card-badge"><i class="<?php echo $icon; ?>"></i></div>
                    <img src="assets/<?php echo ($b['foto']?$b['foto']:'placeholder.jpg'); ?>" alt="Foto">
                </div>
                <div class="card-body">
                    <h3><?php echo htmlspecialchars($b['nama_usaha']); ?></h3>
                    <div class="owner-name"><?php echo htmlspecialchars($b['nama_pengusaha']); ?></div>
                    <div class="address"><?php echo htmlspecialchars($b['alamat']); ?></div>
                    <div class="desc-snippet"><?php echo htmlspecialchars(mb_strimwidth($b['keterangan'], 0, 150, "...")); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal Detail -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-content">
            <button class="btn-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
            <div id="modalBody">
                <!-- Content will be injected by JS -->
            </div>
        </div>
    </div>

    <footer style="margin-top: 0;">
        <div class="footer-grid">
            <div class="footer-col" style="flex: 2; min-width: 300px;">
                <a href="#" class="logo" style="color: var(--white); margin-bottom: 15px; display: inline-flex;"><img src="https://ui-avatars.com/api/?name=DP&background=fff&color=1E3B20&rounded=true" alt="Logo"> Dusun Pilang</a>
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
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Dusun Pilang</p>
        </div>
    </footer>

    <script>
        const businesses = <?php echo json_encode($businesses); ?>;

        function openModal(id) {
            const b = businesses.find(item => item.id_bisnis == id);
            if(!b) return;

            let icon = 'fas fa-store';
            const jenis = b.jenis_usaha.toLowerCase();
            if (jenis.includes('tani') || jenis.includes('padi')) icon = 'fas fa-seedling';
            else if (jenis.includes('ternak')) icon = 'fas fa-truck';
            else if (jenis.includes('jasa')) icon = 'fas fa-concierge-bell';

            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <div class="modal-header-flex">
                    <div class="modal-img">
                        <div class="card-badge"><i class="${icon}"></i></div>
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

            document.getElementById('modalOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalOverlay').style.display = 'none';
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

        // Close on overlay click
        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if(e.target === this) closeModal();
        });

        // Search logic
        document.getElementById('searchInput').addEventListener('input', function() {
            const term = this.value.toLowerCase();
            const cards = document.querySelectorAll('.bisnis-card');
            
            cards.forEach(card => {
                const title = card.querySelector('h3').innerText.toLowerCase();
                const owner = card.querySelector('.owner-name').innerText.toLowerCase();
                if(title.includes(term) || owner.includes(term)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
    <a href="admin/login.php" class="floating-admin">
        <i class="fas fa-user-shield"></i>
        <span>Portal Admin</span>
    </a>
</body>
</html>
