<?php
include 'config.php'; // Menyambungkan ke database

// Cek apakah form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $kategori = $_POST['kategori'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    // Cek apakah ada file gambar yang diupload
    $gambar = $_FILES['gambar'];
    $path_gambar = null;

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) { 
        // Jika ada file yang diupload dan tidak ada error
    
        $upload_dir = 'uploads/'; 
        $file_name = basename($_FILES['gambar']['name']);
        $target_file = $upload_dir . $file_name;
    
        // Debug: cek apakah file ada dan tipe file
        // var_dump($_FILES['gambar']);
        
        // Validasi file (opsional: ukuran, tipe file, dll.)
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error = urlencode("Format file tidak valid. Hanya diperbolehkan JPG, JPEG, PNG, atau GIF.");
            header("Location: create.php?error=$error");
            exit();
        }
    
        // Debug: Pastikan file berhasil dipindahkan
        // var_dump($_FILES['gambar']['tmp_name']);
        // var_dump($target_file);
    
        // Pindahkan file ke folder uploads
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $path_gambar = $target_file; // Path gambar yang akan disimpan di database
        } else {
            $error = urlencode("Gagal mengupload gambar. Pastikan folder uploads memiliki izin tulis.");
            header("Location: create.php?error=$error");
            exit();
        }
    } else {
        $path_gambar = ''; // Jika tidak ada file yang diupload, biarkan kolom gambar kosong
    }
    

    // Query untuk memasukkan data ke database
    $sql = "INSERT INTO barang (ID_Kategori, Nama_Barang, Harga, Stok, Satuan, gambar) 
            VALUES ($kategori, '$nama', $harga, $stok, '$satuan', '$path_gambar')";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman utama dengan pesan sukses
        header("Location: create.php?success=true");
        exit();
    } else {
        // Simpan pesan error ke dalam query string
        $error = urlencode("Error: " . $conn->error);
        header("Location: create.php?error=$error");
        exit();
    }

}
?>