<?php
$conn = mysqli_connect("localhost", "root", "", "db_dusunpilang");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>