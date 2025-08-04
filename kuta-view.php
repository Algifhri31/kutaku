<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuta View - Eco Wisata Mangrove Park</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .destinasi-hero {
            height: 70vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('asset/foto3.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .destinasi-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        .destinasi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-top: 50px;
        }
        .destinasi-info {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .destinasi-info h2 {
            color: #2c3e50;
            font-size: 2.2rem;
            margin-bottom: 20px;
        }
        .destinasi-info p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 20px;
        }
        .destinasi-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .feature-item i {
            font-size: 1.5rem;
            color: #3498db;
        }
        .feature-item span {
            font-weight: 600;
            color: #2c3e50;
        }
        .destinasi-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .cta-section {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 60px 20px;
            text-align: center;
            margin-top: 60px;
        }
        .cta-content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .cta-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-primary {
            background: white;
            color: #3498db;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .btn-secondary {
            background: transparent;
            color: white;
            padding: 15px 30px;
            border: 2px solid white;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: white;
            color: #3498db;
        }
        @media (max-width: 768px) {
            .destinasi-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .destinasi-features {
                grid-template-columns: 1fr;
            }
            .destinasi-gallery {
                grid-template-columns: repeat(2, 1fr);
            }
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
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
                        <li><a href="galeri.php">Objek Wisata</a></li>
                        <li><a href="kuta-view.php" class="active">Kuta View</a></li>
                        <li><a href="pantai-sejarah.php">Pantai Sejarah</a></li>
                    </ul>
                </li>
                <li><a href="index.php#blog">Berita</a></li>
                <li><a href="produk.php">Produk</a></li>
                <li><a href="contact.php">Kontak</a></li>
                <li class="login-mobile"><a href="login.php" class="tombol tombol-login">Login Admin</a></li>
            </ul>
            <a href="login.php" class="tombol tombol-login login-desktop">Login Admin</a>
        </div>
    </nav>

    <div class="container-full">
        <!-- HERO SECTION -->
        <header class="destinasi-hero">
            <div class="hero-content">
                <h1>Kuta View</h1>
                <p>Nikmati pemandangan indah dari ketinggian dengan panorama alam yang memukau</p>
            </div>
        </header>

        <main>
            <div class="destinasi-content">
                <div class="destinasi-grid">
                    <div class="destinasi-info">
                        <h2>Tentang Kuta View</h2>
                        <p>Kuta View adalah destinasi wisata yang menawarkan pemandangan spektakuler dari ketinggian. Berlokasi strategis di kawasan wisata, tempat ini menjadi favorit para pengunjung untuk menikmati sunset dan panorama alam yang menakjubkan.</p>
                        
                        <p>Dengan fasilitas yang lengkap dan akses yang mudah, Kuta View menjadi tempat yang sempurna untuk bersantai sambil menikmati keindahan alam dari perspektif yang berbeda.</p>

                        <div class="destinasi-features">
                            <div class="feature-item">
                                <i class="fas fa-mountain"></i>
                                <span>Panorama Indah</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-sun"></i>
                                <span>Sunset View</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-camera"></i>
                                <span>Spot Foto</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-coffee"></i>
                                <span>Café</span>
                            </div>
                        </div>
                    </div>

                    <div class="destinasi-info">
                        <h2>Fasilitas & Aktivitas</h2>
                        <p>Kuta View menyediakan berbagai fasilitas untuk kenyamanan pengunjung:</p>
                        
                        <ul style="font-size: 1.1rem; line-height: 1.8; color: #555; margin-bottom: 20px;">
                            <li>Area viewing deck dengan pemandangan 360°</li>
                            <li>Café dan restoran dengan menu lokal</li>
                            <li>Spot foto terbaik untuk selfie dan fotografi</li>
                            <li>Area parkir yang luas</li>
                            <li>Toilet umum yang bersih</li>
                            <li>Pemandu wisata lokal</li>
                        </ul>

                        <div class="destinasi-gallery">
                            <div class="gallery-item">
                                <img src="asset/foto5.jpg" alt="Sunset View">
                            </div>
                            <div class="gallery-item">
                                <img src="asset/foto6.jpg" alt="Panorama">
                            </div>
                            <div class="gallery-item">
                                <img src="asset/foto7.jpg" alt="Café">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA SECTION -->
            <section class="cta-section">
                <div class="container">
                    <div class="cta-content">
                        <h2>Siap Menjelajahi Kuta View?</h2>
                        <p>Jangan lewatkan pengalaman menakjubkan di destinasi wisata favorit ini</p>
                        <div class="cta-buttons">
                            <a href="contact.php" class="btn-primary">Hubungi Kami</a>
                            <a href="galeri.php" class="btn-secondary">Lihat Galeri</a>
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