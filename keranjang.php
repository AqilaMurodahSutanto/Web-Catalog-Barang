<?php
session_start();
include 'config.php';
include 'navbar.php';

// Ambil data keranjang belanja berdasarkan user_id
$id_user = $_SESSION['user_id']; // Pastikan sesi sudah aktif dan valid

// Query untuk mendapatkan keranjang beserta harga produk menggunakan subquery
$query = "
    SELECT 
        k.ID_Keranjang, 
        k.ID_Barang, 
        k.Jumlah, 
        k.Subtotal, 
        b.Nama_Barang, 
        b.Gambar, 
        (SELECT Harga FROM barang WHERE ID_Barang = k.ID_Barang) AS Harga
    FROM keranjang k
    JOIN barang b ON k.ID_Barang = b.ID_Barang
    WHERE k.id_user = '$id_user'
";
$result = $conn->query($query);

// Hitung total subtotal
$total = 0;
$shipping = 10000; // Misalnya biaya pengiriman tetap

// Proses jika tombol update jumlah atau hapus ditekan
if (isset($_POST['update_quantity'])) {
    $id_keranjang = $_POST['id_keranjang'];
    $new_quantity = $_POST['quantity'];
    // Update jumlah produk di keranjang
    $updateQuery = "UPDATE keranjang SET Jumlah = '$new_quantity' WHERE ID_Keranjang = '$id_keranjang'";
    if ($conn->query($updateQuery)) {
        // Jika berhasil, redirect ke halaman keranjang
        header("Location: keranjang.php");
        exit;
    } else {
        die("Error: " . $conn->error);
    }
}

if (isset($_GET['remove_product'])) {
    $id_keranjang = $_GET['remove_product'];
    // Hapus produk dari keranjang
    $deleteQuery = "DELETE FROM keranjang WHERE ID_Keranjang = '$id_keranjang'";
    if ($conn->query($deleteQuery)) {
        // Jika berhasil, redirect ke halaman keranjang
        header("Location: keranjang.php");
        exit;
    } else {
        die("Error: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #fef3f7;
    }

    .total-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .btn-custom {
        background-color: #f25487;
        color: white;
    }

    .product-img {
        max-height: 100px;
        object-fit: contain;
        background-color: #fff;
    }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <!-- Keranjang Belanja -->
            <div class="col-md-8">
                <h3 class="fw-bold mb-4">Keranjang Belanja</h3>
                <table class="table table-borderless align-middle">
                    <thead class="text-secondary">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Diskon</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= $row['Gambar']; ?>" alt="<?= $row['Nama_Barang']; ?>"
                                        class="rounded me-3" width="50">
                                    <div>
                                        <strong><?= $row['Nama_Barang']; ?></strong><br>
                                    </div>
                                </div>
                            </td>
                            <td>Rp <?= number_format($row['Harga'], 0, ',', '.'); ?></td>
                            <td>
                                <!-- Form untuk update jumlah -->
                                <form action="keranjang.php" method="POST" class="d-inline">
                                    <input type="number" name="quantity" value="<?= $row['Jumlah']; ?>" min="1"
                                        class="form-control" style="width: 80px; display: inline-block;">
                                    <input type="hidden" name="id_keranjang" value="<?= $row['ID_Keranjang']; ?>">
                                    <button type="submit" name="update_quantity"
                                        class="btn btn-sm btn-info">Update</button>
                                </form>
                            </td>
                            <td>0%</td>
                            <td>Rp <?= number_format($row['Subtotal'], 0, ',', '.'); ?></td>
                            <td>
                                <!-- Link untuk menghapus produk -->
                                <a href="keranjang.php?remove_product=<?= $row['ID_Keranjang']; ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
                                    $total += $row['Subtotal']; // Menambahkan subtotal ke total
                                ?>
                        <?php endwhile; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Keranjang Anda kosong.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Subtotal -->
                <div class="d-flex justify-content-between total-section mt-4">
                    <div>
                        <p class="mb-1">Subtotal Untuk Produk:</p>
                        <p class="mb-1">Subtotal Pengiriman:</p>
                    </div>
                    <div>
                        <p class="mb-1 fw-bold">Rp <?php echo number_format($total, 0, ',', '.'); ?></p>
                        <p class="mb-1 fw-bold">Rp <?php echo number_format($shipping, 0, ',', '.'); ?></p>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <h4 class="fw-bold">Total Pembayaran: <span class="text-danger">Rp
                            <?php echo number_format($total + $shipping, 0, ',', '.'); ?></span></h4>
                </div>
            </div>

            <!-- Info Pembayaran -->
            <div class="col-md-4">
                <h4 class="fw-bold mb-4">Info Pembayaran</h4>
                <form action="proses-pembayaran.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman</label>
                        <input type="text" class="form-control" placeholder="Masukkan Alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Voucher Belanja</label>
                        <input type="text" class="form-control" placeholder="Masukkan Kode" name="voucher">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom btn-lg">Buat Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>