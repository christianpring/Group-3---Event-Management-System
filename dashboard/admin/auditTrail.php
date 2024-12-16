<?php
require_once 'authentication/admin-class.php';

$admin = new ADMIN();

if(!$admin->isUserLoggedIn())
{
    $admin->redirect('../../');
}

try {
    $db = new PDO('mysql:host=localhost;dbname=itelec2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$auditsQry = $db->prepare("SELECT * FROM logs where activity <> 'Has Successfully signed in.'");
$auditsQry->execute();
$audits = $auditsQry->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const dropdownButtons = document.querySelectorAll('.dropdown-btn');

    dropdownButtons.forEach(button => {
        button.addEventListener('click', () => {
            const dropdownMenu = button.nextElementSibling;
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            } else {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
                dropdownMenu.classList.add('show');
            }
        });
    });
});
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../src/css/admin.css">
    <link rel="stylesheet" href="../../src/css/admin css/viewUser.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="logo">G3MS</div>
    <ul class="sidebar-nav">
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-btn">User Management</a>
            <ul class="dropdown-menu">
                <li><a href="viewUser.php">View User</a></li>
                <li><a href="removeUser.php">Remove User</a></li>
                <li><a href="userLogs.php">User Logs</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-btn">Event Management</a>
            <ul class="dropdown-menu">
            <li><a href="mngEvent.php">Manage Events</a></li>
            <li><a href="crtEvent.php">Create Events</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-btn">Ticket Management</a>
            <ul class="dropdown-menu">
            <li><a href="viewTrans.php">View Transaction</a></li>
            <li><a href="auditTrail.php">Audit Trail</a></li>
            </ul>
        </li>
    </ul>
    <a href="../admin/authentication/admin-class.php?admin_signout" class="sign-out-btn">Sign Out</a>
</div>
    <!-- Main Content Area -->
    <div class="content">
        <!-- You can add more content here -->
        <h1>Audit Trails</h1>

        <table border="1">
            <tr>
                <th>User ID</th>
                <th>Activity</th>
                <th>Timestamp</th>
            </tr>
            <?php foreach ($audits as $audit): ?>
            <tr>
                <td><?= $audit['user_id']?></td>
                <td><?= $audit['activity']?></td>
                <td><?= $audit['created_at']?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
