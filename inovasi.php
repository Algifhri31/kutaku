<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inovasi Pendidikan - Pengembangan Inovasi</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <main>
        <section class="section">
            <div class="container">
                <h2 class="section-title">Inovasi</h2>
                                <p class="section-desc" style="text-align:center; max-width:700px; margin:0 auto 32px auto;">Jelajahi berbagai inovasi dalam bidang pendidikan, pertanian, dan teknologi terapan yang dikembangkan untuk memajukan masyarakat dan lingkungan.</p>
                <div class="inovasi-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 32px; margin-top: 40px;">
                    <?php
                    // Mengambil semua inovasi yang aktif dari berbagai kategori
                    $inovasi_list = $conn->query("SELECT * FROM inovasi ORDER BY tanggal_dibuat DESC");
                    if ($inovasi_list->num_rows > 0):
                        while ($inovasi = $inovasi_list->fetch_assoc()):
                            // Menentukan ikon berdasarkan kategori inovasi
                            $icon_class = 'fa-solid fa-lightbulb'; // Ikon default
                            if ($inovasi['kategori'] == 'pendidikan') {
                                $icon_class = 'fa-solid fa-book-open';
                            } elseif ($inovasi['kategori'] == 'pertanian') {
                                $icon_class = 'fa-solid fa-seedling';
                            } elseif ($inovasi['kategori'] == 'teknologi terapan') {
                                $icon_class = 'fa-solid fa-cogs';
                            }
                    ?>
                        <div class="inovasi-card" style="background: #fff; border-radius: 14px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); padding: 25px; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <div style="font-size:3rem; color:#2563eb; margin-bottom:18px;"><i class="<?= $icon_class ?>"></i></div>
                                <?php if ($inovasi['gambar']): ?>
                                    <img src="uploads/<?= htmlspecialchars($inovasi['gambar']) ?>" alt="<?= htmlspecialchars($inovasi['judul']) ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
                                <?php endif; ?>
                                <h3 style="font-size:1.2rem; font-weight:700; margin-bottom:10px; color:#333;"><?= htmlspecialchars($inovasi['judul']) ?></h3>
                                <p style="color:#666; margin-bottom:15px; font-size:0.95rem;"><?= htmlspecialchars(substr($inovasi['deskripsi'], 0, 120)) ?><?= strlen($inovasi['deskripsi']) > 120 ? '...' : '' ?></p>
                            </div>
                            <div style="color:#777; font-size:0.85rem; margin-top: 15px;">
                                <?= date('d/m/Y', strtotime($inovasi['tanggal_dibuat'])) ?>
                            </div>
                            <a href="detail_inovasi.php?id=<?= $inovasi['id'] ?>" class="btn-primary" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: background 0.3s ease;">Lihat Detail</a>
                        </div>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <div class="inovasi-card" style="background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(44,62,80,0.10); padding: 32px 18px 28px 18px; text-align: center; grid-column: 1 / -1;">
                            <div style="font-size:2.5rem; color:#2563eb; margin-bottom:18px;"><i class="fa-solid fa-lightbulb"></i></div>
                            <h3 style="font-size:1.1rem; font-weight:700; margin-bottom:10px;">Belum Ada Inovasi</h3>
                            <p style="color:#555;">Inovasi baru akan segera ditambahkan. Silakan kunjungi halaman ini lagi nanti.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

            </div>
            <div style="text-align: center; margin-bottom: 50px">
                        <a href="index.php" class="btn-back-home"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
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
    <script src="javascript.js"></script>
</body>
</html>