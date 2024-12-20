<?php
include 'config.php'; // Sambungkan ke database

// Pastikan ID_Barang diterima melalui GET
if (!isset($_GET['id_barang'])) {
    die("ID Barang tidak ditemukan.");
}

$id_barang = $_GET['id_barang'];

// Query untuk menghapus data barang berdasarkan ID_Barang
$sql = "DELETE FROM barang WHERE ID_Barang = $id_barang";

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    // Redirect ke halaman utama setelah berhasil menghapus
    header("Location: produk.php?success=true");
    exit();
} else {
    // Simpan pesan error ke dalam query string
    $error = urlencode("Error: " . $conn->error);
    header("Location: produk.php?error=$error");
    exit();
}