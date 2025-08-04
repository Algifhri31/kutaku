<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Travel</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="javascript.js"></script>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-flex">
            <div class="logo">
                <a href=""><img src="asset/logo-black.png" alt="Logo" /></a>
            </div>
            <a href="#" class="tombol-menu" id="hamburger-menu">
                <span class="garis"></span>
                <span class="garis"></span>
                <span class="garis"></span>
            </a>
            <ul id="nav-list">
                <li class="nav-close-mobile"><a href="#" id="close-mobile-menu" aria-label="Tutup menu">&times;</a></li>
                <li><a href="#home">Beranda</a></li>
                <li class="dropdown">
                    <a href="#aboutus">Tentang <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-content">
                        <li><a href="sejarah.php">Sejarah</a></li>
                        <li><a href="#team">Pengembangan Inovasi</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#support">Wisata <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-content">
                        <li><a href="#support">Paket Wisata</a></li>
                        <li><a href="galeri.php">Objek Wisata</a></li>
                        <li><a href="kuta-view.php">Kuta View</a></li>
                        <li><a href="pantai-sejarah.php">Pantai Sejarah</a></li>
                    </ul>
                </li>
                <li><a href="#blog">Berita</a></li>
                <li><a href="produk.php">Produk</a></li>
                <li><a href="#contact">Kontak</a></li>
                <li class="login-mobile"><a href="login.php" class="tombol tombol-login">Login Admin</a></li>
            </ul>
            <a href="login.php" class="tombol tombol-login login-desktop">Login Admin</a>
        </div>
    </nav>

    <div class="container-full">
        <!-- HERO SECTION -->
        <header id="home" class="hero-section">
            <div class="hero-overlay"></div>
            <!-- Video removed due to missing file - using background image instead -->
            <div class="hero-content">
                <h1>Eco Wisata Manggrove Park</h1>
                <p>Mengenal Eco Wisata Mangrove Lebih Dekat, Menjaga Alam sekitar Lebih Erat.</p>
                <a href="#aboutus" class="tombol hero-cta">Info Selanjutnya</a>
            </div>
        </header>

        <main>
            <!-- LAYANAN/PAKET SECTION -->
            <section class="section abuabu" id="support">
                <div class="container">
                    <h2 class="section-title">Layanan Wisata Kami</h2>
                    <div class="layanan-grid">
                        <div class="layanan-card">
                            <div class="layanan-icon"><i class="fa-solid fa-plane"></i></div>
                            <h3>Paket Wisata</h3>
                            <p>Paket wisata lengkap dengan transportasi, akomodasi, dan pemandu wisata profesional.</p>
                            <a href="#" class="layanan-btn">Lihat Paket</a>
                        </div>
                        <div class="layanan-card">
                            <div class="layanan-icon"><i class="fa-solid fa-hotel"></i></div>
                            <h3>Reservasi Hotel</h3>
                            <p>Booking hotel terbaik dengan harga kompetitif di berbagai destinasi wisata Indonesia.</p>
                            <a href="#" class="layanan-btn">Booking Hotel</a>
                        </div>
                        <div class="layanan-card">
                            <div class="layanan-icon"><i class="fa-solid fa-car"></i></div>
                            <h3>Rental Mobil</h3>
                            <p>Layanan rental mobil dengan sopir profesional untuk perjalanan yang nyaman dan aman.</p>
                            <a href="#" class="layanan-btn">Rental Mobil</a>
                        </div>
                        <div class="layanan-card">
                            <div class="layanan-icon"><i class="fa-solid fa-camera"></i></div>
                            <h3>Fotografi Wisata</h3>
                            <p>Jasa fotografi profesional untuk mengabadikan momen indah perjalanan Anda.</p>
                            <a href="#" class="layanan-btn">Booking Foto</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- GALLERY PREVIEW SECTION -->
            <section class="section" id="gallery">
                <div class="container">
                    <h2 class="section-title">Objek Wisata</h2>
                    <p class="section-desc">Jelajahi keindahan alam dan destinasi wisata yang memukau</p>
                    <div class="gallery-preview">
                        <div class="preview-grid">
                            <?php
                            include 'koneksi.php';
                            // Ambil data dari tabel objek_wisata (maksimal 4)
                            $result = mysqli_query($conn, "SELECT * FROM objek_wisata WHERE status = 'aktif' ORDER BY urutan ASC LIMIT 4");
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                                    $judul = htmlspecialchars($row['nama_wisata']);
                                    $deskripsi = htmlspecialchars($row['deskripsi'] ?? '');
                                    
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
                                    ['src' => 'asset/foto4.jpg', 'title' => 'Mangrove Trail', 'desc' => 'Jalur tracking mangrove']
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
                            <a href="galeri.php" class="btn-gallery">Lihat Semua Foto</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- QUOTE SECTION -->
            <section class="section quote">
                <div class="container">
                    <p>Warisan akan budaya sejarahnya, Warisan akan kaya keindahannya</p>
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
                        $result = mysqli_query($conn, "SELECT * FROM inovasi ORDER BY tanggal_dibuat DESC");
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
                </div>
            </section>

            <!-- BERITA SECTION -->
            <section class="section abuabu" id="blog">
                <div class="container">
                    <h2 class="section-title">Berita</h2>
                    <div class="blog-grid">
                        <?php
                        include 'koneksi.php';
                        $query = mysqli_query($conn, "SELECT * FROM berita WHERE status = 'active' ORDER BY tanggal_dibuat DESC");
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
                </div>
            </section>
        </main>

        <!-- FOOTER -->
        <footer id="contact">
            <div class="footer-grid">
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
            <div class="footer-bottom">
                <p>&copy; 2024 Eco Wisata Mangrove Park. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- SCRIPT: MENU & LOGO -->
    <script>
        // Hamburger menu toggle
        const hamburger = document.getElementById('hamburger-menu');
        const navList = document.getElementById('nav-list');
        hamburger.addEventListener('click', function(e) {
            e.preventDefault();
            navList.classList.toggle('show');
        });

        // Tutup menu mobile saat klik link
        document.querySelectorAll('#nav-list li a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 900) {
                    navList.classList.remove('show');
                }
            });
        });

        // Tutup menu mobile saat resize ke desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 900) {
                navList.classList.remove('show');
            }
        });

        // Dropdown mobile toggle
        document.querySelectorAll('.navbar .dropdown > a').forEach(function(drop) {
            drop.addEventListener('click', function(e) {
                if (window.innerWidth <= 900) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    parent.classList.toggle('open');
                }
            });
        });

        // Tombol silang menu mobile
        const closeMobileMenu = document.getElementById('close-mobile-menu');
        if (closeMobileMenu) {
            closeMobileMenu.addEventListener('click', function(e) {
                e.preventDefault();
                navList.classList.remove('show');
            });
        }

        // Navbar font color always black
        document.addEventListener('DOMContentLoaded', function() {
            const menuLinks = document.querySelectorAll('nav .menu ul li a, nav ul#nav-list li a');
            menuLinks.forEach(link => link.style.color = '#232946');
        });
    </script>
</body>

</html>