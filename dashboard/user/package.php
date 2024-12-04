<?php
require_once '../admin/authentication/admin-class.php';
$admin = new ADMIN();
$userId = $_SESSION['adminSession'];

// Fetch the selected event ID from session or query parameter
$eventId = $_SESSION['selected_event'] ?? $_GET['event_id'] ?? 0;

// Ensure eventId is valid
if ($eventId == 0) {
    echo "No event selected.";
    exit;
}

// Fetch packages for the selected event
$stmt = $admin->runQuery("SELECT * FROM packages WHERE event_id = :event_id");
$stmt->execute([':event_id' => $eventId]);
$packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Save selected package in session if 'package_id' is passed in the URL
if (isset($_GET['package_id'])) {
    $_SESSION['selected_package'] = $_GET['package_id']; 
    header('Location: schedule.php?event_id=' . $_GET['event_id'] . '&package_id=' . $_GET['package_id']); // Make sure the event_id and package_id are in the URL
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Package</title>
    <link rel="stylesheet" href="../../src/css/package.css">
</head>
<body>
    <nav>
        <div class="logo">G3MS</div>
        <ul class="main-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="bookEvent.php">Book Event</a></li>
            <li><a href="userTransaction.php">My Transaction</a></li>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
        <a href="../admin/authentication/admin-class.php?admin_signout" class="sign-out-btn">Sign Out</a>
    </nav>

    <h1>Select a Package for Your Event</h1>

    <div class="package-container">
        <!-- Dynamically generate package cards -->
        <?php foreach ($packages as $package): ?>
            <div class="package-card" onclick="selectPackage(<?= $package['id'] ?>)">
                <h2><?= htmlspecialchars($package['name']) ?></h2>
                <p><?= htmlspecialchars($package['description']) ?></p>
                <p>Price: $<?= number_format($package['price'], 2) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function selectPackage(packageId) {
            if (confirm("Do you want to proceed with this package?")) {
                window.location.href = `schedule.php?package_id=${packageId}&event_id=<?php echo $eventId; ?>`; // Pass both event_id and package_id to schedule.php
            }
        }
    </script>
</body>
</html>
