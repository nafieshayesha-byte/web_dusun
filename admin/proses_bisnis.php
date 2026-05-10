<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

$act = isset($_GET['act']) ? $_GET['act'] : '';

if ($act == 'add') {
    $nama_usaha = mysqli_real_escape_string($conn, $_POST['nama_usaha']);
    $nama_pengusaha = mysqli_real_escape_string($conn, $_POST['nama_pengusaha']);
    $jenis_usaha = mysqli_real_escape_string($conn, $_POST['jenis_usaha']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $status = 'buka'; // Default status

    // Handle Upload Foto
    $foto = "";
    if ($_FILES['foto']['name'] != "") {
        $filename = "bisnis_" . time() . "_" . $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp_name, "../assets/" . $filename);
        $foto = $filename;
    }

    $query = "INSERT INTO t_bisnis_desa (nama_usaha, nama_pengusaha, jenis_usaha, keterangan, alamat, no_telp, foto, status) 
              VALUES ('$nama_usaha', '$nama_pengusaha', '$jenis_usaha', '$keterangan', '$alamat', '$no_telp', '$foto', '$status')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: bisnis.php?msg=success_add");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} elseif ($act == 'edit') {
    $id = $_POST['id'];
    $nama_usaha = mysqli_real_escape_string($conn, $_POST['nama_usaha']);
    $nama_pengusaha = mysqli_real_escape_string($conn, $_POST['nama_pengusaha']);
    $jenis_usaha = mysqli_real_escape_string($conn, $_POST['jenis_usaha']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $foto_lama = $_POST['foto_lama'];

    // Handle Upload Foto
    $foto = $foto_lama;
    if ($_FILES['foto']['name'] != "") {
        $filename = "bisnis_" . time() . "_" . $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp_name, "../assets/" . $filename);
        $foto = $filename;
        // Hapus foto lama jika ada
        if ($foto_lama != "" && file_exists("../assets/" . $foto_lama)) {
            unlink("../assets/" . $foto_lama);
        }
    }

    $query = "UPDATE t_bisnis_desa SET 
              nama_usaha='$nama_usaha', 
              nama_pengusaha='$nama_pengusaha', 
              jenis_usaha='$jenis_usaha', 
              keterangan='$keterangan', 
              alamat='$alamat', 
              no_telp='$no_telp', 
              foto='$foto' 
              WHERE id_bisnis='$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: bisnis.php?msg=success_edit");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} elseif ($act == 'del') {
    $id = $_GET['id'];
    
    // Get foto to delete file
    $q = mysqli_query($conn, "SELECT foto FROM t_bisnis_desa WHERE id_bisnis='$id'");
    $data = mysqli_fetch_array($q);
    if ($data['foto'] != "" && file_exists("../assets/" . $data['foto'])) {
        unlink("../assets/" . $data['foto']);
    }

    mysqli_query($conn, "DELETE FROM t_bisnis_desa WHERE id_bisnis='$id'");
    header("Location: bisnis.php?msg=success_del");
}
?>
