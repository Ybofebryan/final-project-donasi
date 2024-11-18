<?php
require '../config/config.php';
session_start();

if (!isset($_SESSION['peran']) || $_SESSION['peran'] != 'donatur') {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['kampanye_id'])) {
    $kampanye_id = $_GET['kampanye_id'];
    $stmt = $pdo->prepare("SELECT * FROM kampanye WHERE id = ?");
    $stmt->execute([$kampanye_id]);
    $kampanye = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah = $_POST['jumlah'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO donasi (user_id, kampanye_id, jumlah) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $kampanye_id, $jumlah])) {
        $success = "Donasi berhasil dibuat! Tunggu verifikasi.";
    } else {
        $error = "Donasi gagal dibuat.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Donasi</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1>Donasi untuk Kampanye</h1>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header"><?= $kampanye['judul'] ?></div>
        <div class="card-body">
            <p><?= $kampanye['deskripsi'] ?></p>
            <p>Target Dana: Rp <?= number_format($kampanye['target_dana'], 0, ',', '.') ?></p>
            <form method="POST">
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Donasi (Rp)</label>
                    <input type="number" class="form-control" name="jumlah" required>
                </div>
                <button type="submit" class="btn btn-primary">Donasi</button>
            </form>
        </div>
    </div>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
