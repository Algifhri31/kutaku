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

    // Cari user di database
    $result = $conn->query("SELECT * FROM admin WHERE username='$username'");

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Kalau password belum di-hash, cek langsung
        if ($password === $admin['password']) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;

            // Redirect ke dashboard admin
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 380px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 40px 32px;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            margin: 0 auto;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            pointer-events: none;
        }
        h2 {
            text-align: center;
            color: #ffffff;
            margin: 0 0 28px 0;
            font-size: 28px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
            width: 100%;
            box-sizing: border-box;
        }
        label {
            font-weight: 500;
            color: #ffffff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
            display: block;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            margin: 6px 0 18px 0;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-size: 15px;
            color: #ffffff;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            box-sizing: border-box;
        }
        .password-container {
            position: relative;
            width: 100%;
        }
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #000000;
            cursor: pointer;
            font-size: 16px;
            z-index: 2;
            transition: color 0.3s ease;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Courier New', monospace;
        }
        .password-toggle:hover {
            color: #333333;
        }
        .password-toggle:focus {
            outline: none;
        }
        input[type="text"]::placeholder, input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        input[type="password"] {
            padding-right: 50px;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border: 1.5px solid rgba(255, 255, 255, 0.8);
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }
        button[type="submit"] {
            width: 100%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 14px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            box-sizing: border-box;
            margin: 0;
        }
        button[type="submit"]:hover {
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .message {
            text-align: center;
            margin: 0 0 18px 0;
            padding: 12px;
            border-radius: 12px;
            position: relative;
            z-index: 1;
            width: 100%;
            box-sizing: border-box;
        }
        .message.error {
            background: rgba(255, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #ff6b6b;
            border: 1px solid rgba(255, 107, 107, 0.3);
        }
        .back-link {
            margin: 20px 0 0 0;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            position: relative;
            z-index: 1;
            width: 100%;
            box-sizing: border-box;
        }
        form {
            width: 100%;
            position: relative;
            z-index: 1;
            margin: 0;
            padding: 0;
        }
        form * {
            box-sizing: border-box;
        }
        .back-link a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .back-link a:hover {
            color: #ffffff;
            text-decoration: underline;
            transform: translateX(-3px);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php if (isset($error))
            echo "<div class='message error'>$error</div>"; ?>
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    👁
                </button>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="back-link">
            <a href="index.php">← Kembali ke Website</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.innerHTML = '👁‍🗨️';
            } else {
                passwordInput.type = 'password';
                toggleButton.innerHTML = '👁';
            }
        }
    </script>
</body>

</html>