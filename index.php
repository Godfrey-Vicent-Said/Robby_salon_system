<?php
require_once 'config.php';
require_once 'classes.php';

// ULINZI (Session Management): Kama haja-login arudishwe login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    Customer::delete($pdo, intval($_GET['delete_id']));
    header("Location: index.php");
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$customers = Customer::viewAll($pdo, $search);
$total_customers = count($customers);
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>Salon System - Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; margin: 0; padding: 30px; }
        .dashboard-container { max-width: 1000px; background: #fff; margin: 0 auto; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; }
        .logo-text { font-size: 22px; font-weight: bold; color: #1e293b; }
        .btn { padding: 10px 20px; border-radius: 6px; text-decoration: none; color: white; font-size: 14px; font-weight: 500; }
        .btn-add { background: #3b82f6; }
        .btn-logout { background: #ef4444; }
        .btn-delete { background: #ef4444; padding: 6px 12px; font-size: 12px; text-decoration: none; border-radius: 4px;}
        .search-box { margin: 20px 0; display: flex; gap: 10px; }
        .search-box input { flex: 1; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; }
        .search-box button { padding: 12px 24px; background: #1e293b; border: 0; color: white; border-radius: 6px; cursor: pointer; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; border-radius: 8px; overflow: hidden; }
        th, td { padding: 14px; text-align: left; }
        th { background-color: #f8fafc; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 12px; border-bottom: 2px solid #edf2f7; }
        td { border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 15px; }
        tr:hover { background-color: #f8fafc; }
        .report-card { background: #dcfce7; padding: 15px 20px; border-radius: 8px; font-weight: bold; color: #15803d; border: 1px solid #bbf7d0; display: inline-block; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="dashboard-container">
    <div class="header">
        <div class="logo-text">💇‍♂️ SALON SMART SYSTEM</div>
        <div style="font-size: 15px; color:#64748b;">Mtumiaji: <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></div>
        <div>
            <a href="add_customer.php" class="btn btn-add">+ Sajili Mteja</a>
            <a href="logout.php" class="btn btn-logout">Toka</a>
        </div>
    </div>

    <div class="report-card">
        📊 RIPOTI: Jumla ya Wateja waliopo: <?php echo $total_customers; ?>
    </div>

    <form action="index.php" method="GET" class="search-box">
        <input type="text" name="search" placeholder="Tafuta mteja kwa jina au aina ya huduma..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Tafuta</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Jina la Mteja</th>
                <th>Namba ya Simu</th>
                <th>Huduma Aliyopata</th>
                <th>Kitendo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($customers)): ?>
                <tr><td colspan="5" style="text-align:center; color: #94a3b8;">Hakuna mteja kwenye mfumo kwa sasa.</td></tr>
            <?php else: ?>
                <?php foreach ($customers as $c): ?>
                    <tr>
                        <td><b><?php echo $c['id']; ?></b></td>
                        <td><?php echo htmlspecialchars($c['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($c['phone_number']); ?></td>
                        <td><span style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 13px;"><?php echo htmlspecialchars($c['service_type']); ?></span></td>
                        <td><a href="index.php?delete_id=<?php echo $c['id']; ?>" class="btn btn-delete" onclick="return confirm('Una uhakika unataka kufuta?')">Futa</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>