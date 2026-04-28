<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$act = isset($_GET['act']) ? $_GET['act'] : '';

if($act == 'add') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $tanggal = $_POST['tanggal'];
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $penyelenggara = mysqli_real_escape_string($conn, $_POST['penyelenggara']);
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $jenis_kegiatan = mysqli_real_escape_string($conn, $_POST['jenis_kegiatan']);
    $status = $_POST['status'];
    
    $foto = '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = 'kegiatan_'.time().'.'.$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/'.$foto);
    }

    $q = "INSERT INTO t_kegiatan_dusun (judul, foto, keterangan, tanggal, lokasi, penyelenggara, waktu_mulai, waktu_selesai, jenis_kegiatan, status) 
          VALUES ('$judul', '$foto', '$keterangan', '$tanggal', '$lokasi', '$penyelenggara', '$waktu_mulai', '$waktu_selesai', '$jenis_kegiatan', '$status')";
    mysqli_query($conn, $q);
    header("Location: index.php?action=list");
} 
elseif($act == 'edit') {
    $id = $_POST['id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $tanggal = $_POST['tanggal'];
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $penyelenggara = mysqli_real_escape_string($conn, $_POST['penyelenggara']);
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $jenis_kegiatan = mysqli_real_escape_string($conn, $_POST['jenis_kegiatan']);
    $status = $_POST['status'];
    
    $foto = $_POST['foto_lama'];
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = 'kegiatan_'.time().'.'.$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/'.$foto);
    }

    $q = "UPDATE t_kegiatan_dusun SET 
            judul='$judul', foto='$foto', keterangan='$keterangan', tanggal='$tanggal', 
            lokasi='$lokasi', penyelenggara='$penyelenggara', waktu_mulai='$waktu_mulai', 
            waktu_selesai='$waktu_selesai', jenis_kegiatan='$jenis_kegiatan', status='$status' 
          WHERE id_kegiatan='$id'";
    mysqli_query($conn, $q);
    header("Location: index.php?action=list");
}
elseif($act == 'del') {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM t_kegiatan_dusun WHERE id_kegiatan='$id'");
    header("Location: index.php?action=list");
}
?>
