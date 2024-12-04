<?php
require_once 'authentication/admin-class.php';

$admin = new ADMIN();

if (!$admin->isUserLoggedIn()) {
    $admin->redirect('../../');
}

// Update the SQL query to join with the packages table
$stmt = $admin->runQuery("
    SELECT b.id, u.username, e.name AS event_name, p.name AS package_name, b.event_date, b.status, b.created_at
    FROM bookings b
    JOIN user u ON b.user_id = u.id
    JOIN packages p ON b.package_id = p.id
    JOIN events e ON b.event_id = e.id
    ORDER BY b.created_at DESC
");

$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../src/css/admin.css">
    <link rel="stylesheet" href="../../src/css/admin css/viewTransaction.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">G3MS</div>
        <ul class="sidebar-nav">
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropdown-btn">User  Management</a>
                <ul class="dropdown-menu">
                    <li><a href="viewUser .php">View User</a></li>
                    <li><a href="removeUser .php">Remove User</a></li>
                    <li><a href="userLogs.php">User  Logs</a></li>
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
        <h1>Transaction Logs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Event</th>
                    <th>Package</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking['id'] ?></td>
                    <td><?= htmlspecialchars($booking['username']) ?></td>
                    <td><?= htmlspecialchars($booking['event_name']) ?></td>
                    <td><?= htmlspecialchars($booking['package_name']) ?></td>
                    <td><?= htmlspecialchars($booking['event_date']) ?></td>            
                    <td><?= htmlspecialchars($booking['status']) ?></td>
                    <td><?= htmlspecialchars($booking['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>