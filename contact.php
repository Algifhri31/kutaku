<?php
session_start();

// Proses form kontak
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kirim_pesan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $subjek = $_POST['subjek'];
    $pesan = $_POST['pesan'];
    
    // Simpan ke database (opsional)
    $conn = new mysqli("localhost", "root", "", "website");
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("INSERT INTO pesan_kontak (nama, email, subjek, pesan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $email, $subjek, $pesan);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
    
    $_SESSION['message'] = "Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.";
    header('Location: contact.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami - Eco Wisata Mangrove Park</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-flex">
            <div class="logo">
                <a href="index.php"><img src="asset/logo-black.png" alt="Logo" /></a>
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
                        <li><a href="index.php#gallery">Objek Wisata</a></li>
                    </ul>
                </li>
                <li><a href="index.php#blog">Berita</a></li>
                <li><a href="contact.php" class="active">Kontak</a></li>
                <li class="login-mobile"><a href="login.php" class="tombol tombol-login">Login Admin</a></li>
            </ul>
            <a href="login.php" class="tombol tombol-login login-desktop">Login Admin</a>
        </div>
    </nav>

    <div class="container-full">
        <!-- HERO SECTION -->
        <header class="hero-section" style="height: 60vh; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('asset/background-bromo.jpg'); background-size: cover; background-position: center;">
            <div class="hero-content">
                <h1>Hubungi Kami</h1>
                <p>Kami siap membantu Anda dengan pertanyaan dan informasi seputar Eco Wisata Mangrove Park</p>
            </div>
        </header>

        <main>
            <!-- CONTACT SECTION -->
            <section class="section">
                <div class="container">
                    <h2 class="section-title">Informasi Kontak</h2>
                    
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="message success"><?= $_SESSION['message'] ?></div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>
                    
                    <div class="contact-grid">
                        <div class="contact-info">
                            <h3>Informasi Lengkap</h3>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <h4>Alamat</h4>
                                    <p>Jl. Pantai Perupuk, Kec. Tanjung Bunga, Sumatera Utara</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <h4>Telepon</h4>
                                    <p>+62 812-3456-7890</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <h4>Email</h4>
                                    <p>info@ecowisatamangrove.com</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <h4>Jam Operasional</h4>
                                    <p>Senin - Minggu<br>08:00 - 17:00 WIB</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-ticket-alt"></i>
                                <div>
                                    <h4>Harga Tiket</h4>
                                    <p>Rp 25.000/orang</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-form">
                            <h3>Kirim Pesan</h3>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap *</label>
                                    <input type="text" id="nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="subjek">Subjek *</label>
                                    <input type="text" id="subjek" name="subjek" required>
                                </div>
                                <div class="form-group">
                                    <label for="pesan">Pesan *</label>
                                    <textarea id="pesan" name="pesan" rows="5" required></textarea>
                                </div>
                                <button type="submit" name="kirim_pesan" class="btn-submit">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- MAP SECTION -->
            <section class="section abuabu">
                <div class="container">
                    <h2 class="section-title">Lokasi Kami</h2>
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15933.350915208945!2d99.5305239!3d3.26608285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3033c76efa846e87%3A0x5a8951815a32f425!2sPantai%20Sejarah%20Pantai%20Perupuk!5e0!3m2!1sen!2sid!4v1747710129374!5m2!1sen!2sid" width="100%" height="450" style="border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);" allowfullscreen="" loading="lazy"></iframe>
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