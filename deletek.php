<?php
include 'config.php'; // Sambungkan ke database

// Pastikan ID_Barang diterima melalui GET
if (!isset($_GET['ID_Kategori'])) {
    die("ID Kategori tidak ditemukan.");
}

$id_kategori = $_GET['ID_Kategori'];

// Query untuk menghapus data barang berdasarkan ID_Barang
$sql = "DELETE FROM KategoriWHERE ID_Kategori = $id_kategori";

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    // Redirect ke halaman utama setelah berhasil menghapus
    header("Location: kategori.php?success=true");
    exit();
} else {
    // Simpan pesan error ke dalam query string
    $error = urlencode("Error: " . $conn->error);
    header("Location: kategori.php?error=$error");
    exit();
}

// Tutup koneksi database
$conn->close();