<?php
include 'koneksi.php';

// Ambil ID produk dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Location: produk.php');
    exit;
}

// Ambil data produk
$stmt = $conn->prepare("SELECT * FROM produk_umkm WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

if (!$produk) {
    header('Location: produk.php');
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produk['nama_produk']) ?> - Detail Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="asset/logo.png" alt="Logo">
                <span>KUTAKU</span>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="sejarah.php">Sejarah</a></li>
                <li><a href="galeri.php">Galeri</a></li>
                <li><a href="produk.php">Produk</a></li>
                <li><a href="contact.php">Kontak</a></li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- Detail Produk Section -->
    <section class="detail-produk-section">
        <div class="container">
            <div class="detail-produk-content">
                <div class="detail-produk-image">
                    <img src="<?= !empty($produk['gambar']) ? htmlspecialchars($produk['gambar']) : 'asset/default-product.jpg' ?>" 
                         alt="<?= htmlspecialchars($produk['nama_produk']) ?>">
                </div>
                <div class="detail-produk-info">
                    <div class="breadcrumb">
                        <a href="produk.php"><i class="fas fa-arrow-left"></i> Kembali ke Produk</a>
                    </div>
                    <h1><?= htmlspecialchars($produk['nama_produk']) ?></h1>
                    <div class="produk-harga-detail">
                        <span class="harga">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span>
                    </div>
                    <div class="produk-deskripsi-detail">
                        <h3>Deskripsi Produk</h3>
                        <p><?= nl2br(htmlspecialchars($produk['deskripsi'] ?? '')) ?></p>
                    </div>
                    <div class="produk-actions-detail">
                        <?php if (!empty($produk['nomor_wa'])): ?>
                            <a href="https://wa.me/<?= htmlspecialchars($produk['nomor_wa']) ?>?text=Halo, saya tertarik dengan produk <?= urlencode($produk['nama_produk']) ?>" 
                               target="_blank" 
                               class="btn-whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                Pesan via WhatsApp
                            </a>
                        <?php else: ?>
                            <a href="https://wa.me/6281234567890?text=Halo, saya tertarik dengan produk <?= urlencode($produk['nama_produk']) ?>" 
                               target="_blank" 
                               class="btn-whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                Pesan via WhatsApp
                            </a>
                        <?php endif; ?>
                        <a href="produk.php" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Lihat Produk Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>KUTAKU</h3>
                    <p>Membangun masa depan yang lebih baik melalui inovasi dan teknologi.</p>
                </div>
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@kutaku.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Contoh No. 123, Kota</p>
                </div>
                <div class="footer-section">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 KUTAKU. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="javascript.js"></script>
</body>
</html> 