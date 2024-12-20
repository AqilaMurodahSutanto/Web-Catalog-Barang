<!-- File: navbar.php -->
<div>
    <nav class="navbar navbar-expand-lg" style="background-color: #fde3fa;">
        <div class="container-fluid">
            <!-- Branding -->
            <a class="navbar-brand fw-bold" href="index.php">Catalog Product</a>

            <!-- Tombol Burger untuk layar kecil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigasi -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Menu Navigasi Home -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"
                            href="index.php">Home</a>
                    </li>

                    <!-- Menu Navigasi Produk -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'product.php' ? 'active' : ''; ?>"
                            href="product.php">Product</a>
                    </li>

                    <!-- Menu Navigasi Favorite -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'favorite.php' ? 'active' : ''; ?>"
                            href="favorite.php">Favorites</a>
                    </li>

                    <!-- Menu Navigasi Produk -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'produk.php' ? 'active' : ''; ?>"
                            href="produk.php">List Product</a>
                    </li>

                    <!-- Menu Navigasi Category -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kategori.php' ? 'active' : ''; ?>"
                            href="kategori.php">Category</a>
                    </li>

                    <!-- Menu Navigasi Users -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'user.php' ? 'active' : ''; ?>"
                            href="user.php">Users</a>
                    </li>
                </ul>

                <!-- Tombol Keranjang -->
                <a href="keranjang.php" class="btn"
                    style="display: flex; align-items: center; justify-content: center; background-color: #f8d200; border: none; color: #000; padding: 8px 15px; border-radius: 5px;">
                    <img src="uploads/kkkkk.png" alt="Keranjang" style="width: 30px; height: 30px; margin-right: 5px;">
                    <span>Keranjang</span>
                </a>


                <!-- Tombol Logout -->
                <a href="logout.php" class="btn btn-danger ms-3">Logout</a>
            </div>
        </div>
    </nav>
</div>