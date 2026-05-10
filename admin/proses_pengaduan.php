<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengaduan = mysqli_real_escape_string($conn, $_POST['id_pengaduan']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $id_admin = mysqli_real_escape_string($conn, $_POST['id_admin']);
    $respon_admin = mysqli_real_escape_string($conn, $_POST['respon_admin']);

    // Handle Foto Respon Upload
    $foto_respon = "";
    if (isset($_FILES['foto_respon']) && $_FILES['foto_respon']['error'] == 0) {
        $target_dir = "../assets/pengaduan/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        
        $file_extension = pathinfo($_FILES["foto_respon"]["name"], PATHINFO_EXTENSION);
        $file_name = "respon_" . time() . "." . $file_extension;
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["foto_respon"]["tmp_name"], $target_file)) {
            $foto_respon = "pengaduan/" . $file_name;
        }
    }

    $sql = "UPDATE t_pengaduan SET 
            status = '$status', 
            id_admin = '$id_admin', 
            respon_admin = '$respon_admin'";
    
    if (!empty($foto_respon)) {
        $sql .= ", foto_respon = '$foto_respon'";
    }
    
    $sql .= " WHERE id_pengaduan = '$id_pengaduan'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: pengaduan.php?action=list&msg=success");
    } else {
        header("Location: pengaduan.php?action=edit&id=$id_pengaduan&msg=error&err=" . urlencode(mysqli_error($conn)));
    }
}
?>
