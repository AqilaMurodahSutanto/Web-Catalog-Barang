<?php
session_start();
include 'config.php'; 
include 'navbar.php';


// Ambil data keranjang berdasarkan id_user
$sql = "SELECT keranjang.ID_Barang, barang.Nama_Barang, barang.Harga, keranjang.Jumlah 
        FROM keranjang 
        JOIN barang ON keranjang.ID_Barang = barang.ID_Barang 
        WHERE keranjang.id_user = '$id_user'";

$result = $conn->query($sql);

if (!$result) {
    die("Error pada query: " . $conn->error);
}

// Menangani perubahan jumlah barang
if (isset($_POST['update_cart'])) {
    foreach ($_POST['jumlah'] as $productId => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity > 0) {
            $updateQuery = "UPDATE keranjang SET Jumlah = '$quantity' WHERE ID_Barang = '$productId' AND id_user = '$id_user'";
            $conn->query($updateQuery);
        } else {
            // Jika jumlahnya 0, hapus produk dari keranjang
            $deleteQuery = "DELETE FROM keranjang WHERE ID_Barang = '$productId' AND id_user = '$id_user'";
            $conn->query($deleteQuery);
        }
    }
    header('Location: cart.php'); // Redirect setelah update
    exit;
}

// Menangani penghapusan produk
if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    $deleteQuery = "DELETE FROM keranjang WHERE ID_Barang = '$productId' AND id_user = '$id_user'";
    $conn->query($deleteQuery);
    header('Location: cart.php'); // Redirect setelah penghapusan
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-4">
        <h2 class="mb-4">Keranjang Belanja</h2>
        <?php if ($result->num_rows > 0): ?>
        <form method="POST">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    while ($row = $result->fetch_assoc()):
                        $subtotal = $row['Harga'] * $row['Jumlah'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Nama_Barang']); ?></td>
                        <td>Rp <?= number_format($row['Harga'], 0, ',', '.'); ?></td>
                        <td>
                            <input type="number" name="jumlah[<?= $row['ID_Barang']; ?>]" class="form-control"
                                value="<?= $row['Jumlah']; ?>" min="1">
                        </td>
                        <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $row['ID_Barang']; ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="text-end">
                <h4>Total: Rp <?= number_format($total, 0, ',', '.'); ?></h4>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="update_cart" class="btn btn-warning">Perbarui Keranjang</button>
                <a href="checkout.php" class="btn btn-success">Checkout</a>
            </div>
        </form>
        <?php else: ?>
        <p class="text-center">Keranjang Anda kosong.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>