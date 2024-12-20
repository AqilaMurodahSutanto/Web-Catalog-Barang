<?php
include 'config.php'; // Menghubungkan ke database
include 'navbar.php';


// Mengecek apakah ada parameter 'search'
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filter = isset($_GET['filter']) ? $conn->real_escape_string($_GET['filter']) : '';

// Ambil daftar kategori untuk dropdown
$kategoriResult = $conn->query("SELECT * FROM Kategori");
if (!$kategoriResult) {
    die("Error mengambil data kategori: " . $conn->error);
}

// Query untuk mengambil data dari tabel 'barang', dengan filter jika ada pencarian
if (!empty($search)) {
    switch ($filter) {
        case 'kategori':
            // Mencari berdasarkan kategori, melakukan join dengan tabel kategori
            $sql = "SELECT barang.* 
                    FROM barang 
                    JOIN Kategori_Barang ON barang.ID_Kategori = Kategori_Barang.ID_Kategori 
                    WHERE Kategori_Barang.Nama_Kategori LIKE '%$search%'";
            break;
        case 'harga':
            // Menggunakan subquery untuk mencari harga > atau < nilai tertentu
            if (strpos($search, '>') !== false || strpos($search, '<') !== false) {
                // Subquery untuk mencari harga lebih besar atau lebih kecil dari pencarian
                $sql = "SELECT * 
                        FROM barang 
                        WHERE Harga $search";
            } else {
                // Jika tidak ada operator, mencari harga yang sama persis
                $sql = "SELECT * FROM barang WHERE Harga = '$search'";
            }
            break;
        case 'stok':
            // Menggunakan subquery untuk mencari stok berdasarkan nilai lebih besar atau sama dengan pencarian
            if (strpos($search, '>') !== false || strpos($search, '<') !== false) {
                // Subquery untuk stok lebih besar atau lebih kecil dari pencarian
                $sql = "SELECT * 
                        FROM barang 
                        WHERE Stok $search";
            } else {
                // Jika pencarian hanya angka (misalnya stok = 9), subquery untuk stok persis sama
                $sql = "SELECT * 
                        FROM barang 
                        WHERE Stok = '$search'";
            }
            break;
        case 'satuan':
            // Mencari berdasarkan satuan
            $sql = "SELECT * FROM barang WHERE Satuan LIKE '%$search%'";
            break;
        default:
            // Pencarian berdasarkan nama barang
            $sql = "SELECT * FROM barang WHERE Nama_Barang LIKE '%$search%'";
    }
} else {
    $sql = "SELECT * FROM barang"; // Jika tidak ada pencarian atau filter
}

$result = $conn->query($sql);

// Mengecek apakah query berhasil dijalankan
if (!$result) {
    die("Error pada query: " . $conn->error);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        margin: 20px auto;
        max-width: 1200px;
    }

    .table {
        margin-bottom: 0;
        font-size: 1.2rem;
    }

    th,
    td {
        padding: 20px;
        text-align: center;
    }

    .table-bordered {
        border: 2px solid #dee2e6;
    }

    .btn {
        font-size: 1rem;
    }

    .aksi-col {
        width: 200px;
    }

    .gambar-col {
        width: 100px;
    }

    .gambar-col img {
        width: 100%;
        height: auto;
        max-height: 100px;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Daftar Barang</h2>
    </div>

    <div class="container mb-2 mt-4">
        <div class="d-flex mb-2 justify-content-start">
            <form class="d-flex" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari barang..."
                    aria-label="Search" value="<?php echo htmlspecialchars($search); ?>">
                <select name="filter" class="form-select me-2" aria-label="Default select example">
                    <option value="">Pilih Filter</option>
                    <option value="kategori" <?php if($filter == "kategori") echo 'selected'; ?>>Kategori</option>
                    <option value="harga" <?php if($filter == "harga") echo 'selected'; ?>>Harga</option>
                    <option value="stok" <?php if($filter == "stok") echo 'selected'; ?>>Stok</option>
                    <option value="satuan" <?php if($filter == "satuan") echo 'selected'; ?>>Satuan</option>
                    <?php
                    // Menampilkan kategori sebagai opsi filter
                    while ($row = $kategoriResult->fetch_assoc()) {
                        echo "<option value='" . $row['Nama_Kategori'] . "' " . ($filter == $row['Nama_Kategori'] ? 'selected' : '') . ">" . $row['Nama_Kategori'] . "</option>";
                    }
                    ?>
                </select>
                <button class=" btn btn-outline-dark me-5" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="container mb-2 mt-4">
        <div class="d-flex mb-2 justify-content-end">
            <a href="create.php" class="btn btn-secondary me-5">Tambah Data</a>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Gambar</th> <!-- Kolom Gambar -->
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Satuan</th>
                        <th scope="col" class="aksi-col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Mengecek apakah ada data di hasil query
                        if ($result->num_rows > 0) {
                            $no = 1; // Nomor urut
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $no++ . "</th>"; // Menampilkan nomor urut
                                // Menampilkan gambar (pastikan path gambar benar)
                                echo "<td class='gambar-col'>";
                                if (!empty($row['gambar']) && file_exists($row['gambar'])) {
                                    echo "<img src='" . $row['gambar'] . "' alt='" . $row['Nama_Barang'] . "' />";
                                } else {
                                    echo "<img src='default.jpg' alt='Gambar Tidak Tersedia' />";
                                }
                                echo "</td>";
                                echo "<td>" . $row['Nama_Barang'] . "</td>"; // Kolom nama
                                echo "<td>" . number_format($row['Harga'], 0, ',', '.') . "</td>"; // Kolom harga dengan format
                                echo "<td>" . $row['Stok'] . "</td>"; // Kolom stok
                                echo "<td>" . $row['Satuan'] . "</td>"; // Kolom satuan
                                echo "<td>
                                    <!-- Tombol Edit -->
                                    <a href='edit.php?id_barang=" . $row['ID_Barang'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <!-- Tombol Delete -->
                                    <a href='delete.php?id_barang=" . $row['ID_Barang'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus barang ini?\")'>Delete</a>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada data barang.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>