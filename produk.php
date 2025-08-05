<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk UMKM - Eco Wisata Mangrove Park</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="logo/1.png" type="image/png">
    <script src="javascript.js"></script>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-flex">
            <div class="logo">
                <a href="index.php"><img src="logo/primary-logo.png" alt="Logo" style="height: 55px;"/></a>
            </div>
            <a href="#" class="tombol-menu" id="hamburger-menu">
                <span class="garis"></span>
                <span class="garis"></span>
                <span class="garis"></span>
            </a>
            <ul id="nav-list">
                <li class="nav-close-mobile"><a href="#" id="close-mobile-menu" aria-label="Tutup menu">&times;</a></li>
                <li><a href="index.php#home">Beranda</a></li>
                <li class="dropdown">
                    <a href="index.php#aboutus">Tentang <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-content">
                        <li><a href="sejarah.php">Sejarah</a></li>
                        <li><a href="index.php#team">Pengembangan Inovasi</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="index.php#support">Wisata <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-content">
                        <li><a href="index.php#support">Paket Wisata</a></li>
                        <li><a href="galeri.php">Objek Wisata</a></li>
                        <li><a href="kuta-view.php">Kuta View</a></li>
                        <li><a href="pantai-sejarah.php">Pantai Sejarah</a></li>
                    </ul>
                </li>
                <li><a href="index.php#blog">Berita</a></li>
                <li><a href="produk.php" class="active">Produk</a></li>
                <li><a href="index.php#contact">Kontak</a></li>
                <li class="login-mobile"><a href="login.php" class="tombol tombol-login">Login Admin</a></li>
            </ul>
            <a href="login.php" class="tombol tombol-login login-desktop">Login Admin</a>
        </div>
    </nav>

    <div class="container-full">
        <!-- HERO SECTION -->
        <header class="hero-section produk-hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1>Produk UMKM</h1>
                <p>Dukung produk lokal dan temukan keunikan hasil karya masyarakat sekitar</p>
            </div>
        </header>

        <main>
            <!-- PRODUK SECTION -->
            <section class="section">
                <div class="container">
                    <h2 class="section-title">Produk UMKM Unggulan</h2>
                    <p class="section-desc">Jelajahi berbagai produk unggulan dari UMKM lokal yang berkualitas</p>

                    <div class="produk-grid">
                        <?php
                        include 'koneksi.php';
                        // Ambil data produk UMKM dari database
                        $result = mysqli_query($conn, "SELECT * FROM produk_umkm ORDER BY created_at DESC");
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-product.jpg';
                                $nama_produk = htmlspecialchars($row['nama_produk'] ?? '');
                                $deskripsi = htmlspecialchars($row['deskripsi'] ?? '');
                                $harga = number_format($row['harga'] ?? 0, 0, ',', '.');

                                echo "<div class='produk-card'>";
                                echo "<div class='produk-image'>";
                                echo "<img src='" . $gambar . "' alt='" . $nama_produk . "' />";
                                echo "</div>";
                                echo "<div class='produk-content'>";
                                echo "<h3>" . $nama_produk . "</h3>";
                                echo "<p class='produk-deskripsi'>" . $deskripsi . "</p>";
                                echo "<div class='produk-harga'>Rp " . $harga . "</div>";
                                echo "<div class='produk-actions'>";
                                echo "<a href='detail_produk.php?id=" . $row['id'] . "' class='btn-secondary'>";
                                echo "<i class='fas fa-eye'></i> Detail";
                                echo "</a>";
                                if (!empty($row['nomor_wa'])) {
                                    $wa_link = "https://wa.me/" . $row['nomor_wa'] . "?text=Halo, saya tertarik dengan produk " . urlencode($nama_produk);
                                    echo "<a href='" . $wa_link . "' class='btn-primary' target='_blank'>";
                                    echo "<i class='fab fa-whatsapp'></i> Pesan via WhatsApp";
                                    echo "</a>";
                                } else {
                                    echo "<a href='https://wa.me/6281234567890?text=Saya tertarik dengan produk " . urlencode($nama_produk) . "' class='btn-primary' target='_blank'>";
                                    echo "<i class='fab fa-whatsapp'></i> Pesan via WhatsApp";
                                    echo "</a>";
                                }
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<div class='no-produk'>";
                            echo "<i class='fas fa-box-open'></i>";
                            echo "<h3>Belum ada produk tersedia</h3>";
                            echo "<p>Produk UMKM akan ditampilkan di sini</p>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- CALL TO ACTION SECTION -->
            <section class="section abuabu">
                <div class="container">
                    <div class="cta-content">
                        <h2>Ingin Menjual Produk UMKM Anda?</h2>
                        <p>Bergabunglah dengan kami untuk mempromosikan produk UMKM Anda kepada pengunjung wisata</p>
                        <a href="index.php#contact" class="tombol">Hubungi Kami</a>
                    </div>
                </div>
            </section>
        </main>

        <!-- FOOTER -->
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h3>Eco Wisata Mangrove Park</h3>
                        <p>Mengenal Eco Wisata Mangrove Lebih Dekat, Menjaga Alam sekitar Lebih Erat.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="footer-section">
                        <h3>Layanan</h3>
                        <ul>
                            <li><a href="index.php#support">Paket Wisata</a></li>
                            <li><a href="index.php#gallery">Objek Wisata</a></li>
                            <li><a href="produk.php">Produk UMKM</a></li>
                            <li><a href="index.php#blog">Berita</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h3>Kontak</h3>
                        <p><i class="fas fa-map-marker-alt"></i> Jl. Mangrove Park, Indonesia</p>
                        <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                        <p><i class="fas fa-envelope"></i> info@mangrovepark.com</p>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; 2024 Eco Wisata Mangrove Park. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>