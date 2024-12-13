<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi.php ada dan benar

// Periksa koneksi ke database
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari form pencarian
$keberangkatan = isset($_GET['keberangkatan']) ? $_GET['keberangkatan'] : '';
$tujuan = isset($_GET['tujuan']) ? $_GET['tujuan'] : '';
$tanggal_keberangkatan = isset($_GET['tanggal_keberangkatan']) ? $_GET['tanggal_keberangkatan'] : '';
$penumpang = isset($_GET['penumpang']) ? intval($_GET['penumpang']) : 1;

// Query untuk mencari data bus yang sesuai
$query = "SELECT * FROM buses 
          WHERE keberangkatan = ? AND tujuan = ? AND DATE(departure_date) = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("sss", $keberangkatan, $tujuan, $tanggal_keberangkatan);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .results-container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-reservasi {
            background-color: #28a745;
            color: #fff;
        }
        .btn-reservasi:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container results-container">
        <h3 class="text-center">Hasil Pencarian</h3>
        <p class="text-center">Keberangkatan: <strong><?= htmlspecialchars($keberangkatan); ?></strong>, Tujuan: <strong><?= htmlspecialchars($tujuan); ?></strong>, Tanggal: <strong><?= htmlspecialchars($tanggal_keberangkatan); ?></strong>, Penumpang: <strong><?= $penumpang; ?> Orang</strong></p>

        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= htmlspecialchars($row['foto_bus']); ?>" class="card-img-top" alt="Foto Bus" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['bus_name']); ?></h5>
                                <p class="card-text">
                                    Keberangkatan: <?= htmlspecialchars($row['keberangkatan']); ?><br>
                                    Tujuan: <?= htmlspecialchars($row['tujuan']); ?><br>
                                    Jam: <?= htmlspecialchars($row['departure_time']); ?><br>
                                    Harga: <?= number_format($row['price']); ?> IDR<br>
                                    Kursi Tersedia: <?= htmlspecialchars($row['available_seats']); ?>
                                </p>
                                <?php if ($row['available_seats'] >= $penumpang): ?>
                                    <a href="reservasi.php?bus_id=<?= $row['id']; ?>&penumpang=<?= $penumpang; ?>" class="btn btn-reservasi btn-block">Reservasi</a>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-block" disabled>Kursi Tidak Cukup</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                Tidak ada bus yang sesuai dengan kriteria pencarian Anda.
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
