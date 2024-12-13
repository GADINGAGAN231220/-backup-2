<?php
session_start();
include '../koneksi.php'; // Pastikan file koneksi.php sudah ada

// Proses penambahan bus jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bus_name = $_POST['bus_name'];
    $keberangkatan = $_POST['keberangkatan'];
    $tujuan = $_POST['tujuan'];
    $price = $_POST['price'];
    $available_seats = $_POST['available_seats'];
    $departure_time = $_POST['departure_time'];
    
    // Proses upload gambar
    $foto_bus = '';
    if (isset($_FILES['foto_bus']) && $_FILES['foto_bus']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/'; // Path relatif ke folder "uploads"
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Membuat folder jika belum ada
        }
        $foto_bus_name = time() . '_' . basename($_FILES['foto_bus']['name']); // Nama file unik
        $foto_bus_path = $upload_dir . $foto_bus_name;
        
        if (move_uploaded_file($_FILES['foto_bus']['tmp_name'], $foto_bus_path)) {
            $foto_bus = 'uploads/' . $foto_bus_name; // Simpan path relatif ke database
        }
    }

    // Simpan data ke database
    $stmt = $koneksi->prepare("INSERT INTO buses (bus_name, keberangkatan, tujuan, price, available_seats, departure_time, foto_bus) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssdis', $bus_name, $keberangkatan, $tujuan, $price, $available_seats, $departure_time, $foto_bus);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data bus berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Bus</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center">Tambah Bus</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="bus_name">Nama Bus</label>
                    <input type="text" class="form-control" id="bus_name" name="bus_name" required>
                </div>
                <div class="form-group">
                    <label for="keberangkatan">Keberangkatan</label>
                    <input type="text" class="form-control" id="keberangkatan" name="keberangkatan" required>
                </div>
                <div class="form-group">
                    <label for="tujuan">Tujuan</label>
                    <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                </div>
                <div class="form-group">
                    <label for="price">Harga (IDR)</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="available_seats">Kursi Tersedia</label>
                    <input type="number" class="form-control" id="available_seats" name="available_seats" required>
                </div>
                <div class="form-group">
                    <label for="departure_time">Jam Keberangkatan</label>
                    <input type="time" class="form-control" id="departure_time" name="departure_time" required>
                </div>
                <div class="form-group">
                    <label for="foto_bus">Foto Bus</label>
                    <input type="file" class="form-control" id="foto_bus" name="foto_bus" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Tambah Bus</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
