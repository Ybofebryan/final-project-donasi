<?php
require '../config/config.php';
session_start();

if (!isset($_SESSION['peran']) || $_SESSION['peran'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Verifikasi donasi
if (isset($_GET['verifikasi'])) {
    $id_donasi = $_GET['verifikasi'];
    $stmt = $pdo->prepare("UPDATE donasi SET status = 'terverifikasi' WHERE id = ?");
    if ($stmt->execute([$id_donasi])) {
        $success = "Donasi berhasil diverifikasi.";
    } else {
        $error = "Gagal memverifikasi donasi.";
    }
}

// Query daftar donasi pending
$stmt = $pdo->query("SELECT d.id, d.jumlah, d.status, u.nama AS donatur, k.judul AS kampanye 
                     FROM donasi d
                     JOIN users u ON d.user_id = u.id
                     JOIN kampanye k ON d.kampanye_id = k.id
                     WHERE d.status = 'pending'");
$donasi = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Donasi</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1>Verifikasi Donasi</h1>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <h3>Daftar Donasi Pending</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Donatur</th>
                <th>Kampanye</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donasi as $d): ?>
                <tr>
                    <td><?= $d['id'] ?></td>
                    <td><?= $d['donatur'] ?></td>
                    <td><?= $d['kampanye'] ?></td>
                    <td>Rp <?= number_format($d['jumlah'], 0, ',', '.') ?></td>
                    <td><?= ucfirst($d['status']) ?></td>
                    <td>
                        <a href="?verifikasi=<?= $d['id'] ?>" class="btn btn-success btn-sm">Verifikasi</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
