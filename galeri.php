<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Wisata - Eco Wisata Mangrove Park</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="container-full">
        <!-- HERO SECTION -->
        <header class="hero-section" style="height: 60vh; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('asset/IMG_7487.JPG'); background-size: cover; background-position: center;">
            <div class="hero-content">
                <h1>Galeri Wisata</h1>
                <p>Jelajahi keindahan alam dan destinasi wisata yang memukau di Desa Kuala Tanjung</p>
            </div>
        </header>

        <main>
            <!-- GALLERY SECTION -->
            <section class="section">
                <div class="container">
                    <h2 class="section-title">Objek Wisata</h2>
                    <p class="section-desc">Nikmati keindahan alam dan destinasi wisata yang menakjubkan</p>

                    <div class="gallery-container">
                        <?php
                        // Ambil data dari tabel galeri (foto yang diupload melalui dashboard) terlebih dahulu
                        $result = mysqli_query($conn, "SELECT * FROM galeri WHERE judul IS NOT NULL AND judul != '' ORDER BY created_at DESC");
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-product.jpg';
                                $judul = !empty($row['judul']) ? htmlspecialchars($row['judul']) : 'Objek Wisata';
                                $deskripsi = !empty($row['deskripsi']) ? htmlspecialchars($row['deskripsi']) : 'Keindahan alam yang memukau';

                                echo "<div class='gallery-item'>";
                                echo "<a href='detail-galeri.php?id=" . $row['id'] . "&type=galeri'>";
                                echo "<div class='gallery-image'>";
                                echo "<img src='" . $gambar . "' alt='" . $judul . "' />";
                                echo "<div class='gallery-overlay'>";
                                echo "<div class='gallery-info'>";
                                echo "<h3>" . $judul . "</h3>";
                                echo "<p>" . $deskripsi . "</p>";
                                echo "<div class='detail-hint'>Klik untuk detail</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</a>";
                                echo "</div>";
                            }
                        }

                        // Tambahkan data dari tabel objek_wisata
                        $result2 = mysqli_query($conn, "SELECT * FROM objek_wisata WHERE status = 'aktif' AND gambar IS NOT NULL AND gambar != '' ORDER BY urutan ASC, id DESC");
                        if ($result2 && mysqli_num_rows($result2) > 0) {
                            while ($row = mysqli_fetch_assoc($result2)) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-product.jpg';
                                $judul = !empty($row['nama_wisata']) ? htmlspecialchars($row['nama_wisata']) : 'Objek Wisata';
                                $deskripsi = !empty($row['deskripsi']) ? htmlspecialchars($row['deskripsi']) : 'Keindahan alam yang memukau';

                                echo "<div class='gallery-item'>";
                                echo "<a href='detail-galeri.php?id=" . $row['id'] . "&type=objek_wisata'>";
                                echo "<div class='gallery-image'>";
                                echo "<img src='" . $gambar . "' alt='" . $judul . "' />";
                                echo "<div class='gallery-overlay'>";
                                echo "<div class='gallery-info'>";
                                echo "<h3>" . $judul . "</h3>";
                                echo "<p>" . $deskripsi . "</p>";
                                echo "<div class='detail-hint'>Klik untuk detail</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</a>";
                                echo "</div>";
                            }
                        }

                        // Jika tidak ada data sama sekali, tampilkan foto statis
                        if ((!$result || mysqli_num_rows($result) == 0) && (!$result2 || mysqli_num_rows($result2) == 0)) {
                            // Fallback ke foto statis jika belum ada data galeri
                            $foto_list = [
                                ['src' => 'asset/foto1.jpg', 'title' => 'Mangrove Park', 'desc' => 'Keindahan hutan mangrove yang asri'],
                                ['src' => 'asset/foto2.jpg', 'title' => 'Pantai Sejarah', 'desc' => 'Pantai dengan pemandangan yang memukau'],
                                ['src' => 'asset/foto3.jpg', 'title' => 'Eco Tourism', 'desc' => 'Wisata ramah lingkungan'],
                                ['src' => 'asset/foto4.jpg', 'title' => 'Mangrove Trail', 'desc' => 'Jalur tracking mangrove'],
                                ['src' => 'asset/foto5.jpg', 'title' => 'Sunset View', 'desc' => 'Pemandangan sunset yang indah'],
                                ['src' => 'asset/foto6.jpg', 'title' => 'Wildlife', 'desc' => 'Kehidupan liar mangrove'],
                                ['src' => 'asset/foto7.jpg', 'title' => 'Boat Tour', 'desc' => 'Tur perahu di mangrove'],
                                ['src' => 'asset/foto8.jpg', 'title' => 'Conservation', 'desc' => 'Konservasi lingkungan']
                            ];

                            foreach ($foto_list as $foto) {
                                echo "<div class='gallery-item'>";
                                echo "<div class='gallery-image'>";
                                echo "<img src='" . $foto['src'] . "' alt='" . $foto['title'] . "' />";
                                echo "<div class='gallery-overlay'>";
                                echo "<div class='gallery-info'>";
                                echo "<h3>" . $foto['title'] . "</h3>";
                                echo "<p>" . $foto['desc'] . "</p>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="index.php" class="btn-back-home"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
                    </div>
                </div>
            </section>

            <!-- INFO SECTION -->
            <section class="section abuabu">
                <div class="container">
                    <h2 class="section-title">Tentang Galeri Wisata</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <h3>Fotografi Profesional</h3>
                            <p>Setiap foto diambil dengan teknik fotografi profesional untuk menangkap keindahan alam yang autentik.</p>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h3>Eco Tourism</h3>
                            <p>Destinasi wisata yang ramah lingkungan dan mendukung konservasi alam.</p>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h3>Lokasi Strategis</h3>
                            <p>Berlokasi di area yang mudah dijangkau dengan pemandangan yang memukau.</p>
                        </div>
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

    <script src="javascript.js"></script>
</body>
</html>