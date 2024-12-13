<?php
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user'])) {
    // Jika session tidak ditemukan, arahkan ke halaman login
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Sukses</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h4>Reservasi Anda Telah Berhasil!</h4>
            <p>Kursi telah berhasil dipesan. Terima kasih atas reservasi Anda.</p>
            <!-- Tambahkan tombol untuk menuju ke halaman pembayaran -->
            <a href="pembayaran.php" class="btn btn-primary">LANJUT KE PEMBAYARAN</a>
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
