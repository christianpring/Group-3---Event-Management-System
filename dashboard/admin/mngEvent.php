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


require_once '../../database/dbconnection.php'; // Include database connection file
// Fetch Events
$eventsQuery = $db->prepare("SELECT * FROM events");
$eventsQuery->execute();
$events = $eventsQuery->fetchAll(PDO::FETCH_ASSOC);

// Fetch Packages
$packagesQuery = $db->prepare("SELECT * FROM packages");
$packagesQuery->execute();
$packages = $packagesQuery->fetchAll(PDO::FETCH_ASSOC);

// Handle Update Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_event'])) {
    $eventId = $_POST['event_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $updateEventQuery = $db->prepare("UPDATE events SET name = ?, description = ? WHERE id = ?");
    $updateEventQuery->execute([$name, $description, $eventId]);

    header('Location: mngEvent.php');
}

// Handle Update Package
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_package'])) {
    $packageId = $_POST['package_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $updatePackageQuery = $db->prepare("UPDATE packages SET name = ?, price = ?, description = ? WHERE id = ?");
    $updatePackageQuery->execute([$name, $price, $description, $packageId]);

    header('Location: mngEvent.php');
}

// Handle Add Package
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_package'])) {
    $eventId = $_POST['event_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $addPackageQuery = $db->prepare("INSERT INTO packages (event_id, name, price, description) VALUES (?, ?, ?, ?)");
    $addPackageQuery->execute([$eventId, $name, $price, $description]);

    header('Location: mngEvent.php');   
    exit; // Ensure no further code is executed after redirection
}

// Handle Delete Package
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_package'])) {
    $packageId = $_POST['delete_package_id'];

    // Prepare and execute the delete query
    $deletePackageQuery = $db->prepare("DELETE FROM packages WHERE id = ?");
    $deletePackageQuery->execute([$packageId]);

    header('Location: mngEvent.php');
    exit; // Ensure no further code is executed after redirection
}

// Handle Delete Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {
    $eventId = $_POST['delete_event_id'];

    // Prepare and execute the delete query
    $deleteEventQuery = $db->prepare("DELETE FROM events WHERE id = ?");
    $deleteEventQuery->execute([$eventId]);

    header('Location: mngEvent.php');
    exit; // Ensure no further code is executed after redirection
}
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
    <link rel="stylesheet" href="../../src/css/admin css/manageEvent.css">
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
        <h1>Manage Events</h1>

        <!-- Event Section -->
        <h2>Events</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= $event['id'] ?></td>
                    <td><?= htmlspecialchars($event['name']) ?></td>
                    <td><?= htmlspecialchars($event['description']) ?></td>
                    <td>
                        <form action="mngEvent.php" method="post">
                            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>
                            <input type="text" name="description" value="<?= htmlspecialchars($event['description']) ?>">
                            <button type="submit" name="update_event">Update</button>
                            <input type="hidden" name="delete_event_id" value="<?= $event['id'] ?>">
                            <button type="submit" name="delete_event" class="delete-button" onclick="return confirm('Are you sure you want to delete this event?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

       <!-- Package Section -->
       <h2>Packages</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Event ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($packages as $package): ?>
                <tr>
                    <td><?= $package['id'] ?></td>
                    <td><?= $package['event_id'] ?></td>
                    <td><?= htmlspecialchars($package['name']) ?></td>
                    <td><?= $package['price'] ?></td>
                    <td><?= htmlspecialchars($package['description']) ?></td>
                    <td>
                        <form action="mngEvent.php" method="post">
                            <input type="hidden" name="package_id" value="<?= $package['id'] ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($package['name']) ?>" required>
                            <input type="number" step="0.01" name="price" value="<?= $package['price'] ?>" required>
                            <input type="text" name="description" value="<?= htmlspecialchars($package['description']) ?>">
                            <button type="submit" name="update_package">Update</button>
                            <input type="hidden" name="delete_package_id" value="<?= $package['id'] ?>">
                            <button type="submit" name="delete_package" class="delete-button" onclick="return confirm('Are you sure you want to delete this package?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Add Package Section -->
        <div class="container">
    <h2>Add Package</h2>
    <form id="add-package-form" action="mngEvent.php" method="post">
        <label for="event_id">Event ID:</label>
        <select name="event_id" id="event_id" required>
            <?php foreach ($events as $event): ?>
                <option value="<?= $event['id'] ?>">Event <?= $event['id'] ?>: <?= htmlspecialchars($event['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" id="price" required>

        <label for="description">Description:</label>
        <input type="text" name="description" id="description">

        <button type="submit" name="add_package">Add Package</button>
    </form>
</div>

    </div>
</body>
</html>
