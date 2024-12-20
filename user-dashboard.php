<?php
session_start();

// Memastikan hanya user yang dapat mengakses halaman ini
if ($_SESSION['user_role'] != 'user') {
    header("Location: index.php"); // Arahkan kembali ke halaman utama jika bukan user
    exit();
}

echo "Selamat datang, User!";
?>