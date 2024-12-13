<?php
session_start();
// if ($_SESSION['role'] != 'admin') {
//     header('Location: ../index.php');
//     exit;
// }
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $koneksi->query("INSERT INTO users (email, password, role) VALUES ('$email', '$password', '$role')");
    header('Location: manage_user.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Data Pengguna</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Tambah Data Pengguna</h2>
    <form method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
        <a href="manage_user.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
