# Sistem Testimonial Pantai Sejarah

## Deskripsi
Sistem testimonial yang memungkinkan pengunjung untuk memberikan testimoni tentang pengalaman mereka mengunjungi Pantai Sejarah. Testimonial akan ditinjau oleh admin sebelum dipublikasikan.

## Fitur
1. **Form Testimonial untuk Pengunjung**
   - Input nama lengkap
   - Input profesi
   - Text area untuk testimoni
   - Rating 1-5 bintang
   - Upload foto profil (opsional)

2. **Admin Dashboard Terintegrasi**
   - Melihat semua testimonial (pending, active, rejected)
   - Menyetujui/menolak testimonial
   - Menghapus testimonial
   - Filter berdasarkan status
   - Statistik testimonial pending di dashboard utama

3. **Validasi dan Keamanan**
   - Validasi input
   - Sanitasi data
   - Upload file yang aman
   - Session management

## File yang Dibuat/Dimodifikasi

### File Baru:
- `submit_testimonial.php` - Memproses form testimonial
- `create_testimonial_table.sql` - SQL untuk membuat tabel
- `sample_testimonials.sql` - Data testimonial contoh

### File yang Dimodifikasi:
- `pantai-sejarah.php` - Menambahkan form testimonial
- `detail_produk.php` - Memperbaiki navbar
- `admin_dashboard.php` - Mengintegrasikan sistem testimonial
- `website.sql` - Menambahkan struktur tabel testimonial

## Cara Penggunaan

### 1. Setup Database
Jalankan query SQL berikut di database:
```sql
-- Buat tabel testimonial
CREATE TABLE IF NOT EXISTS `testimonial_pantai_sejarah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `profesi` varchar(100) NOT NULL,
  `testimoni` text NOT NULL,
  `rating` int(1) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('pending','active','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### 2. Pengunjung
1. Buka halaman `pantai-sejarah.php`
2. Scroll ke bagian "Testimoni Pengunjung"
3. Isi form testimonial
4. Klik "Kirim Testimoni"
5. Testimonial akan masuk ke status "pending"

### 3. Admin
1. Login ke admin dashboard
2. Lihat statistik testimonial pending di dashboard utama
3. Klik menu "Testimonial"
4. Kelola testimonial (setujui/tolak/hapus)
5. Gunakan filter untuk melihat testimonial berdasarkan status

## Struktur Database

### Tabel: `testimonial_pantai_sejarah`
- `id` - Primary key
- `nama` - Nama lengkap pengunjung
- `profesi` - Profesi pengunjung
- `testimoni` - Isi testimonial
- `rating` - Rating 1-5 bintang
- `avatar` - Path file foto profil (opsional)
- `status` - Status testimonial (pending/active/rejected)
- `created_at` - Waktu testimonial dibuat

## Keamanan
- Input validation dan sanitization
- File upload validation (hanya gambar, max 5MB)
- Prepared statements untuk mencegah SQL injection
- Session management untuk admin

## Responsive Design
- Form testimonial responsive di mobile
- Admin dashboard responsive
- Filter testimonial yang mudah digunakan

## Fitur Dashboard Admin
- **Statistik**: Menampilkan jumlah testimonial pending di dashboard utama
- **Filter**: Filter testimonial berdasarkan status (Semua, Pending, Disetujui, Ditolak)
- **Aksi**: Setujui, Tolak, atau Hapus testimonial
- **Tampilan**: Card-based layout yang modern dan mudah dibaca

## Catatan
- Testimonial dengan status "active" akan ditampilkan di halaman pantai-sejarah
- Testimonial dengan status "pending" hanya bisa dilihat admin
- Testimonial dengan status "rejected" tidak akan ditampilkan
- File avatar akan disimpan di folder `uploads/`
- Sistem terintegrasi dalam satu admin dashboard (tidak ada halaman terpisah) 