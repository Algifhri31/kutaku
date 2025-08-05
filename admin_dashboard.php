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

    // CRUD untuk Testimonial
    if ($page == 'testimonial-pantai') {
        if (isset($_POST['action'])) {
            $id = intval($_POST['id']);

            if ($_POST['action'] == 'approve') {
                $stmt = $conn->prepare("UPDATE testimonial_pantai_sejarah SET status = 'active' WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
                $_SESSION['message_testimonial'] = "Testimonial berhasil disetujui!";
            } elseif ($_POST['action'] == 'reject') {
                $stmt = $conn->prepare("UPDATE testimonial_pantai_sejarah SET status = 'rejected' WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
                $_SESSION['message_testimonial'] = "Testimonial berhasil ditolak!";
            } elseif ($_POST['action'] == 'delete') {
                // Ambil info avatar untuk dihapus
                $stmt = $conn->prepare("SELECT avatar FROM testimonial_pantai_sejarah WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $testimonial = $result->fetch_assoc();
                $stmt->close();

                // Hapus file avatar jika ada
                if ($testimonial['avatar'] && file_exists($testimonial['avatar'])) {
                    unlink($testimonial['avatar']);
                }

                // Hapus dari database
                $stmt = $conn->prepare("DELETE FROM testimonial_pantai_sejarah WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
                $_SESSION['message_testimonial'] = "Testimonial berhasil dihapus!";
            }

            header('Location: admin_dashboard.php?page=testimonial-pantai');
            exit;
        }
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

// Inovasi Management (Pendidikan, Pertanian, Teknologi)
if (in_array($page, ['inovasi-pendidikan', 'inovasi-pertanian', 'inovasi-teknologi'])) {
    $kategori = str_replace('inovasi-', '', $page);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_inovasi'])) {
        $judul = $_POST['judul_inovasi'];
        $deskripsi = $_POST['deskripsi_inovasi'];
        $tanggal = $_POST['tanggal_inovasi'];
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_inovasi"]["name"]);

        if (move_uploaded_file($_FILES["gambar_inovasi"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO inovasi (kategori, judul, deskripsi, gambar, tanggal) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $kategori, $judul, $deskripsi, $target_file, $tanggal);
            if ($stmt->execute()) {
                $_SESSION['message_inovasi'] = "Inovasi berhasil ditambahkan!";
            } else {
                $_SESSION['error_inovasi'] = "Gagal menambahkan inovasi.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_inovasi'] = "Gagal mengupload gambar.";
        }
        header("Location: admin_dashboard.php?page=$page");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_inovasi'])) {
        $id = $_POST['id'];
        $judul = $_POST['judul_inovasi'];
        $deskripsi = $_POST['deskripsi_inovasi'];
        $tanggal = $_POST['tanggal_inovasi'];
        $gambar = $_POST['gambar_lama'];

        if (!empty($_FILES['gambar_inovasi']['name'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_inovasi"]["name"]);
            if (move_uploaded_file($_FILES["gambar_inovasi"]["tmp_name"], $target_file)) {
                if (!empty($gambar) && file_exists($gambar)) {
                    unlink($gambar);
                }
                $gambar = $target_file;
            }
        }

        $stmt = $conn->prepare("UPDATE inovasi SET judul=?, deskripsi=?, gambar=?, tanggal=? WHERE id=?");
        $stmt->bind_param("ssssi", $judul, $deskripsi, $gambar, $tanggal, $id);
        if ($stmt->execute()) {
            $_SESSION['message_inovasi'] = "Inovasi berhasil diupdate!";
        } else {
            $_SESSION['error_inovasi'] = "Gagal update inovasi.";
        }
        $stmt->close();
        header("Location: admin_dashboard.php?page=$page");
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
        header("Location: admin_dashboard.php?page=$page");
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
    } elseif (in_array($page, ['inovasi-pendidikan', 'inovasi-pertanian', 'inovasi-teknologi'])) {
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
            text-align: left;
            vertical-align: middle;
        }
        .admin-table thead {
            border-bottom: 2px solid var(--border-color);
        }
        .admin-table tbody tr {
            border-bottom: 1px solid var(--border-color);
        }
        .admin-table tbody tr:last-child {
            border-bottom: 0;
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
        .dashboard-card.orange .icon { background: #fed7aa; color: #ea580c; }
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

        /* Testimonial Status Badges */
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-active { background-color: #d1fae5; color: #065f46; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }
        .filter-tab {
            padding: 8px 16px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            cursor: pointer;
            background: var(--card-bg);
            color: var(--text-secondary);
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .filter-tab.active {
            background: var(--accent-light);
            color: var(--accent);
            border-color: var(--accent);
            font-weight: 600;
        }
        .filter-tab:hover:not(.active) {
            background: var(--background);
            color: var(--primary);
            border-color: #cbd5e1;
        }

        .testimonial-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }
        .testimonial-card {
            background: var(--card-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }
        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 1.5rem;
            font-weight: 600;
        }
        .testimonial-info h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary);
        }
        .testimonial-info p {
            margin: 4px 0 0 0;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
        .testimonial-body {
            padding: 16px 0;
            flex-grow: 1;
        }
        .testimonial-content {
            font-style: italic;
            color: #374151;
            line-height: 1.6;
        }
        .testimonial-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #f59e0b;
            margin-top: 16px;
        }
        .testimonial-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-secondary);
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }
        .testimonial-actions {
            display: flex;
            gap: 8px;
        }
        .btn-approve, .btn-reject, .btn-delete {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
            font-size: 1.1rem;
            line-height: 1;
        }
        .btn-approve { color: #10b981; }
        .btn-approve:hover { background: #dcfce7; }
        .btn-reject { color: #ef4444; }
        .btn-reject:hover { background: #fee2e2; }
        .btn-delete { color: #6b7280; }
        .btn-delete:hover { background: #f1f5f9; }

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

        .form-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
        }

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .galeri-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 24px;
        }
        .galeri-card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .galeri-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .galeri-card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        .galeri-card-content {
            padding: 16px;
        }
        .galeri-card-title {
            font-weight: 600;
            margin: 0 0 4px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .galeri-card-date {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        .galeri-card-actions {
            position: absolute;
            top: 12px;
            right: 12px;
            display: flex;
            gap: 8px;
            background: rgba(0,0,0,0.4);
            padding: 6px;
            border-radius: 8px;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .galeri-card:hover .galeri-card-actions {
            opacity: 1;
        }
        .galeri-card-actions a {
            color: white;
            padding: 4px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .galeri-card-actions .btn-secondary { background: var(--accent); }
        .galeri-card-actions .btn-danger { background: #dc2626; }


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
                <h3>Admin Panel</h3>
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
                $total_testimonial_pending = $conn->query("SELECT COUNT(*) FROM testimonial_pantai_sejarah WHERE status='pending'")->fetch_row()[0];
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
                <div class="dashboard-card orange">
                    <div class="icon"><i class="fa-solid fa-comments"></i></div>
                    <div class="info">
                        <div class="count"><?= $total_testimonial_pending ?></div>
                        <div class="label">Testimonial Pending</div>
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
                            <textarea id="deskripsi_galeri" name="deskripsi_galeri" rows="5" placeholder="Masukkan deskripsi singkat..."><?= htmlspecialchars($edit_galeri['deskripsi'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="gambar_galeri">Gambar</label>
                            <div class="image-upload-wrapper">
                                <input type="file" id="gambar_galeri" name="gambar_galeri" accept="image/*" onchange="previewImage(event, 'imagePreviewGaleri')" <?= $action == 'tambah' ? 'required' : '' ?>>
                                <div class="image-preview" id="imagePreviewGaleri">
                                    <?php if ($action == 'edit' && !empty($edit_galeri['gambar'])) : ?>
                                        <img src="<?= htmlspecialchars($edit_galeri['gambar']) ?>" alt="Preview Gambar">
                                        <span class="image-preview-text">Ganti Gambar</span>
                                    <?php else: ?>
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <span class="image-preview-text">Pilih atau seret gambar ke sini</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="<?= $action == 'tambah' ? 'tambah_galeri' : 'update_galeri' ?>" class="btn-primary">
                                <i class="fa-solid fa-save"></i> <?= $action == 'tambah' ? 'Tambah Foto' : 'Update Foto' ?>
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="card-header">
                        <h2>Manajemen Galeri</h2>
                        <a href="admin_dashboard.php?page=galeri&action=tambah" class="btn-primary">+ Tambah Foto</a>
                    </div>
                    <div class="galeri-grid">
                        <?php
                        $result = $conn->query("SELECT * FROM galeri ORDER BY created_at DESC");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                        ?>
                            <div class="galeri-card">
                                <img src="<?= $gambar ?>" alt="<?= htmlspecialchars($row['judul']) ?>" class="galeri-card-img">
                                <div class="galeri-card-content">
                                    <h4 class="galeri-card-title" title="<?= htmlspecialchars($row['judul']) ?>"><?= htmlspecialchars($row['judul']) ?></h4>
                                    <p class="galeri-card-date"><?= date('d M Y', strtotime($row['created_at'])) ?></p>
                                </div>
                                <div class="galeri-card-actions">
                                    <a href="admin_dashboard.php?page=galeri&action=edit&id=<?= $row['id'] ?>" class="btn-secondary" title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="admin_dashboard.php?page=galeri&action=hapus&id=<?= $row['id'] ?>" class="btn-danger" title="Hapus" onclick="return confirm('Yakin hapus foto ini?');"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo "<div class='empty-state' style='grid-column: 1 / -1;'><i class='fa-solid fa-images'></i><p>Belum ada foto di galeri.</p></div>";
                        }
                        ?>
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
                            <small style="display: block; margin-top: 8px; color: #666; font-size: 0.85rem;">Hanya 4 objek wisata yang akan ditampilkan di halaman utama.</small>
                        </div>

                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <div class="image-upload-wrapper">
                                <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event, 'imagePreviewWisata')" <?= $action == 'tambah' ? 'required' : '' ?>>
                                <div class="image-preview" id="imagePreviewWisata">
                                    <?php if ($action == 'edit' && !empty($edit_wisata['gambar'])) : ?>
                                        <img src="<?= htmlspecialchars($edit_wisata['gambar']) ?>" alt="Preview Gambar">
                                        <span class="image-preview-text">Ganti Gambar</span>
                                    <?php else: ?>
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <span class="image-preview-text">Pilih atau seret gambar ke sini</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="<?= $action == 'tambah' ? 'tambah_wisata' : 'update_wisata' ?>" class="btn-primary">
                                <i class="fa-solid fa-save"></i> <?= $action == 'tambah' ? 'Tambah Objek Wisata' : 'Update Objek Wisata' ?>
                            </button>
                        </div>
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
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><img src="<?= $gambar ?>" alt="Gambar Wisata" class="berita-thumb"></td>
                                    <td>
                                        <div class="berita-judul"><?= htmlspecialchars($row['nama_wisata'] ?? '') ?></div>
                                    </td>
                                    <td>
                                        <p class="berita-draft" style="white-space: normal;"><?= htmlspecialchars(substr($row['deskripsi'] ?? '', 0, 120)) . (strlen($row['deskripsi'] ?? '') > 120 ? '...' : '') ?></p>
                                    </td>
                                    <td style="text-align: center;"><?= htmlspecialchars($row['urutan'] ?? '') ?></td>
                                    <td>
                                        <div class="aksi">
                                            <a href="admin_dashboard.php?page=objek-wisata&action=edit&id=<?= $row['id'] ?>" class="btn-secondary" title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                            <a href="admin_dashboard.php?page=objek-wisata&action=hapus&id=<?= $row['id'] ?>" class="btn-danger" title="Hapus" onclick="return confirm('Yakin hapus objek wisata ini?');"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='6'><div class='empty-state'><i class='fa-solid fa-mountain'></i><p>Belum ada objek wisata yang ditambahkan.</p></div></td></tr>";
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
                unset($_SESSION['message_testimonial']);
                ?>
                <?php if ($message) echo "<div class='message success'>$message</div>"; ?>

                <div class="card-header">
                    <h2>Kelola Testimonial Pantai Sejarah</h2>
                    <p>Kelola testimonial yang dikirim oleh pengunjung</p>
                </div>

                <!-- Filter Tabs -->
                <div class="filter-tabs" style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <div class="filter-tab active" data-filter="all" style="padding: 8px 16px; border: 2px solid #ddd; border-radius: 20px; cursor: pointer; background: #007bff; color: white; border-color: #007bff;">Semua</div>
                    <div class="filter-tab" data-filter="pending" style="padding: 8px 16px; border: 2px solid #ddd; border-radius: 20px; cursor: pointer; background: white;">Pending</div>
                    <div class="filter-tab" data-filter="active" style="padding: 8px 16px; border: 2px solid #ddd; border-radius: 20px; cursor: pointer; background: white;">Disetujui</div>
                    <div class="filter-tab" data-filter="rejected" style="padding: 8px 16px; border: 2px solid #ddd; border-radius: 20px; cursor: pointer; background: white;">Ditolak</div>
                </div>

                <!-- Testimonial List -->
                <div class="testimonial-list">
                    <?php
                    $testimonials = $conn->query("SELECT * FROM testimonial_pantai_sejarah ORDER BY created_at DESC");
                    if ($testimonials->num_rows > 0):
                    ?>
                        <?php while ($testimonial = $testimonials->fetch_assoc()): ?>
                            <div class="testimonial-card <?= $testimonial['status'] ?>" data-status="<?= $testimonial['status'] ?>" style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                                <?php if ($testimonial['status'] == 'pending'): ?>
                                    <div style="border-left-color: #ffc107;"></div>
                                <?php elseif ($testimonial['status'] == 'active'): ?>
                                    <div style="border-left-color: #28a745;"></div>
                                <?php elseif ($testimonial['status'] == 'rejected'): ?>
                                    <div style="border-left-color: #dc3545;"></div>
                                <?php endif; ?>

                                <div class="testimonial-header" style="display: flex; align-items: center; margin-bottom: 15px;">
                                    <?php if ($testimonial['avatar']): ?>
                                        <!-- Hapus tampilan avatar -->
                                    <?php else: ?>
                                        <div class="testimonial-avatar" style="width: 50px; height: 50px; background: #007bff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; margin-right: 15px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="testimonial-info">
                                        <h4 style="margin: 0; color: #333;"><?= htmlspecialchars($testimonial['nama']) ?></h4>
                                        <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9rem;"><?= htmlspecialchars($testimonial['profesi']) ?></p>
                                        <span class="status-badge status-<?= $testimonial['status'] ?>" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">
                                            <?php
                                            switch($testimonial['status']) {
                                                case 'pending': echo 'Pending'; break;
                                                case 'active': echo 'Disetujui'; break;
                                                case 'rejected': echo 'Ditolak'; break;
                                                default: echo 'Unknown'; break;
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="testimonial-content" style="margin-bottom: 15px; line-height: 1.6; color: #555;">
                                    "<?= htmlspecialchars($testimonial['testimoni']) ?>"
                                </div>

                                <div class="testimonial-rating" style="margin-bottom: 15px;">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa<?= $i <= $testimonial['rating'] ? 's' : 'r' ?> fa-star" style="color: #ffc107;"></i>
                                    <?php endfor; ?>
                                    <span style="margin-left: 10px; color: #666;">(<?= $testimonial['rating'] ?>/5)</span>
                                </div>

                                <div style="color: #666; font-size: 0.9rem; margin-bottom: 15px;">
                                    <i class="fas fa-clock"></i> <?= date('d/m/Y H:i', strtotime($testimonial['created_at'])) ?>
                                </div>

                                <div class="testimonial-actions" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <?php if ($testimonial['status'] == 'pending'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="id" value="<?= $testimonial['id'] ?>">
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn-approve" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 0.9rem;" onclick="return confirm('Setujui testimonial ini?')">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="id" value="<?= $testimonial['id'] ?>">
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn-reject" style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 0.9rem;" onclick="return confirm('Tolak testimonial ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $testimonial['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn-delete" style="background: #6c757d; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 0.9rem;" onclick="return confirm('Hapus testimonial ini? Tindakan ini tidak dapat dibatalkan.')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px; color: #666;">
                            <i class="fas fa-comments" style="font-size: 3rem; margin-bottom: 20px; color: #ddd;"></i>
                            <h3>Belum ada testimonial</h3>
                            <p>Testimonial yang dikirim oleh pengunjung akan muncul di sini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (in_array($page, ['inovasi-pendidikan', 'inovasi-pertanian', 'inovasi-teknologi'])): ?>
            <div class="card" id="inovasi">
                <?php
                $message = isset($_SESSION['message_inovasi']) ? $_SESSION['message_inovasi'] : null;
                $error = isset($_SESSION['error_inovasi']) ? $_SESSION['error_inovasi'] : null;
                unset($_SESSION['message_inovasi'], $_SESSION['error_inovasi']);
                ?>
                <?php if ($error) echo "<div class='message error'>$error</div>"; ?>
                <?php if ($message) echo "<div class='message success'>$message</div>"; ?>

                <div class="card-header">
                    <h2>Manajemen Inovasi <?= ucfirst($kategori) ?></h2>
                    <a href="admin_dashboard.php?page=<?= $page ?>&action=tambah" class="btn-primary">
                        <i class="fa-solid fa-plus"></i> Tambah Inovasi
                    </a>
                </div>

                <?php if ($action=='tambah' || ($action=='edit' && isset($edit_inovasi))): ?>
                    <div class="card-header">
                        <h2><?= $action == 'tambah' ? 'Tambah Inovasi Baru' : 'Edit Inovasi' ?></h2>
                        <a href="admin_dashboard.php?page=<?= $page ?>" class="btn-secondary">&larr; Kembali ke Daftar Inovasi</a>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data" class="modern-form">
                        <?php if ($edit_inovasi): ?>
                            <input type="hidden" name="id" value="<?= $edit_inovasi['id'] ?>">
                            <input type="hidden" name="gambar_lama" value="<?= $edit_inovasi['gambar'] ?>">
                        <?php endif; ?>

                        <label for="judul_inovasi">Judul Inovasi</label>
                        <input type="text" id="judul_inovasi" name="judul_inovasi" value="<?= $edit_inovasi ? htmlspecialchars($edit_inovasi['judul']) : '' ?>" required>

                        <label for="deskripsi_inovasi">Deskripsi</label>
                        <textarea id="deskripsi_inovasi" name="deskripsi_inovasi" rows="6" required><?= $edit_inovasi ? htmlspecialchars($edit_inovasi['deskripsi']) : '' ?></textarea>

                        <label for="tanggal_inovasi">Tanggal</label>
                        <input type="date" id="tanggal_inovasi" name="tanggal_inovasi" value="<?= $edit_inovasi ? $edit_inovasi['tanggal'] : date('Y-m-d') ?>" required>

                        <label for="gambar_inovasi">Gambar</label>
                        <input type="file" id="gambar_inovasi" name="gambar_inovasi" accept="image/*" <?= $edit_inovasi ? '' : 'required' ?>>
                        <?php if ($edit_inovasi && $edit_inovasi['gambar']): ?>
                            <div style="margin-top: 8px;">
                                <img src="<?= htmlspecialchars($edit_inovasi['gambar']) ?>" alt="Current Image" style="width: 200px; height: 150px; object-fit: cover; border-radius: 8px;">
                            </div>
                        <?php endif; ?>

                        <button type="submit" name="<?= $edit_inovasi ? 'update_inovasi' : 'tambah_inovasi' ?>">
                            <?= $edit_inovasi ? 'Update Inovasi' : 'Tambah Inovasi' ?>
                        </button>
                    </form>
                <?php else: ?>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $inovasi_list = $conn->query("SELECT * FROM inovasi WHERE kategori='$kategori' ORDER BY tanggal DESC");
                                while ($inovasi = $inovasi_list->fetch_assoc()):
                                ?>
                                <tr>
                                    <td>
                                        <?php if ($inovasi['gambar']): ?>
                                            <img src="<?= htmlspecialchars($inovasi['gambar']) ?>" alt="Inovasi" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        <?php else: ?>
                                            <div style="width: 80px; height: 60px; background: #e5e7eb; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa-solid fa-image" style="color: #9ca3af;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($inovasi['judul']) ?></td>
                                    <td><?= htmlspecialchars(substr($inovasi['deskripsi'], 0, 100)) ?>...</td>
                                    <td><?= date('d/m/Y', strtotime($inovasi['tanggal'])) ?></td>
                                    <td>
                                        <a href="admin_dashboard.php?page=<?= $page ?>&action=edit&id=<?= $inovasi['id'] ?>" class="btn-primary" style="margin-right: 8px;">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <a href="admin_dashboard.php?page=<?= $page ?>&action=hapus&id=<?= $inovasi['id'] ?>" class="btn-danger" onclick="return confirm('Yakin ingin menghapus inovasi ini?')">
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

        // Filter functionality for testimonials
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            if (filterTabs.length > 0) {
                filterTabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Remove active class from all tabs
                        filterTabs.forEach(t => t.classList.remove('active'));
                        // Add active class to clicked tab
                        this.classList.add('active');

                        const filter = this.dataset.filter;
                        const testimonials = document.querySelectorAll('.testimonial-card');

                        testimonials.forEach(testimonial => {
                            if (filter === 'all' || testimonial.dataset.status === filter) {
                                testimonial.style.display = 'block';
                            } else {
                                testimonial.style.display = 'none';
                            }
                        });
                    });
                });
            }
        });

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