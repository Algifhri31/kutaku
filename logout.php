<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6fb;
            margin: 0;
            padding: 0;
        }
        .login-container {
            max-width: 380px;
            margin: 60px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 28px 24px 28px;
            text-align: center;
        }
        h2 {
            color: #2d3a4b;
            margin-bottom: 18px;
        }
        .message.success {
            background: #eaffea;
            color: #388e3c;
            border: 1px solid #b6eab6;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 24px;
        }
        a.button {
            display: inline-block;
            background: #4f8cff;
            color: #fff;
            padding: 12px 32px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: background 0.2s;
        }
        a.button:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Logout Berhasil</h2>
        <div class="message success">Anda telah berhasil logout dari dashboard admin.</div>
        <a href="login.php" class="button">Kembali ke Login</a>
    </div>
</body>
</html>