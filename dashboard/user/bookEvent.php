<?php
require_once '../admin/authentication/admin-class.php';
$admin = new ADMIN();
$userId = $_SESSION['adminSession'];

// Fetch available events from the database
$stmt = $admin->runQuery("SELECT * FROM events");
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$events) {
    echo "No events found.";
    exit; // Exit early if no events are found
}

// Check if event_id is passed in the query string, and store it in the session
if (isset($_GET['event_id'])) {
    $_SESSION['selected_event'] = $_GET['event_id'];
    header('Location: package.php'); // Redirect to package.php after setting the event ID
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Event</title>
    <link rel="stylesheet" href="../../src/css/bookEvent.css">
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

    <h1>Book Your Event Now</h1>
    <div class="event-container">
        <?php foreach ($events as $event): ?>
            <div class="event-card" onclick="redirectToPackage(<?= $event['id'] ?>)">
                <img src="<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['name']) ?> Event">
                <h2><?= htmlspecialchars($event['name']) ?></h2>
                <p><?= htmlspecialchars($event['description']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // Function that is called when the user clicks on an event
        function redirectToPackage(eventId) {
            if (confirm("Do you want to continue with this event?")) {
                // Redirect to package.php and pass the event_id via GET request
                window.location.href = `package.php?event_id=${eventId}`;
            }
        }
    </script>
</body>
</html>
