<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_id = $_SESSION['admin_id'] ?? 1;
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $tema = mysqli_real_escape_string($conn, $_POST['tema'] ?? 'light');
    $bahasa = mysqli_real_escape_string($conn, $_POST['bahasa'] ?? 'id');
    
    // Handle Profile Picture
    $foto_profil = "";
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $target_dir = "../assets/";
        $file_extension = pathinfo($_FILES["foto_profil"]["name"], PATHINFO_EXTENSION);
        $file_name = "admin_" . time() . "." . $file_extension;
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $target_file)) {
            $foto_profil = $file_name;
        }
    }

    $sql = "UPDATE t_admin SET username = '$username', nama_lengkap = '$nama_lengkap', tema = '$tema', bahasa = '$bahasa'";
    if (!empty($foto_profil)) {
        $sql .= ", foto_profil = '$foto_profil'";
        $_SESSION['admin_foto'] = $foto_profil; // Update session if you use it in sidebar
    }
    
    // Update password if provided in Profile section
    if (!empty($_POST['password_profil'])) {
        $sql .= ", password = '" . mysqli_real_escape_string($conn, $_POST['password_profil']) . "'";
    }

    $sql .= " WHERE id_admin = '$admin_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['admin_name'] = $nama_lengkap;
        header("Location: pengaturan.php?msg=success");
    } else {
        header("Location: pengaturan.php?msg=error&err=" . urlencode(mysqli_error($conn)));
    }
}
?>
