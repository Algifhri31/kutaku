<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kutaku Sejahtera</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="icon" href="logo/1.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="javascript.js"></script>
    <style>
        .deskripsi {
            max-width: 800px; /* Limit width on large screens */
            margin: 40px auto; /* Center the div and add vertical spacing */
            padding: 0 20px; /* Add horizontal padding for smaller screens */
            text-align: center; /* Center the text */
        }

        .deskripsi p {
            font-size: 1.1rem; /* Default font size */
            line-height: 1.6;
            color: #333;
        }

        /* Media query for desktop screens */
        @media (min-width: 769px) {
            .deskripsi p {
                font-size: 1.3rem; /* Larger font size for desktop */
            }
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .deskripsi {
                margin: 20px auto; /* Reduce vertical margin on smaller screens */
                padding: 0 15px; /* Adjust padding */
            }
            .deskripsi p {
                font-size: 1rem; /* Slightly smaller font size on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .deskripsi p {
                font-size: 0.9rem; /* Even smaller font size on very small screens */
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-flex">
            <div class="logo">
                <a href=""><img src="logo/primary-logo.png" alt="Logo" id="main-logo" style="height: 55px;"/></a>
            </div>
            <a href="#" class="tombol-menu" id="hamburger-menu">
                <span class="garis"></span>
                <span class="garis"></span>
                <span class="garis"></span>
            </a>
            <ul id="nav-list">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#team">Inovasi</a></li>
                <li class="dropdown">
                    <a href="">Wisata <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-content" style="list-style-type: none;">
                        <li><a href="kuta-view.php">Kuta View</a></li>
                        <li><a href="pantai-sejarah.php">Pantai Sejarah</a></li>
                    </ul>
                </li>
                <li><a href="#produk-umkm">Produk</a></li>
                <li><a href="#blog">Berita</a></li>
                <li><a href="#contact">Kontak</a></li>
                <!--<li class="login-mobile"><a href="login.php" class="tombol tombol-login">Login Admin</a></li>-->
            </ul>
            <!--<a href="login.php" class="tombol tombol-login login-desktop">Login Admin</a>-->
        </div>
    </nav>

    <div class="container-full">
        <!-- HERO SECTION -->
        <header id="home" class="hero-section">
            <div class="hero-overlay"></div>
            <!-- Video removed due to missing file - using background image instead -->
            <div class="hero-content">
                <h1>KUTAKU SEJAHTERA</h1>
            </div>
        </header>

        <div class="deskripsi">
            <p>Kutaku Sejahtera merupakan kepanjangan dari Kuala Tanjung Ku Sejahtera. Sebagai simbol dari kebanggaan masyarakatnya. Kuala Tanjung adalah desa pesisir yang tumbuh di tengah kawasan industri besar seperti PT Inalum.</p>
        </div>

        <main>
            <!-- GALLERY PREVIEW SECTION -->
            <section class="section" id="gallery">
                <div class="container">
                    <h2 class="section-title">Highlight</h2>
                    <div class="gallery-preview">
                        <div class="preview-grid">
                            <?php
                            include 'koneksi.php';
                            // Ambil data dari tabel objek_wisata (maksimal 4)
                            $result = mysqli_query($conn, "SELECT * FROM galeri WHERE judul IS NOT NULL AND judul != '' ORDER BY created_at DESC LIMIT 6");
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-product.jpg';
                                    $judul = !empty($row['judul']) ? htmlspecialchars($row['judul']) : 'Objek Wisata';
                                    $deskripsi = !empty($row['deskripsi']) ? htmlspecialchars($row['deskripsi']) : 'Keindahan alam yang memukau';

                                    echo "<div class='preview-item'>";
                                    echo "<img src='" . $gambar . "' alt='" . $judul . "' />";
                                    echo "<div class='preview-overlay'>";
                                    echo "<h3>" . $judul . "</h3>";
                                    echo "<p>" . $deskripsi . "</p>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else {
                                // Fallback ke foto statis jika belum ada data objek wisata
                                $foto_list = [
                                    ['src' => 'asset/foto1.jpg', 'title' => 'Mangrove Park', 'desc' => 'Keindahan hutan mangrove yang asri'],
                                    ['src' => 'asset/foto2.jpg', 'title' => 'Pantai Sejarah', 'desc' => 'Pantai dengan pemandangan yang memukau'],
                                    ['src' => 'asset/foto3.jpg', 'title' => 'Eco Tourism', 'desc' => 'Wisata ramah lingkungan'],
                                    ['src' => 'asset/foto4.jpg', 'title' => 'Mangrove Trail', 'desc' => 'Jalur tracking mangrove'],
                                    ['src' => 'asset/foto1.jpg', 'title' => 'Mangrove Park', 'desc' => 'Keindahan hutan mangrove yang asri'],
                                    ['src' => 'asset/foto2.jpg', 'title' => 'Pantai Sejarah', 'desc' => 'Pantai dengan pemandangan yang memukau'],
                                ];

                                foreach ($foto_list as $foto) {
                                    echo "<div class='preview-item'>";
                                    echo "<img src='" . $foto['src'] . "' alt='" . $foto['title'] . "' />";
                                    echo "<div class='preview-overlay'>";
                                    echo "<h3>" . $foto['title'] . "</h3>";
                                    echo "<p>" . $foto['desc'] . "</p>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="preview-cta">
                            <a href="galeri.php" class="btn-gallery">Lihat Semua</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- INOVASI SECTION -->
            <section class="section" id="team">
                <div class="container">
                    <h2 class="section-title">Karya Pengembangan Inovasi</h2>
                    <p class="section-desc">Berikut adalah karya inovasi yang telah dikembangkan:</p>
                    <div class="inovasi-grid">
                        <?php
                        include 'koneksi.php';
                        $result = mysqli_query($conn, "SELECT * FROM inovasi ORDER BY tanggal_dibuat DESC LIMIT 4");
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                                echo "<div class='inovasi-card'>";
                                echo "<a href='detail-inovasi.php?id=" . $row['id'] . "' class='inovasi-link'>";
                                echo "<img src='" . $gambar . "' alt='" . htmlspecialchars($row['judul']) . "' class='inovasi-img'>";
                                echo "<div class='inovasi-info'>";
                                echo "<h6>" . htmlspecialchars($row['judul']) . "</h6>";
                                echo "<span>" . htmlspecialchars($row['penulis']) . "</span>";
                                echo "</div>";
                                echo "</a>";
                                echo "</div>";
                            }
                        } else {
                            echo "<div class='inovasi-empty'>Belum ada inovasi yang ditambahkan.</div>";
                        }
                        ?>
                    </div>
                    <div class="preview-cta">
                        <a href="inovasi.php" class="btn-gallery" style="margin: 20px">Lihat Selengkapnya</a>
                    </div>
                </div>

            </section>

            <!-- PRODUK UMKM SECTION -->
            <section class="section" id="produk-umkm">
                <div class="container">
                    <h2 class="section-title">Produk UMKM</h2>
                    <p class="section-desc">Dukung produk lokal UMKM kami.</p>
                    <div class="produk-umkm-grid">
                        <?php
                        include 'koneksi.php';
                        $result = mysqli_query($conn, "SELECT * FROM produk_umkm ORDER BY created_at DESC LIMIT 9");
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-product.jpg';
                                $harga = !empty($row['harga']) ? "Rp " . number_format($row['harga'], 0, ',', '.') : 'Harga tidak tersedia';
                                $deskripsi_singkat = !empty($row['deskripsi']) ? substr(strip_tags($row['deskripsi']), 0, 100) . "..." : 'Deskripsi tidak tersedia.';
                                echo "<div class='produk-card'>";
                                echo "<a href='detail_produk.php?id=" . $row['id'] . "' class='produk-link'>";
                                echo "<div class='produk-image'>";
                                echo "<img src='" . $gambar . "' alt='" . htmlspecialchars($row['nama_produk']) . "'>";
                                echo "</div>";
                                echo "<div class='produk-content'>";
                                echo "<h3>" . htmlspecialchars($row['nama_produk']) . "</h3>";
                                echo "<p class='produk-deskripsi'>" . $deskripsi_singkat . "</p>";
                                echo "<p class='produk-harga'>" . $harga . "</p>";
                                echo "</div>";
                                echo "</a>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="preview-cta">
                        <a href="produk.php" class="btn-gallery" style="margin: 40px">Lihat Lainnya</a>
                    </div>
                </div>
            </section>
            <section class="section abuabu" id="blog">
                <div class="container">
                    <h2 class="section-title">Berita</h2>
                    <div class="blog-grid">
                        <?php
                        include 'koneksi.php';
                        $query = mysqli_query($conn, "SELECT * FROM berita WHERE status = 'active' ORDER BY tanggal_dibuat DESC LIMIT 3");
                        if (!$query) {
                            die("Query error: " . mysqli_error($conn));
                        }
                        while ($row = mysqli_fetch_assoc($query)) {
                            $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : "asset/default-image.jpg";
                            $preview = substr(strip_tags($row['draft']), 0, 150) . "...";
                        ?>
                            <div class="berita-card">
                                <div class="berita-card-thumb" style="background-image: url('<?= $gambar ?>');"></div>
                                <div class="berita-card-body">
                                    <h4><a href="detail-berita.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['judul']) ?></a></h4>
                                    <p class="berita-meta"><em>Oleh <?= htmlspecialchars($row['penulis']) ?> | <?= date('d M Y', strtotime($row['tanggal_dibuat'])) ?></em></p>
                                    <p><?= $preview ?> <a href="detail-berita.php?id=<?= $row['id'] ?>" class="read-more">Baca selengkapnya</a></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="preview-cta" style="margin-top: 40px; text-align: center;">
                        <a href="berita.php" class="btn-gallery">Lihat Lainnya</a>
                    </div>
                </div>
            </section>
        </main>

        <!-- FOOTER -->
        <footer id="contact">
            <div class="footer-grid" style="padding: 20px 40px">
                <div>
                    <h5>Informasi</h5>
                    <p>Eco Wisata Mangrove Park adalah destinasi wisata alam yang menawarkan pengalaman unik menjelajahi ekosistem mangrove dengan pemandangan yang memukau dan udara yang segar.</p>
                </div>
                <div>
                    <h5>Kontak</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Pantai Perupuk, Kec. Tanjung Bunga<br>
                    <i class="fas fa-phone"></i> +62 812-3456-7890<br>
                    <i class="fas fa-envelope"></i> info@ecowisatamangrove.com</p>
                </div>
                <div>
                    <h5>Jam Operasional</h5>
                    <p><i class="fas fa-clock"></i> Senin - Minggu<br>
                    08:00 - 17:00 WIB<br>
                    <i class="fas fa-ticket-alt"></i> Tiket: Rp 25.000/orang</p>
                </div>
                <div>
                    <h5>Lokasi</h5>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15933.350915208945!2d99.5305239!3d3.26608285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3033c76efa846e87%3A0x5a8951815a32f425!2sPantai%20Sejarah%20Pantai%20Perupuk!5e0!3m2!1sen!2sid!4v1747710129374!5m2!1sen!2sid" width="100%" height="150" style="border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);" allowfullscreen="" loading="lazy"></iframe>
                    <div class="footer-social">
                        <a href="#" class="footer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="footer-social-link" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="footer-social-link" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="footer-social-link" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div style='text:center; color:#fff; align-items: center; justify-content: center;display: flex;'>
                <p>&copy; 2025 Kutaku Sejahtera. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>

</html>