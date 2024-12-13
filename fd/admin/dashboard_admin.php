<?php
session_start();
// Cek apakah admin sudah login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Jika belum login atau bukan admin, arahkan ke halaman login
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Dashboard Admin</h1>
        <!-- Link untuk Kelola Bus, pastikan path-nya sesuai -->
        <a href="manage_bus.php" class="btn btn-success mt-3">Kelola Bus</a>
        <!-- Link untuk Kelola Pengguna -->
        <a href="manage_user.php" class="btn btn-info mt-3">Kelola Pengguna</a>
        <!-- Link untuk Logout -->
        <a href="../logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
