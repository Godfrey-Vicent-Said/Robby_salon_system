<?php
require_once 'config.php';
require_once 'classes.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone_number']);
    $service = trim($_POST['service_type']);

    if (empty($name) || empty($phone) || empty($service)) {
        $message = "<div style='color:red;'>Tafadhali jaza nafasi zote!</div>";
    } else {
        $customer = new Customer($pdo, $_SESSION['user_id'], $name, $phone, $service);
        if ($customer->save()) {
            $message = "<div style='color:green;'>Mteja amesajiliwa na data zake zimesimbwa (Encrypted)!</div>";
        } else {
            $message = "<div style='color:red;'>Makosa yamejitokeza.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Sajili Mteja Mpya</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; padding: 20px; }
        .form-container { max-width: 450px; background: #fff; margin: 30px auto; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { color: #1e293b; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #475569; }
        input[type="text"] { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; }
        .btn { padding: 11px 20px; border: 0; border-radius: 6px; color: white; cursor: pointer; font-size: 15px; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-save { background: #28a745; margin-right: 10px; }
        .btn-back { background: #6c757d; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Sajili Mteja Mpya</h2>
    <?php echo $message; ?>
    <form action="add_customer.php" method="POST" style="margin-top: 15px;">
        <div class="form-group">
            <label>Jina Kamili la Mteja</label>
            <input type="text" name="customer_name" placeholder="Mf. Juma Hamis" required>
        </div>
        <div class="form-group">
            <label>Namba ya Simu</label>
            <input type="text" name="phone_number" placeholder="Mf. 0711XXXXXX" required>
        </div>
        <div class="form-group">
            <label>Aina ya Huduma</label>
            <input type="text" name="service_type" placeholder="Mf. Kunyoa au Kusuka" required>
        </div>
        <button type="submit" class="btn btn-save">Hifadhi Mteja</button>
        <a href="index.php" class="btn btn-back">Rudi Dashboard</a>
    </form>
</div>
</body>
</html>