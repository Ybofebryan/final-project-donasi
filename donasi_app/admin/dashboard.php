<?php
require '../config/config.php';
session_start();

if (!isset($_SESSION['peran']) || $_SESSION['peran'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->query("SELECT COUNT(*) AS total_kampanye FROM kampanye");
$total_kampanye = $stmt->fetch()['total_kampanye'];

$stmt = $pdo->query("SELECT COUNT(*) AS total_donasi FROM donasi");
$total_donasi = $stmt->fetch()['total_donasi'];

$stmt = $pdo->query("SELECT SUM(jumlah) AS total_dana FROM donasi WHERE status = 'terverifikasi'");
$total_dana = $stmt->fetch()['total_dana'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1>Dashboard Admin</h1>
    <a href="../logout.php" class="btn btn-danger mb-3">Logout</a>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header bg-primary text-white">Total Kampanye</div>
                <div class="card-body">
                    <h3><?= $total_kampanye ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header bg-success text-white">Total Donasi</div>
                <div class="card-body">
                    <h3><?= $total_donasi ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header bg-info text-white">Dana Terkumpul</div>
                <div class="card-body">
                    <h3>Rp <?= number_format($total_dana, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
