<?php
require_once '../admin/authentication/admin-class.php';

$admin = new ADMIN();



$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../src/css/bookEvent.css">
</head>
<body>
    <nav>
        <div class="logo">G3MS</div>
        <ul class="main-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="bookEvent.php">Book Event</a></li>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
        <a href="../admin/authentication/admin-class.php?admin_signout" class="sign-out-btn">Sign Out</a>
    </nav>

    <h1>Hello user, Book your event now.</h1>


    <div class="event-container">
    <div class="event-card" onclick="redirectToPackage('Birthday')">
        <img src="../../src/img/birthday.jpeg" alt="Birthday Event">
        <h2>Birthday</h2>
        <p>Celebrate your special day with loved ones!</p>
    </div>
    <div class="event-card" onclick="redirectToPackage('Wedding')">
        <img src="../../src/img/wedding.jpeg" alt="Wedding Event">
        <h2>Wedding</h2>
        <p>Say "I Do" in the perfect setting.</p>
    </div>
    <div class="event-card" onclick="redirectToPackage('Christening')">
        <img src="../../src/img/christening.jpeg" alt="Christening Event">
        <h2>Christening</h2>
        <p>Welcome your little one into the world.</p>
    </div>
    <div class="event-card" onclick="redirectToPackage('Anniversary')">
        <img src="../../src/img/anniversary.jpeg" alt="Anniversary Event">
        <h2>Anniversary</h2>
        <p>Celebrate your love and togetherness.</p>
    </div>
</div>
<script>
    function redirectToPackage(eventType) {
        if (confirm(`Do you want to continue with the ${eventType} event?`)) {
            // Redirect to package.php with the event type as a query parameter
            window.location.href = `package.php?event=${eventType}`;
        }
    }
</script>

</body>
</html>