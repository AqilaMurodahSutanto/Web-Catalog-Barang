<?php
include 'config.php'; // Menyambungkan ke database

// Cek apakah form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];

    // Query untuk memasukkan data ke database
    $sql = "INSERT INTO Kategori (Nama_Kategori) 
            VALUES ('$nama')";
         // Eksekusi query
         if ($conn->query($sql) === TRUE) {
            // Redirect ke halaman utama dengan parameter success
            header("Location: createk.php?success=true");
            exit();
        } else {
            // Simpan pesan error ke dalam query string
            $error = urlencode("Error: " . $conn->error);
            header("Location: createk.php?error=$error");
            exit();
        }
    
    }
    ?>