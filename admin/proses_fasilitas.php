<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$act = isset($_GET['act']) ? $_GET['act'] : '';

if($act == 'add') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_fasilitas']);
    $unit = intval($_POST['unit']);
    $pj = mysqli_real_escape_string($conn, $_POST['penanggung_jawab']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    
    $foto = '';
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = 'fasilitas_'.time().'.'.$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/'.$foto);
    }

    $q = "INSERT INTO t_fasilitas_dusun (nama_fasilitas, unit, penanggung_jawab, foto, keterangan) 
          VALUES ('$nama', '$unit', '$pj', '$foto', '$keterangan')";
    mysqli_query($conn, $q);
    header("Location: fasilitas.php?action=list");
} 
elseif($act == 'edit') {
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_fasilitas']);
    $unit = intval($_POST['unit']);
    $pj = mysqli_real_escape_string($conn, $_POST['penanggung_jawab']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    
    $foto = $_POST['foto_lama'];
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = 'fasilitas_'.time().'.'.$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/'.$foto);
    }

    $q = "UPDATE t_fasilitas_dusun SET 
            nama_fasilitas='$nama', unit='$unit', penanggung_jawab='$pj', 
            foto='$foto', keterangan='$keterangan' 
          WHERE id_fasilitas='$id'";
    mysqli_query($conn, $q);
    header("Location: fasilitas.php?action=list");
}
elseif($act == 'del') {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM t_fasilitas_dusun WHERE id_fasilitas='$id'");
    header("Location: fasilitas.php?action=list");
}
?>
