<?php
require 'config.php';

// Empty the table first to guarantee EXACT match for the 4 items
mysqli_query($conn, "TRUNCATE TABLE t_kegiatan_dusun");

$data = [
    [
        'judul' => 'Kerja Bakti Serentak, Peringati Hari Desa Nasional Tahun 2026',
        'foto' => 'https://images.unsplash.com/photo-1594708767771-a7502209ff51?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'keterangan' => '-',
        'tanggal' => '2026-04-17',
        'jenis_kegiatan' => 'Kegiatan warga'
    ],
    [
        'judul' => 'Pembangunan Makam Ki Wonosari Dusun Pilang',
        'foto' => 'https://images.unsplash.com/photo-1541888086925-920eb1fb1c13?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'keterangan' => '-',
        'tanggal' => '2026-02-12',
        'jenis_kegiatan' => 'Berita dusun'
    ],
    [
        'judul' => 'Jalan Sehat HUT ke-80 RI Dusun Pilang Berlangsung Meriah',
        'foto' => 'https://images.unsplash.com/photo-1551065171-d68a9fc81d6e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'keterangan' => '-',
        'tanggal' => '2026-03-24',
        'jenis_kegiatan' => 'Agenda dusun'
    ],
    [
        'judul' => 'Posyandu Rutin Tingkatkan Kesehatan Balita',
        'foto' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'keterangan' => '-',
        'tanggal' => '2026-01-03',
        'jenis_kegiatan' => 'Berita dusun'
    ]
];

foreach($data as $d) {
    $j = $d['judul'];
    $f = $d['foto'];
    $k = $d['keterangan'];
    $t = $d['tanggal'];
    $jk = $d['jenis_kegiatan'];
    mysqli_query($conn, "INSERT INTO t_kegiatan_dusun (judul, foto, keterangan, tanggal, jenis_kegiatan, status) VALUES ('$j', '$f', '$k', '$t', '$jk', 'selesai')");
}
echo "Done";
?>
