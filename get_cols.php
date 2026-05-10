<?php
require 'config.php';
$desc = mysqli_query($conn, 'DESCRIBE t_bisnis_desa');
$cols = [];
while($r = mysqli_fetch_assoc($desc)) $cols[] = $r;
file_put_contents('cols.json', json_encode($cols));
