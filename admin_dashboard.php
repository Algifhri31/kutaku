<?php
session_start();
include 'koneksi.php';

// Get page and action
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? '';

// Process all form submissions and redirects BEFORE any HTML output
if ($page == 'berita') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_berita'])) {
        $judul = $_POST['judul'];
        $draft = $_POST['draft'];
        $penulis = $_POST['penulis'];
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO berita (judul, draft, penulis, gambar) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $judul, $draft, $penulis, $target_file);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Berita berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan berita.";
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Gagal mengupload gambar.";
        }
        header('Location: admin_dashboard.php?page=berita');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_berita'])) {
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $draft = $_POST['draft'];
        $penulis = $_POST['penulis'];
        $gambar = $_POST['gambar_lama'];
        
        if (!empty($_FILES['gambar']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        }
        
        $stmt = $conn->prepare("UPDATE berita SET judul=?, draft=?, penulis=?, gambar=? WHERE id=?");
        $stmt->bind_param("ssssi", $judul, $draft, $penulis, $target_file, $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Berita berhasil diupdate!";
        } else {
            $_SESSION['error'] = "Gagal update berita.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=berita');
        exit;
    }
    
    if ($action=='hapus' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = $conn->query("SELECT gambar FROM berita WHERE id=$id");
        if ($q && $row = $q->fetch_assoc()) {
            if (!empty($row['gambar']) && file_exists($row['gambar'])) unlink($row['gambar']);
        }
        $conn->query("DELETE FROM berita WHERE id=$id");
        $_SESSION['message'] = "Berita berhasil dihapus.";
        header('Location: admin_dashboard.php?page=berita');
        exit;
    }
}

if ($page == 'inovasi') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_inovasi'])) {
        $judul = $_POST['judul_inovasi'];
        $deskripsi = $_POST['deskripsi_inovasi'];
        $penulis = $_POST['penulis_inovasi'];
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_inovasi"]["name"]);
        
        if (move_uploaded_file($_FILES["gambar_inovasi"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO inovasi (judul, deskripsi, penulis, gambar) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $judul, $deskripsi, $penulis, $target_file);
            if ($stmt->execute()) {
                $_SESSION['message_inovasi'] = "Inovasi berhasil ditambahkan!";
            } else {
                $_SESSION['error_inovasi'] = "Gagal menambahkan inovasi.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_inovasi'] = "Gagal mengupload gambar.";
        }
        header('Location: admin_dashboard.php?page=inovasi');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_inovasi'])) {
        $id = $_POST['id'];
        $judul = $_POST['judul_inovasi'];
        $deskripsi = $_POST['deskripsi_inovasi'];
        $penulis = $_POST['penulis_inovasi'];
        $gambar = $_POST['gambar_lama'];
        
        if (!empty($_FILES['gambar_inovasi']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_inovasi"]["name"]);
            move_uploaded_file($_FILES["gambar_inovasi"]["tmp_name"], $target_file);
        }
        
        $stmt = $conn->prepare("UPDATE inovasi SET judul=?, deskripsi=?, penulis=?, gambar=? WHERE id=?");
        $stmt->bind_param("ssssi", $judul, $deskripsi, $penulis, $target_file, $id);
        if ($stmt->execute()) {
            $_SESSION['message_inovasi'] = "Inovasi berhasil diupdate!";
        } else {
            $_SESSION['error_inovasi'] = "Gagal update inovasi.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=inovasi');
        exit;
    }
    
    if ($action=='hapus' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = $conn->query("SELECT gambar FROM inovasi WHERE id=$id");
        if ($q && $row = $q->fetch_assoc()) {
            if (!empty($row['gambar']) && file_exists($row['gambar'])) unlink($row['gambar']);
        }
        $conn->query("DELETE FROM inovasi WHERE id=$id");
        $_SESSION['message_inovasi'] = "Inovasi berhasil dihapus.";
        header('Location: admin_dashboard.php?page=inovasi');
        exit;
    }
}

if ($page == 'sejarah') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_sejarah'])) {
        $sejarah = $_POST['sejarah'];
        $conn->query("UPDATE sejarah SET konten='$sejarah' WHERE id=1");
        $_SESSION['message_sejarah'] = "Sejarah berhasil diupdate!";
        header('Location: admin_dashboard.php?page=sejarah');
        exit;
    }
}

if ($page == 'galeri') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_galeri'])) {
        $judul = $_POST['judul_galeri'];
        $deskripsi = $_POST['deskripsi_galeri'];
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_galeri"]["name"]);
        
        if (move_uploaded_file($_FILES["gambar_galeri"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO galeri (judul, deskripsi, gambar) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $judul, $deskripsi, $target_file);
            if ($stmt->execute()) {
                $_SESSION['message_galeri'] = "Foto galeri berhasil ditambahkan!";
            } else {
                $_SESSION['error_galeri'] = "Gagal menambahkan foto galeri.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_galeri'] = "Gagal mengupload gambar.";
        }
        header('Location: admin_dashboard.php?page=galeri');
        exit;
    }
    
    if ($action=='hapus' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = $conn->query("SELECT gambar FROM galeri WHERE id=$id");
        if ($q && $row = $q->fetch_assoc()) {
            if (!empty($row['gambar']) && file_exists($row['gambar'])) unlink($row['gambar']);
        }
        $conn->query("DELETE FROM galeri WHERE id=$id");
        $_SESSION['message_galeri'] = "Foto galeri berhasil dihapus.";
        header('Location: admin_dashboard.php?page=galeri');
        exit;
    }
    
    if ($action=='edit' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = $conn->query("SELECT * FROM galeri WHERE id=$id");
        if ($q && $row = $q->fetch_assoc()) {
            $edit_galeri = $row;
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_galeri'])) {
        $id = $_POST['id'];
        $judul = $_POST['judul_galeri'];
        $deskripsi = $_POST['deskripsi_galeri'];
        $gambar = $_POST['gambar_lama'];
        
        if (!empty($_FILES['gambar_galeri']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_galeri"]["name"]);
            if (move_uploaded_file($_FILES["gambar_galeri"]["tmp_name"], $target_file)) {
                $gambar = $target_file;
            }
        }
        
        $stmt = $conn->prepare("UPDATE galeri SET judul=?, deskripsi=?, gambar=? WHERE id=?");
        $stmt->bind_param("sssi", $judul, $deskripsi, $gambar, $id);
        if ($stmt->execute()) {
            $_SESSION['message_galeri'] = "Foto galeri berhasil diupdate!";
        } else {
            $_SESSION['error_galeri'] = "Gagal update foto galeri.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=galeri');
        exit;
    }
}

if ($page == 'preview-galeri') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_preview'])) {
        $judul = $_POST['judul_preview'];
        $deskripsi = $_POST['deskripsi_preview'];
        $urutan = $_POST['urutan_preview'];
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_preview"]["name"]);
        
        if (move_uploaded_file($_FILES["gambar_preview"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO preview_galeri (judul, deskripsi, gambar, urutan) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $judul, $deskripsi, $target_file, $urutan);
            if ($stmt->execute()) {
                $_SESSION['message_preview'] = "Foto preview berhasil ditambahkan!";
            } else {
                $_SESSION['error_preview'] = "Gagal menyimpan foto preview.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_preview'] = "Gagal mengupload foto.";
        }
        header('Location: admin_dashboard.php?page=preview-galeri');
        exit;
    }
    
    if ($action=='hapus' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = $conn->query("SELECT gambar FROM preview_galeri WHERE id=$id");
        if ($q && $row = $q->fetch_assoc()) {
            if (!empty($row['gambar']) && file_exists($row['gambar'])) unlink($row['gambar']);
        }
        $conn->query("DELETE FROM preview_galeri WHERE id=$id");
        $_SESSION['message_preview'] = "Foto preview berhasil dihapus.";
        header('Location: admin_dashboard.php?page=preview-galeri');
        exit;
    }
}

if ($page == 'kontak') {
    if ($action=='update_status' && isset($_GET['id']) && isset($_GET['status'])) {
        $id = intval($_GET['id']);
        $status = $_GET['status'];
        if (in_array($status, ['unread', 'read', 'replied'])) {
            $stmt = $conn->prepare("UPDATE pesan_kontak SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $id);
            if ($stmt->execute()) {
                $_SESSION['message_kontak'] = "Status pesan berhasil diupdate!";
            } else {
                $_SESSION['error_kontak'] = "Gagal update status pesan.";
            }
            $stmt->close();
        }
        header('Location: admin_dashboard.php?page=kontak');
        exit;
    }
    
    if ($action=='hapus' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $conn->query("DELETE FROM pesan_kontak WHERE id=$id");
        $_SESSION['message_kontak'] = "Pesan berhasil dihapus.";
        header('Location: admin_dashboard.php?page=kontak');
        exit;
    }
}

if ($page == 'produk-umkm') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_produk'])) {
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $nomor_wa = $_POST['nomor_wa'];
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // Bersihkan harga dari karakter non-numerik kecuali titik dan koma
            $harga = preg_replace('/[^0-9.,]/', '', $harga);
            $harga = str_replace(',', '.', $harga);
            
            // Bersihkan nomor WhatsApp dari karakter non-numerik
            $nomor_wa = preg_replace('/[^0-9]/', '', $nomor_wa);
            
            $stmt = $conn->prepare("INSERT INTO produk_umkm (nama_produk, deskripsi, harga, nomor_wa, gambar) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $nama_produk, $deskripsi, $harga, $nomor_wa, $target_file);
            if ($stmt->execute()) {
                $_SESSION['message_umkm'] = "Produk berhasil ditambahkan!";
            } else {
                $_SESSION['error_umkm'] = "Gagal menambahkan produk.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_umkm'] = "Gagal mengupload gambar.";
        }
        header('Location: admin_dashboard.php?page=produk-umkm');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_produk'])) {
        $id = $_POST['id'];
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $nomor_wa = $_POST['nomor_wa'];
        $gambar_path = $_POST['gambar_lama'];

        if (!empty($_FILES['gambar']['name'])) {
            $target_dir = "uploads/";
            $new_gambar_path = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $new_gambar_path)) {
                if (!empty($gambar_path) && file_exists($gambar_path)) {
                    unlink($gambar_path);
                }
                $gambar_path = $new_gambar_path;
            }
        }

        // Bersihkan harga dari karakter non-numerik kecuali titik dan koma
        $harga = preg_replace('/[^0-9.,]/', '', $harga);
        $harga = str_replace(',', '.', $harga);
        
        // Bersihkan nomor WhatsApp dari karakter non-numerik
        $nomor_wa = preg_replace('/[^0-9]/', '', $nomor_wa);
        
        $stmt = $conn->prepare("UPDATE produk_umkm SET nama_produk=?, deskripsi=?, harga=?, nomor_wa=?, gambar=? WHERE id=?");
        $stmt->bind_param("ssdssi", $nama_produk, $deskripsi, $harga, $nomor_wa, $gambar_path, $id);
        if ($stmt->execute()) {
            $_SESSION['message_umkm'] = "Produk berhasil diupdate!";
        } else {
            $_SESSION['error_umkm'] = "Gagal update produk.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=produk-umkm');
        exit;
    }
    
    // CRUD untuk Objek Wisata
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_wisata'])) {
        $nama_wisata = $_POST['nama_wisata'];
        $deskripsi = $_POST['deskripsi'];
        $urutan = $_POST['urutan'];
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO objek_wisata (nama_wisata, deskripsi, gambar, urutan) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $nama_wisata, $deskripsi, $target_file, $urutan);
            if ($stmt->execute()) {
                $_SESSION['message_wisata'] = "Objek wisata berhasil ditambahkan!";
            } else {
                $_SESSION['error_wisata'] = "Gagal menambahkan objek wisata.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_wisata'] = "Gagal mengupload gambar.";
        }
        header('Location: admin_dashboard.php?page=objek-wisata');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_wisata'])) {
        $id = $_POST['id'];
        $nama_wisata = $_POST['nama_wisata'];
        $deskripsi = $_POST['deskripsi'];
        $urutan = $_POST['urutan'];
        $gambar_path = $_POST['gambar_lama'];

        if (!empty($_FILES['gambar']['name'])) {
            $target_dir = "uploads/";
            $new_gambar_path = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $new_gambar_path)) {
                if (!empty($gambar_path) && file_exists($gambar_path)) {
                    unlink($gambar_path);
                }
                $gambar_path = $new_gambar_path;
            }
        }
        
        $stmt = $conn->prepare("UPDATE objek_wisata SET nama_wisata=?, deskripsi=?, gambar=?, urutan=? WHERE id=?");
        $stmt->bind_param("sssii", $nama_wisata, $deskripsi, $gambar_path, $urutan, $id);
        if ($stmt->execute()) {
            $_SESSION['message_wisata'] = "Objek wisata berhasil diupdate!";
        } else {
            $_SESSION['error_wisata'] = "Gagal update objek wisata.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=objek-wisata');
        exit;
    }
    
    if ($action=='hapus' && isset($_GET['id']) && $page == 'objek-wisata') {
        $id = intval($_GET['id']);
        $q = $conn->query("SELECT gambar FROM objek_wisata WHERE id=$id");
        if ($q && $row = $q->fetch_assoc()) {
            if (!empty($row['gambar']) && file_exists($row['gambar'])) unlink($row['gambar']);
        }
        $conn->query("DELETE FROM objek_wisata WHERE id=$id");
        $_SESSION['message_wisata'] = "Objek wisata berhasil dihapus.";
        header('Location: admin_dashboard.php?page=objek-wisata');
        exit;
    }
    
    if ($action=='hapus' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = $conn->query("SELECT gambar FROM produk_umkm WHERE id=$id");
        if ($q && $row = $q->fetch_assoc()) {
            if (!empty($row['gambar']) && file_exists($row['gambar'])) unlink($row['gambar']);
        }
        $conn->query("DELETE FROM produk_umkm WHERE id=$id");
        $_SESSION['message_umkm'] = "Produk berhasil dihapus.";
        header('Location: admin_dashboard.php?page=produk-umkm');
        exit;
    }
}

// Pantai Sejarah Management
if ($page == 'pantai-sejarah') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_section'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_POST['image_lama'];
        
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file;
            }
        }
        
        $stmt = $conn->prepare("UPDATE pantai_sejarah SET title=?, content=?, image=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $content, $image, $id);
        if ($stmt->execute()) {
            $_SESSION['message_pantai'] = "Section Pantai Sejarah berhasil diupdate!";
        } else {
            $_SESSION['error_pantai'] = "Gagal update section.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=pantai-sejarah');
        exit;
    }
}

// Testimonial Pantai Sejarah Management
if ($page == 'testimonial-pantai') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_testimonial'])) {
        $nama = $_POST['nama'];
        $profesi = $_POST['profesi'];
        $testimoni = $_POST['testimoni'];
        $rating = $_POST['rating'];
        $avatar = '';
        
        if (!empty($_FILES['avatar']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . time() . "_" . basename($_FILES["avatar"]["name"]);
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                $avatar = $target_file;
            }
        }
        
        $stmt = $conn->prepare("INSERT INTO testimonial_pantai_sejarah (nama, profesi, testimoni, rating, avatar) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $nama, $profesi, $testimoni, $rating, $avatar);
        if ($stmt->execute()) {
            $_SESSION['message_testimonial'] = "Testimonial berhasil ditambahkan!";
        } else {
            $_SESSION['error_testimonial'] = "Gagal menambahkan testimonial.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=testimonial-pantai');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_testimonial'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $profesi = $_POST['profesi'];
        $testimoni = $_POST['testimoni'];
        $rating = $_POST['rating'];
        $avatar = $_POST['avatar_lama'];
        
        if (!empty($_FILES['avatar']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . time() . "_" . basename($_FILES["avatar"]["name"]);
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                $avatar = $target_file;
            }
        }
        
        $stmt = $conn->prepare("UPDATE testimonial_pantai_sejarah SET nama=?, profesi=?, testimoni=?, rating=?, avatar=? WHERE id=?");
        $stmt->bind_param("sssisi", $nama, $profesi, $testimoni, $rating, $avatar, $id);
        if ($stmt->execute()) {
            $_SESSION['message_testimonial'] = "Testimonial berhasil diupdate!";
        } else {
            $_SESSION['error_testimonial'] = "Gagal update testimonial.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=testimonial-pantai');
        exit;
    }
    
    if ($action=='hapus' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $q = $conn->query("SELECT avatar FROM testimonial_pantai_sejarah WHERE id=$id");
        if ($q && $row = $q->fetch_assoc()) {
            if (!empty($row['avatar']) && file_exists($row['avatar'])) unlink($row['avatar']);
        }
        $conn->query("DELETE FROM testimonial_pantai_sejarah WHERE id=$id");
        $_SESSION['message_testimonial'] = "Testimonial berhasil dihapus.";
        header('Location: admin_dashboard.php?page=testimonial-pantai');
        exit;
    }
}

// Get edit data if needed
$edit_berita = null;
$edit_inovasi = null;
$edit_produk = null;
$edit_wisata = null;
$edit_testimonial = null;
if ($action == 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    if ($page == 'berita') {
        $q = $conn->query("SELECT * FROM berita WHERE id=$edit_id");
        $edit_berita = $q ? $q->fetch_assoc() : null;
    } elseif ($page == 'inovasi') {
        $q = $conn->query("SELECT * FROM inovasi WHERE id=$edit_id");
        $edit_inovasi = $q ? $q->fetch_assoc() : null;
    } elseif ($page == 'produk-umkm') {
        $q = $conn->query("SELECT * FROM produk_umkm WHERE id=$edit_id");
        $edit_produk = $q ? $q->fetch_assoc() : null;
    } elseif ($page == 'objek-wisata') {
        $q = $conn->query("SELECT * FROM objek_wisata WHERE id=$edit_id");
        $edit_wisata = $q ? $q->fetch_assoc() : null;
    } elseif ($page == 'testimonial-pantai') {
        $q = $conn->query("SELECT * FROM testimonial_pantai_sejarah WHERE id=$edit_id");
        $edit_testimonial = $q ? $q->fetch_assoc() : null;
    }
}

// Now start HTML output
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --background: #f5f6fa;
            --primary: #1a202c;
            --secondary: #2d3748;
            --text-primary: #e2e8f0;
            --text-secondary: #a0aec0;
            --accent: #2563eb;
            --accent-light: #dbeafe;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        body { 
            margin: 0; 
            background: var(--background); 
            font-family: 'Inter', sans-serif;
            color: var(--primary);
        }
        .admin-layout { 
            display: flex; 
            min-height: 100vh; 
        }
        .sidebar {
            width: 240px;
            background: var(--primary);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: sticky;
            top: 0;
            transition: transform 0.3s ease;
            z-index: 1001;
        }
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 8px 24px 8px;
            border-bottom: 1px solid var(--secondary);
        }
        .sidebar-header img {
            height: 40px;
        }
        .sidebar-header h3 {
            color: var(--text-primary);
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }
        .sidebar nav {
            flex-grow: 1;
            margin-top: 24px;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 12px 16px;
            margin-bottom: 8px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar a .fa-solid {
            margin-right: 16px;
            font-size: 1.125rem;
            width: 24px;
            text-align: center;
        }
        .sidebar a.active, .sidebar a:hover {
            background: var(--accent);
            color: var(--text-primary);
        }
        .sidebar-dropdown {
            position: relative;
        }
        .dropdown-toggle .dropdown-icon {
            margin-left: auto;
            transition: transform 0.2s;
        }
        .sidebar-dropdown.open .dropdown-toggle .dropdown-icon {
            transform: rotate(180deg);
        }
        .dropdown-menu {
            display: none;
            padding-left: 24px;
        }
        .sidebar-dropdown.open .dropdown-menu {
            display: block;
        }
        .dropdown-menu a {
            padding: 10px 16px;
            font-size: 0.95rem;
        }
        .dropdown-menu a.active {
            background: transparent;
            color: var(--accent);
            font-weight: 600;
        }
        .sidebar-footer {
            padding-top: 16px;
            border-top: 1px solid var(--secondary);
        }
        .main-content { 
            flex: 1; 
            padding: 24px 32px;
            overflow-y: auto;
        }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .menu-toggle { 
            display: none; 
            background: none; 
            border: none; 
            font-size: 1.5rem; 
            color: var(--primary); 
            cursor: pointer;
        }
        .topbar-title {
            font-size: 1.75rem;
            font-weight: 700;
        }
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .admin-profile .admin-name {
            font-weight: 600;
        }
        .logout-btn {
            background: var(--accent-light);
            color: var(--accent);
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .logout-btn:hover {
            background: #bfdbfe;
        }
        .card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid var(--border-color);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }
        .card-header h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .btn-primary {
            background: var(--accent);
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-secondary {
            background: var(--accent-light);
            color: var(--accent);
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .btn-secondary:hover {
            background: #bfdbfe;
        }
        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .btn-danger:hover {
            background: #fecaca;
        }
        label { 
            font-weight: 500; 
            color: var(--primary);
            margin-bottom: 8px;
            display: block;
        }
        input[type="text"], textarea, input[type="file"], input[type="number"] {
            width: 100%; 
            padding: 12px; 
            margin-bottom: 16px;
            border: 1px solid var(--border-color); 
            border-radius: 8px; 
            background: var(--background);
            font-size: 1rem; 
            transition: border-color 0.2s, box-shadow 0.2s;
            color: var(--primary);
            box-sizing: border-box;
        }
        input[type="text"]:focus, textarea:focus, input[type="number"]:focus { 
            border-color: var(--accent); 
            outline: none; 
            box-shadow: 0 0 0 3px var(--accent-light);
        }
        button[type="submit"] {
            background: var(--accent);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #1d4ed8;
        }
        .message { 
            text-align: center; 
            margin-bottom: 18px; 
            padding: 12px; 
            border-radius: 8px; 
            font-weight: 500;
        }
        .message.error { 
            background: #fee2e2; 
            color: #b91c1c; 
            border: 1px solid #fecaca; 
        }
        .message.success { 
            background: #dcfce7; 
            color: #166534; 
            border: 1px solid #bbf7d0; 
        }
        .admin-table {
            width: 100%; 
            border-collapse: collapse;
            font-size: 1rem;
        }
        .admin-table th, .admin-table td { 
            padding: 16px; 
            border-bottom: 1px solid var(--border-color);
            text-align: left;
            vertical-align: middle;
        }
        .admin-table th {
            background: #f9fafb;
            color: var(--text-secondary); 
            font-weight: 600; 
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .admin-table tbody tr:hover { 
            background: #f9fafb; 
        }
        .admin-table img { 
            height: 48px; 
            width: 72px;
            object-fit: cover;
            border-radius: 6px; 
        }
        .admin-table .aksi {
            display: flex;
            gap: 8px;
        }
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }
        .dashboard-card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            padding: 24px;
            gap: 16px;
            border: 1px solid var(--border-color);
        }
        .dashboard-card .icon {
            font-size: 1.75rem;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .dashboard-card.blue .icon { background: var(--accent-light); color: var(--accent); }
        .dashboard-card.green .icon { background: #dcfce7; color: #16a34a; }
        .dashboard-card.red .icon { background: #fee2e2; color: #dc2626; }
        .dashboard-card .info .count {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }
        .dashboard-card .info .label {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-top: 2px;
        }
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
        }
        .status-unread { background-color: #fee2e2; color: #991b1b; }
        .status-read { background-color: #dbeafe; color: #1e40af; }
        .status-replied { background-color: #dcfce7; color: #15803d; }

        .berita-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .berita-thumb {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .berita-judul {
            font-weight: 600;
            margin-bottom: 4px;
        }
        .berita-draft {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
        .berita-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }
        .berita-card-item {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
        }
        .berita-card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .berita-card-link {
            text-decoration: none;
            color: inherit;
            flex-grow: 1;
        }
        .berita-card-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .berita-card-content {
            padding: 16px;
        }
        .berita-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 8px 0;
        }
        .berita-card-excerpt {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.5;
            margin: 0 0 16px 0;
        }
        .berita-card-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }
        .berita-card-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .berita-card-actions {
            padding: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 8px;
        }
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 48px;
        }
        .empty-state i {
            font-size: 3rem;
            color: var(--border-color);
        }
        .empty-state p {
            margin-top: 16px;
            color: var(--text-secondary);
        }
        .modern-form .form-group {
            margin-bottom: 24px;
        }
        .modern-form .form-actions {
            margin-top: 32px;
            text-align: right;
        }
        .image-upload-wrapper {
            position: relative;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        .image-upload-wrapper:hover {
            border-color: var(--accent);
        }
        .image-upload-wrapper input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .image-preview {
            margin-top: 16px;
        }
        .image-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
        }
        .image-preview-text {
            display: block;
            margin-top: 8px;
            color: var(--text-secondary);
        }

        @media (max-width: 900px) {
            .sidebar {
                position: fixed;
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                padding: 16px;
            }
            .menu-toggle {
                display: block;
            }
            .topbar-title {
                display: none;
            }
            .sidebar-overlay { 
                display: none; 
                position: fixed; 
                top: 0; 
                left: 0; 
                width: 100vw; 
                height: 100vh; 
                background: rgba(0,0,0,0.5); 
                z-index: 1000; 
            }
            .sidebar.open ~ .sidebar-overlay { 
                display: block; 
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="asset/logo-white.png" alt="Logo">
                <h3>Admin</h3>
            </div>
            <nav>
                <a href="admin_dashboard.php?page=home" class="<?= $page=='home'?'active':'' ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                <a href="admin_dashboard.php?page=berita" class="<?= $page=='berita'?'active':'' ?>"><i class="fa-solid fa-newspaper"></i> Berita</a>
                <a href="admin_dashboard.php?page=galeri" class="<?= $page=='galeri'?'active':'' ?>"><i class="fa-solid fa-images"></i> Galeri</a>
                <a href="admin_dashboard.php?page=objek-wisata" class="<?= $page=='objek-wisata'?'active':'' ?>"><i class="fa-solid fa-mountain"></i> Objek Wisata</a>
                <a href="admin_dashboard.php?page=pantai-sejarah" class="<?= $page=='pantai-sejarah'?'active':'' ?>"><i class="fa-solid fa-umbrella-beach"></i> Pantai Sejarah</a>
                <a href="admin_dashboard.php?page=testimonial-pantai" class="<?= $page=='testimonial-pantai'?'active':'' ?>"><i class="fa-solid fa-comments"></i> Testimonial</a>
                <a href="admin_dashboard.php?page=produk-umkm" class="<?= $page=='produk-umkm'?'active':'' ?>"><i class="fa-solid fa-store"></i> Produk UMKM</a>
                <div class="sidebar-dropdown">
                    <a href="#" class="dropdown-toggle <?= (in_array($page, ['inovasi-pendidikan', 'inovasi-pertanian', 'inovasi-teknologi'])) ? 'active' : '' ?>"><i class="fa-solid fa-lightbulb"></i> Inovasi <i class="fa-solid fa-chevron-down dropdown-icon"></i></a>
                    <div class="dropdown-menu">
                        <a href="admin_dashboard.php?page=inovasi-pendidikan" class="<?= $page=='inovasi-pendidikan'?'active':'' ?>">Pendidikan</a>
                        <a href="admin_dashboard.php?page=inovasi-pertanian" class="<?= $page=='inovasi-pertanian'?'active':'' ?>">Pertanian</a>
                        <a href="admin_dashboard.php?page=inovasi-teknologi" class="<?= $page=='inovasi-teknologi'?'active':'' ?>">Teknologi Terapan</a>
                    </div>
                </div>
            </nav>
            <div class="sidebar-footer">
                 <a href="#" id="logoutBtn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
        </div>
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <div class="main-content">
            <div class="topbar">
                <button class="menu-toggle" id="menuToggle"><i class="fa-solid fa-bars"></i></button>
                <h1 class="topbar-title">
                    <?php 
                        if ($page == 'home') echo 'Dashboard';
                        else if ($page == 'berita') echo 'Manajemen Berita';
                        else if ($page == 'inovasi') echo 'Manajemen Inovasi';
                        else if ($page == 'sejarah') echo 'Manajemen Sejarah';
                        else if ($page == 'galeri') echo 'Manajemen Galeri';
                        else if ($page == 'preview-galeri') echo 'Manajemen Preview';
                        else if ($page == 'kontak') echo 'Pesan Masuk';
                        else if ($page == 'produk-umkm') echo 'Manajemen Produk UMKM';
                        else if ($page == 'objek-wisata') echo 'Manajemen Objek Wisata';
                        else if ($page == 'pantai-sejarah') echo 'Manajemen Pantai Sejarah';
                        else if ($page == 'testimonial-pantai') echo 'Manajemen Testimonial';
                    ?>
                </h1>
                <div class="admin-profile">
                    <span class="admin-name"><?= isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : 'Admin'; ?></span>
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode(isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin') ?>&background=dbeafe&color=2563eb&font-size=0.5" alt="Avatar" style="width:40px; height:40px; border-radius:50%;">
                </div>
            </div>

            <?php if ($page=='home'): ?>
            <div class="dashboard-cards">
                <?php
                $total_berita = $conn->query("SELECT COUNT(*) FROM berita")->fetch_row()[0];
                $total_inovasi = $conn->query("SELECT COUNT(*) FROM inovasi")->fetch_row()[0];
                $total_pesan = $conn->query("SELECT COUNT(*) FROM pesan_kontak WHERE status='unread'")->fetch_row()[0];
                ?>
                <div class="dashboard-card blue">
                    <div class="icon"><i class="fa-solid fa-newspaper"></i></div>
                    <div class="info">
                        <div class="count"><?= $total_berita ?></div>
                        <div class="label">Total Berita</div>
                    </div>
                </div>
                <div class="dashboard-card green">
                    <div class="icon"><i class="fa-solid fa-lightbulb"></i></div>
                    <div class="info">
                        <div class="count"><?= $total_inovasi ?></div>
                        <div class="label">Total Inovasi</div>
                    </div>
                </div>
                <div class="dashboard-card red">
                    <div class="icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="info">
                        <div class="count"><?= $total_pesan ?></div>
                        <div class="label">Pesan Baru</div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($page=='berita'): ?>
            <div class="card" id="berita">
                <?php
                $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
                $error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
                unset($_SESSION['message'], $_SESSION['error']);
                ?>
                <?php if ($error) echo "<div class='message error'>$error</div>"; ?>
                <?php if ($message) echo "<div class='message success'>$message</div>"; ?>

                <?php if ($action=='tambah' || ($action=='edit' && isset($edit_berita))): ?>
                    <div class="card-header">
                        <h2><?= $action == 'tambah' ? 'Tulis Berita Baru' : 'Edit Berita' ?></h2>
                        <a href="admin_dashboard.php?page=berita" class="btn-secondary">&larr; Kembali ke Daftar Berita</a>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data" class="modern-form">
                        <input type="hidden" name="id" value="<?= $edit_berita['id'] ?? '' ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $edit_berita['gambar'] ?? '' ?>">
                        
                        <div class="form-group">
                            <label for="judul">Judul Berita</label>
                            <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($edit_berita['judul'] ?? '') ?>" required placeholder="Masukkan judul berita...">
                        </div>
                        
                        <div class="form-group">
                            <label for="penulis">Nama Penulis</label>
                            <input type="text" id="penulis" name="penulis" value="<?= htmlspecialchars($edit_berita['penulis'] ?? '') ?>" required placeholder="Contoh: John Doe">
                        </div>

                        <div class="form-group">
                            <label for="draft">Isi Berita</label>
                            <textarea id="draft" name="draft" rows="12" required placeholder="Tulis isi berita di sini..."><?= htmlspecialchars($edit_berita['draft'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar Utama</label>
                            <div class="image-upload-wrapper">
                                <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)" <?= $action == 'tambah' ? 'required' : '' ?>>
                                <div class="image-preview" id="imagePreview">
                                    <?php if ($action == 'edit' && !empty($edit_berita['gambar'])) : ?>
                                        <img src="<?= htmlspecialchars($edit_berita['gambar']) ?>" alt="Preview Gambar">
                                        <span class="image-preview-text">Ganti Gambar</span>
                                    <?php else: ?>
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <span class="image-preview-text">Pilih atau seret gambar ke sini</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="<?= $action == 'tambah' ? 'tambah_berita' : 'update_berita' ?>" class="btn-primary"><i class="fa-solid fa-save"></i> <?= $action == 'tambah' ? 'Simpan Berita' : 'Update Berita' ?></button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="card-header">
                        <h2>Daftar Berita</h2>
                        <a href="admin_dashboard.php?page=berita&action=tambah" class="btn-primary"><i class="fa-solid fa-plus"></i> Tulis Berita</a>
                    </div>
                    <div class="berita-grid">
                        <?php
                        $result = $conn->query("SELECT * FROM berita ORDER BY tanggal_dibuat DESC");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <div class="berita-card-item">
                                <div class="berita-card-link">
                                    <img src="<?= !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg' ?>" alt="Gambar Berita" class="berita-card-image">
                                    <div class="berita-card-content">
                                        <h3 class="berita-card-title"><?= htmlspecialchars($row['judul'] ?? '') ?></h3>
                                        <p class="berita-card-excerpt"><?= htmlspecialchars(substr($row['draft'] ?? '', 0, 100)) . (strlen($row['draft'] ?? '') > 100 ? '...' : '') ?></p>
                                        <div class="berita-card-meta">
                                            <span><i class="fa-solid fa-user"></i> <?= htmlspecialchars($row['penulis'] ?? '') ?></span>
                                            <span><i class="fa-solid fa-calendar-days"></i> <?= date('d M Y', strtotime($row['tanggal_dibuat'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="berita-card-actions">
                                    <a href="admin_dashboard.php?page=berita&action=edit&id=<?= $row['id'] ?>" class="btn-secondary"><i class="fa-solid fa-pencil"></i> Edit</a>
                                    <a href="admin_dashboard.php?page=berita&action=hapus&id=<?= $row['id'] ?>" class="btn-danger" onclick="return confirm('Yakin hapus berita ini?');"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo "<div class='empty-state'><i class='fa-solid fa-newspaper'></i><p>Belum ada berita yang ditambahkan.</p></div>";
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($page=='kontak'): ?>
            <div class="card" id="kontak">
                <?php
                $message_kontak = isset($_SESSION['message_kontak']) ? $_SESSION['message_kontak'] : null;
                $error_kontak = isset($_SESSION['error_kontak']) ? $_SESSION['error_kontak'] : null;
                unset($_SESSION['message_kontak'], $_SESSION['error_kontak']);
                ?>
                <?php if ($error_kontak) echo "<div class='message error'>$error_kontak</div>"; ?>
                <?php if ($message_kontak) echo "<div class='message success'>$message_kontak</div>"; ?>
                
                <div class="card-header">
                    <h2>Daftar Pesan Kontak</h2>
                </div>
                
                <div style="overflow-x:auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Subjek</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM pesan_kontak ORDER BY created_at DESC");
                    $no = 1;
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $status_class = 'status-' . $row['status'];
                            $status_text = ucfirst($row['status']);
                            
                            echo "<tr>";
                            echo "<td>".($no)."</td>";
                            echo "<td>".htmlspecialchars($row['nama'] ?? '')."</td>";
                            echo "<td>".htmlspecialchars($row['email'] ?? '')."</td>";
                            echo "<td>".htmlspecialchars($row['subjek'] ?? '')."</td>";
                            echo "<td style='max-width:200px;'>".htmlspecialchars(substr($row['pesan'] ?? '', 0, 50)).(strlen($row['pesan'] ?? '') > 50 ? '...' : '')."</td>";
                            echo "<td>".date('d M Y H:i', strtotime($row['created_at']))."</td>";
                            echo "<td><span class='status-badge $status_class'>$status_text</span></td>";
                            echo "<td class='aksi'>";
                            if ($row['status'] == 'unread') {
                                echo "<a href='admin_dashboard.php?page=kontak&action=update_status&id={$row['id']}&status=read' class='btn-secondary'>Baca</a>";
                            }
                            if ($row['status'] != 'replied') {
                                echo "<a href='admin_dashboard.php?page=kontak&action=update_status&id={$row['id']}&status=replied' class='btn-primary'>Balas</a>";
                            }
                            echo "<a href='admin_dashboard.php?page=kontak&action=hapus&id={$row['id']}' onclick=\"return confirm('Yakin hapus pesan ini?');\" class='btn-danger'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;padding:24px;'>Belum ada pesan kontak.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($page=='galeri'): ?>
            <div class="card" id="galeri">
                <?php
                $message = isset($_SESSION['message_galeri']) ? $_SESSION['message_galeri'] : null;
                $error = isset($_SESSION['error_galeri']) ? $_SESSION['error_galeri'] : null;
                unset($_SESSION['message_galeri'], $_SESSION['error_galeri']);
                ?>
                <?php if ($error) echo "<div class='message error'>$error</div>"; ?>
                <?php if ($message) echo "<div class='message success'>$message</div>"; ?>

                <?php if ($action=='tambah' || ($action=='edit' && isset($edit_galeri))): ?>
                    <div class="card-header">
                        <h2><?= $action == 'tambah' ? 'Tambah Foto Galeri' : 'Edit Foto Galeri' ?></h2>
                        <a href="admin_dashboard.php?page=galeri" class="btn-secondary">&larr; Kembali ke Daftar Galeri</a>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data" class="modern-form">
                        <input type="hidden" name="id" value="<?= $edit_galeri['id'] ?? '' ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $edit_galeri['gambar'] ?? '' ?>">
                        
                        <div class="form-group">
                            <label for="judul_galeri">Judul Foto</label>
                            <input type="text" id="judul_galeri" name="judul_galeri" value="<?= htmlspecialchars($edit_galeri['judul'] ?? '') ?>" required placeholder="Masukkan judul foto...">
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi_galeri">Deskripsi (Opsional)</label>
                            <textarea id="deskripsi_galeri" name="deskripsi_galeri" rows="3" placeholder="Masukkan deskripsi foto..."><?= htmlspecialchars($edit_galeri['deskripsi'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="gambar_galeri">Gambar</label>
                            <?php if ($action == 'edit' && !empty($edit_galeri['gambar'])) : ?>
                                <div style="margin-bottom: 10px;">
                                    <img src="<?= htmlspecialchars($edit_galeri['gambar']) ?>" alt="Gambar Galeri" style="width:200px;height:auto;border-radius:8px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" id="gambar_galeri" name="gambar_galeri" accept="image/*" <?= $action == 'tambah' ? 'required' : '' ?>>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="<?= $action == 'tambah' ? 'tambah_galeri' : 'update_galeri' ?>" class="btn-primary">
                                <?= $action == 'tambah' ? 'Tambah Foto' : 'Update Foto' ?>
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="card-header">
                        <h2>Manajemen Galeri</h2>
                        <a href="admin_dashboard.php?page=galeri&action=tambah" class="btn-primary">+ Tambah Foto</a>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM galeri ORDER BY created_at DESC");
                            $no = 1;
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                                    echo "<tr>";
                                    echo "<td>".($no++)."</td>";
                                    echo "<td><img src='" . $gambar . "' alt='Gambar Galeri' style='width:80px;height:60px;object-fit:cover;border-radius:4px;'></td>";
                                    echo "<td>".htmlspecialchars($row['judul'] ?? '')."</td>";
                                    echo "<td>".htmlspecialchars(substr($row['deskripsi'] ?? '', 0, 100)).(strlen($row['deskripsi'] ?? '') > 100 ? '...' : '')."</td>";
                                    echo "<td>".date('d/m/Y H:i', strtotime($row['created_at']))."</td>";
                                    echo "<td class='aksi'>
                                    <a href='admin_dashboard.php?page=galeri&action=edit&id={$row['id']}' class='btn-secondary'>Edit</a>
                                    <a href='admin_dashboard.php?page=galeri&action=hapus&id={$row['id']}' class='btn-danger' onclick=\"return confirm('Yakin hapus foto ini?');\">Hapus</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center;padding:24px;'>Belum ada foto galeri.</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($page=='produk-umkm'): ?>
            <div class="card" id="produk-umkm">
                <?php
                $message_umkm = isset($_SESSION['message_umkm']) ? $_SESSION['message_umkm'] : null;
                $error_umkm = isset($_SESSION['error_umkm']) ? $_SESSION['error_umkm'] : null;
                unset($_SESSION['message_umkm'], $_SESSION['error_umkm']);
                ?>
                <?php if ($error_umkm) echo "<div class='message error'>$error_umkm</div>"; ?>
                <?php if ($message_umkm) echo "<div class='message success'>$message_umkm</div>"; ?>

                <?php if ($action=='tambah' || ($action=='edit' && isset($_GET['id']))): ?>
                    <?php
                    $edit_produk = null;
                    if ($action == 'edit') {
                        $edit_id = intval($_GET['id']);
                        $q = $conn->query("SELECT * FROM produk_umkm WHERE id=$edit_id");
                        $edit_produk = $q ? $q->fetch_assoc() : null;
                    }
                    ?>
                    <div class="card-header">
                        <h2><?= $action == 'tambah' ? 'Tambah Produk UMKM' : 'Edit Produk UMKM' ?></h2>
                        <a href="admin_dashboard.php?page=produk-umkm" class="btn-secondary">&larr; Kembali</a>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $edit_produk['id'] ?? '' ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $edit_produk['gambar'] ?? '' ?>">
                        <label>Nama Produk:</label>
                        <input type="text" name="nama_produk" value="<?= htmlspecialchars($edit_produk['nama_produk'] ?? '') ?>" required>
                        <label>Deskripsi:</label>
                        <textarea name="deskripsi" rows="5" required><?= htmlspecialchars($edit_produk['deskripsi'] ?? '') ?></textarea>
                        <label>Harga:</label>
                        <input type="number" name="harga" step="0.01" min="0" max="9999999999999.99" value="<?= htmlspecialchars($edit_produk['harga'] ?? '') ?>" required>
                        <label>Nomor WhatsApp:</label>
                        <input type="tel" name="nomor_wa" placeholder="6281234567890" value="<?= htmlspecialchars($edit_produk['nomor_wa'] ?? '') ?>" required>
                        <small style="color: #666; font-size: 0.85rem;">Masukkan nomor tanpa tanda + atau spasi (contoh: 6281234567890)</small>
                        <label>Gambar:</label>
                        <?php if ($action == 'edit' && !empty($edit_produk['gambar'])) : ?>
                            <img src="<?= htmlspecialchars($edit_produk['gambar']) ?>" alt="Gambar Produk" style="width:150px;height:auto;margin-bottom:10px;border-radius:8px;">
                        <?php endif; ?>
                        <input type="file" name="gambar" accept="image/*" <?= $action == 'tambah' ? 'required' : '' ?>>
                        <button type="submit" name="<?= $action == 'tambah' ? 'tambah_produk' : 'update_produk' ?>"><?= $action == 'tambah' ? 'Tambah Produk' : 'Update Produk' ?></button>
                    </form>
                <?php else: ?>
                    <div class="card-header">
                        <h2>Manajemen Produk UMKM</h2>
                        <a href="admin_dashboard.php?page=produk-umkm&action=tambah" class="btn-primary">+ Tambah Produk</a>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Nomor WA</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM produk_umkm ORDER BY id DESC");
                            $no = 1;
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                                    echo "<tr>";
                                    echo "<td>".($no++)."</td>";
                                    echo "<td><img src='" . $gambar . "' alt='Gambar Produk'></td>";
                                    echo "<td>".htmlspecialchars($row['nama_produk'] ?? '')."</td>";
                                    echo "<td>".htmlspecialchars(substr($row['deskripsi'] ?? '', 0, 100)).(strlen($row['deskripsi'] ?? '') > 100 ? '...' : '')."</td>";
                                    echo "<td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>";
                                    echo "<td>";
                                    if (!empty($row['nomor_wa'])) {
                                        $wa_link = "https://wa.me/" . $row['nomor_wa'] . "?text=Halo, saya tertarik dengan produk " . urlencode($row['nama_produk']);
                                        echo "<a href='" . $wa_link . "' target='_blank' class='btn-secondary' style='font-size: 0.8rem; padding: 4px 8px;'>Test WA</a>";
                                        echo "<br><small style='color: #666;'>" . htmlspecialchars($row['nomor_wa']) . "</small>";
                                    } else {
                                        echo "<span style='color: #999; font-size: 0.8rem;'>Belum diatur</span>";
                                    }
                                    echo "</td>";
                                    echo "<td class='aksi'>
                                    <a href='admin_dashboard.php?page=produk-umkm&action=edit&id={$row['id']}' class='btn-secondary'>Edit</a>
                                    <a href='admin_dashboard.php?page=produk-umkm&action=hapus&id={$row['id']}' class='btn-danger' onclick=\"return confirm('Yakin hapus produk ini?');\">Hapus</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' style='text-align:center;padding:24px;'>Belum ada produk UMKM.</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($page=='objek-wisata'): ?>
            <div class="card" id="objek-wisata">
                <?php
                $message = isset($_SESSION['message_wisata']) ? $_SESSION['message_wisata'] : null;
                $error = isset($_SESSION['error_wisata']) ? $_SESSION['error_wisata'] : null;
                unset($_SESSION['message_wisata'], $_SESSION['error_wisata']);
                ?>
                <?php if ($error) echo "<div class='message error'>$error</div>"; ?>
                <?php if ($message) echo "<div class='message success'>$message</div>"; ?>

                <?php if ($action=='tambah' || ($action=='edit' && isset($edit_wisata))): ?>
                    <div class="card-header">
                        <h2><?= $action == 'tambah' ? 'Tambah Objek Wisata' : 'Edit Objek Wisata' ?></h2>
                        <a href="admin_dashboard.php?page=objek-wisata" class="btn-secondary">&larr; Kembali ke Daftar Objek Wisata</a>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data" class="modern-form">
                        <input type="hidden" name="id" value="<?= $edit_wisata['id'] ?? '' ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $edit_wisata['gambar'] ?? '' ?>">
                        
                        <div class="form-group">
                            <label for="nama_wisata">Nama Objek Wisata</label>
                            <input type="text" id="nama_wisata" name="nama_wisata" value="<?= htmlspecialchars($edit_wisata['nama_wisata'] ?? '') ?>" required placeholder="Masukkan nama objek wisata...">
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="5" required placeholder="Masukkan deskripsi objek wisata..."><?= htmlspecialchars($edit_wisata['deskripsi'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="urutan">Urutan Tampilan (1-4)</label>
                            <input type="number" id="urutan" name="urutan" min="1" max="4" value="<?= htmlspecialchars($edit_wisata['urutan'] ?? '1') ?>" required>
                            <small style="color: #666; font-size: 0.85rem;">Hanya 4 objek wisata yang akan ditampilkan di halaman utama</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <?php if ($action == 'edit' && !empty($edit_wisata['gambar'])) : ?>
                                <img src="<?= htmlspecialchars($edit_wisata['gambar']) ?>" alt="Gambar Wisata" style="width:200px;height:auto;margin-bottom:10px;border-radius:8px;">
                            <?php endif; ?>
                            <input type="file" id="gambar" name="gambar" accept="image/*" <?= $action == 'tambah' ? 'required' : '' ?>>
                        </div>
                        
                        <button type="submit" name="<?= $action == 'tambah' ? 'tambah_wisata' : 'update_wisata' ?>"><?= $action == 'tambah' ? 'Tambah Objek Wisata' : 'Update Objek Wisata' ?></button>
                    </form>
                <?php else: ?>
                    <div class="card-header">
                        <h2>Manajemen Objek Wisata</h2>
                        <a href="admin_dashboard.php?page=objek-wisata&action=tambah" class="btn-primary">+ Tambah Objek Wisata</a>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Objek Wisata</th>
                                    <th>Deskripsi</th>
                                    <th>Urutan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM objek_wisata ORDER BY urutan ASC, id DESC");
                            $no = 1;
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                                    echo "<tr>";
                                    echo "<td>".($no++)."</td>";
                                    echo "<td><img src='" . $gambar . "' alt='Gambar Wisata' style='width:80px;height:60px;object-fit:cover;border-radius:4px;'></td>";
                                    echo "<td>".htmlspecialchars($row['nama_wisata'] ?? '')."</td>";
                                    echo "<td>".htmlspecialchars(substr($row['deskripsi'] ?? '', 0, 100)).(strlen($row['deskripsi'] ?? '') > 100 ? '...' : '')."</td>";
                                    echo "<td>".htmlspecialchars($row['urutan'] ?? '')."</td>";
                                    echo "<td class='aksi'>
                                    <a href='admin_dashboard.php?page=objek-wisata&action=edit&id={$row['id']}' class='btn-secondary'>Edit</a>
                                    <a href='admin_dashboard.php?page=objek-wisata&action=hapus&id={$row['id']}' class='btn-danger' onclick=\"return confirm('Yakin hapus objek wisata ini?');\">Hapus</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center;padding:24px;'>Belum ada objek wisata.</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($page=='pantai-sejarah'): ?>
            <div class="card" id="pantai-sejarah">
                <?php
                $message = isset($_SESSION['message_pantai']) ? $_SESSION['message_pantai'] : null;
                $error = isset($_SESSION['error_pantai']) ? $_SESSION['error_pantai'] : null;
                unset($_SESSION['message_pantai'], $_SESSION['error_pantai']);
                ?>
                <?php if ($error) echo "<div class='message error'>$error</div>"; ?>
                <?php if ($message) echo "<div class='message success'>$message</div>"; ?>

                <div class="card-header">
                    <h2>Manajemen Konten Pantai Sejarah</h2>
                    <p>Kelola konten untuk halaman Pantai Sejarah</p>
                </div>

                <div class="section-list">
                    <?php
                    $sections = $conn->query("SELECT * FROM pantai_sejarah ORDER BY order_number ASC");
                    while ($section = $sections->fetch_assoc()):
                    ?>
                    <div class="section-item" style="background: white; padding: 24px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <div class="section-header" style="display: flex; justify-content: between; align-items: center; margin-bottom: 16px;">
                            <h3 style="margin: 0; color: var(--primary);"><?= htmlspecialchars($section['title']) ?></h3>
                            <span style="background: #e5e7eb; color: #374151; padding: 4px 12px; border-radius: 20px; font-size: 0.875rem; font-weight: 500;">
                                <?= ucfirst($section['section_name']) ?>
                            </span>
                        </div>
                        
                        <div class="section-content" style="margin-bottom: 16px;">
                            <p style="color: #6b7280; margin: 0;"><?= htmlspecialchars(substr($section['content'], 0, 200)) ?>...</p>
                        </div>
                        
                        <div class="section-actions">
                            <button onclick="editSection(<?= $section['id'] ?>)" class="btn-primary" style="margin-right: 8px;">
                                <i class="fa-solid fa-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>

                <!-- Modal Edit Section -->
                <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 32px; border-radius: 12px; width: 90%; max-width: 600px; max-height: 80vh; overflow-y: auto;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                            <h3 style="margin: 0;">Edit Section</h3>
                            <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
                        </div>
                        
                        <form id="editForm" method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="editId">
                            <input type="hidden" name="image_lama" id="editImageLama">
                            
                            <label for="editTitle">Judul</label>
                            <input type="text" id="editTitle" name="title" required>
                            
                            <label for="editContent">Konten</label>
                            <textarea id="editContent" name="content" rows="6" required></textarea>
                            
                            <label for="editImage">Gambar (Opsional)</label>
                            <input type="file" id="editImage" name="image" accept="image/*">
                            <div id="currentImage" style="margin-top: 8px;"></div>
                            
                            <div style="display: flex; gap: 12px; margin-top: 24px;">
                                <button type="submit" name="update_section" class="btn-primary">Update Section</button>
                                <button type="button" onclick="closeModal()" class="btn-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($page=='testimonial-pantai'): ?>
            <div class="card" id="testimonial-pantai">
                <?php
                $message = isset($_SESSION['message_testimonial']) ? $_SESSION['message_testimonial'] : null;
                $error = isset($_SESSION['error_testimonial']) ? $_SESSION['error_testimonial'] : null;
                unset($_SESSION['message_testimonial'], $_SESSION['error_testimonial']);
                ?>
                <?php if ($error) echo "<div class='message error'>$error</div>"; ?>
                <?php if ($message) echo "<div class='message success'>$message</div>"; ?>

                <div class="card-header">
                    <h2>Manajemen Testimonial Pantai Sejarah</h2>
                    <a href="admin_dashboard.php?page=testimonial-pantai&action=tambah" class="btn-primary">
                        <i class="fa-solid fa-plus"></i> Tambah Testimonial
                    </a>
                </div>

                <?php if ($action=='tambah' || ($action=='edit' && isset($edit_testimonial))): ?>
                    <div class="card-header">
                        <h2><?= $action == 'tambah' ? 'Tambah Testimonial Baru' : 'Edit Testimonial' ?></h2>
                        <a href="admin_dashboard.php?page=testimonial-pantai" class="btn-secondary">&larr; Kembali ke Daftar Testimonial</a>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data" class="modern-form">
                        <?php if ($edit_testimonial): ?>
                            <input type="hidden" name="id" value="<?= $edit_testimonial['id'] ?>">
                            <input type="hidden" name="avatar_lama" value="<?= $edit_testimonial['avatar'] ?>">
                        <?php endif; ?>
                        
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" value="<?= $edit_testimonial ? htmlspecialchars($edit_testimonial['nama']) : '' ?>" required>
                        
                        <label for="profesi">Profesi</label>
                        <input type="text" id="profesi" name="profesi" value="<?= $edit_testimonial ? htmlspecialchars($edit_testimonial['profesi']) : '' ?>" required>
                        
                        <label for="testimoni">Testimoni</label>
                        <textarea id="testimoni" name="testimoni" rows="4" required><?= $edit_testimonial ? htmlspecialchars($edit_testimonial['testimoni']) : '' ?></textarea>
                        
                        <label for="rating">Rating (1-5)</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" value="<?= $edit_testimonial ? $edit_testimonial['rating'] : 5 ?>" required>
                        
                        <label for="avatar">Avatar (Opsional)</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*">
                        <?php if ($edit_testimonial && $edit_testimonial['avatar']): ?>
                            <div style="margin-top: 8px;">
                                <img src="<?= htmlspecialchars($edit_testimonial['avatar']) ?>" alt="Current Avatar" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            </div>
                        <?php endif; ?>
                        
                        <button type="submit" name="<?= $edit_testimonial ? 'update_testimonial' : 'tambah_testimonial' ?>">
                            <?= $edit_testimonial ? 'Update Testimonial' : 'Tambah Testimonial' ?>
                        </button>
                    </form>
                <?php else: ?>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Avatar</th>
                                    <th>Nama</th>
                                    <th>Profesi</th>
                                    <th>Testimoni</th>
                                    <th>Rating</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $testimonials = $conn->query("SELECT * FROM testimonial_pantai_sejarah ORDER BY created_at DESC");
                                while ($testimonial = $testimonials->fetch_assoc()):
                                ?>
                                <tr>
                                    <td>
                                        <?php if ($testimonial['avatar']): ?>
                                            <img src="<?= htmlspecialchars($testimonial['avatar']) ?>" alt="Avatar" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                        <?php else: ?>
                                            <div style="width: 50px; height: 50px; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa-solid fa-user" style="color: #9ca3af;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($testimonial['nama']) ?></td>
                                    <td><?= htmlspecialchars($testimonial['profesi']) ?></td>
                                    <td><?= htmlspecialchars(substr($testimonial['testimoni'], 0, 100)) ?>...</td>
                                    <td>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa-solid fa-star" style="color: <?= $i <= $testimonial['rating'] ? '#f39c12' : '#e5e7eb' ?>;"></i>
                                        <?php endfor; ?>
                                    </td>
                                    <td>
                                        <a href="admin_dashboard.php?page=testimonial-pantai&action=edit&id=<?= $testimonial['id'] ?>" class="btn-primary" style="margin-right: 8px;">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <a href="admin_dashboard.php?page=testimonial-pantai&action=hapus&id=<?= $testimonial['id'] ?>" class="btn-danger" onclick="return confirm('Yakin ingin menghapus testimonial ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php $conn->close(); ?>
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');
        
        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.style.display = 'block';
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.style.display = 'none';
        }

        if (menuToggle) menuToggle.addEventListener('click', openSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

        document.querySelectorAll('.sidebar-dropdown > .dropdown-toggle').forEach(toggle => {
            const parent = toggle.parentElement;
            if (parent.querySelector('.dropdown-menu .active')) {
                parent.classList.add('open');
            }

            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                if (parent.classList.contains('open')) {
                    parent.classList.remove('open');
                } else {
                    document.querySelectorAll('.sidebar-dropdown.open').forEach(openDropdown => {
                        openDropdown.classList.remove('open');
                    });
                    parent.classList.add('open');
                }
            });
        });

        // Validasi form produk UMKM
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const hargaInput = this.querySelector('input[name="harga"]');
                if (hargaInput) {
                    const harga = parseFloat(hargaInput.value);
                    if (isNaN(harga) || harga < 0 || harga > 9999999999999.99) {
                        e.preventDefault();
                        alert('Harga harus berupa angka positif dan tidak lebih dari 9999999999999.99');
                        return false;
                    }
                }
            });
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 900) {
                closeSidebar();
            }
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--accent)',
                cancelButtonColor: 'var(--secondary)',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                background: 'var(--card-bg)',
                color: 'var(--primary)'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();
            confirmLogout();
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('imagePreview');
                output.innerHTML = '<img src="' + reader.result + '"/>';
            }
            reader.readAsDataURL(event.target.files[0]);
        };

        // Functions for Pantai Sejarah management
        function editSection(id) {
            // Fetch section data via AJAX
            fetch('get_section_data.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editTitle').value = data.title;
                    document.getElementById('editContent').value = data.content;
                    document.getElementById('editImageLama').value = data.image;
                    
                    if (data.image) {
                        document.getElementById('currentImage').innerHTML = '<img src="' + data.image + '" style="width: 200px; height: 150px; object-fit: cover; border-radius: 8px;">';
                    } else {
                        document.getElementById('currentImage').innerHTML = '';
                    }
                    
                    document.getElementById('editModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengambil data section');
                });
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>