<?php
require_once 'authentication/admin-class.php';

$admin = new ADMIN();

if(!$admin->isUserLoggedIn())
{
    $admin->redirect('../../');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../src/css/admin.css">
</head>
<body>
<body>
    <div class="sidebar">
        <div class="logo">G3MS</div>
        <ul class="sidebar-nav">
            <li class="dropdown">
                <a href="userMan.php" class="dropdown-btn">User Management</a>
                <ul class="dropdown-menu">
                    <li><a href="viewUser.php">View User</a></li>
                    <li><a href="removeUser.php">Remove User</a></li>
                </ul>
            </li>
            <li><a href="eventMan.php">Event Management</a></li>
            <li><a href="ticketMan.php">Ticket Management</a></li>
        </ul>
        <a href="../admin/authentication/admin-class.php?admin_signout" class="sign-out-btn">Sign Out</a>
    </div>
</body>


    <!-- Main Content Area -->
    <div class="content">
        <!-- You can add more content here -->
        <h1></h1>
    </div>
</body>
</html>
