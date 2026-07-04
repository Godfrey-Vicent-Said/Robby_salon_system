<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once 'config.php';
require_once 'classes.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $userObj = new User($pdo);
    if ($userObj->login($username, $password)) {
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
    <title>Salon Smart System - Login</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; font-weight: bold; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Salon Smart System</h2>
    <?php if (!empty($error)): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="POST">
        <label>Username</label><input type="text" name="username" placeholder="Robby" required>
        <label>Password</label><input type="password" name="password" placeholder="12345" required>
        <button type="submit">Ingia Mfumoni</button>
    </form>
</div>
</body>
</html>
