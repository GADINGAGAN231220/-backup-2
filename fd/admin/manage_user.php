<?php
session_start();
// if ($_SESSION['role'] != 'admin') {
//     header('Location: ../index.php');
//     exit;
// }
include '../koneksi.php';

// Menghapus pengguna jika ada parameter delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $koneksi->query("DELETE FROM users WHERE id=$id");
    header('Location: manage_user.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Data Pengguna</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Kelola Data Pengguna</h2>
    <a href="add_user.php" class="btn btn-primary mb-3">Tambah Pengguna Baru</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $koneksi->query("SELECT * FROM users");
            while ($user = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['role']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="manage_user.php?delete=<?= $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pengguna ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
