<?php
session_start();
require_once 'koneksi.php'; // Pastikan file ini ada dan terhubung ke database

// Pastikan pengguna sudah login
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    die("Data pengguna tidak valid. Silakan login terlebih dahulu.");
}

// Ambil data pengguna dari session
$user_id = $_SESSION['user']['user_id'];

// Ambil data dari query string (keberangkatan dan tujuan)
$keberangkatan = $_GET['keberangkatan'] ?? '';
$tujuan = $_GET['tujuan'] ?? '';

// Periksa apakah parameter keberangkatan dan tujuan tersedia
if (empty($keberangkatan) || empty($tujuan)) {
    die("Parameter keberangkatan dan tujuan diperlukan.");
}

// Ambil data bus berdasarkan keberangkatan dan tujuan
$query = $koneksi->prepare("SELECT * FROM buses WHERE keberangkatan = ? AND tujuan = ?");
$query->bind_param('ss', $keberangkatan, $tujuan);
$query->execute();
$result = $query->get_result();
$bus = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bus_id = $_POST['bus_id'];
    $tanggal = $_POST['tanggal'];
    $kursi = (int) $_POST['kursi'];

    // Validasi jumlah kursi tersedia
    if ($kursi > $bus['available_seats']) {
        $error = 'Jumlah kursi melebihi ketersediaan.';
    } else {
        // Simpan reservasi ke database
        $stmt = $koneksi->prepare("INSERT INTO reservations (user_id, bus_id, tanggal, kursi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iisi', $user_id, $bus_id, $tanggal, $kursi);

        if ($stmt->execute()) {
            // Kurangi jumlah kursi tersedia
            $updateQuery = $koneksi->prepare("UPDATE buses SET available_seats = available_seats - ? WHERE id = ?");
            $updateQuery->bind_param('ii', $kursi, $bus_id);
            $updateQuery->execute();

            // Redirect ke halaman sukses
            header('Location: notif-succes.php');
            exit;
        } else {
            $error = 'Gagal melakukan reservasi. Coba lagi.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Reservasi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Reservasi Bus</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($bus): ?>
            <form method="POST">
                <input type="hidden" name="bus_id" value="<?= htmlspecialchars($bus['id']); ?>">

                <div class="form-group">
                    <label>Nama Bus</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($bus['bus_name']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Kursi Tersedia</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($bus['available_seats']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Jam Keberangkatan</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($bus['departure_time']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Tanggal Reservasi</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jumlah Kursi</label>
                    <input type="number" name="kursi" class="form-control" required min="1" max="<?= htmlspecialchars($bus['available_seats']); ?>">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Reservasi</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">Bus tidak ditemukan untuk rute ini.</div>
        <?php endif; ?>
    </div>
</body>
</html>
