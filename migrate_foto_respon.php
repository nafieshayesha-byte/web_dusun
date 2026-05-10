<?php
$conn = mysqli_connect("localhost", "root", "", "db_dusunpilang");
if (!$conn) die("Connection failed");

// Add column if not exists
mysqli_query($conn, "ALTER TABLE t_pengaduan ADD COLUMN foto_respon VARCHAR(225) AFTER respon_admin");

// Update dummy data for ID 1 to look complete
mysqli_query($conn, "UPDATE t_pengaduan SET 
    no_telp = '081234567890',
    pengaduan = 'Kondisi Makam Ki Wonosari saat ini membutuhkan perbaikan pada area pagar dan jalan setapak demi kenyamanan peziarah.'
    WHERE id_pengaduan = 1");

echo "Success updating database schema and data";
?>
