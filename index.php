<?php
require_once 'config.php';
require_once 'classes.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$customerObj = new Customer($pdo);
$customers = $customerObj->getAllCustomers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Smart System - Home</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; font-weight: bold; }
        .logout { float: right; color: #dc3545 !important; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<div class="container">
    <div class="nav">
        <a href="index.php">Nyumbani (Dashboard)</a>
        <a href="add_customer.php">Ongeza Mteja</a>
        <a href="logout.php" class="logout">Log Out</a>
    </div>
    
    <h1>Salon Smart System</h1>
    <p>Karibu, <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong></p>
    <hr>
    
    <h3>Orodha ya Wateja (Data Zilizotolewa na Kufanyiwa Decryption)</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Jina la Mteja</th>
                <th>Namba ya Simu</th>
                <th>Huduma</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($customers)): ?>
                <tr><td colspan="4" style="text-align:center;">Hakuna wateja waliorekodiwa bado.</td></tr>
            <?php else: ?>
                <?php foreach ($customers as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['id']); ?></td>
                        <td><?php echo htmlspecialchars($c['name']); ?></td>
                        <td><?php echo htmlspecialchars($c['phone']); ?></td>
                        <td><?php echo htmlspecialchars($c['service']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
