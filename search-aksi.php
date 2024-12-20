<?php
include 'config.php'; // Menghubungkan ke database

// Tangkap kata kunci pencarian jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Query untuk mengambil data dari tabel 'barang' dengan filter pencarian
$sql = "SELECT * FROM barang";
$whereClauses = [];

if (!empty($search)) {
    $whereClauses[] = "Nama_Barang LIKE '%$search%'";
}

if (!empty($category)) {
    $whereClauses[] = "ID_Kategori = '$category'";
}

if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

$result = $conn->query($sql);

// Mengecek apakah query berhasil dijalankan
if (!$result) {
    die("Error pada query: " . $conn->error);
}
?>