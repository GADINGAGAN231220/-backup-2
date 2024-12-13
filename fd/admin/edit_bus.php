<?php
session_start();
// Pastikan pengguna adalah admin
// if ($_SESSION['role'] != 'admin') {
//     header('Location: ../index.php');
//     exit;
// }
include '../koneksi.php';

// Periksa apakah parameter ID disediakan
if (!isset($_GET['id'])) {
    header('Location: manage_bus.php');
    exit;
}

$id = $_GET['id'];

// Ambil data bus berdasarkan ID
$query = "SELECT * FROM buses WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$bus = $result->fetch_assoc();

if (!$bus) {
    echo "Data bus tidak ditemukan.";
    exit;
}

// Proses update data bus
if (isset($_POST['update_bus'])) {
    $bus_name = $_POST['bus_name'];
    $keberangkatan = $_POST['keberangkatan'];
    $tujuan = $_POST['tujuan'];
    $price = $_POST['price'];
    $available_seats = $_POST['available_seats'];

    $query = "UPDATE buses SET bus_name = ?, keberangkatan = ?, tujuan = ?, price = ?, available_seats = ? WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssiii", $bus_name, $keberangkatan, $tujuan, $price, $available_seats, $id);

    if ($stmt->execute()) {
        header('Location: manage_bus.php');
        exit;
    } else {
        echo "Terjadi kesalahan saat mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Bus</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Data Bus</h2>
    <form method="POST">
        <div class="form-group">
            <label for="bus_name">Nama Bus</label>
            <input type="text" name="bus_name" id="bus_name" class="form-control" value="<?= htmlspecialchars($bus['bus_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="keberangkatan">Keberangkatan</label>
            <input type="text" name="keberangkatan" id="keberangkatan" class="form-control" value="<?= htmlspecialchars($bus['keberangkatan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="tujuan">Tujuan</label>
            <input type="text" name="tujuan" id="tujuan" class="form-control" value="<?= htmlspecialchars($bus['tujuan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" name="price" id="price" class="form-control" value="<?= htmlspecialchars($bus['price']); ?>" required>
        </div>
        <div class="form-group">
            <label for="available_seats">Kursi Tersedia</label>
            <input type="number" name="available_seats" id="available_seats" class="form-control" value="<?= htmlspecialchars($bus['available_seats']); ?>" required>
        </div>
        <button type="submit" name="update_bus" class="btn btn-primary">Update</button>
        <a href="manage_bus.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
