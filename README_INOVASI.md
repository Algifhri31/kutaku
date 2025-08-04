# Sistem Inovasi KUTAKU

## Overview
Sistem inovasi KUTAKU memungkinkan admin untuk mengelola konten inovasi dalam 3 kategori: Pendidikan, Pertanian, dan Teknologi Terapan. Setiap kategori memiliki halaman sendiri dengan fitur upload gambar, galeri, dan detail lengkap.

## Fitur Utama

### 1. **Admin Dashboard**
- Menu dropdown "Inovasi" dengan 3 sub-menu:
  - Pendidikan
  - Pertanian  
  - Teknologi Terapan
- CRUD (Create, Read, Update, Delete) untuk setiap kategori
- Upload gambar dengan preview
- Validasi form
- Pesan sukses/error

### 2. **Halaman Publik**
- **Halaman Kategori**: `inovasi_pendidikan.php`, `inovasi_pertanian.php`, `inovasi_teknologi.php`
- **Halaman Detail**: `detail_inovasi.php`
- Grid responsive dengan hover effects
- Breadcrumb navigation
- Related content sidebar

### 3. **Database**
- Table `inovasi` dengan struktur:
  - `id` (Primary Key, Auto Increment)
  - `kategori` (enum: 'pendidikan', 'pertanian', 'teknologi')
  - `judul` (varchar 255)
  - `deskripsi` (text)
  - `gambar` (varchar 255, nullable)
  - `tanggal` (date)
  - `status` (enum: 'active', 'inactive')
  - `created_at` (datetime)

## File yang Dibuat/Dimodifikasi

### File Baru:
1. **`inovasi_pendidikan.php`** - Halaman inovasi pendidikan
2. **`inovasi_pertanian.php`** - Halaman inovasi pertanian  
3. **`inovasi_teknologi.php`** - Halaman inovasi teknologi terapan
4. **`detail_inovasi.php`** - Halaman detail inovasi
5. **`navbar.php`** - Komponen navbar konsisten
6. **`footer.php`** - Komponen footer konsisten
7. **`README_INOVASI.md`** - Dokumentasi ini

### File Dimodifikasi:
1. **`admin_dashboard.php`** - Tambah logika CRUD inovasi
2. **`index.php`** - Hapus section "Layanan Wisata Kami", update dropdown inovasi
3. **`style.css`** - Tambah CSS untuk hover effects dan responsive
4. **`website.sql`** - Tambah table inovasi

## Cara Penggunaan

### Admin:
1. Login ke admin dashboard
2. Pilih menu "Inovasi" → pilih kategori
3. Klik "Tambah Inovasi" untuk menambah konten baru
4. Isi form: judul, deskripsi, tanggal, upload gambar
5. Klik "Tambah Inovasi" untuk menyimpan
6. Untuk edit/hapus, gunakan tombol aksi di tabel

### Pengunjung:
1. Dari navbar: "Tentang" → "Pengembangan Inovasi" → pilih kategori
2. Atau langsung akses: `inovasi_pendidikan.php`, `inovasi_pertanian.php`, `inovasi_teknologi.php`
3. Klik card inovasi untuk melihat detail
4. Di halaman detail, ada sidebar dengan inovasi terkait

## Struktur URL

### Admin:
- `admin_dashboard.php?page=inovasi-pendidikan`
- `admin_dashboard.php?page=inovasi-pertanian`
- `admin_dashboard.php?page=inovasi-teknologi`

### Publik:
- `inovasi_pendidikan.php`
- `inovasi_pertanian.php`
- `inovasi_teknologi.php`
- `detail_inovasi.php?id={id}`

## Database Schema

```sql
CREATE TABLE `inovasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` enum('pendidikan','pertanian','teknologi') NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

## Fitur Responsive

- Grid layout menyesuaikan ukuran layar
- Mobile-friendly navigation
- Touch-friendly buttons
- Optimized images dengan object-fit
- Responsive typography

## Keamanan

- Prepared statements untuk mencegah SQL injection
- Validasi input di server-side
- Sanitasi output dengan htmlspecialchars()
- Validasi file upload (hanya gambar)
- Session management untuk admin

## Maintenance

### Backup Database:
```bash
mysqldump -u username -p database_name > backup.sql
```

### Upload File:
- File gambar disimpan di folder `uploads/`
- Nama file: `timestamp_filename.ext`
- Format yang didukung: jpg, jpeg, png, gif
- Maksimal ukuran: 5MB

### Troubleshooting:
1. **Gambar tidak muncul**: Cek path file dan permission folder uploads
2. **Form tidak submit**: Cek koneksi database dan error log
3. **Menu tidak muncul**: Pastikan sudah login sebagai admin

## Update Terbaru

- ✅ Hapus section "Layanan Wisata Kami" dari homepage
- ✅ Buat 3 halaman inovasi terpisah
- ✅ Integrasi dengan admin dashboard
- ✅ Fitur upload gambar
- ✅ Halaman detail dengan related content
- ✅ Responsive design
- ✅ Breadcrumb navigation
- ✅ Hover effects pada cards 