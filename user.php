<?php 
include 'config.php';
include 'navbar.php';

// Tangkap input pencarian (jika ada)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Query untuk mengambil data dengan filter pencarian hanya berdasarkan Email
$sql = "SELECT * FROM users";
if (!empty($search)) {
    $sql .= " WHERE email LIKE '%$search%'";
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
    <title>Users</title>
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
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Daftar Pengguna</h2>
    </div>
    <div class="container mb-2 mt-4">
        <div class="d-flex mb-2 justify-content-start">
            <form class="d-flex" method="GET" action="">
                <input class="form-control me-2" type="search" name="search"
                    placeholder="Cari pengguna berdasarkan email..." aria-label="Search"
                    value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-dark me-5" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="container mb-2 mt-4">
        <div class="d-flex mb-2 justify-content-end">
            <a href="create_user.php" class="btn btn-secondary me-5">Tambah Pengguna</a>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tanggal Dibuat</th>
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
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>"; // Kolom email
                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>"; // Kolom nama
                            echo "<td>" . htmlspecialchars($row['created']) . "</td>"; // Kolom tanggal dibuat
                            echo "<td>
                                <!-- Tombol Edit -->
                                <a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                <!-- Tombol Delete -->
                                <a href='delete_user.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pengguna ini?\")'>Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data pengguna yang ditemukan.</td></tr>";
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