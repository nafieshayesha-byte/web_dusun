-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Apr 2026 pada 07.06
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
  `password` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `status` enum('akan_datang','dimulai','ditunda','selesai','dibatalkan') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `kategori` enum('keamanan','fasilitas','lain_lain') DEFAULT NULL,
  `foto_bukti` varchar(225) DEFAULT NULL,
  `status` enum('diterima','diproses','selesai') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `status` enum('ditarik','masuk_tabungan') DEFAULT NULL
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
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_bisnis_desa`
--
ALTER TABLE `t_bisnis_desa`
  MODIFY `id_bisnis` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_fasilitas_dusun`
--
ALTER TABLE `t_fasilitas_dusun`
  MODIFY `id_fasilitas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_kategori`
--
ALTER TABLE `t_kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_kegiatan_dusun`
--
ALTER TABLE `t_kegiatan_dusun`
  MODIFY `id_kegiatan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_nasabah`
--
ALTER TABLE `t_nasabah`
  MODIFY `id_nasabah` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_pengaduan`
--
ALTER TABLE `t_pengaduan`
  MODIFY `id_pengaduan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_profil_dusun`
--
ALTER TABLE `t_profil_dusun`
  MODIFY `id_profil` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_sampah`
--
ALTER TABLE `t_sampah`
  MODIFY `id_sampah` int NOT NULL AUTO_INCREMENT;

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
