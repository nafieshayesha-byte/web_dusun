<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_nasabah = mysqli_real_escape_string($conn, $_POST['id_nasabah']);
    $id_admin = mysqli_real_escape_string($conn, $_POST['id_admin']);
    $id_sampah = mysqli_real_escape_string($conn, $_POST['id_sampah']);
    $tgl_transaksi = mysqli_real_escape_string($conn, $_POST['tgl_transaksi']);
    $berat_sampah = mysqli_real_escape_string($conn, $_POST['berat_sampah']);
    $total_harga = mysqli_real_escape_string($conn, $_POST['total_harga']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Handle File Upload
    $foto = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/transaksi/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
        $file_extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $foto = "trans_" . time() . "." . $file_extension;
        $target_file = $target_dir . $foto;
        
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        $foto = "transaksi/" . $foto; // Store relative path
    }

    // Insert Transaction
    $sql = "INSERT INTO t_transaksi (id_nasabah, id_admin, id_sampah, tgl_transaksi, berat_sampah, total_harga, status, foto) 
            VALUES ('$id_nasabah', '$id_admin', '$id_sampah', '$tgl_transaksi', '$berat_sampah', '$total_harga', '$status', '$foto')";
    
    if (mysqli_query($conn, $sql)) {
        // If status is masuk_tabungan, update t_tabungan
        if ($status == 'masuk_tabungan') {
            // Check if tabungan exists
            $q_check = mysqli_query($conn, "SELECT * FROM t_tabungan WHERE id_nasabah = '$id_nasabah'");
            if (mysqli_num_rows($q_check) > 0) {
                mysqli_query($conn, "UPDATE t_tabungan SET saldo = saldo + $total_harga WHERE id_nasabah = '$id_nasabah'");
            } else {
                mysqli_query($conn, "INSERT INTO t_tabungan (id_nasabah, saldo) VALUES ('$id_nasabah', '$total_harga')");
            }
        }
        
        header("Location: transaksi.php?msg=success");
    } else {
        header("Location: transaksi.php?msg=error&err=" . urlencode(mysqli_error($conn)));
    }
}
?>
