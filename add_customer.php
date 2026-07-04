<?php
require_once 'config.php';
require_once 'classes.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? '');

    if (!empty($name) && !empty($phone) && !empty($service)) {
        $customerObj = new Customer($pdo);
        if ($customerObj->addCustomer($name, $phone, $service)) {
            $message = 'Mteja ameongezwa kwa usalama (Data Imekuwa Encrypted)!';
        } else {
            $message = 'Imeshindikana kuongeza mteja.';
        }
    } else {
        $message = 'Tafadhali jaza nafasi zote!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ongeza Mteja - Salon Smart System</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 12px; margin: 8px 0 20px 0; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #28a745; border: none; color: white; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; }
        .msg { background: #e2f0d9; color: #385723; padding: 10px; border-radius: 4px; text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="nav">
        <a href="index.php">Dashboard</a>
        <a href="logout.php">Log Out</a>
    </div>
    
    <h2>Ongeza Mteja Mpya</h2>
    <?php if (!empty($message)): ?>
        <div class="msg"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    
    <form action="add_customer.php" method="POST">
        <label>Jina la Mteja</label>
        <input type="text" name="name" required>
        
        <label>Namba ya Simu</label>
        <input type="text" name="phone" required>
        
        <label>Huduma (Mfano: Kusuka, Kunyoa)</label>
        <input type="text" name="service" required>
        
        <button type="submit">Hifadhi Mteja</button>
    </form>
</div>
</body>
</html>
