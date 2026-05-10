<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Cek hardcoded admin admin sesuai permintaan
if($username === 'admin' && $password === 'admin') {
    require_once '../config.php';
    $q = mysqli_query($conn, "SELECT * FROM t_admin WHERE username = 'admin' LIMIT 1");
    $admin = mysqli_fetch_assoc($q);
    
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $admin['id_admin'] ?? 1;
    $_SESSION['admin_name'] = $admin['nama_lengkap'] ?? 'Karina Cahya Kirana';
    $_SESSION['admin_foto'] = $admin['foto_profil'] ?? 'placeholder.jpg';
    
    header("Location: index.php");
    exit;
} else {
    echo "<script>alert('Username atau password salah!'); window.location.href='login.php';</script>";
}
?>
