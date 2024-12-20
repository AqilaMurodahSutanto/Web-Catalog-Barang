<?php
include 'config.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Arahkan ke login jika belum login
    exit();
}

include 'navbar.php'; // Navbar tetap digunakan jika diperlukan
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYCatalog</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Custom Styles */
    body {
        font-family: Arial, sans-serif;
    }

    /* Hero Section */
    .hero {
        background: url('uploads/tokokami.jpg') no-repeat center center/cover;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        position: relative;
    }

    /* Semi-transparent overlay for text visibility */
    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        /* Dark overlay */
        z-index: -1;
    }

    .hero h1 {
        font-size: 3.5rem;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .hero h3 {
        font-size: 1.8rem;
        margin-bottom: 20px;
        font-weight: 300;
    }

    /* Search Form in Hero */
    .search-form {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10;
        display: flex;
        /* Membuat input dan tombol sejajar */
        align-items: center;
        gap: 10px;
        /* Memberikan jarak antara input dan tombol */
    }


    .search-form input {
        border-radius: 50px;
        border: 2px solid #EC47B0;
        padding: 10px 15px;
        font-size: 1rem;
        margin-right: 10px;
        width: 250px;
    }

    .search-form button {
        background-color: #EC47B0;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .search-form button:hover {
        background-color: #F89AC3;
    }

    /* Product Grid Section */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    .product-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-card .card-body {
        padding: 20px;
    }

    .product-card .card-body h5 {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .product-card .card-body p {
        font-size: 1rem;
        color: #555;
    }

    /* Button style */
    .view-more-btn {
        display: block;
        margin: 30px auto;
        padding: 12px 25px;
        background-color: #EC47B0;
        color: white;
        text-align: center;
        font-weight: bold;
        border-radius: 50px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .view-more-btn:hover {
        background-color: #F89AC3;
    }

    /* User name under navbar */
    .user-name {
        margin: 10px 0;
        padding-left: 15px;
        font-size: 1.2rem;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <section class="hero">
        <!-- Search Form in Hero -->
        <div class="search-form">
            <form action="product.php" method="GET" class="d-flex">
                <!-- Kolom Pencarian -->
                <input type="search" name="search" class="form-control" placeholder="Cari Produk"
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <!-- Tombol Cari -->
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>


        <!-- Hero Content -->
        <div class="container">
            <h3>THE BEST PRODUCT</h3>
            <h1>AQILA NURUL AGENCY</h1>
            <p class="lead">Selamat datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        </div>
    </section>



    <!-- Product Grid Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Our Featured Products</h2>

            <!-- Product Grid -->
            <div class="product-grid">
                <!-- Product 1 -->
                <div class="product-card">
                    <img src="uploads/alattulishome.jpg" alt="Alat Tulis">
                    <div class="card-body">
                        <h5>Alat Tulis</h5>
                        <p>Kami menyediakan berbagai macam alat tulis yang aesthetic dan modern.</p>
                    </div>
                </div>
                <!-- Product 2 -->
                <div class="product-card">
                    <img src="uploads/dubaihome.webp" alt="Coklat Dubai">
                    <div class="card-body">
                        <h5>Coklat Dubai</h5>
                        <p>Hingga coklat viral Dubai pun kami sediakan 😊.</p>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="product-card">
                    <img src="uploads/wardah2home.webp" alt="Lipstik">
                    <div class="card-body">
                        <h5>Make Up</h5>
                        <p>Ingin tampil menarik? Belanja di sini solusinya!</p>
                    </div>
                </div>
                <!-- Additional Products -->
                <div class="product-card">
                    <img src="uploads/prt.webp" alt="Peralatan Rumah Tangga">
                    <div class="card-body">
                        <h5>Peralatan Rumah Tangga</h5>
                        <p>Peralatan rumah tangga minimalis juga sudah tersedia.</p>
                    </div>
                </div>
                <!-- More products can be added here -->
            </div>

            <a href="product.php" class="view-more-btn">View More Products</a>
        </div>
    </section>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>