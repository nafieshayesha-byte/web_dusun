<?php
include '../config.php';
// Query untuk mengambil data bisnis
$bisnis = mysqli_query($conn, "SELECT * FROM t_bisnis_desa");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Kelola Bisnis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="d-flex">
        <div class="bg-dark text-white p-4" style="width: 250px; min-height: 100vh;">
            <h4>CMS Dusun</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="kegiatan.php" class="nav-link text-white">Kegiatan</a></li>
                <li class="nav-item"><a href="bisnis.php" class="nav-link text-white active">Bisnis Warga</a></li>
                <li class="nav-item"><a href="pengaduan.php" class="nav-link text-white">Pengaduan</a></li>
            </ul>
        </div>

        <div class="container-fluid p-4">
            <h2 class="mb-4">Kelola Bisnis Warga</h2>
            <table class="table table-bordered bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Usaha</th>
                        <th>Pemilik</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($b = mysqli_fetch_array($bisnis)) { ?>
                    <tr>
                        <td><?= $b['nama_usaha'] ?></td> [cite: 10]
                        <td><?= $b['nama_pengusaha'] ?></td> [cite: 10]
                        <td><?= $b['jenis_usaha'] ?></td> [cite: 10]
                        <td><span class="badge bg-info"><?= $b['status'] ?></span></td> [cite: 10]
                        <td>
                            <a href="#" class="btn btn-sm btn-warning">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>