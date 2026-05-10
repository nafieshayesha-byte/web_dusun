<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .container-pengaduan {
            max-width: 1000px;
            margin: 60px auto 100px;
            padding: 0 20px;
        }
        .header-pengaduan h1 {
            font-size: 42px;
            font-weight: 800;
            color: #12361A;
            margin-bottom: 5px;
        }
        .header-pengaduan p {
            color: #62836b;
            font-size: 16px;
            margin-bottom: 50px;
            font-weight: 600;
        }
        .form-row {
            display: grid;
            grid-template-columns: 200px 30px 1fr;
            align-items: start;
            margin-bottom: 25px;
        }
        .form-label {
            font-weight: 800;
            color: #12361A;
            font-size: 18px;
            padding-top: 12px;
        }
        .form-separator {
            font-weight: 800;
            color: #12361A;
            font-size: 18px;
            padding-top: 12px;
        }
        .form-input {
            background-color: #E2EAC7;
            border: none;
            border-radius: 15px;
            padding: 15px 25px;
            font-size: 16px;
            color: #12361A;
            font-weight: 600;
            width: 100%;
            outline: none;
        }
        .form-input::placeholder {
            color: #8fa696;
        }
        .category-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .category-btn {
            background-color: #E2EAC7;
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-size: 15px;
            font-weight: 700;
            color: #12361A;
            cursor: pointer;
            transition: all 0.3s;
        }
        .category-btn.active {
            background-color: #12361A;
            color: #ffffff;
        }
        .textarea-container {
            position: relative;
            background-color: #E2EAC7;
            border-radius: 20px;
            padding: 15px;
        }
        .form-textarea {
            background: transparent;
            border: none;
            width: 100%;
            height: 180px;
            font-size: 16px;
            color: #12361A;
            font-weight: 600;
            resize: none;
            outline: none;
            padding: 10px;
        }
        .char-count {
            position: absolute;
            bottom: 15px;
            right: 20px;
            font-size: 14px;
            font-weight: 700;
            color: #12361A;
            opacity: 0.6;
        }
        .upload-area {
            background-color: #E2EAC7;
            border-radius: 25px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .btn-change-photo {
            background-color: #9AB17A;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-size: 15px;
            font-weight: 800;
            color: #12361A;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit-container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }
        .btn-submit {
            background-color: #12361A;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 45px;
            font-size: 18px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(18, 54, 26, 0.2);
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }
            .form-separator { display: none; }
            .form-label { padding-top: 0; margin-bottom: 10px; }
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
                <li><a href="index.php#kontak">Kontak</a></li>
            </ul>
            <a href="pengaduan.php" class="btn-primary" style="background: #12361A; color: white;">Pengaduan &rarr;</a>
        </div>
    </header>

    <main class="container-pengaduan">
        <div class="header-pengaduan">
            <h1>Pengaduan</h1>
            <p>Sampaikan keluhan, kritik, atau saran Anda untuk kemajuan dusun kami !</p>
        </div>

        <form action="proses_pengaduan.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <label class="form-label">Nama</label>
                <span class="form-separator">:</span>
                <input type="text" name="nama" class="form-input" placeholder="Masukkan Nama">
            </div>

            <div class="form-row">
                <label class="form-label">No. HP</label>
                <span class="form-separator">:</span>
                <input type="text" name="no_hp" class="form-input" placeholder="Masukkan No. Telp">
            </div>

            <div class="form-row">
                <label class="form-label">Kategori</label>
                <span class="form-separator">:</span>
                <div class="category-options">
                    <button type="button" class="category-btn active">Fasilitas</button>
                    <button type="button" class="category-btn">Keamanan</button>
                    <button type="button" class="category-btn">Saran</button>
                    <button type="button" class="category-btn">DLL</button>
                    <input type="hidden" name="kategori" id="selected_category" value="Fasilitas">
                </div>
            </div>

            <div class="form-row">
                <label class="form-label">Judul Pengaduan</label>
                <span class="form-separator">:</span>
                <input type="text" name="judul" class="form-input" placeholder="Masukkan Judul">
            </div>

            <div class="form-row">
                <label class="form-label">Pengaduan</label>
                <span class="form-separator">:</span>
                <div class="textarea-container">
                    <textarea name="pengaduan" class="form-textarea" placeholder="Masukkan pengaduan Anda."></textarea>
                    <span class="char-count">0/2000</span>
                </div>
            </div>

            <div class="form-row">
                <label class="form-label">Foto</label>
                <span class="form-separator">:</span>
                <div class="upload-area">
                    <button type="button" class="btn-change-photo">Pilih Foto</button>
                    <input type="file" name="foto" style="display: none;" id="file_input">
                </div>
            </div>

            <div class="btn-submit-container">
                <button type="submit" class="btn-submit">Kirim aduan &rarr;</button>
            </div>
        </form>
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
                        <span><b>TELEPON</b><br>082 1234567</span>
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
        // Category selection
        const catBtns = document.querySelectorAll('.category-btn');
        const selectedInput = document.getElementById('selected_category');
        catBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                catBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedInput.value = btn.innerText;
            });
        });

        // Photo upload trigger
        const uploadArea = document.querySelector('.upload-area');
        const fileInput = document.getElementById('file_input');
        uploadArea.addEventListener('click', () => fileInput.click());
    </script>
</body>
</html>
