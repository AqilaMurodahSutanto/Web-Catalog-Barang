<?php
include 'config.php'; // Sambungkan ke database

// Pastikan ID_Barang diterima melalui GET
if (!isset($_GET['id_barang'])) {
    die("ID Barang tidak ditemukan.");
}

$id_barang = $_GET['id_barang'];

// Query untuk mengambil data barang berdasarkan ID_Barang
$query = "SELECT * FROM barang WHERE ID_Barang = $id_barang";
$result = $conn->query($query);

// Cek apakah data ditemukan
if ($result->num_rows == 0) {
    die("Barang tidak ditemukan.");
}

$barang = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #e7fbff;
    }

    .card {
        background-color: #b4ebec;
        border: 1px solid #9fd7fe;
    }

    h2 {
        color: #7da7fc;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Data Barang</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="edit-aksi.php" method="POST">
                            <!-- ID_Barang diinput sebagai hidden field -->
                            <input type="hidden" name="id_barang" value="<?php echo $barang['ID_Barang']; ?>">

                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <input class="form-control" list="datalistOptions" id="kategori" name="kategori"
                                    required value="<?php echo $barang['ID_Kategori']; ?>">
                                <datalist id="datalistOptions">
                                    <option value="1">Buku</option>
                                    <option value="2">Pakaian</option>
                                    <option value="3">Makanan</option>
                                    <option value="4">Minuman</option>
                                    <option value="5">Peralatan Rumah Tangga</option>
                                    <option value="6">Alat Tulis</option>
                                    <option value="7">Kecantikan</option>
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama" name="nama" required
                                    value="<?php echo $barang['Nama_Barang']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" required
                                    value="<?php echo $barang['Harga']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" required
                                    value="<?php echo $barang['Stok']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" required
                                    value="<?php echo $barang['Satuan']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Upload Gambar:</label>
                                <input class="form-control" type="file" id="gambar" name="gambar">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Sukses -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
        successModal.show();
    });
    </script>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="successModalLabel">Sukses!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Data berhasil diupdate.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="produk.php" type="button" class="btn btn-primary">back</a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tampilkan Error Jika Ada -->
    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger mt-3" role="alert">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    // Hapus query string dari URL setelah modal muncul
    if (window.location.search.includes('success=true')) {
        history.replaceState({}, document.title, window.location.pathname);
    }
    </script>
</body>

</html>