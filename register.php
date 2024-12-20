<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Cek apakah email sudah terdaftar
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        $error = "Email sudah terdaftar.";
    } else {
        // Masukkan data pengguna ke database
        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php?register_success=true");
            exit();
        } else {
            $error = "Gagal mendaftar: " . $conn->error;
        }
    }
}
?>
