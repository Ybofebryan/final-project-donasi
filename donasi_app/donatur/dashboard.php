<?php
require '../config/config.php';
session_start();

if (!isset($_SESSION['peran']) || $_SESSION['peran'] != 'donatur') {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM kampanye WHERE batas_waktu >= CURDATE()");
$kampanye = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Donatur</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1>Dashboard Donatur</h1>
    <a href="../logout.php" class="btn btn-danger mb-3">Logout</a>
    <h3>Daftar Kampanye Aktif</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Target Dana</th>
                <th>Terkumpul</th>
                <th>Batas Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kampanye as $k): ?>
                <tr>
                    <td><?= $k['id'] ?></td>
                    <td><?= $k['judul'] ?></td>
                    <td>Rp <?= number_format($k['target_dana'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($k['dana_terkumpul'], 0, ',', '.') ?></td>
                    <td><?= $k['batas_waktu'] ?></td>
                    <td>
                        <a href="donasi.php?kampanye_id=<?= $k['id'] ?>" class="btn btn-primary btn-sm">Donasi</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
