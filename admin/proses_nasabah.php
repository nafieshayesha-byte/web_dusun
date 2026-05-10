<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

if ($act == 'add') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $tgl_bergabung = mysqli_real_escape_string($conn, $_POST['tgl_bergabung']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $q = mysqli_query($conn, "INSERT INTO t_nasabah (nama, alamat, telp, tgl_bergabung, status) VALUES ('$nama', '$alamat', '$telp', '$tgl_bergabung', '$status')");
    
    if ($q) {
        header("Location: nasabah.php?msg=success");
    } else {
        header("Location: nasabah.php?msg=error");
    }
} 
elseif ($act == 'edit') {
    $id = mysqli_real_escape_string($conn, $_POST['id_nasabah']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $tgl_bergabung = mysqli_real_escape_string($conn, $_POST['tgl_bergabung']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $q = mysqli_query($conn, "UPDATE t_nasabah SET nama='$nama', alamat='$alamat', telp='$telp', tgl_bergabung='$tgl_bergabung', status='$status' WHERE id_nasabah='$id'");
    
    if ($q) {
        header("Location: nasabah.php?msg=updated");
    } else {
        header("Location: nasabah.php?msg=error");
    }
} 
elseif ($act == 'del') {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $q = mysqli_query($conn, "DELETE FROM t_nasabah WHERE id_nasabah='$id'");
    
    if ($q) {
        header("Location: nasabah.php?msg=deleted");
    } else {
        header("Location: nasabah.php?msg=error");
    }
}
?>
