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
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_galeri"]["name"]);
        
        if (move_uploaded_file($_FILES["gambar_galeri"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO galeri (judul, gambar) VALUES (?, ?)");
            $stmt->bind_param("ss", $judul, $target_file);
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
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar"]["name"]);
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO produk_umkm (nama_produk, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $nama_produk, $deskripsi, $harga, $target_file);
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

        $stmt = $conn->prepare("UPDATE produk_umkm SET nama_produk=?, deskripsi=?, harga=?, gambar=? WHERE id=?");
        $stmt->bind_param("ssdsi", $nama_produk, $deskripsi, $harga, $gambar_path, $id);
        if ($stmt->execute()) {
            $_SESSION['message_umkm'] = "Produk berhasil diupdate!";
        } else {
            $_SESSION['error_umkm'] = "Gagal update produk.";
        }
        $stmt->close();
        header('Location: admin_dashboard.php?page=produk-umkm');
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

// Get edit data if needed
$edit_berita = null;
$edit_inovasi = null;
if ($action == 'edit' && isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);
    if ($page == 'berita') {
        $q = $conn->query("SELECT * FROM berita WHERE id=$edit_id");
        $edit_berita = $q ? $q->fetch_assoc() : null;
    } elseif ($page == 'inovasi') {
        $q = $conn->query("SELECT * FROM inovasi WHERE id=$edit_id");
        $edit_inovasi = $q ? $q->fetch_assoc() : null;
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
                                        <h3 class="berita-card-title"><?= htmlspecialchars($row['judul']) ?></h3>
                                        <p class="berita-card-excerpt"><?= htmlspecialchars(substr($row['draft'], 0, 100)) . (strlen($row['draft']) > 100 ? '...' : '') ?></p>
                                        <div class="berita-card-meta">
                                            <span><i class="fa-solid fa-user"></i> <?= htmlspecialchars($row['penulis']) ?></span>
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
                            echo "<td>".htmlspecialchars($row['nama'])."</td>";
                            echo "<td>".htmlspecialchars($row['email'])."</td>";
                            echo "<td>".htmlspecialchars($row['subjek'])."</td>";
                            echo "<td style='max-width:200px;'>".htmlspecialchars(substr($row['pesan'], 0, 50)).(strlen($row['pesan']) > 50 ? '...' : '')."</td>";
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
                        <input type="number" name="harga" step="0.01" value="<?= htmlspecialchars($edit_produk['harga'] ?? '') ?>" required>
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
                                    echo "<td>".htmlspecialchars($row['nama_produk'])."</td>";
                                    echo "<td>".htmlspecialchars(substr($row['deskripsi'], 0, 100)).(strlen($row['deskripsi']) > 100 ? '...' : '')."</td>";
                                    echo "<td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>";
                                    echo "<td class='aksi'>
                                    <a href='admin_dashboard.php?page=produk-umkm&action=edit&id={$row['id']}' class='btn-secondary'>Edit</a>
                                    <a href='admin_dashboard.php?page=produk-umkm&action=hapus&id={$row['id']}' class='btn-danger' onclick=\"return confirm('Yakin hapus produk ini?');\">Hapus</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center;padding:24px;'>Belum ada produk UMKM.</td></tr>";
                            }
                            ?>
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
    </script>
</body>
</html>