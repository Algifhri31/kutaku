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
                <div style="text-align: center; margin-top: 20px;">
                        <a href="index.php" class="btn-back-home"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
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