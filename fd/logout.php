<?php
session_start();
session_destroy(); // Menghapus semua data sesi
header('Location: index.php'); // Redirect ke halaman login
exit;
?>
