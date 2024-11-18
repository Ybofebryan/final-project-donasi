<?php
require '../config/config.php';
session_start();

if (!isset($_SESSION['peran']) || $_SESSION['peran'] != 'donatur') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT d.jumlah, d.status, k.judul 
                       FROM donasi d 
                       JOIN kampanye k ON d.kampanye_id = k.id 
                       WHERE d.user_id = ?");
$stmt->execute([$user_id]);
$riwayat = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Donasi</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1>Riwayat Donasi Anda</h1>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul Kampanye</th>
                <th>Jumlah Donasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($riwayat as $r): ?>
                <tr>
                    <td><?= $r['judul'] ?></td>
                    <td>Rp <?= number_format($r['jumlah'], 0, ',', '.') ?></td>
                    <td><?= ucfirst($r['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
