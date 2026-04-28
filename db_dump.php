<?php
require_once "config.php";
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_array($result)) {
    echo $row[0] . "\n";
    $desc = mysqli_query($conn, "DESCRIBE " . $row[0]);
    while ($r = mysqli_fetch_assoc($desc)) {
        echo "  " . $r['Field'] . " - " . $r['Type'] . "\n";
    }
}
?>
