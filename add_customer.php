<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once 'config.php';
require_once 'classes.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $service = $_POST['service'] ?? '';

    $customerObj = new Customer($pdo);
    if ($customerObj->addCustomer($name, $phone, $service)) {
        $msg = 'Mteja alihifadhiwa kwa encryption kwa ufanisi!';[cite: 1]
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ongeza Mteja</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f6f9; }
        .form-box { max-width: 400px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        input[type="text"] { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px; background: green; color: white; border: none; width: 100%; cursor: pointer; }
    </style>
</head>
<body>
<div class="form-box">
    <a href="index.php">Rudi Nyumbani</a>
    <h2>Sajili Mteja</h2>
    <?php if($msg): ?><div style="color: green;"><?php echo $msg; ?></div><?php endif; ?>
    <form method="POST">
        <label>Jina</label><input type="text" name="name" required>
        <label>Simu</label><input type="text" name="phone" required>
        <label>Huduma</label><input type="text" name="service" required>
        <button type="submit">Hifadhi</button>
    </form>
</div>
</body>
</html>
