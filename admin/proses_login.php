<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Cek hardcoded admin admin sesuai permintaan
if($username === 'admin' && $password === 'admin') {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_name'] = 'Karina Cahya Kirana';
    header("Location: index.php");
    exit;
} else {
    echo "<script>alert('Username atau password salah!'); window.location.href='login.php';</script>";
}
?>
