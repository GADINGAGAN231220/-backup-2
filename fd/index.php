<?php
session_start();
require_once 'koneksi.php'; // Pastikan file ini terhubung ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validasi input
    if (!empty($email) && !empty($password)) {
        // Cek apakah email yang dimasukkan adalah untuk admin
        if ($email === 'admin' && $password === 'admin') {
            // Set session untuk admin
            $_SESSION['user'] = [
                'email' => 'admin',
                'nama' => 'Admin',
                'role' => 'admin'
            ];
            header('Location: admin/dashboard_admin.php'); // Halaman dashboard admin
            exit();
        } else {
            // Jika bukan admin, cek apakah email valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = "Format email tidak valid.";
            } else {
                // Menggunakan prepared statement untuk mencegah SQL Injection
                $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();

                    // Verifikasi password
                    if (password_verify($password, $user['password'])) {
                        // Login berhasil, simpan data pengguna di session
                        $_SESSION['user'] = [
                            'user_id' => $user['id'],  // Menyimpan user_id
                            'email' => $user['email'],
                            'nama' => $user['nama'],
                            'role' => $user['role']
                        ];
                        header('Location: dashboard.php'); // Halaman dashboard pengguna biasa
                        exit();
                    } else {
                        $error_message = "Login gagal. Password Anda salah.";
                    }
                } else {
                    $error_message = "Login gagal. Email tidak ditemukan.";
                }

                $stmt->close();
            }
        }
    } else {
        $error_message = "Harap isi email dan password.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($error_message)) {
                            echo "<div class='alert alert-danger'>$error_message</div>";
                        }
                        ?>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Masukkan email atau admin" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                        <p class="text-center mt-3">
                            Belum punya akun? <a href="register.php" class="text-primary">Registrasi di sini</a>
                        </p>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-outline-secondary btn-sm">Lupa Password?</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
