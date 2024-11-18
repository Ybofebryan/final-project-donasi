<?php
require '../config/config.php';
session_start();

if (!isset($_SESSION['peran']) || $_SESSION['peran'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $target_dana = $_POST['target_dana'];
    $batas_waktu = $_POST['batas_waktu'];

    $stmt = $pdo->prepare("INSERT INTO kampanye (judul, deskripsi, target_dana, batas_waktu) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$judul, $deskripsi, $target_dana, $batas_waktu])) {
        $success = "Kampanye berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan kampanye.";
    }
}

$stmt = $pdo->query("SELECT * FROM kampanye");
$kampanye = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kampanye</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1>Kelola Kampanye</h1>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <h3>Tambah Kampanye Baru</h3>
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Kampanye</label>
            <input type="text" class="form-control" name="judul" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="target_dana" class="form-label">Target Dana</label>
            <input type="number" class="form-control" name="target_dana" required>
        </div>
        <div class="mb-3">
            <label for="batas_waktu" class="form-label">Batas Waktu</label>
            <input type="date" class="form-control" name="batas_waktu" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Kampanye</button>
    </form>

    <h3>Daftar Kampanye</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Target Dana</th>
                <th>Terkumpul</th>
                <th>Batas Waktu</th>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
