<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_dashboard.php');
    exit;
}
$conn = new mysqli("localhost", "root", "", "website");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admin WHERE username='$username'");

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($password === $admin['password']) { // In a real app, use password_verify
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Kutaku</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --background-light: #F8F9FA;
            --white: #FFFFFF;
            --gray-100: #F1F3F5;
            --gray-300: #DEE2E6;
            --gray-500: #ADB5BD;
            --gray-700: #495057;
            --gray-900: #212529;
            --blue-500: #3366FF;
            --blue-600: #2a55d9;
            --red-500: #E03131;
            --red-100: #FFECEC;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-light);
            color: var(--gray-900);
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            background-color: var(--white);
            overflow: hidden;
        }

        .login-promo {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--white);
        }

        .promo-content {
            max-width: 450px;
        }

        .promo-content h1 {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .promo-content p {
            font-size: 20px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .login-form-container {
            flex: 1;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .form-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .form-wrapper .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 24px;
        }

        .form-wrapper .logo span {
            color: var(--blue-500);
        }

        .form-wrapper h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-wrapper .subtitle {
            color: var(--gray-700);
            margin-bottom: 32px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--gray-700);
        }

        .input-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--blue-500);
            box-shadow: 0 0 0 3px rgba(51, 102, 255, 0.15);
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-500);
            font-size: 20px;
            padding: 4px;
            line-height: 1;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background-color: var(--blue-500);
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
            margin-top: 16px;
        }

        .btn-submit:hover {
            background-color: var(--blue-600);
            transform: translateY(-2px);
        }

        .message.error {
            padding: 12px;
            margin-bottom: 24px;
            border-radius: 8px;
            background-color: var(--red-100);
            color: var(--red-500);
            border: 1px solid var(--red-500);
            text-align: center;
            font-size: 14px;
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            color: var(--gray-700);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: var(--blue-500);
            text-decoration: underline;
        }

        @media (max-width: 800px) {
            .login-promo {
                display: none;
            }
            .login-form-container {
                padding: 32px;
            }
            .form-wrapper {
                max-width: 100%;
            }
        }

    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-promo">
            <div class="promo-content">
                <h1>Kutaku Admin Panel</h1>
                <p>Manajemen konten dan data untuk website Desa Kuala Tanjung.</p>
            </div>
        </div>
        <div class="login-form-container">
            <div class="form-wrapper">
                <div class="logo">Kutaku<span>.</span></div>
                <h2>Selamat Datang Kembali</h2>
                <p class="subtitle">Silakan masuk untuk melanjutkan.</p>

                <?php if (isset($error)): ?>
                    <div class="message error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">👁️</button>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Login</button>
                </form>
                <div class="back-link">
                    <a href="index.php">← Kembali ke Website</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.password-toggle');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }
    </script>
</body>
</html>