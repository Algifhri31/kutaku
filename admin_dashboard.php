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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { margin: 0; background: #f5f6fa; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: 220px; min-width: 140px; max-width: 90vw;
            background: #232946;
            box-shadow: 2px 0 16px rgba(0,0,0,0.04);
            padding: 32px 0 0 0;
            display: flex; flex-direction: column; align-items: center;
            height: 100vh; overflow-y: auto; position: sticky; top: 0; z-index: 1001; transition: left 0.3s, box-shadow 0.3s;
        }
        .sidebar h3 { color: #fff; margin-bottom: 32px; font-size: 1.3rem; letter-spacing: 1px; }
        .sidebar a {
            display: flex;
            align-items: center;
            color: #b8c1ec;
            text-decoration: none;
            padding: 12px 32px 12px 24px;
            margin-bottom: 8px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1.08rem;
            min-height: 44px;
            position: relative;
            transition: background 0.25s, color 0.25s, box-shadow 0.25s;
            box-sizing: border-box;
        }
        .sidebar a .fa-solid {
            margin-right: 14px;
            font-size: 1.18em;
            min-width: 22px;
            text-align: center;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #e0e7ef;
            color: #232946;
            box-shadow: 0 2px 8px rgba(44,62,80,0.06);
        }
        .sidebar a.active::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 8px;
            bottom: 8px;
            width: 5px;
            border-radius: 4px;
            background: #fca311;
            transition: all 0.25s;
        }
        .sidebar a:not(.active)::before {
            content: '';
            display: none;
        }
        .sidebar-close { display: none; }
        .sidebar-overlay { display: none; }
        .main-content { flex: 1; padding: 0 0 32px 0; }
        .topbar {
            background: #232946;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            padding: 18px 40px;
            display: flex; align-items: center; justify-content: space-between; position: relative;
        }
        .topbar .admin { font-weight: 600; color: #b8c1ec; }
        .topbar .logout {
            background: #fca311;
            color: #232946;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
        }
        .topbar .logout:hover { background: #e85d04; color: #fff; }
        .menu-toggle { display: none; background: none; border: none; font-size: 2rem; color: #b8c1ec; cursor: pointer; margin-right: 18px; }
        .card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(44,62,80,0.08);
            padding: 32px 28px 24px 28px;
            margin: 32px auto 0 auto;
            max-width: 900px;
            border: 1.5px solid #e0e7ef;
        }
        .card h2 { text-align: center; color: #232946; margin-bottom: 28px; letter-spacing: 0.5px; }
        label { font-weight: 500; color: #232946; }
        input[type="text"], textarea, input[type="file"] {
            width: 100%; padding: 10px; margin-top: 6px; margin-bottom: 18px;
            border: 1.5px solid #b8c1ec; border-radius: 6px; background: #f5f6fa;
            font-size: 15px; transition: border 0.2s; color: #232946;
        }
        input[type="text"]:focus, textarea:focus { border: 1.5px solid #fca311; outline: none; }
        button[type="submit"] {
            width: 100%;
            background: #fca311;
            color: #232946;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #e85d04;
            color: #fff;
        }
        .message { text-align: center; margin-bottom: 18px; padding: 10px; border-radius: 6px; }
        .message.error { background: #ffeaea; color: #d32f2f; border: 1px solid #f8bcbc; }
        .message.success { background: #eaffea; color: #388e3c; border: 1px solid #b6eab6; }
        .divider { border-top: 1px solid #e0e0e0; margin: 36px 0 28px 0; }
        .admin-table {
            width: 100%; border-collapse: separate; border-spacing: 0;
            background: #fff; box-shadow: 0 2px 16px rgba(44,62,80,0.06);
            border-radius: 16px; overflow: hidden; font-size: 1.08rem; border: 1.5px solid #e0e7ef;
        }
        .admin-table th, .admin-table td { padding: 18px 16px; border-bottom: 1px solid #e0e7ef; }
        .admin-table th {
            background: #f5f6fa;
            color: #232946; font-weight: 700; font-size: 1.08rem; letter-spacing: 0.5px;
        }
        .admin-table tr:nth-child(even) { background: #f8fafc; }
        .admin-table tr:nth-child(odd) { background: #fff; }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tbody tr:hover { background: #e0e7ef; color: #232946; transition: background 0.2s; }
        .admin-table img { height: 48px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        .admin-table .aksi a {
            display: inline-block; margin-right: 8px; font-weight: 600; padding: 7px 18px; border-radius: 8px; font-size: 1rem; text-decoration: none; transition: background 0.2s, color 0.2s;
        }
        .admin-table .aksi a:first-child { background: #b8c1ec; color: #232946; }
        .admin-table .aksi a:last-child { background: #ffeaea; color: #d32f2f; }
        .admin-table .aksi a:hover { filter: brightness(0.95); }
        /* Sidebar drawer mobile */
        @media (max-width: 900px) {
            .admin-layout { flex-direction: row; }
            .sidebar { width: 220px; min-width: 110px; padding: 16px 0 0 0; left: -240px; position: fixed; top: 0; height: 100vh; z-index: 1001; box-shadow: 2px 0 16px rgba(0,0,0,0.10); transition: left 0.3s, box-shadow 0.3s; }
            .sidebar.open { left: 0; box-shadow: 2px 0 32px rgba(0,0,0,0.18); }
            .sidebar h3 { display: none; }
            .sidebar a { margin: 8px 4px 8px 0; padding: 10px 12px; font-size: 0.98rem; }
            .sidebar-close { display: block; position: absolute; top: 18px; right: 18px; background: none; border: none; font-size: 2rem; color: #b8c1ec; cursor: pointer; }
            .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(30,34,50,0.35); z-index: 1000; }
            .sidebar.open ~ .sidebar-overlay { display: block; }
            .main-content { padding: 0; }
            .card { margin: 18px 4px 0 4px; max-width: 100%; }
            .admin-table th, .admin-table td { padding: 10px 6px; font-size: 0.98rem; }
            .menu-toggle { display: block; }
        }
        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            margin: 32px 0 0 0;
            justify-content: flex-start;
        }
        .dashboard-card {
            flex: 1 1 220px;
            min-width: 220px;
            max-width: 320px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(44,62,80,0.08);
            display: flex;
            align-items: center;
            padding: 24px 28px;
            gap: 18px;
            border: 1.5px solid #e0e7ef;
        }
        .dashboard-card .icon {
            font-size: 2.5rem;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .dashboard-card.blue .icon { background: #e3f0fa; color: #2563eb; }
        .dashboard-card.green .icon { background: #eafbe7; color: #2ecc40; }
        .dashboard-card.orange .icon { background: #fff4e3; color: #fca311; }
        .dashboard-card.red .icon { background: #ffeaea; color: #e74c3c; }
        .dashboard-card .info { flex: 1; }
        .dashboard-card .info .count {
            font-size: 2rem;
            font-weight: 700;
            color: #232946;
        }
        .dashboard-card .info .label {
            font-size: 1.08rem;
            color: #888;
            margin-top: 2px;
        }
        @media (max-width: 900px) {
            .dashboard-cards { flex-direction: column; gap: 18px; }
            .dashboard-card { min-width: 0; max-width: 100%; }
        }
        .status-unread { color: #e74c3c; font-weight: bold; }
        .status-read { color: #34495e; font-weight: bold; }
        .status-replied { color: #27ae60; font-weight: bold; }
    </style>
</head>
<body>
    <div class="admin-layout">
            <div class="sidebar" id="sidebar">
                <button class="sidebar-close" id="sidebarClose" style="display:none;">&times;</button>
                <h3>Admin Panel</h3>
                <a href="admin_dashboard.php?page=home" class="<?= $page=='home'?'active':'' ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                <a href="admin_dashboard.php?page=berita" class="<?= $page=='berita'?'active':'' ?>"><i class="fa-solid fa-newspaper"></i> Berita</a>
                <a href="admin_dashboard.php?page=inovasi" class="<?= $page=='inovasi'?'active':'' ?>"><i class="fa-solid fa-lightbulb"></i>Inovasi</a>
                <a href="admin_dashboard.php?page=sejarah" class="<?= $page=='sejarah'?'active':'' ?>"><i class="fa-solid fa-book"></i> Sejarah</a>
                <a href="admin_dashboard.php?page=galeri" class="<?= $page=='galeri'?'active':'' ?>"><i class="fa-solid fa-images"></i> Galeri Wisata</a>
                <a href="admin_dashboard.php?page=preview-galeri" class="<?= $page=='preview-galeri'?'active':'' ?>"><i class="fa-solid fa-eye"></i> Preview Beranda</a>
                <a href="admin_dashboard.php?page=kontak" class="<?= $page=='kontak'?'active':'' ?>"><i class="fa-solid fa-envelope"></i> Pesan Kontak</a>
                <button type="button" class="logout" id="logoutBtn" style="width:90%;margin:8px 0 0 0;"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
            </div>
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <div class="main-content">
                <div class="topbar">
                    <button class="menu-toggle" id="menuToggle">&#9776;</button>
                    <span class="admin">👤 <?= isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : 'Admin'; ?></span>
                    <button type="button" class="logout" id="logoutBtnTop">Logout</button>
                </div>
            <?php if ($page=='home'): ?>
            <div class="card" style="max-width:1200px;">
                <h2 style="text-align:left;">Dashboard</h2>
                <hr style="margin-bottom:32px;">
                <div class="dashboard-cards">
                    <?php
                    $total_berita = $conn->query("SELECT COUNT(*) FROM berita")->fetch_row()[0];
                    $total_inovasi = $conn->query("SELECT COUNT(*) FROM inovasi")->fetch_row()[0];
                    $total_pengguna = $conn->query("SHOW TABLES LIKE 'pengguna'")->num_rows ? $conn->query("SELECT COUNT(*) FROM pengguna")->fetch_row()[0] : 0;
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
                        <div class="icon"><i class="fa-solid fa-users"></i></div>
                        <div class="info">
                            <div class="count"><?= $total_pengguna ?></div>
                            <div class="label">Total Pengguna</div>
                        </div>
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
                <?php if ($action=='tambah'): ?>
                    <h2>Tambah Berita</h2>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <label>Judul:</label>
                        <input type="text" name="judul" required>
                        <label>Draft:</label>
                        <textarea name="draft" rows="5" required></textarea>
                        <label>Penulis:</label>
                        <input type="text" name="penulis" required>
                        <label>Gambar:</label>
                        <input type="file" name="gambar" accept="image/*" required>
                        <button type="submit" name="tambah_berita">Tambah Berita</button>
                    </form>
                    <div style="margin-top:18px;">
                        <a href="admin_dashboard.php?page=berita" style="color:#eebbc3;text-decoration:underline;">&larr; Kembali ke Daftar Berita</a>
                    </div>
                <?php elseif ($action=='edit' && isset($edit_berita)): ?>
                    <h2>Edit Berita</h2>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <label>Judul:</label>
                        <input type="text" name="judul" value="<?= htmlspecialchars($edit_berita['judul']) ?>" required>
                        <label>Draft:</label>
                        <textarea name="draft" rows="5" required><?= htmlspecialchars($edit_berita['draft']) ?></textarea>
                        <label>Penulis:</label>
                        <input type="text" name="penulis" value="<?= htmlspecialchars($edit_berita['penulis']) ?>" required>
                        <label>Gambar:</label>
                        <?php if ($edit_berita['gambar']): ?>
                            <img src="<?= htmlspecialchars($edit_berita['gambar']) ?>" alt="Gambar" style="width:100%;max-width:120px;margin-bottom:10px;border-radius:8px;display:block;">
                        <?php endif; ?>
                        <input type="file" name="gambar" accept="image/*">
                        <button type="submit" name="update_berita">Update Berita</button>
                    </form>
                    <div style="margin-top:18px;">
                        <a href="admin_dashboard.php?page=berita" style="color:#eebbc3;text-decoration:underline;">&larr; Kembali ke Daftar Berita</a>
                    </div>
                <?php else: ?>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <h2 style="margin-bottom:0;">Daftar Berita</h2>
                        <a href="admin_dashboard.php?page=berita&action=tambah" style="background:#eebbc3;color:#232946;padding:8px 18px;border-radius:6px;text-decoration:none;font-weight:600;">+ Tambah Berita</a>
                    </div>
                    <div style="overflow-x:auto;margin-top:24px;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM berita ORDER BY tanggal_dibuat DESC");
                        $no = 1;
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                                echo "<tr>";
                                echo "<td>".$no."</td>";
                                echo "<td>".htmlspecialchars($row['judul'])."</td>";
                                echo "<td>".htmlspecialchars($row['penulis'])."</td>";
                                echo "<td>".date('d M Y', strtotime($row['tanggal_dibuat']))."</td>";
                                echo "<td><img src='".$gambar."' alt='Gambar'></td>";
                                echo "<td class='aksi'>
                                <a href='admin_dashboard.php?page=berita&action=edit&id={$row['id']}'>Edit</a>
                                <a href='admin_dashboard.php?page=berita&action=hapus&id={$row['id']}' onclick=\"return confirm('Yakin hapus berita ini?')\">Hapus</a>
                                </td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;padding:18px;color:#888;'>Belum ada berita.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php elseif ($page=='inovasi'): ?>
            <div class="card" id="inovasi">
                <?php
                $message_inovasi = isset($_SESSION['message_inovasi']) ? $_SESSION['message_inovasi'] : null;
                $error_inovasi = isset($_SESSION['error_inovasi']) ? $_SESSION['error_inovasi'] : null;
                unset($_SESSION['message_inovasi'], $_SESSION['error_inovasi']);
                ?>
                <?php if ($error_inovasi) echo "<div class='message error'>$error_inovasi</div>"; ?>
                <?php if ($message_inovasi) echo "<div class='message success'>$message_inovasi</div>"; ?>
                <?php if ($action=='tambah'): ?>
                    <h2>Tambah Pengembangan Inovasi</h2>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <label>Judul Inovasi:</label>
                        <input type="text" name="judul_inovasi" required>
                        <label>Deskripsi:</label>
                        <textarea name="deskripsi_inovasi" rows="5" required></textarea>
                        <label>Penulis:</label>
                        <input type="text" name="penulis_inovasi" required>
                        <label>Gambar:</label>
                        <input type="file" name="gambar_inovasi" accept="image/*" required>
                        <button type="submit" name="tambah_inovasi">Tambah Inovasi</button>
                    </form>
                    <div style="margin-top:18px;">
                        <a href="admin_dashboard.php?page=inovasi" style="color:#eebbc3;text-decoration:underline;">&larr; Kembali ke Daftar Inovasi</a>
                    </div>
                <?php elseif ($action=='edit' && isset($edit_inovasi)): ?>
                    <h2>Edit Inovasi</h2>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <label>Judul Inovasi:</label>
                        <input type="text" name="judul_inovasi" value="<?= htmlspecialchars($edit_inovasi['judul']) ?>" required>
                        <label>Deskripsi:</label>
                        <textarea name="deskripsi_inovasi" rows="5" required><?= htmlspecialchars($edit_inovasi['deskripsi']) ?></textarea>
                        <label>Penulis:</label>
                        <input type="text" name="penulis_inovasi" value="<?= htmlspecialchars($edit_inovasi['penulis']) ?>" required>
                        <label>Gambar:</label>
                        <?php if ($edit_inovasi['gambar']): ?>
                            <img src="<?= htmlspecialchars($edit_inovasi['gambar']) ?>" alt="Gambar" style="width:100%;max-width:120px;margin-bottom:10px;border-radius:8px;display:block;">
                        <?php endif; ?>
                        <input type="file" name="gambar_inovasi" accept="image/*">
                        <button type="submit" name="update_inovasi">Update Inovasi</button>
                    </form>
                    <div style="margin-top:18px;">
                        <a href="admin_dashboard.php?page=inovasi" style="color:#eebbc3;text-decoration:underline;">&larr; Kembali ke Daftar Inovasi</a>
                    </div>
                <?php else: ?>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <h2 style="margin-bottom:0;">Daftar Pengembangan Inovasi</h2>
                        <a href="admin_dashboard.php?page=inovasi&action=tambah" style="background:#eebbc3;color:#232946;padding:8px 18px;border-radius:6px;text-decoration:none;font-weight:600;">+ Tambah Inovasi</a>
                    </div>
                    <div style="overflow-x:auto;margin-top:24px;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM inovasi ORDER BY tanggal_dibuat DESC");
                        $no = 1;
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                                echo "<tr>";
                                echo "<td>".$no."</td>";
                                echo "<td>".htmlspecialchars($row['judul'])."</td>";
                                echo "<td>".htmlspecialchars($row['penulis'])."</td>";
                                echo "<td>".date('d M Y', strtotime($row['tanggal_dibuat']))."</td>";
                                echo "<td><img src='".$gambar."' alt='Gambar'></td>";
                                echo "<td class='aksi'>
                                <a href='admin_dashboard.php?page=inovasi&action=edit&id={$row['id']}'>Edit</a>
                                <a href='admin_dashboard.php?page=inovasi&action=hapus&id={$row['id']}' onclick=\"return confirm('Yakin hapus inovasi ini?')\">Hapus</a>
                                </td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;padding:18px;color:#888;'>Belum ada inovasi.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php elseif ($page=='sejarah'): ?>
            <div class="card" id="sejarah">
                <?php
                $message_sejarah = isset($_SESSION['message_sejarah']) ? $_SESSION['message_sejarah'] : null;
                $error_sejarah = isset($_SESSION['error_sejarah']) ? $_SESSION['error_sejarah'] : null;
                unset($_SESSION['message_sejarah'], $_SESSION['error_sejarah']);
                ?>
                <?php if ($error_sejarah) echo "<div class='message error'>$error_sejarah</div>"; ?>
                <?php if ($message_sejarah) echo "<div class='message success'>$message_sejarah</div>"; ?>
                <h2>Kelola Sejarah</h2>
                <form method="POST" action="" enctype="multipart/form-data">
                    <label>Judul Sejarah:</label>
                    <input type="text" name="judul_sejarah" value="<?php
                        $result = $conn->query("SELECT judul FROM sejarah LIMIT 1");
                        if ($result && $row = $result->fetch_assoc()) {
                            echo htmlspecialchars($row['judul']);
                        }
                    ?>" required>
                    <label>Deskripsi Sejarah:</label>
                    <textarea name="deskripsi_sejarah" rows="8" required><?php
                        $result = $conn->query("SELECT deskripsi FROM sejarah LIMIT 1");
                        if ($result && $row = $result->fetch_assoc()) {
                            echo htmlspecialchars($row['deskripsi']);
                        }
                    ?></textarea>
                    <label>Gambar Sejarah:</label>
                    <?php
                        $result = $conn->query("SELECT gambar FROM sejarah LIMIT 1");
                        if ($result && $row = $result->fetch_assoc() && !empty($row['gambar'])) {
                            echo "<img src='".htmlspecialchars($row['gambar'])."' alt='Gambar Sejarah' style='width:100%;max-width:200px;margin-bottom:10px;border-radius:8px;display:block;'>";
                        }
                    ?>
                    <input type="file" name="gambar_sejarah" accept="image/*">
                    <button type="submit" name="simpan_sejarah">Simpan Sejarah</button>
                </form>
            </div>
            <?php elseif ($page=='galeri'): ?>
            <?php if ($action=='tambah'): ?>
            <div class="card" id="tambah-galeri">
                <h2>Tambah Galeri Wisata</h2>
                <form method="POST" action="" enctype="multipart/form-data">
                    <label>Foto:</label>
                    <input type="file" name="gambar_galeri" accept="image/*" required>
                    <button type="submit" name="tambah_galeri">Tambah Foto</button>
                </form>
                <div style="margin-top:18px;">
                    <a href="admin_dashboard.php?page=galeri" style="color:#eebbc3;text-decoration:underline;">&larr; Kembali ke Daftar Galeri</a>
                </div>
            </div>
            <?php else: ?>
            <div class="card" id="galeri">
                <?php
                $message_galeri = isset($_SESSION['message_galeri']) ? $_SESSION['message_galeri'] : null;
                $error_galeri = isset($_SESSION['error_galeri']) ? $_SESSION['error_galeri'] : null;
                unset($_SESSION['message_galeri'], $_SESSION['error_galeri']);
                ?>
                <?php if ($error_galeri) echo "<div class='message error'>$error_galeri</div>"; ?>
                <?php if ($message_galeri) echo "<div class='message success'>$message_galeri</div>"; ?>
                <h2>Daftar Foto Galeri</h2>
                <div style="margin-bottom: 20px;">
                    <a href="admin_dashboard.php?page=galeri&action=tambah" class="btn-tambah">+ Tambah Galeri Wisata</a>
                </div>
                <div style="overflow-x:auto;margin-top:24px;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Tanggal</th>
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
                            echo "<td>".$no."</td>";
                            echo "<td><img src='".$gambar."' alt='Gambar' style='width:100px;height:60px;object-fit:cover;border-radius:4px;'></td>";
                            echo "<td>".date('d M Y', strtotime($row['created_at']))."</td>";
                            echo "<td class='aksi'>
                            <a href='admin_dashboard.php?page=galeri&action=hapus&id={$row['id']}' onclick=\"return confirm('Yakin hapus foto galeri ini?')\" style='color:#e74c3c;'>Hapus</a>
                            </td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;padding:18px;color:#888;'>Belum ada foto galeri.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
            <?php endif; ?>
            <?php elseif ($page=='preview-galeri'): ?>
            <div class="card" id="preview-galeri">
                <?php
                $message_preview = isset($_SESSION['message_preview']) ? $_SESSION['message_preview'] : null;
                $error_preview = isset($_SESSION['error_preview']) ? $_SESSION['error_preview'] : null;
                unset($_SESSION['message_preview'], $_SESSION['error_preview']);
                ?>
                <?php if ($error_preview) echo "<div class='message error'>$error_preview</div>"; ?>
                <?php if ($message_preview) echo "<div class='message success'>$message_preview</div>"; ?>
                
                <h2>Kelola Preview Galeri Beranda</h2>
                <p style="color:#666;margin-bottom:24px;">Kelola foto-foto yang ditampilkan di preview galeri pada halaman beranda.</p>
                
                <?php if ($action=='tambah'): ?>
                    <h3>Tambah Foto Preview</h3>
                    
                    <!-- Debug info -->
                    <div style="background:#f8f9fa; padding:15px; border-radius:8px; margin-bottom:20px; border-left:4px solid #eebbc3;">
                        <h4 style="margin:0 0 10px 0; color:#232946;">🔧 Debug Info:</h4>
                        <ul style="margin:0; padding-left:20px; color:#666;">
                            <li>Upload max filesize: <?= ini_get('upload_max_filesize') ?></li>
                            <li>Post max size: <?= ini_get('post_max_size') ?></li>
                            <li>Upload directory: <?= is_dir('uploads/') ? 'Exists' : 'Missing' ?></li>
                            <li>Directory writable: <?= is_writable('uploads/') ? 'Yes' : 'No' ?></li>
                        </ul>
                    </div>
                    
                    <form method="POST" action="" enctype="multipart/form-data">
                        <label>Judul Foto:</label>
                        <input type="text" name="judul_preview" required placeholder="Contoh: Mangrove Park">
                        
                        <label>Deskripsi:</label>
                        <textarea name="deskripsi_preview" rows="3" required placeholder="Contoh: Keindahan hutan mangrove yang asri"></textarea>
                        
                        <label>Foto:</label>
                        <input type="file" name="gambar_preview" accept="image/*" required>
                        <small style="color:#666; display:block; margin-top:5px;">
                            Format: JPG, PNG, GIF | Maksimal: 2MB
                        </small>
                        
                        <label>Urutan (1-4):</label>
                        <input type="number" name="urutan_preview" min="1" max="4" required value="1">
                        
                        <button type="submit" name="tambah_preview">Tambah Foto Preview</button>
                    </form>
                    
                    <div style="margin-top:18px;">
                        <a href="admin_dashboard.php?page=preview-galeri" style="color:#eebbc3;text-decoration:underline;">&larr; Kembali ke Daftar Preview</a>
                    </div>
                <?php elseif ($action=='edit' && isset($_GET['id'])): ?>
                    <?php
                    $edit_id = intval($_GET['id']);
                    $q = $conn->query("SELECT * FROM preview_galeri WHERE id=$edit_id");
                    $edit_preview = $q ? $q->fetch_assoc() : null;
                    
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_preview'])) {
                        $judul = $_POST['judul_preview'];
                        $deskripsi = $_POST['deskripsi_preview'];
                        $urutan = $_POST['urutan_preview'];
                        $gambar = $edit_preview['gambar'];
                        
                        if (!empty($_FILES['gambar_preview']['name'])) {
                            $target_dir = "uploads/";
                            $gambar = $target_dir . time() . "_" . basename($_FILES["gambar_preview"]["name"]);
                            move_uploaded_file($_FILES["gambar_preview"]["tmp_name"], $gambar);
                        }
                        
                        $stmt = $conn->prepare("UPDATE preview_galeri SET judul=?, deskripsi=?, gambar=?, urutan=? WHERE id=?");
                        $stmt->bind_param("sssii", $judul, $deskripsi, $gambar, $urutan, $edit_id);
                        if ($stmt->execute()) {
                            $_SESSION['message_preview'] = "Preview galeri berhasil diupdate!";
                        } else {
                            $_SESSION['error_preview'] = "Gagal update preview galeri.";
                        }
                        $stmt->close();
                        header('Location: admin_dashboard.php?page=preview-galeri');
                        exit;
                    }
                    ?>
                    
                    <?php if ($edit_preview): ?>
                    <h3>Edit Foto Preview</h3>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <label>Judul Foto:</label>
                        <input type="text" name="judul_preview" value="<?= htmlspecialchars($edit_preview['judul']) ?>" required>
                        <label>Deskripsi:</label>
                        <textarea name="deskripsi_preview" rows="3" required><?= htmlspecialchars($edit_preview['deskripsi']) ?></textarea>
                        <label>Foto:</label>
                        <?php if ($edit_preview['gambar']): ?>
                            <img src="<?= htmlspecialchars($edit_preview['gambar']) ?>" alt="Gambar" style="width:100%;max-width:120px;margin-bottom:10px;border-radius:8px;display:block;">
                        <?php endif; ?>
                        <input type="file" name="gambar_preview" accept="image/*">
                        <label>Urutan (1-4):</label>
                        <input type="number" name="urutan_preview" min="1" max="4" value="<?= $edit_preview['urutan'] ?>" required>
                        <button type="submit" name="update_preview">Update Foto Preview</button>
                    </form>
                    <div style="margin-top:18px;">
                        <a href="admin_dashboard.php?page=preview-galeri" style="color:#eebbc3;text-decoration:underline;">&larr; Kembali ke Daftar Preview</a>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php
                    // Proses tambah preview galeri
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_preview'])) {
                        $judul = $_POST['judul_preview'];
                        $deskripsi = $_POST['deskripsi_preview'];
                        $urutan = $_POST['urutan_preview'];
                        $target_dir = "uploads/";
                        $target_file = $target_dir . time() . "_" . basename($_FILES["gambar_preview"]["name"]);
                        
                        // Debug info
                        error_log("Upload attempt - File: " . $_FILES["gambar_preview"]["name"]);
                        error_log("Target file: " . $target_file);
                        error_log("Upload error: " . $_FILES["gambar_preview"]["error"]);
                        
                        // Check if file was uploaded
                        if (!isset($_FILES["gambar_preview"]) || $_FILES["gambar_preview"]["error"] != 0) {
                            $error_msg = "Gagal upload file. Error: " . ($_FILES["gambar_preview"]["error"] ?? "Unknown error");
                            $_SESSION['error_preview'] = $error_msg;
                            error_log("Upload failed: " . $error_msg);
                        } else {
                            // Check file size (2MB limit)
                            if ($_FILES["gambar_preview"]["size"] > 2 * 1024 * 1024) {
                                $_SESSION['error_preview'] = "File terlalu besar. Maksimal 2MB.";
                                error_log("File too large: " . $_FILES["gambar_preview"]["size"] . " bytes");
                            } else {
                                // Check file type
                                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                                if (!in_array($_FILES["gambar_preview"]["type"], $allowed_types)) {
                                    $_SESSION['error_preview'] = "Format file tidak didukung. Gunakan JPG, PNG, atau GIF.";
                                    error_log("Invalid file type: " . $_FILES["gambar_preview"]["type"]);
                                } else {
                                    // Try to upload file
                                    if (move_uploaded_file($_FILES["gambar_preview"]["tmp_name"], $target_file)) {
                                        error_log("File uploaded successfully to: " . $target_file);
                                        
                                        // Insert to database
                                        $stmt = $conn->prepare("INSERT INTO preview_galeri (judul, deskripsi, gambar, urutan) VALUES (?, ?, ?, ?)");
                                        $stmt->bind_param("sssi", $judul, $deskripsi, $target_file, $urutan);
                                        
                                        if ($stmt->execute()) {
                                            $_SESSION['message_preview'] = "Foto preview berhasil ditambahkan!";
                                            error_log("Database insert successful. ID: " . $stmt->insert_id);
                                        } else {
                                            $_SESSION['error_preview'] = "Gagal menyimpan ke database: " . $stmt->error;
                                            error_log("Database insert failed: " . $stmt->error);
                                            // Delete uploaded file if database insert failed
                                            if (file_exists($target_file)) {
                                                unlink($target_file);
                                            }
                                        }
                                        $stmt->close();
                                    } else {
                                        $_SESSION['error_preview'] = "Gagal memindahkan file ke server.";
                                        error_log("Failed to move uploaded file to: " . $target_file);
                                    }
                                }
                            }
                        }
                        
                        header('Location: admin_dashboard.php?page=preview-galeri');
                        exit;
                    }
                    
                    // Proses hapus preview galeri
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
                    ?>
                    
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                        <div>
                            <h3 style="margin-bottom:8px;">Daftar Foto Preview Beranda</h3>
                            <p style="color:#666;margin:0;">Kelola 4 foto yang ditampilkan di preview galeri beranda</p>
                        </div>
                        <a href="admin_dashboard.php?page=preview-galeri&action=tambah" style="background:#eebbc3;color:#232946;padding:8px 18px;border-radius:6px;text-decoration:none;font-weight:600;">+ Tambah Foto Preview</a>
                    </div>
                    
                    <div style="overflow-x:auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Urutan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM preview_galeri ORDER BY urutan ASC");
                        $no = 1;
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'asset/default-image.jpg';
                                echo "<tr>";
                                echo "<td>".$no."</td>";
                                echo "<td><img src='".$gambar."' alt='Preview' style='width:80px;height:60px;object-fit:cover;border-radius:4px;'></td>";
                                echo "<td>".htmlspecialchars($row['judul'])."</td>";
                                echo "<td style='max-width:200px;'>".htmlspecialchars($row['deskripsi'])."</td>";
                                echo "<td>".$row['urutan']."</td>";
                                echo "<td class='aksi'>
                                <a href='admin_dashboard.php?page=preview-galeri&action=edit&id={$row['id']}'>Edit</a>
                                <a href='admin_dashboard.php?page=preview-galeri&action=hapus&id={$row['id']}' onclick=\"return confirm('Yakin hapus foto preview ini?')\">Hapus</a>
                                </td>";
                                echo "</tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center;padding:18px;color:#888;'>Belum ada foto preview. Silakan tambahkan foto untuk ditampilkan di beranda.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                    
                    <div style="margin-top:24px;padding:16px;background:#f8f9fa;border-radius:8px;border-left:4px solid #eebbc3;">
                        <h4 style="margin-bottom:8px;color:#232946;">📋 Panduan Preview Galeri:</h4>
                        <ul style="margin:0;padding-left:20px;color:#666;">
                            <li>Maksimal 4 foto yang akan ditampilkan di preview beranda</li>
                            <li>Urutan 1-4 menentukan posisi foto di preview</li>
                            <li>Foto akan ditampilkan dengan efek hover yang menarik</li>
                            <li>Pastikan foto memiliki rasio aspek yang konsisten</li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <?php elseif ($page=='kontak'): ?>
            <div class="card" id="kontak">
                <?php
                $message_kontak = isset($_SESSION['message_kontak']) ? $_SESSION['message_kontak'] : null;
                $error_kontak = isset($_SESSION['error_kontak']) ? $_SESSION['error_kontak'] : null;
                unset($_SESSION['message_kontak'], $_SESSION['error_kontak']);
                ?>
                <?php if ($error_kontak) echo "<div class='message error'>$error_kontak</div>"; ?>
                <?php if ($message_kontak) echo "<div class='message success'>$message_kontak</div>"; ?>
                
                <h2>Daftar Pesan Kontak</h2>
                
                <?php
                // Proses update status pesan
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
                }
                
                // Proses hapus pesan
                if ($action=='hapus' && isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $conn->query("DELETE FROM pesan_kontak WHERE id=$id");
                    $_SESSION['message_kontak'] = "Pesan berhasil dihapus.";
                    header('Location: admin_dashboard.php?page=kontak');
                    exit;
                }
                ?>
                
                <div style="overflow-x:auto;margin-top:24px;">
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
                            $status_class = '';
                            $status_text = '';
                            switch($row['status']) {
                                case 'unread':
                                    $status_class = 'status-unread';
                                    $status_text = 'Belum Dibaca';
                                    break;
                                case 'read':
                                    $status_class = 'status-read';
                                    $status_text = 'Sudah Dibaca';
                                    break;
                                case 'replied':
                                    $status_class = 'status-replied';
                                    $status_text = 'Sudah Dibalas';
                                    break;
                            }
                            
                            echo "<tr>";
                            echo "<td>".$no."</td>";
                            echo "<td>".htmlspecialchars($row['nama'])."</td>";
                            echo "<td>".htmlspecialchars($row['email'])."</td>";
                            echo "<td>".htmlspecialchars($row['subjek'])."</td>";
                            echo "<td style='max-width:200px;'>".htmlspecialchars(substr($row['pesan'], 0, 100)).(strlen($row['pesan']) > 100 ? '...' : '')."</td>";
                            echo "<td>".date('d M Y H:i', strtotime($row['created_at']))."</td>";
                            echo "<td><span class='$status_class'>$status_text</span></td>";
                            echo "<td class='aksi'>";
                            if ($row['status'] == 'unread') {
                                echo "<a href='admin_dashboard.php?page=kontak&action=update_status&id={$row['id']}&status=read' style='background:#3498db;color:#fff;'>Tandai Dibaca</a> ";
                            }
                            if ($row['status'] != 'replied') {
                                echo "<a href='admin_dashboard.php?page=kontak&action=update_status&id={$row['id']}&status=replied' style='background:#27ae60;color:#fff;'>Tandai Dibalas</a> ";
                            }
                            echo "<a href='admin_dashboard.php?page=kontak&action=hapus&id={$row['id']}' onclick=\"return confirm('Yakin hapus pesan ini?')\" style='background:#e74c3c;color:#fff;'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;padding:18px;color:#888;'>Belum ada pesan kontak.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php $conn->close(); ?>
    <script>
        // Sidebar drawer mobile toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.style.display = 'block';
            sidebarClose.style.display = 'block';
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.style.display = 'none';
            sidebarClose.style.display = 'none';
        }
        if (menuToggle) menuToggle.onclick = openSidebar;
        if (sidebarOverlay) sidebarOverlay.onclick = closeSidebar;
        if (sidebarClose) sidebarClose.onclick = closeSidebar;
        window.addEventListener('resize', function() {
            if (window.innerWidth > 900) closeSidebar();
        });
        // SweetAlert2 logout confirmation
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e85d04',
                cancelButtonColor: '#b8c1ec',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }
        document.querySelectorAll('#logoutBtn, #logoutBtnTop').forEach(btn => {
            if (btn) btn.onclick = confirmLogout;
        });
    </script>
</body>
</html>