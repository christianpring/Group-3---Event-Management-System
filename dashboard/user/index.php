<?php  
include_once '../../config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../src/css/user.css">

    <!-- Inline CSS for Background Image -->
    <style>
        body {
            background-image: url('../../src/img/background2.jpg'); /* Path to background image */
            background-size: cover; /* Ensures the image covers the entire page */
            background-repeat: no-repeat; /* Prevents background repetition */
            background-position: center; /* Centers the background image */
            margin: 0; /* Removes default margin */
            font-family: Arial, sans-serif; /* Default font style */
            color: #333; /* Default text color */
        }
    </style>
</head>
<body>
    <!-- Navigation -->
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

    <!-- Hero Section -->
    <div class="hero">
        <h1>Your Professional Event Organizer</h1>
        <p>"From concept to completion, we deliver events that resonate. Let us turn your goals into unforgettable experiences."</p>
    </div>

  

    <!-- Slider Script -->
    <div class="slider">
  <div class="slider-container">
    <div class="slide"><img src="../../src/img/birthday.jpeg" alt="Birthday"><p>Birthday</p></div>
    <div class="slide"><img src="../../src/img/wedding.jpeg" alt="Wedding"><p>Wedding</p></div>
    <div class="slide"><img src="../../src/img/christening.jpeg" alt="Christening"><p>Christening</p></div>
    <div class="slide"><img src="../../src/img/anniversary.jpeg" alt="Anniversary"><p>Anniversary</p></div>
  </div>
  <button class="prev">&lt;</button>
  <button class="next">&gt;</button>
</div>
<script src="../../src/js/slider.js"></script>
</body>
</html>
