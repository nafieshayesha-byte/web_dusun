-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 10 Bulan Mei 2026 pada 07.38
-- Versi server: 8.0.30
-- Versi PHP: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_dusunpilang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_admin`
--

CREATE TABLE `t_admin` (
  `id_admin` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `foto_profil` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `tema` varchar(10) DEFAULT 'light',
  `bahasa` varchar(10) DEFAULT 'id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `t_admin`
--

INSERT INTO `t_admin` (`id_admin`, `username`, `nama_lengkap`, `foto_profil`, `password`, `tema`, `bahasa`) VALUES
(1, 'admin', 'Karina Cahya Kirana', 'admin_1778390522.png', 'admin', 'light', 'id');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_bisnis_desa`
--

CREATE TABLE `t_bisnis_desa` (
  `id_bisnis` int NOT NULL,
  `nama_usaha` varchar(100) DEFAULT NULL,
  `nama_pengusaha` varchar(100) DEFAULT NULL,
  `jenis_usaha` varchar(100) DEFAULT NULL,
  `keterangan` text,
  `alamat` varchar(225) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `foto` varchar(225) DEFAULT NULL,
  `status` enum('buka','tutup','libur') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `t_bisnis_desa`
--

INSERT INTO `t_bisnis_desa` (`id_bisnis`, `nama_usaha`, `nama_pengusaha`, `jenis_usaha`, `keterangan`, `alamat`, `no_telp`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Penjualan Bibit Padi Gulung', 'Bpk. Ahmad Nawawi', 'Pertanian', 'Menyediakan bibit padi gulung berkualitas tinggi yang siap tanam, usaha ini hadir untuk membantu petani bekerja lebih cepat, praktis, dan efisien. Dengan perawatan yang optimal, bibit yang dihasilkan lebih sehat dan siap menghasilkan panen yang maksimal.', 'Jl. Pilang  RT 02/RW 08 No.134', '081234567890', 'bisnis_1778320844_petani.jpg', 'buka', '2026-05-09 10:00:44', '2026-05-09 10:00:44'),
(2, 'Peternakan Bebek', 'Bpk. Nastadi', 'Peternakan', 'Peternakan bebek kami menghasilkan bebek yang sehat dan berkualitas. Dirawat dengan baik menggunakan pakan pilihan dan lingkungan yang bersih. Cocok untuk kebutuhan konsumsi maupun usaha ternak. Kualitas terjamin dan siap memenuhi kebutuhan Anda!', 'Jl. Pilang RT 03/RW 08 No.168', '089028391738', 'bisnis_1778320952_bebek.jpg', 'buka', '2026-05-09 10:02:32', '2026-05-09 22:20:15'),
(3, 'Jasa Jahit Baju', 'Ibu Sriyati', 'Jasa', 'Kami melayani jasa jahit dan permak baju sesuai keinginan Anda. Dikerjakan dengan rapi, teliti, dan hasil yang memuaskan. Cocok untuk berbagai jenis pakaian, dari santai hingga formal. Percayakan kebutuhan jahit Anda kepada kami!', 'Jl. Pilang  RT 05/RW 08 No.246', '081234567890', 'bisnis_1778398192_jahit.webp', 'buka', '2026-05-10 07:29:52', '2026-05-10 07:29:52'),
(4, 'Bengkel Makmur Jaya', 'Bpk. Suryanto', 'Jasa', 'Bengkel kami siap membantu perbaikan dan perawatan kendaraan Anda. Dikerjakan oleh tenaga berpengalaman dengan hasil yang maksimal. Pelayanan cepat, tepat, dan harga bersahabat. Kendaraan Anda akan kembali nyaman digunakan!', 'Jl. Pilang  RT 05/RW 08 No.140', '082732847434', 'bisnis_1778398286_bengkel.jpg', 'buka', '2026-05-10 07:31:26', '2026-05-10 07:31:26'),
(5, 'Cuci Motor Enggal Jaya', 'Bpk. Arif Pratama', 'Jasa', 'Kami menyediakan layanan cuci motor dengan hasil bersih maksimal. Menggunakan peralatan yang lengkap dan tenaga yang profesional. Motor Anda akan kembali kinclong seperti baru. Pelayanan cepat dan harga terjangkau!', 'Jl. Pilang RT 01/RW 08 No.089', '082738294637', 'bisnis_1778398354_cuci.jpg', 'buka', '2026-05-10 07:32:34', '2026-05-10 07:32:34'),
(6, 'Laundry Baju Cahya', 'Ibu Walik Pratiwi', 'Jasa', 'Laundry kami memberikan hasil cucian yang bersih, wangi, dan rapi. Proses pencucian dilakukan dengan teliti dan higienis. Cocok untuk Anda yang ingin praktis tanpa repot. Kepuasan pelanggan adalah prioritas kami!', 'Jl. Pilang  RT 02/RW 08 No.176', '082736524152', 'bisnis_1778398449_laundry.jpg', 'buka', '2026-05-10 07:34:09', '2026-05-10 07:34:09'),
(7, 'Peternak Kambing', 'Bpk. Sunaryadi', 'Peternakan', 'Kami menyediakan kambing sehat dan berkualitas untuk berbagai kebutuhan. Dirawat dengan pakan terbaik dan lingkungan yang terjaga. Cocok untuk konsumsi maupun acara tertentu. Kualitas dan kesehatan hewan selalu kami utamakan!', 'Jl. Pilang  RT 04/RW 08 No.568', '0825367894926', 'bisnis_1778398533_kambingg.jpg', 'buka', '2026-05-10 07:35:11', '2026-05-10 07:35:33'),
(8, 'Bidan Kesehatan', 'Dr. Fandilah', 'DLL', 'Kami memberikan pelayanan kesehatan khususnya untuk ibu dan anak. Didukung tenaga medis yang profesional dan berpengalaman. Pelayanan dilakukan dengan ramah dan penuh perhatian. Kesehatan Anda adalah prioritas utama kami!', 'Jl. Pilang RT 01/RW 08 No.144', '082537465839', 'bisnis_1778398613_bidan.jpg', 'buka', '2026-05-10 07:36:53', '2026-05-10 07:36:53'),
(9, 'Warung Aim', 'Bpk. Yasin', 'DLL', 'Warung kami menyediakan berbagai kebutuhan sehari-hari dengan lengkap. Harga yang ditawarkan terjangkau dan bersaing. Pelayanan ramah membuat belanja jadi lebih nyaman. Solusi praktis untuk kebutuhan Anda setiap hari!', 'Jl. Pilang  RT 05/RW 08 No.256', '083940593849', 'bisnis_1778398674_warung.jpg', 'buka', '2026-05-10 07:37:54', '2026-05-10 07:37:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_fasilitas_dusun`
--

CREATE TABLE `t_fasilitas_dusun` (
  `id_fasilitas` int NOT NULL,
  `nama_fasilitas` varchar(200) DEFAULT NULL,
  `unit` int DEFAULT NULL,
  `penanggung_jawab` varchar(100) DEFAULT NULL,
  `foto` varchar(225) DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `t_fasilitas_dusun`
--

INSERT INTO `t_fasilitas_dusun` (`id_fasilitas`, `nama_fasilitas`, `unit`, `penanggung_jawab`, `foto`, `keterangan`, `created_at`) VALUES
(1, 'Ambulans', 2, 'Bpk. Udin', 'fasilitas_1778391648.jpg', 'Ambulans Dusun Pilang siap melayani warga untuk keperluan darurat, antar-jemput pasien, dan rujukan ke fasilitas kesehatan dengan cepat dan aman.', '2026-05-10 05:40:48'),
(2, 'Truk Sampah', 1, 'Bpk. Ogah', 'fasilitas_1778391729.jpg', 'Truk sampah Dusun Pilang melayani pengangkutan sampah warga secara rutin untuk menjaga kebersihan lingkungan, kesehatan masyarakat, dan kenyamanan bersama.', '2026-05-10 05:42:09'),
(3, 'Makam Ki Wonosari', 1, 'Bpk. Joko', 'fasilitas_1778391816.jpg', 'Lokasi di RT. 02, dusun Pilang, Kecamatan Boja, Kabupaten Kendal.\r\nMakam Ki Wonosari merupakan tempat peristirahatan terakhir warga sekaligus ruang untuk berziarah, mengenang, dan mendoakan para leluhur.', '2026-05-10 05:43:36'),
(4, 'Masjid Roudlotus Salimin', 1, 'Bpk. Supri', 'fasilitas_1778397802.jpg', 'Lokasi di RT. 01, dusun Pilang, Kecamatan Boja, Kabupaten Kendal.\r\nMasjid Roudlotus Salimin menjadi pusat ibadah dan kegiatan keagamaan warga Dusun Pilang, sekaligus tempat mempererat kebersamaan dan nilai gotong royong.', '2026-05-10 07:23:22'),
(5, 'SDN 7 Boja', 2, 'Bpk. Yanto', 'fasilitas_1778397883.jpg', 'Lokasi di RT. 05, dusun Pilang, Kecamatan Boja, Kabupaten Kendal.\r\nSDN 7 Boja menjadi tempat pendidikan dasar bagi anak-anak, membangun pengetahuan, keterampilan, dan karakter sebagai bekal masa depan.', '2026-05-10 07:24:43'),
(6, 'TK Tarbiyatul Athfal', 1, 'Bpk. Arif', 'fasilitas_1778398019.jpg', 'Lokasi di RT. 01, dusun Pilang, Kecamatan Boja, Kabupaten Kendal.\r\nTK Tarbiyatul Athfal menjadi tempat belajar dan bermain bagi anak usia dini, mendukung tumbuh kembang serta pembentukan karakter sejak dini.', '2026-05-10 07:26:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kategori`
--

CREATE TABLE `t_kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kegiatan_dusun`
--

CREATE TABLE `t_kegiatan_dusun` (
  `id_kegiatan` int NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `foto` varchar(225) DEFAULT NULL,
  `keterangan` text,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(225) DEFAULT NULL,
  `penyelenggara` varchar(100) DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `jenis_kegiatan` varchar(50) DEFAULT NULL,
  `status` enum('akan_datang','dimulai','ditunda','selesai','dibatalkan') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `t_kegiatan_dusun`
--

INSERT INTO `t_kegiatan_dusun` (`id_kegiatan`, `judul`, `foto`, `keterangan`, `tanggal`, `lokasi`, `penyelenggara`, `waktu_mulai`, `waktu_selesai`, `jenis_kegiatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Kerja Bakti Serentak, Peringati Hari Desa Nasional Tahun 2026', 'kegiatan_1777166292.jpg', 'Kerja Bakti Serentak dalam rangka memperingati Hari Desa Nasional Tahun 2026 merupakan wujud nyata semangat gotong royong dan kepedulian masyarakat terhadap lingkungan serta pembangunan desa. Kegiatan ini dilaksanakan secara bersama-sama oleh seluruh warga desa, mulai dari perangkat desa, pemuda, hingga masyarakat umum, dengan tujuan menciptakan lingkungan yang bersih, sehat, dan nyaman untuk ditinggali.\r\n\r\nMelalui kerja bakti serentak ini, masyarakat diajak untuk berpartisipasi aktif dalam berbagai kegiatan, seperti membersihkan jalan desa, saluran air, tempat ibadah, fasilitas umum, serta melakukan penataan lingkungan agar terlihat lebih rapi dan asri. Selain itu, kegiatan ini juga menjadi sarana untuk mempererat tali silaturahmi, meningkatkan rasa kebersamaan, serta menumbuhkan kesadaran akan pentingnya menjaga kebersihan dan kelestarian lingkungan.\r\n\r\nPeringatan Hari Desa Nasional Tahun 2026 tidak hanya menjadi momentum seremonial, tetapi juga menjadi pengingat bahwa kemajuan desa sangat bergantung pada peran aktif dan kerja sama seluruh masyarakat. Dengan semangat gotong royong yang terus dijaga, diharapkan desa dapat berkembang menjadi lingkungan yang mandiri, berdaya saing, dan sejahtera. Oleh karena itu, kerja bakti serentak ini diharapkan dapat menjadi budaya positif yang terus dilaksanakan secara berkelanjutan demi kemajuan desa di masa yang akan datang.\r\n', '2026-04-17', 'Pos RT 01', 'Pak Mukhlis', '07:00:00', '10:00:00', 'Kegiatan warga', 'selesai', '2026-04-26 01:11:17', '2026-04-26 01:18:12'),
(2, 'Perbaikan Makam Ki Wonosari Dusun Pilang', 'kegiatan_1777166703.jpg', 'Perbaikan Makam Ki Wonosari di Dusun Pilang merupakan bentuk kepedulian masyarakat dalam menjaga dan melestarikan warisan sejarah serta menghormati jasa para leluhur. Ki Wonosari dikenal sebagai tokoh penting yang memiliki peran besar dalam perkembangan Dusun Pilang, sehingga keberadaan makam beliau menjadi salah satu simbol sejarah yang memiliki nilai budaya dan spiritual bagi masyarakat setempat.\r\n\r\nKegiatan perbaikan ini dilakukan secara bertahap dengan melibatkan berbagai elemen masyarakat, mulai dari perangkat desa, tokoh masyarakat, hingga warga sekitar. Proses perbaikan meliputi pembersihan area makam, pembenahan struktur bangunan yang mulai mengalami kerusakan, serta penataan lingkungan di sekitar makam agar lebih rapi, bersih, dan nyaman untuk dikunjungi. Selain itu, akses menuju lokasi makam juga turut diperhatikan agar memudahkan masyarakat maupun peziarah yang datang.\r\n\r\nSemangat gotong royong terlihat jelas dalam setiap tahapan kegiatan, di mana warga bekerja sama dengan penuh keikhlasan dan rasa tanggung jawab. Hal ini menunjukkan bahwa nilai kebersamaan dan kepedulian terhadap peninggalan sejarah masih terjaga dengan baik di tengah masyarakat Dusun Pilang.\r\n\r\nPerbaikan makam ini tidak hanya bertujuan untuk menjaga kondisi fisik semata, tetapi juga sebagai upaya untuk mempertahankan nilai-nilai sejarah dan kearifan lokal yang terkandung di dalamnya. Dengan kondisi makam yang lebih baik, diharapkan generasi muda dapat lebih mengenal dan menghargai sejarah desa serta meneladani nilai-nilai positif yang diwariskan oleh Ki Wonosari.\r\n\r\nKe depan, masyarakat diharapkan dapat terus merawat dan menjaga kebersihan serta kelestarian makam Ki Wonosari agar tetap terjaga dalam jangka panjang. Dengan demikian, makam tersebut tidak hanya menjadi tempat ziarah, tetapi juga menjadi sarana edukasi, penguatan identitas budaya, serta simbol kebanggaan bagi seluruh warga Dusun Pilang.\r\n', '2026-05-12', 'Depan RT 03', 'Pak Ogah', '07:00:00', '13:00:00', 'Agenda dusun', 'dibatalkan', '2026-04-26 01:11:17', '2026-04-26 03:51:01'),
(3, 'Jalan Sehat HUT ke-80 RI Dusun Pilang Berlangsung Meriah', 'kegiatan_1777166491.jpg', 'Jalan Sehat dalam rangka memperingati HUT ke-80 Republik Indonesia di Dusun Pilang berlangsung dengan sangat meriah dan penuh antusiasme dari masyarakat. Sejak pagi hari, warga dari berbagai kalangan, mulai dari anak-anak, remaja, hingga orang tua, telah berkumpul di titik start dengan semangat kebersamaan yang tinggi. Kegiatan ini menjadi salah satu agenda utama dalam rangka memeriahkan peringatan kemerdekaan sekaligus sebagai sarana untuk mempererat tali silaturahmi antarwarga.\r\n\r\nRute jalan sehat yang telah disiapkan panitia melintasi beberapa wilayah di Dusun Pilang, sehingga peserta dapat menikmati suasana lingkungan desa yang asri dan penuh kehangatan. Sepanjang perjalanan, terlihat keceriaan para peserta yang berjalan santai sambil bercengkerama, bahkan tidak sedikit yang mengabadikan momen bersama keluarga maupun teman. Hal ini menjadikan kegiatan jalan sehat tidak hanya sekadar olahraga, tetapi juga sebagai ajang kebersamaan yang menyenangkan.\r\n\r\nAcara semakin semarak dengan adanya pembagian doorprize menarik yang telah disiapkan oleh panitia. Berbagai hadiah, mulai dari kebutuhan rumah tangga hingga hadiah utama, berhasil menambah semangat dan antusiasme peserta. Selain itu, panitia juga menyisipkan hiburan dan pembagian konsumsi, sehingga suasana semakin hidup dan penuh kegembiraan.\r\n\r\nKegiatan jalan sehat ini juga mencerminkan semangat nasionalisme dan rasa cinta tanah air dalam memperingati HUT ke-80 Republik Indonesia. Melalui kegiatan yang sederhana namun penuh makna ini, diharapkan masyarakat Dusun Pilang dapat terus menjaga persatuan, meningkatkan rasa kebersamaan, serta menumbuhkan gaya hidup sehat di tengah kehidupan sehari-hari.\r\n\r\nDengan terselenggaranya kegiatan ini secara lancar dan meriah, diharapkan tradisi positif seperti jalan sehat dalam rangka peringatan hari kemerdekaan dapat terus dilestarikan setiap tahunnya. Semangat kebersamaan dan gotong royong yang terjalin selama kegiatan menjadi bukti bahwa masyarakat Dusun Pilang memiliki kekompakan yang kuat dalam membangun lingkungan yang harmonis dan penuh kebahagiaan.\r\n', '2026-08-17', 'Lapangan Voli samping Masjid', 'Pak Joko', '07:00:00', '09:00:00', 'Kegiatan warga', 'selesai', '2026-04-26 01:11:17', '2026-04-26 01:34:10'),
(4, 'Posyandu Rutin Tingkatkan Kesehatan Balita', 'kegiatan_1777166775.jpg', '     Kegiatan posyandu kembali dilaksanakan dengan penuh antusias oleh para ibu bersama balita mereka. Sejak pagi hari, warga sudah mulai berdatangan ke lokasi posyandu untuk mengikuti rangkaian kegiatan yang telah disiapkan oleh para kader kesehatan desa. Suasana terlihat ramai dan penuh keakraban, mencerminkan tingginya kesadaran masyarakat akan pentingnya menjaga kesehatan sejak dini.\r\n\r\n     Dalam kegiatan ini, para balita mendapatkan berbagai layanan kesehatan, seperti penimbangan berat badan, pengukuran tinggi badan, serta pemeriksaan kondisi kesehatan secara umum. Selain itu, petugas juga memberikan vitamin dan imunisasi sesuai dengan jadwal yang telah ditentukan, guna meningkatkan daya tahan tubuh serta mencegah berbagai penyakit.\r\n\r\n     Tidak hanya itu, para ibu juga mendapatkan edukasi mengenai pola asuh anak, pentingnya pemberian gizi seimbang, serta cara menjaga kebersihan lingkungan keluarga. Para kader posyandu dengan sabar memberikan penjelasan dan menjawab berbagai pertanyaan dari para ibu, sehingga kegiatan ini juga menjadi sarana belajar bersama.\r\n\r\n     Melalui kegiatan ini, warga diharapkan semakin sadar akan pentingnya memantau tumbuh kembang anak secara rutin. Posyandu tidak hanya menjadi tempat pelayanan kesehatan, tetapi juga menjadi wadah silaturahmi dan kebersamaan antarwarga. Dengan adanya kegiatan yang rutin dan terorganisir dengan baik, diharapkan generasi anak-anak di desa dapat tumbuh sehat, cerdas, dan berkualitas di masa depan.', '2026-01-03', 'Balai Desa Dusun Pilang', 'Pak Mustofa', '08:00:00', '10:00:00', 'Kegiatan warga', 'dimulai', '2026-04-26 01:11:17', '2026-04-26 01:26:15'),
(5, 'Peringatan Hari Kemerdekaan Indonesia', 'kegiatan_1777257039.jpg', 'Peringatan Hari Kemerdekaan Indonesia merupakan momen penting yang diperingati setiap tahun sebagai bentuk penghormatan atas perjuangan para pahlawan dalam merebut dan mempertahankan kemerdekaan bangsa. Kegiatan ini tidak hanya menjadi acara seremonial semata, tetapi juga menjadi sarana untuk menumbuhkan rasa nasionalisme, cinta tanah air, serta memperkuat persatuan dan kesatuan di tengah masyarakat.\r\n\r\nDalam rangka memperingati Hari Kemerdekaan Indonesia, berbagai kegiatan biasanya diselenggarakan dengan melibatkan seluruh lapisan masyarakat, mulai dari anak-anak hingga orang dewasa. Kegiatan tersebut antara lain upacara bendera, lomba-lomba tradisional, pentas seni, hingga kegiatan sosial yang bertujuan mempererat kebersamaan. Suasana peringatan biasanya dipenuhi dengan nuansa merah putih, mulai dari pemasangan bendera, umbul-umbul, hingga dekorasi lingkungan yang mencerminkan semangat kemerdekaan.\r\n\r\nSelain sebagai bentuk perayaan, peringatan ini juga menjadi momentum refleksi bagi seluruh masyarakat untuk mengenang jasa para pahlawan yang telah berjuang dengan penuh pengorbanan. Nilai-nilai seperti semangat juang, gotong royong, dan persatuan perlu terus ditanamkan, terutama kepada generasi muda agar mereka dapat melanjutkan perjuangan dengan cara yang sesuai dengan perkembangan zaman.\r\n\r\nMelalui peringatan Hari Kemerdekaan Indonesia, diharapkan masyarakat tidak hanya merasakan euforia perayaan, tetapi juga mampu mengambil makna yang lebih dalam tentang pentingnya menjaga kemerdekaan yang telah diraih. Dengan semangat kebersamaan dan persatuan, bangsa Indonesia diharapkan dapat terus maju, berkembang, serta menghadapi berbagai tantangan di masa depan dengan penuh optimisme dan rasa tanggung jawab.\r\n', '2026-08-19', 'Balai Desa Dusun Pilang', 'Bu Dewi', '08:00:00', '11:00:00', 'Pengumuman', 'akan_datang', '2026-04-26 03:57:39', '2026-04-27 02:30:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_nasabah`
--

CREATE TABLE `t_nasabah` (
  `id_nasabah` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(225) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `tgl_bergabung` date DEFAULT NULL,
  `status` enum('aktif','non_aktif') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pengaduan`
--

CREATE TABLE `t_pengaduan` (
  `id_pengaduan` int NOT NULL,
  `id_admin` int DEFAULT NULL,
  `nama_pelapor` varchar(100) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `judul_pengaduan` varchar(100) DEFAULT NULL,
  `pengaduan` text,
  `kategori` enum('fasilitas','keamanan','saran','dll') DEFAULT NULL,
  `foto_bukti` varchar(225) DEFAULT NULL,
  `status` enum('diterima','diproses','selesai') DEFAULT NULL,
  `respon_admin` text,
  `foto_respon` varchar(225) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `t_pengaduan`
--

INSERT INTO `t_pengaduan` (`id_pengaduan`, `id_admin`, `nama_pelapor`, `no_telp`, `judul_pengaduan`, `pengaduan`, `kategori`, `foto_bukti`, `status`, `respon_admin`, `foto_respon`, `created_at`, `updated_at`) VALUES
(1, 1, 'Veila Devina', '081234567890', 'Perbaikan Makam Ki Wonosari Dusun Pilang', 'Kondisi Makam Ki Wonosari saat ini membutuhkan perbaikan pada area pagar dan jalan setapak demi kenyamanan peziarah.', 'fasilitas', 'pengaduan/aduan_1778382289.png', 'diterima', '', NULL, '2026-05-10 03:04:49', '2026-05-10 03:17:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_profil_dusun`
--

CREATE TABLE `t_profil_dusun` (
  `id_profil` int NOT NULL,
  `nama_dusun` varchar(100) DEFAULT NULL,
  `kepala_dusun` varchar(225) DEFAULT NULL,
  `sejarah` text,
  `visi` text,
  `misi` text,
  `logo` varchar(300) DEFAULT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `lokasi` text,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_sampah`
--

CREATE TABLE `t_sampah` (
  `id_sampah` int NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `nama_sampah` varchar(100) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `harga_per_kg` decimal(10,2) DEFAULT NULL,
  `keterangan` text,
  `foto` varchar(225) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `t_sampah`
--

INSERT INTO `t_sampah` (`id_sampah`, `id_kategori`, `nama_sampah`, `satuan`, `harga_per_kg`, `keterangan`, `foto`, `updated_at`) VALUES
(1, NULL, 'Botol Plastik Tipe A', NULL, 2500.00, NULL, NULL, '2026-05-10 02:32:03'),
(2, NULL, 'Botol Plastik Tipe B', NULL, 1500.00, NULL, NULL, '2026-05-10 02:32:03'),
(3, NULL, 'Kardus', NULL, 1000.00, NULL, NULL, '2026-05-10 02:32:03'),
(4, NULL, 'Kaleng', NULL, 3500.00, NULL, NULL, '2026-05-10 02:32:03'),
(5, NULL, 'Buku Bekas - HVS', NULL, 1500.00, NULL, NULL, '2026-05-10 02:32:03'),
(6, NULL, 'Botol kaca', NULL, 1500.00, NULL, NULL, '2026-05-10 02:32:03'),
(7, NULL, 'Besi', NULL, 4500.00, NULL, NULL, '2026-05-10 02:32:03'),
(8, NULL, 'Koran', NULL, 1000.00, NULL, NULL, '2026-05-10 02:32:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_tabungan`
--

CREATE TABLE `t_tabungan` (
  `id_tabungan` int NOT NULL,
  `id_nasabah` int DEFAULT NULL,
  `saldo` decimal(12,2) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_transaksi`
--

CREATE TABLE `t_transaksi` (
  `id_transaksi` int NOT NULL,
  `id_nasabah` int DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `id_sampah` int DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `berat_sampah` decimal(8,2) DEFAULT NULL,
  `total_harga` decimal(12,2) DEFAULT NULL,
  `status` enum('ditarik','masuk_tabungan') DEFAULT NULL,
  `foto` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `t_bisnis_desa`
--
ALTER TABLE `t_bisnis_desa`
  ADD PRIMARY KEY (`id_bisnis`);

--
-- Indeks untuk tabel `t_fasilitas_dusun`
--
ALTER TABLE `t_fasilitas_dusun`
  ADD PRIMARY KEY (`id_fasilitas`);

--
-- Indeks untuk tabel `t_kategori`
--
ALTER TABLE `t_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `t_kegiatan_dusun`
--
ALTER TABLE `t_kegiatan_dusun`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `t_nasabah`
--
ALTER TABLE `t_nasabah`
  ADD PRIMARY KEY (`id_nasabah`);

--
-- Indeks untuk tabel `t_pengaduan`
--
ALTER TABLE `t_pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indeks untuk tabel `t_profil_dusun`
--
ALTER TABLE `t_profil_dusun`
  ADD PRIMARY KEY (`id_profil`);

--
-- Indeks untuk tabel `t_sampah`
--
ALTER TABLE `t_sampah`
  ADD PRIMARY KEY (`id_sampah`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `t_tabungan`
--
ALTER TABLE `t_tabungan`
  ADD PRIMARY KEY (`id_tabungan`),
  ADD UNIQUE KEY `id_nasabah` (`id_nasabah`);

--
-- Indeks untuk tabel `t_transaksi`
--
ALTER TABLE `t_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_nasabah` (`id_nasabah`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_sampah` (`id_sampah`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `t_bisnis_desa`
--
ALTER TABLE `t_bisnis_desa`
  MODIFY `id_bisnis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `t_fasilitas_dusun`
--
ALTER TABLE `t_fasilitas_dusun`
  MODIFY `id_fasilitas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `t_kategori`
--
ALTER TABLE `t_kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_kegiatan_dusun`
--
ALTER TABLE `t_kegiatan_dusun`
  MODIFY `id_kegiatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `t_nasabah`
--
ALTER TABLE `t_nasabah`
  MODIFY `id_nasabah` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_pengaduan`
--
ALTER TABLE `t_pengaduan`
  MODIFY `id_pengaduan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `t_profil_dusun`
--
ALTER TABLE `t_profil_dusun`
  MODIFY `id_profil` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_sampah`
--
ALTER TABLE `t_sampah`
  MODIFY `id_sampah` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `t_tabungan`
--
ALTER TABLE `t_tabungan`
  MODIFY `id_tabungan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_transaksi`
--
ALTER TABLE `t_transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_pengaduan`
--
ALTER TABLE `t_pengaduan`
  ADD CONSTRAINT `t_pengaduan_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `t_admin` (`id_admin`);

--
-- Ketidakleluasaan untuk tabel `t_sampah`
--
ALTER TABLE `t_sampah`
  ADD CONSTRAINT `t_sampah_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `t_kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `t_tabungan`
--
ALTER TABLE `t_tabungan`
  ADD CONSTRAINT `t_tabungan_ibfk_1` FOREIGN KEY (`id_nasabah`) REFERENCES `t_nasabah` (`id_nasabah`);

--
-- Ketidakleluasaan untuk tabel `t_transaksi`
--
ALTER TABLE `t_transaksi`
  ADD CONSTRAINT `t_transaksi_ibfk_1` FOREIGN KEY (`id_nasabah`) REFERENCES `t_nasabah` (`id_nasabah`),
  ADD CONSTRAINT `t_transaksi_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `t_admin` (`id_admin`),
  ADD CONSTRAINT `t_transaksi_ibfk_3` FOREIGN KEY (`id_sampah`) REFERENCES `t_sampah` (`id_sampah`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
