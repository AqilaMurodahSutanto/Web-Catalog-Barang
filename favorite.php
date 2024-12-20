<?php
session_start();
include 'config.php'; 
include 'navbar.php';

$id_user = $_SESSION['user_id']; // Ambil id_user dari session
$id_barang = isset($_GET['add_to_favorites']) ? $_GET['add_to_favorites'] : null;

$query = "SELECT suka.*, barang.Nama_Barang, barang.Harga, barang.gambar 
          FROM suka 
          JOIN barang ON suka.ID_Barang = barang.ID_Barang 
          WHERE suka.id = '$id_user'";

// Eksekusi query
$result = $conn->query($query);

// Periksa jika ada error pada query
if (!$result) {
    die("Error pada query: " . $conn->error);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>❤️Favorites❤️</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .product-card {
        margin: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .product-img {
        max-height: 150px;
        object-fit: contain;
        background-color: #fff;
    }

    .btn-chat {
        background-color: #F8BB0C;
        color: #fff;
        border-radius: 20px;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn-chat:hover {
        background-color: #F0DB0D;
    }

    .search-form {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="container my-4">
        <h2 class="mb-4">Produk yang Disukai</h2>

        <div class="row">
            <?php if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="col-md-3 col-sm-6">
                <div class="card product-card">
                    <img src="<?= !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; ?>"
                        class="card-img-top product-img" alt="Produk">
                    <div class="card-body text-center">
                        <h6 class="card-title"><?= htmlspecialchars($row['Nama_Barang']); ?></h6>
                        <p class="text-danger mb-1">Rp <?= number_format($row['Harga'], 0, ',', '.'); ?></p>
                        <a href="keranjang.php?add_to_cart=<?= $row['ID_Barang']; ?>" class="btn btn-chat">
                            Masukkan Keranjang
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else : ?>
            <p class="text-center">Anda belum menyukai produk apapun.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>