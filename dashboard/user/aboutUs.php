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
    <title>About Us</title>
    <link rel="stylesheet" href="../../src/css/aboutUs.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
    
    <main>
        <div class="about-us">
            <div class="image-section">
                <img src="../../src/img/aboutUs.jpg" alt="About Us" />
            </div>
            <div class="text-section">
                <h1>About Us</h1>
                <p>Welcome to G3MS, your trusted partner in creating exceptional events and unforgettable experiences. With a passion for precision and a commitment to excellence, we specialize in offering comprehensive event management solutions tailored to meet your unique needs.</p>
                <p>We are a dynamic team of creative thinkers, meticulous planners, and passionate professionals. Whether you're planning a corporate event, a grand wedding, a product launch, or a social celebration, we bring your vision to life with creativity, efficiency, and a touch of flair.</p>
            </div>
        </div>

        <div class="contact-info">
            <p><i class="fas fa-phone"></i> 09462829896</p>
            <p><i class="fas fa-envelope"></i> G3MS@gmail.com</p>
            <p><i class="fab fa-instagram"></i> @gemseventsplace</p>
        </div>
    </main>
</body>
</html>
