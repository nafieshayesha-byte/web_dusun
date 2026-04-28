<?php
require_once "config.php";
$query = "ALTER TABLE t_kegiatan_dusun ADD COLUMN jenis_kegiatan ENUM('Berita', 'Kegiatan', 'Pengumuman', 'Event') AFTER waktu_selesai";
// Wait, looking at image 1: tags say "Kegiatan", "Berita", "Event".
// Actually image 3 specifies "Jenis Kegiatan" options: "Berita dusun", "Kegiatan warga", "Pengumuman", "Agenda dusun", "Potensi dusun".
$query2 = "ALTER TABLE t_kegiatan_dusun ADD COLUMN jenis_kegiatan VARCHAR(50) AFTER waktu_selesai";
mysqli_query($conn, $query2);
echo "Done";
?>
