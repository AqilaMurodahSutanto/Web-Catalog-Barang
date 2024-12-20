<?php
session_start();
include 'config.php'; 

// Periksa apakah parameter 'add_to_favorites' dan sesi user ID tersedia
if (isset($_GET['add_to_favorites']) && isset($_SESSION['user_id'])) {
    $productId = $_GET['add_to_favorites'];
    $id_user = $_SESSION['user_id'];

    // Query untuk menambahkan data ke tabel suka
    $insertQuery = "INSERT INTO suka (ID_Barang, id) VALUES ('$productId', '$id_user')";
    echo "ID Barang: $productId<br>";
    echo "ID User: $id_user<br>";
    echo $insertQuery;

    if ($conn->query($insertQuery)) {
        // Berhasil menambahkan ke tabel suka
        header('Location: product.php'); 
        exit;
    } else {
        // Gagal menjalankan query
        die("Error saat menambahkan produk ke favorit: " . $conn->error);
    }
} 


// session_start();
// include 'config.php';

// if ($conn->connect_error) {
//     die("Koneksi database gagal: " . $conn->connect_error);
// }
// echo "Koneksi database berhasil.";
// if (isset($_GET['add_to_favorite'])) {
//     $productId = $_GET['add_to_favorite'];
//     $id_user = $_SESSION['id_user'];

//     // Debugging: Tampilkan nilai yang diterima
//     echo "ID Barang: $productId<br>";
//     echo "ID User: $id_user<br>";
//     exit; // Hentikan eksekusi untuk melihat output
//}

?>