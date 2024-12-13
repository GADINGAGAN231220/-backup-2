<?php
session_start();

// Pastikan pengguna telah login
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Contoh: Ambil data user untuk pembayaran (jika diperlukan)
$user_id = $_SESSION['user']['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .payment-card {
            margin: 50px auto;
            max-width: 600px;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .form-control {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-card">
            <h2 class="text-center mb-4">Form Pembayaran</h2>
            <form action="proses_pembayaran.php" method="POST">
                <div class="form-group">
                    <label for="metode">Metode Pembayaran:</label>
                    <select name="metode" id="metode" class="form-control">
                        <option value="transfer">Transfer Bank</option>
                        <option value="kartu_kredit">Kartu Kredit</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Bayar Sekarang</button>
            </form>
            <div class="text-center mt-4">
                <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
