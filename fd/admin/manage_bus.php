<?php
session_start();
// if ($_SESSION['role'] != 'admin') {
//     header('Location: ../index.php');
//     exit;
// }
include '../koneksi.php';

// Menghapus bus jika ada parameter delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Hapus data terkait di tabel reservations
    $koneksi->query("DELETE FROM reservations WHERE bus_id=$id");

    // Hapus data di tabel buses
    $koneksi->query("DELETE FROM buses WHERE id=$id");

    // Redirect kembali ke halaman manage_bus.php
    header('Location: manage_bus.php');
    exit();
}

// Menambah bus baru
if (isset($_POST['add_bus'])) {
    $bus_name = $_POST['bus_name'];
    $keberangkatan = $_POST['keberangkatan'];
    $tujuan = $_POST['tujuan'];
    $price = $_POST['price'];
    $available_seats = $_POST['available_seats'];

    $query = "INSERT INTO buses (bus_name, keberangkatan, tujuan, price, available_seats) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssssi", $bus_name, $keberangkatan, $tujuan, $price, $available_seats);
    $stmt->execute();

    header('Location: manage_bus.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Data Bus</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Kelola Data Bus</h2>
    <a href="add_bus.php" class="btn btn-primary mb-3">Tambah Bus Baru</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Bus</th>
                <th>Keberangkatan</th>
                <th>Tujuan</th>
                <th>Harga</th>
                <th>Kursi Tersedia</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $koneksi->query("SELECT * FROM buses");
            while ($bus = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $bus['id']; ?></td>
                    <td><?= $bus['bus_name']; ?></td>
                    <td><?= $bus['keberangkatan']; ?></td>
                    <td><?= $bus['tujuan']; ?></td>
                    <td><?= $bus['price']; ?></td>
                    <td><?= $bus['available_seats']; ?></td>
                    <td>
                        <a href="edit_bus.php?id=<?= $bus['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="manage_bus.php?delete=<?= $bus['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus bus ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
