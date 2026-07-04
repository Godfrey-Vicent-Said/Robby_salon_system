<?php
// Zima kabisa error zote zisionekane kwenye screen hata zikitokea
error_reporting(0);
ini_set('display_errors', 0);

require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Kuingia moja kwa moja bila kugusa database
    if ($username === 'Robby' && $password === '12345') {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'admin';
        
        header('Location: index.php'); 
        exit;
    } else {
        $error = 'Username au Password sio sahihi!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Smart System - Login</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 350px; }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; text-align: center; margin-bottom: 20px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; margin: 8px 0 20px 0; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #007bff; border: none; color: white; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Salon Smart System</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" placeholder="Weka Robby" required>
        
        <label>Password</label>
        <input type="password" name="password" placeholder="Weka 12345" required>
        
        <button type="submit">Ingia Kwenye Mfumo</button>
    </form>
</div>
</body>
</html>
