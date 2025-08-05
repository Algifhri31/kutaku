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

    <script src="javascript.js"></script>
</body>
</html>