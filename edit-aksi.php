<?php
include 'config.php'; // Sambungkan ke database

// Pastikan data form diterima melalui POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_barang = $_POST['id_barang'];
    $kategori = $_POST['kategori'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    // Cek apakah ada file gambar yang diupload
    $gambar = $_FILES['gambar'];
    $path_gambar = null;

    if ($gambar['error'] == 0) { // Jika ada file yang diupload
        $upload_dir = 'uploads/';
        $file_name = basename($gambar['name']);
        $target_file = $upload_dir . $file_name;

        // Validasi file (opsional: ukuran, tipe file, dll.)
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error = urlencode("Format file tidak valid. Hanya diperbolehkan JPG, JPEG, PNG, atau GIF.");
            header("Location: edit.php?id_barang=$id_barang&error=$error");
            exit();
        }

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($gambar['tmp_name'], $target_file)) {
            $path_gambar = $target_file; // Path gambar yang akan disimpan di database
        } else {
            $error = urlencode("Gagal mengupload gambar.");
            header("Location: edit.php?id_barang=$id_barang&error=$error");
            exit();
        }
    }

    // Query untuk update data barang
    $sql = "UPDATE barang SET 
            ID_Kategori = $kategori, 
            Nama_Barang = '$nama', 
            Harga = $harga, 
            Stok = $stok, 
            Satuan = '$satuan'";
    
    // Tambahkan update gambar jika ada file gambar
    if ($path_gambar) {
        $sql .= ", gambar = '$path_gambar'";
    }
    
    $sql .= " WHERE ID_Barang = $id_barang";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman edit dengan pesan sukses
        header("Location: edit.php?id_barang=$id_barang&success=true");
        exit();
    } else {
        // Simpan pesan error ke dalam query string
        $error = urlencode("Error: " . $conn->error);
        header("Location: edit.php?id_barang=$id_barang&error=$error");
        exit();
    }


}
?>