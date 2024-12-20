<?php

session_start();
include 'config.php';  // Pastikan koneksi database sudah disertakan

// Periksa apakah parameter 'add_to_cart' dan sesi user ID tersedia
if (isset($_GET['add_to_cart']) && isset($_SESSION['user_id'])) {
    $productId = $_GET['add_to_cart'];  // Ambil ID Barang dari URL
    $id_user = $_SESSION['user_id'];  // Ambil ID User dari sesi
    $jumlah = isset($_GET['jumlah']) ? $_GET['jumlah'] : 1;  // Ambil jumlah produk yang akan ditambahkan ke keranjang (default 1)

    // Query untuk menambahkan data ke tabel keranjang
    $insertQuery = "INSERT INTO keranjang (id_user, ID_Barang, Jumlah, Subtotal, Tanggal_Ditambahkan) 
                    VALUES ('$id_user', '$productId', '$jumlah', (SELECT Harga FROM barang WHERE ID_Barang = '$productId') * '$jumlah', NOW())";

    // Debugging: Tampilkan query yang akan dijalankan
    echo "Query yang dijalankan: $insertQuery<br>";

    // Jalankan query untuk memasukkan data ke tabel keranjang
    if ($conn->query($insertQuery)) {
        // Berhasil menambahkan ke tabel keranjang
        echo "Produk berhasil ditambahkan ke keranjang.<br>";
        header('Location: product.php');  // Arahkan ke halaman keranjang setelah berhasil
        exit;
    } else {
        // Gagal menjalankan query
        die("Error saat menambahkan produk ke keranjang: " . $conn->error);
    }
} else {
    // Jika parameter atau sesi tidak tersedia
    echo "Parameter atau sesi tidak valid.";
}
?>

?>