<?php
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantai Sejarah - Eco Wisata Mangrove Park</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .destinasi-hero {
            height: 70vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('asset/foto2.jpg');
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
        .fasilitas-card:hover {
            transform: translateY(-5px);
        }
        .tip-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .foto-item:hover {
            transform: translateY(-5px);
        }
        .testimonial-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
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
            .detail-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
            .fasilitas-grid {
                grid-template-columns: 1fr !important;
            }
            .jadwal-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
            .tips-grid {
                grid-template-columns: 1fr !important;
            }
            .testimonial-grid {
                grid-template-columns: 1fr !important;
            }
            .galeri-foto-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .testimonial-form-container form > div {
                grid-template-columns: 1fr !important;
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
                        <li><a href="kuta-view.php">Kuta View</a></li>
                        <li><a href="pantai-sejarah.php" class="active">Pantai Sejarah</a></li>
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
                <?php
                $hero_section = $conn->query("SELECT * FROM pantai_sejarah WHERE section_name = 'hero' LIMIT 1")->fetch_assoc();
                ?>
                <h1><?= htmlspecialchars($hero_section['title'] ?? 'Pantai Sejarah') ?></h1>
                <p><?= htmlspecialchars($hero_section['content'] ?? 'Destinasi wisata edukasi mangrove dengan keindahan alam dan nilai sejarah yang tinggi') ?></p>
            </div>
        </header>

        <main>
            <div class="destinasi-content">
                <div class="destinasi-grid">
                    <div class="destinasi-info">
                        <?php
                        $profil_section = $conn->query("SELECT * FROM pantai_sejarah WHERE section_name = 'profil' LIMIT 1")->fetch_assoc();
                        ?>
                        <h2><?= htmlspecialchars($profil_section['title'] ?? 'Profil Pantai Sejarah') ?></h2>
                        <p><?= nl2br(htmlspecialchars($profil_section['content'] ?? 'Pantai Sejarah adalah destinasi wisata edukasi yang menggabungkan keindahan alam pantai dengan nilai historis dan edukasi mangrove yang tinggi. Berlokasi strategis di kawasan pesisir, pantai ini menjadi pusat pembelajaran tentang ekosistem mangrove dan konservasi alam.')) ?></p>
                        
                        <p>Dengan luas area yang cukup besar, Pantai Sejarah menyediakan berbagai fasilitas edukasi dan rekreasi yang memadai. Pengunjung dapat menikmati keindahan alam sambil mempelajari pentingnya menjaga kelestarian ekosistem mangrove dan kehidupan burung migrasi.</p>

                        <div class="destinasi-features">
                            <div class="feature-item">
                                <i class="fas fa-tree"></i>
                                <span>Taman Edukasi</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-dove"></i>
                                <span>Burung Migrasi</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-history"></i>
                                <span>Nilai Sejarah</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-leaf"></i>
                                <span>Ekosistem Mangrove</span>
                            </div>
                        </div>
                    </div>

                    <div class="destinasi-info">
                        <h2>Destinasi Wisata & Aktivitas</h2>
                        <p>Pantai Sejarah menawarkan berbagai destinasi wisata dan aktivitas edukasi yang menarik:</p>
                        
                        <ul style="font-size: 1.1rem; line-height: 1.8; color: #555; margin-bottom: 20px;">
                            <li><strong>Taman Edukasi Pohon Mangrove:</strong> Area pembelajaran tentang berbagai jenis pohon mangrove</li>
                            <li><strong>Pengamatan Burung Migrasi:</strong> Spot terbaik untuk melihat burung-burung migrasi</li>
                            <li><strong>Jalur Tracking Mangrove:</strong> Trekking di hutan mangrove yang asri</li>
                            <li><strong>Menara Pengamatan:</strong> Untuk melihat pemandangan luas kawasan mangrove</li>
                            <li><strong>Area Piknik:</strong> Tempat bersantai sambil menikmati keindahan alam</li>
                            <li><strong>Spot Foto:</strong> Lokasi foto terbaik dengan background mangrove</li>
                            <li><strong>Pemandu Edukasi:</strong> Pemandu wisata khusus edukasi mangrove</li>
                        </ul>

                        <div class="destinasi-gallery">
                            <div class="gallery-item">
                                <img src="asset/foto1.jpg" alt="Taman Edukasi Mangrove">
                            </div>
                            <div class="gallery-item">
                                <img src="asset/foto4.jpg" alt="Burung Migrasi">
                            </div>
                            <div class="gallery-item">
                                <img src="asset/foto8.jpg" alt="Ekosistem Mangrove">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL SECTION -->
            <section class="section abuabu">
                <div class="container">
                    <h2 class="section-title">Destinasi Wisata Unggulan</h2>
                    <div class="detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px;">
                        <div class="detail-card" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <div style="text-align: center; margin-bottom: 20px;">
                                <i class="fas fa-tree" style="font-size: 3rem; color: #27ae60;"></i>
                            </div>
                            <h3 style="color: #2c3e50; margin-bottom: 15px; text-align: center;">Taman Edukasi Pohon Mangrove</h3>
                            <p style="font-size: 1.1rem; line-height: 1.7; color: #555; margin-bottom: 20px;">
                                Taman edukasi ini menampilkan berbagai jenis pohon mangrove yang tumbuh di kawasan pesisir. Pengunjung dapat mempelajari:
                            </p>
                            <ul style="font-size: 1rem; line-height: 1.6; color: #555;">
                                <li>Jenis-jenis pohon mangrove lokal</li>
                                <li>Manfaat ekosistem mangrove</li>
                                <li>Cara konservasi mangrove</li>
                                <li>Keanekaragaman hayati mangrove</li>
                            </ul>
                        </div>
                        
                        <div class="detail-card" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <div style="text-align: center; margin-bottom: 20px;">
                                <i class="fas fa-dove" style="font-size: 3rem; color: #3498db;"></i>
                            </div>
                            <h3 style="color: #2c3e50; margin-bottom: 15px; text-align: center;">Pengamatan Burung Migrasi</h3>
                            <p style="font-size: 1.1rem; line-height: 1.7; color: #555; margin-bottom: 20px;">
                                Kawasan ini menjadi habitat sementara bagi berbagai jenis burung migrasi. Aktivitas yang dapat dilakukan:
                            </p>
                            <ul style="font-size: 1rem; line-height: 1.6; color: #555;">
                                <li>Pengamatan burung dengan teropong</li>
                                <li>Fotografi satwa liar</li>
                                <li>Belajar pola migrasi burung</li>
                                <li>Konservasi habitat burung</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FASILITAS SECTION -->
            <section class="section">
                <div class="container">
                    <h2 class="section-title">Fasilitas & Layanan</h2>
                    <div class="fasilitas-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px;">
                        <div class="fasilitas-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s ease;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-parking" style="font-size: 2.5rem; color: #e74c3c;"></i>
                            </div>
                            <h4 style="color: #2c3e50; margin-bottom: 10px;">Area Parkir Luas</h4>
                            <p style="color: #555; font-size: 0.95rem;">Parkir gratis untuk pengunjung dengan kapasitas hingga 100 kendaraan</p>
                        </div>
                        
                        <div class="fasilitas-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s ease;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-toilet" style="font-size: 2.5rem; color: #f39c12;"></i>
                            </div>
                            <h4 style="color: #2c3e50; margin-bottom: 10px;">Toilet Umum</h4>
                            <p style="color: #555; font-size: 0.95rem;">Toilet bersih dan terawat untuk kenyamanan pengunjung</p>
                        </div>
                        
                        <div class="fasilitas-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s ease;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-utensils" style="font-size: 2.5rem; color: #e67e22;"></i>
                            </div>
                            <h4 style="color: #2c3e50; margin-bottom: 10px;">Warung Makan</h4>
                            <p style="color: #555; font-size: 0.95rem;">Warung makan dengan menu lokal dan seafood segar</p>
                        </div>
                        
                        <div class="fasilitas-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s ease;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-camera" style="font-size: 2.5rem; color: #9b59b6;"></i>
                            </div>
                            <h4 style="color: #2c3e50; margin-bottom: 10px;">Spot Foto</h4>
                            <p style="color: #555; font-size: 0.95rem;">Area foto dengan pemandangan mangrove yang indah</p>
                        </div>
                        
                        <div class="fasilitas-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s ease;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-user-tie" style="font-size: 2.5rem; color: #3498db;"></i>
                            </div>
                            <h4 style="color: #2c3e50; margin-bottom: 10px;">Pemandu Wisata</h4>
                            <p style="color: #555; font-size: 0.95rem;">Pemandu profesional untuk edukasi mangrove</p>
                        </div>
                        
                        <div class="fasilitas-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s ease;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-first-aid" style="font-size: 2.5rem; color: #e74c3c;"></i>
                            </div>
                            <h4 style="color: #2c3e50; margin-bottom: 10px;">P3K</h4>
                            <p style="color: #555; font-size: 0.95rem;">Kotak P3K untuk keamanan pengunjung</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- JADWAL SECTION -->
            <section class="section abuabu">
                <div class="container">
                    <h2 class="section-title">Jadwal & Informasi Kunjungan</h2>
                    <div class="jadwal-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px;">
                        <div class="jadwal-info" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <h3 style="color: #2c3e50; margin-bottom: 20px; text-align: center;">Jam Operasional</h3>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee;">
                                <span style="font-weight: 600; color: #2c3e50;">Senin - Jumat</span>
                                <span style="color: #555;">08:00 - 17:00 WIB</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee;">
                                <span style="font-weight: 600; color: #2c3e50;">Sabtu - Minggu</span>
                                <span style="color: #555;">07:00 - 18:00 WIB</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
                                <span style="font-weight: 600; color: #2c3e50;">Hari Libur Nasional</span>
                                <span style="color: #555;">07:00 - 18:00 WIB</span>
                            </div>
                        </div>
                        
                        <div class="harga-info" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <h3 style="color: #2c3e50; margin-bottom: 20px; text-align: center;">Harga Tiket</h3>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee;">
                                <span style="font-weight: 600; color: #2c3e50;">Dewasa</span>
                                <span style="color: #27ae60; font-weight: 600;">Rp 25.000</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee;">
                                <span style="font-weight: 600; color: #2c3e50;">Anak-anak (3-12 tahun)</span>
                                <span style="color: #27ae60; font-weight: 600;">Rp 15.000</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #eee;">
                                <span style="font-weight: 600; color: #2c3e50;">Pemandu Wisata</span>
                                <span style="color: #27ae60; font-weight: 600;">Rp 50.000</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
                                <span style="font-weight: 600; color: #2c3e50;">Parkir Motor</span>
                                <span style="color: #27ae60; font-weight: 600;">Gratis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TIPS SECTION -->
            <section class="section">
                <div class="container">
                    <h2 class="section-title">Tips Kunjungan</h2>
                    <div class="tips-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-top: 40px;">
                        <div class="tip-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-clock" style="font-size: 2rem;"></i>
                            </div>
                            <h4 style="margin-bottom: 10px;">Waktu Terbaik</h4>
                            <p style="font-size: 0.9rem; opacity: 0.9;">Kunjungi pagi hari (07:00-10:00) untuk melihat burung migrasi dan sore hari untuk sunset</p>
                        </div>
                        
                        <div class="tip-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-tshirt" style="font-size: 2rem;"></i>
                            </div>
                            <h4 style="margin-bottom: 10px;">Pakaian</h4>
                            <p style="font-size: 0.9rem; opacity: 0.9;">Gunakan pakaian nyaman, sepatu anti air, dan topi untuk melindungi dari sinar matahari</p>
                        </div>
                        
                        <div class="tip-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-camera" style="font-size: 2rem;"></i>
                            </div>
                            <h4 style="margin-bottom: 10px;">Fotografi</h4>
                            <p style="font-size: 0.9rem; opacity: 0.9;">Bawa kamera dengan lensa zoom untuk mengabadikan burung migrasi dari jarak jauh</p>
                        </div>
                        
                        <div class="tip-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 25px; border-radius: 15px; text-align: center;">
                            <div style="margin-bottom: 15px;">
                                <i class="fas fa-leaf" style="font-size: 2rem;"></i>
                            </div>
                            <h4 style="margin-bottom: 10px;">Konservasi</h4>
                            <p style="font-size: 0.9rem; opacity: 0.9;">Jangan merusak ekosistem mangrove dan jaga kebersihan lingkungan</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TESTIMONIAL SECTION -->
            <section class="section abuabu">
                <div class="container">
                    <h2 class="section-title">Testimoni Pengunjung</h2>
                    
                    <!-- Form Testimonial untuk Pengunjung -->
                    <div class="testimonial-form-container" style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                        <h3 style="color: #2c3e50; margin-bottom: 20px; text-align: center;">Bagikan Pengalaman Anda</h3>
                        
                        <?php if (isset($_SESSION['success_message'])): ?>
                            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success_message']) ?>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['error_message']) ?>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>
                        <form action="submit_testimonial.php" method="POST" style="max-width: 600px; margin: 0 auto;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                <div>
                                    <label for="nama" style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Nama Lengkap *</label>
                                    <input type="text" id="nama" name="nama" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                                </div>
                                <div>
                                    <label for="profesi" style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Profesi *</label>
                                    <input type="text" id="profesi" name="profesi" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                                </div>
                            </div>
                            
                            <div style="margin-bottom: 20px;">
                                <label for="testimoni" style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Testimoni *</label>
                                <textarea id="testimoni" name="testimoni" required rows="4" placeholder="Bagikan pengalaman Anda mengunjungi Pantai Sejarah..." style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
                            </div>
                            
                            <div style="margin-bottom: 20px;">
                                <label for="rating" style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Rating *</label>
                                <select id="rating" name="rating" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                                    <option value="">Pilih rating</option>
                                    <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Baik)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 - Baik)</option>
                                    <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                                    <option value="2">⭐⭐ (2 - Kurang)</option>
                                    <option value="1">⭐ (1 - Sangat Kurang)</option>
                                </select>
                            </div>
                            
                            <div style="text-align: center;">
                                <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: transform 0.3s ease;">
                                    <i class="fas fa-paper-plane"></i> Kirim Testimoni
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="testimonial-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px;">
                        <?php
                        $testimonials = $conn->query("SELECT * FROM testimonial_pantai_sejarah WHERE status = 'active' ORDER BY created_at DESC LIMIT 3");
                        $gradients = [
                            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
                        ];
                        $gradient_index = 0;
                        
                        while ($testimonial = $testimonials->fetch_assoc()):
                        ?>
                        <div class="testimonial-card" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <div style="display: flex; align-items: center; margin-bottom: 20px;">
                                <?php if ($testimonial['avatar']): ?>
                                    <img src="<?= htmlspecialchars($testimonial['avatar']) ?>" alt="<?= htmlspecialchars($testimonial['nama']) ?>" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 15px;">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; background: <?= $gradients[$gradient_index % count($gradients)] ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                        <i class="fas fa-user" style="color: white; font-size: 1.5rem;"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <h4 style="color: #2c3e50; margin: 0;"><?= htmlspecialchars($testimonial['nama']) ?></h4>
                                    <p style="color: #7f8c8d; margin: 0; font-size: 0.9rem;"><?= htmlspecialchars($testimonial['profesi']) ?></p>
                                </div>
                            </div>
                            <p style="color: #555; line-height: 1.6; font-style: italic;">"<?= htmlspecialchars($testimonial['testimoni']) ?>"</p>
                            <div style="margin-top: 15px;">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa<?= $i <= $testimonial['rating'] ? 's' : 'r' ?> fa-star" style="color: #f39c12;"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php 
                        $gradient_index++;
                        endwhile; 
                        ?>
                    </div>
                </div>
            </section>

            <!-- GALERI FOTO SECTION -->
            <section class="section">
                <div class="container">
                    <h2 class="section-title">Galeri Foto Pantai Sejarah</h2>
                    <div class="galeri-foto-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 40px;">
                        <div class="foto-item" style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <img src="asset/foto1.jpg" alt="Taman Edukasi Mangrove" style="width: 100%; height: 200px; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 15px;">
                                <h4 style="margin: 0; font-size: 1rem;">Taman Edukasi Mangrove</h4>
                            </div>
                        </div>
                        
                        <div class="foto-item" style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <img src="asset/foto2.jpg" alt="Burung Migrasi" style="width: 100%; height: 200px; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 15px;">
                                <h4 style="margin: 0; font-size: 1rem;">Burung Migrasi</h4>
                            </div>
                        </div>
                        
                        <div class="foto-item" style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <img src="asset/foto3.jpg" alt="Jalur Tracking" style="width: 100%; height: 200px; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 15px;">
                                <h4 style="margin: 0; font-size: 1rem;">Jalur Tracking</h4>
                            </div>
                        </div>
                        
                        <div class="foto-item" style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <img src="asset/foto4.jpg" alt="Menara Pengamatan" style="width: 100%; height: 200px; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 15px;">
                                <h4 style="margin: 0; font-size: 1rem;">Menara Pengamatan</h4>
                            </div>
                        </div>
                        
                        <div class="foto-item" style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <img src="asset/foto5.jpg" alt="Sunset View" style="width: 100%; height: 200px; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 15px;">
                                <h4 style="margin: 0; font-size: 1rem;">Sunset View</h4>
                            </div>
                        </div>
                        
                        <div class="foto-item" style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <img src="asset/foto6.jpg" alt="Ekosistem Mangrove" style="width: 100%; height: 200px; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 15px;">
                                <h4 style="margin: 0; font-size: 1rem;">Ekosistem Mangrove</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA SECTION -->
            <section class="cta-section">
                <div class="container">
                    <div class="cta-content">
                        <h2>Siap Menjelajahi Pantai Sejarah?</h2>
                        <p>Jangan lewatkan pengalaman edukasi mangrove dan pengamatan burung migrasi yang menakjubkan</p>
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