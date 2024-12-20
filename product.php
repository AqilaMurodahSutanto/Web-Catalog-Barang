<?php
session_start();
include 'config.php'; 
include 'navbar.php';

$id_user = $_SESSION['id_user']; // Ambil id_user dari session

// Mengecek apakah ada parameter 'search' dan 'filter'
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

// Ambil daftar kategori untuk dropdown
$kategoriResult = $conn->query("SELECT * FROM Kategori");
if (!$kategoriResult) {
    die("Error mengambil data kategori: " . $conn->error);
}

// Query untuk mengambil data barang berdasarkan filter pencarian
if (!empty($search)) {
    switch ($filter) {
        case 'kategori':
            $sql = "SELECT barang.* 
                    FROM barang 
                    JOIN Kategori ON barang.ID_Kategori = Kategori.ID_Kategori 
                    WHERE Kategori.Nama_Kategori LIKE '%$search%'";
            break;
        case 'harga':
            if (strpos($search, '>') !== false || strpos($search, '<') !== false) {
                $sql = "SELECT * 
                        FROM barang 
                        WHERE Harga $search";
            } else {
                $sql = "SELECT * FROM barang WHERE Harga = '$search'";
            }
            break;
        case 'stok':
            if (strpos($search, '>') !== false || strpos($search, '<') !== false) {
                $sql = "SELECT * 
                        FROM barang 
                        WHERE Stok $search";
            } else {
                $sql = "SELECT * 
                        FROM barang 
                        WHERE Stok = '$search'";
            }
            break;
        case 'satuan':
            $sql = "SELECT * FROM barang WHERE Satuan LIKE '%$search%'";
            break;
        default:
            $sql = "SELECT * FROM barang WHERE Nama_Barang LIKE '%$search%'";
    }
} else {
    $sql = "SELECT * FROM barang"; 
}

$result = $conn->query($sql);

// Mengecek apakah query berhasil dijalankan
if (!$result) {
    die("Error pada query: " . $conn->error);
}

// Menangani penambahan produk ke keranjang
if (isset($_GET['add_to_cart'])) {
    $productId = $_GET['add_to_cart'];
    $quantity = 1; // default jumlah 1
    $id_user = $_SESSION['id_user']; // Ambil id_user dari session

    // Cek jika produk sudah ada di keranjang
    $checkQuery = "SELECT * FROM keranjang WHERE ID_Barang = '$productId' AND id_user = '$id_user'"; // Ganti 'id' menjadi 'id_user'
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Jika produk sudah ada di keranjang, update jumlahnya
        $updateQuery = "UPDATE keranjang SET Jumlah = Jumlah + 1 WHERE ID_Barang = '$productId' AND id_user = '$id_user'"; // Ganti 'id' menjadi 'id_user'
        $conn->query($updateQuery);
    } else {
        // Jika produk belum ada, tambahkan ke keranjang
        $insertQuery = "INSERT INTO keranjang (ID_Barang, id_user, Jumlah) VALUES ('$productId', '$id_user', 1)"; // Ganti 'id' menjadi 'id_user'
        $conn->query($insertQuery);
    }

    header('Location: product.php'); // Mengarahkan kembali ke halaman keranjang
    exit;
}

// Menangani penambahan produk ke daftar favorit
if (isset($_GET['add_to_favorites'])) {
    $productId = $_GET['add_to_favorites'];
    $id_user = $_SESSION['id_user']; // Ambil id_user dari session

    // Cek jika produk sudah ada di daftar suka
    $checkQuery = "SELECT * FROM suka WHERE ID_Barang = '$productId' AND id = '$id_user'"; // Menggunakan 'id' sesuai dengan tabel 'suka'
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows == 0) {
        // Jika produk belum ada di daftar suka, tambahkan ke daftar suka
        $insertQuery = "INSERT INTO suka (ID_Barang, id) VALUES ('$productId', '$id_user')"; // Menggunakan 'id' sesuai dengan tabel 'suka'
        $conn->query($insertQuery);
    }

    header('Location: product.php'); // Mengarahkan kembali ke halaman favorit
    exit;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalog Product</title>
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

    .btn-like {
        background-color: #FF6F61;
        color: #fff;
        border-radius: 20px;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn-like:hover {
        background-color: #FF3C2B;
    }

    .search-form {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="container my-4">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <form class="search-form row g-3" method="GET">
                    <div class="col-md-4">
                        <select name="filter" class="form-select">
                            <option value="">Filter Berdasarkan</option>
                            <option value="kategori" <?= $filter == 'kategori' ? 'selected' : ''; ?>>Kategori</option>
                            <option value="harga" <?= $filter == 'harga' ? 'selected' : ''; ?>>Harga</option>
                            <option value="stok" <?= $filter == 'stok' ? 'selected' : ''; ?>>Stok</option>
                            <option value="satuan" <?= $filter == 'satuan' ? 'selected' : ''; ?>>Satuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                            value="<?= htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <img src="uploads/logo.png" alt="catalogkita" height="80">
            </div>
        </div>

        <div class="row">
            <?php if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="col-md-3 col-sm-6">
                <div class="card product-card">
                    <img src="<?= !empty($row['gambar']) ? $row['gambar'] : 'default.jpg'; ?>"
                        class="card-img-top product-img" alt="Produk">
                    <div class="card-body text-center">
                        <h6 class="card-title"> <?= htmlspecialchars($row['Nama_Barang']); ?> </h6>
                        <p class="text-danger mb-1"> Rp <?= number_format($row['Harga'], 0, ',', '.'); ?> </p>
                        <p class="text-muted mb-2">Stok: <?= $row['Stok']; ?> </p>
                        <a href="keranjang-aksi.php?add_to_cart=<?= $row['ID_Barang']; ?>" class="btn btn-chat">
                            Masukkan Keranjang
                        </a>
                        <a href="favorite-aksi.php?add_to_favorites=<?= $row['ID_Barang']; ?>" class="btn btn-like">
                            Tambah ke Favorit
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else : ?>
            <p class="text-center">Tidak ada data yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>