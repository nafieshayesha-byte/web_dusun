<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $kategori = strtolower(mysqli_real_escape_string($conn, $_POST['kategori']));
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengaduan = mysqli_real_escape_string($conn, $_POST['pengaduan']);
    $status = 'diterima';

    // Handle File Upload
    $foto = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "assets/pengaduan/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
        $file_extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $foto = "aduan_" . time() . "." . $file_extension;
        $target_file = $target_dir . $foto;
        
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        $foto = "pengaduan/" . $foto;
    }

    $sql = "INSERT INTO t_pengaduan (nama_pelapor, no_telp, kategori, judul_pengaduan, pengaduan, foto_bukti, status) 
            VALUES ('$nama', '$no_hp', '$kategori', '$judul', '$pengaduan', '$foto', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Aduan berhasil dikirim!'); window.location.href='pengaduan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
