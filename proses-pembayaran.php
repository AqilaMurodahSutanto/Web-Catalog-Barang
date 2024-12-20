<?php
include 'config.php';
session_start();

// Ambil data dari form pembayaran
$alamat = $_POST['alamat'];
$voucher = $_POST['voucher'];  // Anda bisa menambahkan logika untuk memvalidasi voucher

// Simpan informasi pembayaran ke dalam database atau lakukan proses lainnya
$id_user = $_SESSION['id_user'];  // Pastikan id_user sudah disimpan dalam session

// Misalnya, memasukkan data pembayaran ke tabel transaksi
$query = "INSERT INTO transaksi (id_user, alamat, total, tanggal) 
          VALUES ('$id_user', '$alamat', '$total', NOW())";

if (mysqli_query($conn, $query)) {
    // Hapus data keranjang setelah pembayaran selesai
    $delete_query = "DELETE FROM keranjang WHERE id_user = '$id_user'";
    mysqli_query($conn, $delete_query);

    echo "Pembayaran berhasil! Silakan cek email Anda untuk detail transaksi.";
} else {
    echo "Terjadi kesalahan: " . mysqli_error($conn);
}
?>
