<?php
include 'config.php'; // Menghubungkan ke database
session_start(); // Memulai session

// Cek jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data pengguna berdasarkan email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql); // Gunakan prepared statement untuk keamanan
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    echo $sql;
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Debugging - Cek apakah password sesuai dengan hash yang ada di database
        var_dump($user['password']); // Tampilkan hash password yang disimpan di database
        var_dump($password); // Tampilkan password yang dimasukkan oleh pengguna

        // Verifikasi password
        //if (password_verify($password, $user['password'])) {
            if($password == $user['password']){
                // Simpan data user di session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['nama'];  // Menyimpan nama pengguna ke session
            
                // Redirect ke halaman index.php
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Password salah.";
            header("Location: login.php"); // Redirect kembali ke halaman login
            exit();
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
        header("Location: login.php"); // Redirect kembali ke halaman login
        exit();
    }
