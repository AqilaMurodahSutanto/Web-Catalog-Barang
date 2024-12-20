<?php
include 'config.php'; // Sambungkan ke database

// Pastikan ID_Kategori diterima melalui GET
if (!isset($_GET['ID_Kategori'])) {
    die("ID Kategori tidak ditemukan.");
}

$ID_Kategori = $_GET['ID_Kategori'];

// Query untuk mengambil data kategori berdasarkan ID_Kategori
$query = "SELECT * FROM Kategori WHERE ID_Kategori = $ID_Kategori";
$result = $conn->query($query);

// Cek apakah data ditemukan
if ($result->num_rows == 0) {
    die("Kategori tidak ditemukan.");
}

$kategori = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Kategori Barang</title>
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
                        <<form action='editk-aksi.php' method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="nama" name="nama" required
                                    placeholder="Masukkan Nama Kategori">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Tambah Data</button>
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
                    <a href="kategori.php" type="button" class="btn btn-primary">back</a>
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