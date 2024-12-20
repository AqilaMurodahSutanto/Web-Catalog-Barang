<?php
include 'config.php'; // Menyambungkan ke database

// Cek apakah form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];

    
    // Query untuk memasukkan data ke database
    $sql = "INSERT INTO users (email, password, nama) 
            VALUES ('$email', '$password', '$nama')";

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman utama dengan pesan sukses
        header("Location: create_user.php?success=true");
        exit();
    } else {
        // Simpan pesan error ke dalam query string
        $error = urlencode("Error: " . $conn->error);
        header("Location: create_user.php?error=$error");
        exit();
    }

}
?>