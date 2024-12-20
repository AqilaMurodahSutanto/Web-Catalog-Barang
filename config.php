<?php
$host = 'localhost';  // Host
$username = 'thmyid_aqilam';   // Username
$password = 'Tukang_123';       // Password
$dbname = 'thmyid_aqila'; // Nama Database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>