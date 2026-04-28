<?php
require 'config.php';
$res = mysqli_query($conn, 'SHOW COLUMNS FROM t_kegiatan_dusun');
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
