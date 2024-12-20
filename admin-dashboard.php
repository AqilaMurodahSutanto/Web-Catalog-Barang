<?php
session_start();

// Memastikan hanya admin yang dapat mengakses halaman ini
if ($_SESSION['user_role'] != 'admin') {
    header("Location: index.php"); // Arahkan kembali ke halaman utama jika bukan admin
    exit();
}

echo "Selamat datang, Admin!";
?>