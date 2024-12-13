<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi.php ada dan benar

// Periksa koneksi ke database
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil semua data bus dari database
$query = "SELECT * FROM buses";
$result = $koneksi->query($query);

// Periksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . $koneksi->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .table {
            background: #ffffff;
            border-radius: 5px;
            overflow: hidden;
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="dashboard-header">
            <h1>Selamat Datang di Dashboard</h1>
            <p>Berikut adalah daftar bus yang tersedia untuk reservasi.</p>
        </div>

        <!-- Tabel Daftar Bus -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Bus</th>
                        <th>Keberangkatan</th>
                        <th>Tujuan</th>
                        <th>Harga</th>
                        <th>Kursi Tersedia</th>
                        <th>Jam Keberangkatan</th>
                        <th>Foto Bus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['bus_name'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($row['keberangkatan'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($row['tujuan'] ?? ''); ?></td>
                                <td><?= number_format($row['price'] ?? 0); ?> IDR</td>
                                <td><?= htmlspecialchars($row['available_seats'] ?? '0'); ?></td>
                                <td><?= htmlspecialchars($row['departure_time'] ?? ''); ?></td>
                                <td>
                                    <?php if (!empty($row['foto_bus'])): ?>
                                        <img src="<?= htmlspecialchars($row['foto_bus']); ?>" alt="Foto Bus" style="width:100px; height:auto;">
                                    <?php else: ?>
                                        Tidak ada foto
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="reservasi.php?keberangkatan=<?= urlencode($row['keberangkatan'] ?? ''); ?>&tujuan=<?= urlencode($row['tujuan'] ?? ''); ?>" class="btn btn-primary btn-sm">
                                        Reservasi
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data bus tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
