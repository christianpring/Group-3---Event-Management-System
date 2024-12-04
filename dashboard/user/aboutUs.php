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
    <link rel="stylesheet" href="../../src/css/aboutUs.css">
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
    <br>
    <body>
        <div class="about-us">
            <div class="inner-section">
                <h1>About us</h1>
                <pc class="text">
                Welcome to G3MS, your trusted partner in creating 
                exceptional events and unforgettable experiences. With a passion
                 for precision and a 
                 commitment to excellence, we specialize in offering comprehensive 
                 event management solutions tailored to meet your unique needs.
                 we are a dynamic team of creative thinkers, meticulous planners, and passionate professionals. 
                 Whether you're planning a corporate event, a 
                 grand wedding, a product launch, or a social celebration, we bring your vision to life with creativity, efficiency, and a touch of flair.
                </p>
                <br>
                <h2>Contact Us</h2>
                <br>
                <p>
                    Mobile Number: 09462829896 <br>
                    Email: G3MS@gmail.com <br>
                    Instagram: @gemseventsplace <br>
                </p>
            </div>
        </div>
    </body>
</body>
</html>
