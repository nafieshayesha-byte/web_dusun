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
                <li><a href="#informasi">Informasi <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a></li>
                <li><a href="#bisnis">Bisnis Warga</a></li>
                <li><a href="bank_sampah.php">Bank Sampah <i class="fas fa-chevron-down" style="font-size: 10px;"></i></a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            <a href="#kontak" class="btn-primary">Pengaduan &rarr;</a>
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
                        $kategori = isset($k['jenis_kegiatan']) && !empty($k['jenis_kegiatan']) ? $k['jenis_kegiatan'] : 'Kegiatan';
                        
                        $kategori_badge = $kategori;
                        

                        $mo = ['01'=>'Januari','02'=>'FEB','03'=>'MAR','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                        $tgl_fmt = '';
                        if($k['tanggal']) {
                            $time_parts = explode('-', $k['tanggal']);
                            if(count($time_parts) == 3) {
                                $tgl_fmt = $time_parts[2] . ' ' . (isset($mo[$time_parts[1]]) ? $mo[$time_parts[1]] : $time_parts[1]) . ' ' . $time_parts[0];
                            } else {
                                $tgl_fmt = date('d M Y', strtotime($k['tanggal']));
                            }
                        } else {
                            $tgl_fmt = 'Akan datang';
                        }
                        
                        $w_mulai = !empty($k['waktu_mulai']) ? date('H.i', strtotime($k['waktu_mulai'])) : '00.00';
                        $w_selesai = !empty($k['waktu_selesai']) ? date('H.i', strtotime($k['waktu_selesai'])) : '00.00';
                        $waktu_str = $w_mulai . '-' . $w_selesai;
                        $keterangan_snippet = !empty($k['keterangan']) ? mb_strimwidth(strip_tags($k['keterangan']), 0, 70, "...") : '-';
                        $status_kegiatan = str_replace('_', ' ', $k['status']);
                        $status_raw = $k['status'];
                        $bg_status = '#fff0d4'; 
                        $txt_status = '#b45309';
                        if($status_raw == 'akan_datang') { $bg_status = '#4A65ED'; $txt_status = '#ffffff'; }
                        elseif($status_raw == 'selesai') { $bg_status = '#546B41'; $txt_status = '#ffffff'; }
                        elseif($status_raw == 'dimulai') { $bg_status = '#FF8409'; $txt_status = '#ffffff'; }
                        elseif($status_raw == 'dibatalkan') { $bg_status = '#B42336'; $txt_status = '#ffffff'; }
                        
                        echo '<a href="detail_kegiatan.php?id='.intval($k['id_kegiatan']).'" class="interactive-card" style="text-decoration: none; display: flex; flex-direction: column; cursor: pointer; flex: 1 1 200px; max-width: calc(25% - 15px); background: #fbfdf9; border: 1px solid #e7ece2; border-radius: 16px; padding-bottom: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); transition: transform 0.3s;">';
                        echo '  <div style="position: relative; width: 100%; height: 165px; border-radius: 16px 16px 0 0; overflow: hidden; margin-bottom: 12px;">';
                        echo '      <span style="position: absolute; top: 12px; left: 12px; background: #ffffff; color: #356345; font-size: 11px; font-weight: 700; padding: 4px 14px; border-radius: 50px; z-index: 2; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">'.htmlspecialchars($kategori_badge).'</span>';
                        echo '      <img src="assets/'.($k['foto']?$k['foto']:'placeholder.jpg').'" alt="'.htmlspecialchars($k['judul']).'" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src=\'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80\'">';
                        echo '  </div>';
                        
                        echo '  <div style="padding: 0 15px; flex: 1; display: flex; flex-direction: column;">';
                        echo '      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">';
                        echo '          <div style="display: flex; flex-direction: column; gap: 4px;">';
                        echo '              <div style="font-size: 11px; color: #4e8357; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right:4px;"></i>'.$tgl_fmt.'</div>';
                        echo '              <div style="font-size: 11px; color: #62836b; font-weight: 600;"><i class="far fa-clock" style="margin-right:4px;"></i>'.$waktu_str.'</div>';
                        echo '          </div>';
                        echo '          <div style="background: '.$bg_status.'; color: '.$txt_status.'; font-size: 8.5px; font-weight: 800; padding: 4px 12px; border-radius: 50px; text-transform: uppercase; white-space: nowrap;">'.htmlspecialchars($status_kegiatan).'</div>';
                        echo '      </div>';
                        
                        echo '      <h3 style="font-size: 15px; color: #1f4228; font-weight: 800; line-height: 1.4; margin-bottom: 8px;">'.htmlspecialchars($k['judul']).'</h3>';
                        echo '      <p style="font-size: 12px; color: #6b7280; line-height: 1.5; margin-bottom: 5px; flex: 1;">'.htmlspecialchars($keterangan_snippet).'</p>';
                        echo '      <div style="font-size: 11px; font-weight: 800; color: #4e8357; display: flex; align-items: center; gap: 5px; margin-top: 5px;">Lihat selengkapnya <i class="fas fa-arrow-right" style="font-size: 9px;"></i></div>';
                        
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
                        echo '<div class="card interactive-card" style="box-shadow: none; border: none; text-align: center;">';
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
            <a href="#" class="btn-primary" style="padding: 12px 32px;">Lihat Semua Bisnis &rarr;</a>
        </div>
    </section>

    <!-- Bank Sampah -->
    <section class="cta-section">
        <div class="max-w">
            <div class="section-header" style="margin-bottom: 15px;">
                <h2 class="section-title">Bank Sampah</h2>
                <p class="section-desc">Program Pelayanan lingkungan sehat bagi masyarakat</p>
            </div>
            
            <div class="card-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
                <?php
                // Dummy data array for display to match Figma
                $sampah_list = [
                    ['nama' => 'Botol Plastik Tipe A', 'kat' => 'Plastik (Bersih)', 'harga' => '3,000', 'img' => 'https://images.unsplash.com/photo-1528323273322-d81458248d40?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'],
                    ['nama' => 'Botol Plastik Tipe B', 'kat' => 'Plastik (Kotor)', 'harga' => '1,500', 'img' => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'],
                    ['nama' => 'Kardus', 'kat' => 'Kertas', 'harga' => '1,000', 'img' => 'https://images.unsplash.com/photo-1589405626993-3fd00c926d9e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'],
                    ['nama' => 'Kaleng', 'kat' => 'Logam', 'harga' => '5,000', 'img' => 'https://images.unsplash.com/photo-1591871960205-021966de184e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80']
                ];
                foreach($sampah_list as $s):
                ?>
                <div class="card has-bg interactive-card">
                    <div class="card-img-wrap"><img src="<?php echo $s['img']; ?>" alt="<?php echo $s['nama']; ?>"></div>
                    <div class="card-content">
                        <h3 class="card-title"><?php echo $s['nama']; ?></h3>
                        <div style="font-size: 13px; color: var(--text-light); margin-bottom: 10px;">Kategori : <?php echo $s['kat']; ?></div>
                        <div class="card-price">Rp. <?php echo $s['harga']; ?>/kg</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: right; margin-top: 10px;">
                <a href="#" class="section-link">Informasi selengkapnya ></a>
            </div>
        </div>
    </section>

    <!-- Pengaduan Section -->
    <section id="kontak" class="section">
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
                        <img src="https://images.unsplash.com/photo-1515150144380-bca9f1650ed9?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" alt="Contoh foto jalan rusak" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;">
                        <div style="position: absolute; bottom: 15px; left: 0; right: 0; text-align: center;">
                            <label class="btn-secondary" style="font-size: 13px; padding: 8px 16px; background: rgba(255,255,255,0.8); backdrop-filter: blur(4px); cursor: pointer; border: none;">
                                Ganti Foto
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
                    <li><a href="#kontak">• Pengaduan Publik</a></li>
                    <li><a href="#kontak">• Hubungi Kami</a></li>
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