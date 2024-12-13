<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $query = "SELECT * FROM reservasi WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Booking</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Status Booking Anda</h2>
        <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
            <table class="table">
                <tr>
                    <th>Nama</th>
                    <th>Keberangkatan</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['keberangkatan']; ?></td>
                        <td><?= $row['tujuan']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['jam']; ?></td>
                        <td>Confirmed</td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Tidak ada reservasi ditemukan untuk email ini.</p>
        <?php endif; ?>
    </div>
</body>
</html>
