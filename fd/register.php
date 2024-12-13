<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi database tersambung

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validasi input
    if (!empty($nama) && !empty($email) && !empty($password)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Format email tidak valid.');</script>";
        } else {
            // Cek apakah email sudah terdaftar
            $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('Email sudah terdaftar. Silakan gunakan email lain.');</script>";
            } else {
                // Hash password menggunakan password_hash
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Simpan data pengguna baru ke database
                $stmt = $koneksi->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'user')");
                $stmt->bind_param("sss", $nama, $email, $hashed_password);

                if ($stmt->execute()) {
                    echo "<script>alert('Registrasi berhasil. Silakan login.'); window.location.href='index.php';</script>";
                } else {
                    echo "<script>alert('Registrasi gagal: " . $koneksi->error . "');</script>";
                }

                $stmt->close();
            }
        }
    } else {
        echo "<script>alert('Harap isi semua kolom.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <title>Registrasi</title>
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Registrasi</h2>
        <form method="POST" class="mt-3">
            <div class="form-group">
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-success btn-block">Registrasi</button>
        </form>
        <p class="text-center mt-3">Sudah punya akun? <a href="index.php">Login di sini</a></p>
    </div>
</body>
</html>
