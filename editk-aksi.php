<?php
include 'config.php'; // Sambungkan ke database

// Pastikan data form diterima melalui POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $ID_Kategori = $_POST['ID_Kategori'];
    $nama = $_POST['nama'];

    // Query untuk update data barang
    $sql = "UPDATE Kategori SET  
            Nama_Kategori = '$nama'
            WHERE ID_Kategori = $ID_Kategori";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman edit dengan pesan sukses
        header("Location: editk.php?id_barang=$id_barang&success=true");
        exit();
    } else {
        // Simpan pesan error ke dalam query string
        $error = urlencode("Error: " . $conn->error);
        header("Location: editk.php?id_barang=$id_barang&error=$error");
        exit();
    }

    // Tutup koneksi database
    $conn->close();
}