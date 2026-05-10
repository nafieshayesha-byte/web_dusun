<?php
require_once 'config.php';
$query = mysqli_query($conn, "SELECT * FROM t_fasilitas_dusun ORDER BY id_fasilitas ASC");
$all_fasilitas = [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas Dusun - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: var(--white);
        }
        .fasilitas-header {
            text-align: center;
            padding: 30px 20px 50px;
        }
        .fasilitas-title {
            font-size: 48px;
            font-weight: 900;
            color: #12361A;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .fasilitas-subtitle {
            font-size: 15px;
            color: #4a6d41;
            max-width: 650px;
            margin: 0 auto 25px;
            line-height: 1.6;
            font-weight: 500;
        }
        .breadcrumb {
            font-size: 13px;
            font-weight: 600;
            color: #62836b;
        }
        .breadcrumb span {
            color: #12361A;
            font-weight: 800;
        }
        
        .fasilitas-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px 40px;
            max-width: 1000px;
            margin: 0 auto 100px;
            padding: 0 20px;
        }
        
        .f-card {
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .f-card:hover {
            transform: translateY(-5px);
        }
        .f-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.03);
        }
        .f-title {
            font-size: 24px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }
        .f-pj {
            font-size: 15px;
            font-weight: 500;
            color: #4a6d41;
            margin-bottom: 15px;
        }
        .f-desc {
            font-size: 14px;
            color: #4a6d41;
            line-height: 1.7;
            font-weight: 500;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        @media (max-width: 768px) {
            .fasilitas-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .f-img {
                height: 250px;
            }
            .fasilitas-title {
                font-size: 36px;
            }
        }

        /* Modal Styles matching the exact image provided */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); backdrop-filter: blur(5px);
            display: none; justify-content: center; align-items: center; z-index: 2000; padding: 20px;
        }
        .modal-content {
            background: white; width: 100%; max-width: 850px; max-height: 90vh;
            border-radius: 24px; position: relative; overflow-y: auto; padding: 40px 40px 30px;
            animation: modalIn 0.4s ease;
        }
        @keyframes modalIn { from { opacity: 0; transform: translateY(30px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .btn-close { position: absolute; top: 20px; left: 20px; background: none; border: none; font-size: 20px; color: #12361A; cursor: pointer; z-index: 10; font-weight: 900; }
        
        .modal-header-flex { display: flex; gap: 30px; margin-bottom: 25px; align-items: center; }
        .modal-img-wrap { width: 380px; height: 220px; border-radius: 12px; overflow: hidden; flex-shrink: 0; position: relative; }
        .modal-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .card-badge-modal { position: absolute; top: 12px; left: 12px; background: #ffffff; color: #12361A; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 12px; z-index: 2; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        
        .modal-info { flex: 1; display: flex; flex-direction: column; justify-content: center; }
        .modal-info h2 { font-size: 22px; font-weight: 800; color: #12361A; margin-bottom: 12px; letter-spacing: -0.5px; }
        .info-row { font-size: 13px; font-weight: 700; color: #12361A; margin-bottom: 6px; }
        .info-row span { font-weight: 500; }
        
        .modal-actions-top { display: flex; align-items: center; gap: 12px; margin-top: 15px; }
        .btn-icon-outline { background: none; border: none; font-size: 18px; color: #ef4444; cursor: pointer; transition: transform 0.2s; }
        .btn-icon-outline:active { transform: scale(1.2); }
        .btn-icon-outline.liked i { font-weight: 900; color: #ef4444; }
        .btn-copy { font-size: 18px; color: #4a6d41; background: none; border: none; cursor: pointer; }
        
        .btn-wa { background: #064e3b; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 8px; font-size: 13px; margin-top: 5px; width: fit-content; }
        
        .modal-desc { font-size: 13px; color: #4a6d41; line-height: 1.8; margin-bottom: 30px; font-weight: 500; }
        
        @media (max-width: 768px) { .modal-header-flex { flex-direction: column; } .modal-img-wrap { width: 100%; height: 250px; } }
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
                        <li><a href="tentang_dusun.php">Tentang Dusun</a></li>
                        <li><a href="fasilitas.php" class="active">Fasilitas</a></li>
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

    <div class="fasilitas-header">
        <h1 class="fasilitas-title">Dusun<br>Pilang</h1>
        <p class="fasilitas-subtitle">Mengenal lebih dekat layanan dan fasilitas di Dusun Pilang. Mari ciptakan dusun yang nyaman, mandiri, dan sejahtera untuk kita semua.</p>
        <div class="breadcrumb">Profil Dusun <span style="margin: 0 10px;">></span> <span>Fasilitas Dusun</span></div>
    </div>

    <div class="fasilitas-grid">
        <?php
        if($query && mysqli_num_rows($query) > 0) {
            while($f = mysqli_fetch_array($query)) {
                $all_fasilitas[] = $f;
                ?>
                <div class="f-card" onclick="openModal(<?php echo $f['id_fasilitas']; ?>)">
                    <img src="assets/<?php echo $f['foto'] ? $f['foto'] : 'placeholder.jpg'; ?>" class="f-img" alt="<?php echo htmlspecialchars($f['nama_fasilitas']); ?>" onerror="this.src='https://via.placeholder.com/600x400/e2e8f0/64748b?text=Fasilitas'">
                    <h2 class="f-title"><?php echo htmlspecialchars($f['nama_fasilitas']); ?></h2>
                    <div class="f-pj">Bpk. <?php echo htmlspecialchars(str_replace('Bpk. ', '', $f['penanggung_jawab'])); ?></div>
                    <div class="f-desc"><?php echo htmlspecialchars(mb_strimwidth($f['keterangan'], 0, 150, "...")); ?></div>
                </div>
                <?php
            }
        } else {
            echo '<div style="grid-column: 1/-1; text-align: center; color: #62836b; padding: 40px;">Belum ada data fasilitas.</div>';
        }
        ?>
    </div>

    <!-- Modal Detail Fasilitas (Matching Provided Image Layout) -->
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

    <script>
        const fasilitasData = <?php echo json_encode($all_fasilitas); ?>;

        function openModal(id) {
            const f = fasilitasData.find(item => item.id_fasilitas == id);
            if(!f) return;

            const modalBody = document.getElementById('modalBody');
            
            // Generate HTML to exactly match the provided layout structure
            modalBody.innerHTML = `
                <div class="modal-header-flex">
                    <div class="modal-img-wrap">
                        <div class="card-badge-modal"><i class="fas fa-building"></i></div>
                        <img src="assets/${f.foto ? f.foto : 'placeholder.jpg'}" alt="Foto" onerror="this.src='https://via.placeholder.com/600x400/e2e8f0/64748b?text=Fasilitas'">
                    </div>
                    <div class="modal-info">
                        <h2>${f.nama_fasilitas}</h2>
                        <div class="info-row">Penanggung Jawab : <span>Bpk. ${f.penanggung_jawab.replace('Bpk. ', '')}</span></div>
                        <div class="info-row">Jumlah Unit : <span>${f.unit} Unit</span></div>
                        
                        <div class="modal-actions-top">
                            <button class="btn-icon-outline" onclick="toggleLike(this)"><i class="far fa-heart"></i></button>
                            <button class="btn-copy" onclick="copyLink()"><i class="far fa-clone"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-desc">
                    ${f.keterangan ? f.keterangan.replace(/\\n/g, '<br>') : '<i>Tidak ada deskripsi tersedia.</i>'}
                </div>
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

        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if(e.target === this) closeModal();
        });
    </script>
</body>
</html>
