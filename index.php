<?php
error_reporting(0);
ini_set('display_errors', 0);
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
    <title>Dashboard - Salon Smart System</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
<div class="container">
    <div style="float: right;"><a href="logout.php" style="color: red;">Log Out</a></div>
    <h2>Dashboard</h2>
    <p>Karibu, <?php echo htmlspecialchars($_SESSION['user']); ?> | <a href="add_customer.php">Ongeza Mteja Mpya</a></p>
    <hr>
    <h3>Orodha ya Wateja</h3>
    <table>
        <tr><th>ID</th><th>Jina</th><th>Simu</th><th>Huduma</th></tr>
        <?php foreach ($customers as $c): ?>
        <tr>
            <td><?php echo htmlspecialchars($c['id']); ?></td>
            <td><?php echo htmlspecialchars($c['name']); ?></td>
            <td><?php echo htmlspecialchars($c['phone']); ?></td>
            <td><?php echo htmlspecialchars($c['service']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
