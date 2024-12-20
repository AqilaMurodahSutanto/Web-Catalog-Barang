<?php 
include 'config.php'; // Menghubungkan file config untuk koneksi database
session_start(); // Memulai session
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalog-login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    * {
        font-family: 'Inter', sans-serif;
    }

    .login-card {
        max-width: 700px;
        /* Memperbesar ukuran kartu login */
    }

    .full {
        height: 100vh;
    }

    .form-label {
        font-size: 1.1rem;
        /* Membuat label lebih besar */
    }

    .form-control {
        font-size: 1.1rem;
        /* Membuat input lebih besar */
        padding: 12px;
        /* Memberikan padding lebih pada input */
    }

    .btn {
        font-size: 1.2rem;
        /* Membuat tombol lebih besar */
        padding: 12px;
        /* Memberikan padding lebih pada tombol */
    }

    .card-body {
        padding: 2rem;
        /* Menambah padding pada card-body */
    }

    .card {
        border-radius: 15px;
        /* Membuat sudut kartu lebih membulat */
    }

    .mt-3 {
        margin-top: 1rem;
    }
    </style>

</head>

<body>
    <div class="full d-flex justify-content-center align-items-center">
        <div class="login-card card">
            <div class="card-body">
                <form action="login-aksi.php" method="POST">
                    <h4 class="fw-bold text-center mb-4">Catalog-login</h4>
                    <div class="mb-3 text-center">Masukkan detail akun anda untuk memulai</div>

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Masukkan email anda"
                            name="email" required>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan password anda"
                            name="password" required>
                    </div>

                    <!-- Error Message -->
                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                    <!-- Menghapus pesan error setelah ditampilkan -->
                    <?php endif; ?>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark">Masuk</button>
                    </div>

                    <!-- Link to Register -->
                    <div class="text-center">
                        <a href="register.php">Belum punya akun? Daftar di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>