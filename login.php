<?php
require_once 'config.php';

$error = '';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Tafadhali jaza nafasi zote!";
    } else {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Username au Password sio sahihi!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Salon Smart System - Login</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            /* Picha halisi ya saluni ya kishua (Real-world interior) */
            background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=1200&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .login-container { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.3); 
            width: 100%; 
            max-width: 360px; 
            backdrop-filter: blur(5px);
        }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 25px; font-weight: 600; letter-spacing: 1px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #34495e; font-weight: 500; }
        input[type="text"], input[type="password"] { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #cbd5e1; 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 14px;
        }
        button { 
            width: 100%; 
            padding: 12px; 
            background: #2c3e50; 
            border: 0; 
            border-radius: 6px; 
            color: white; 
            font-size: 16px; 
            font-weight: bold;
            cursor: pointer; 
        }
        button:hover { background: #1a252f; }
        .error { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 10px; 
            border-radius: 6px; 
            text-align: center; 
            margin-bottom: 20px; 
            font-size: 14px; 
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>SALON SYSTEM</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Ingiza Username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Ingiza Password" required>
        </div>
        <button type="submit">Ingia Kwenye Mfumo</button>
    </form>
</div>
</body>
</html>