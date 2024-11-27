<?php
include_once '../../config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G3MS - Event Organizer</title>
  
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../src/css/user.css">
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
</body>
</html>

  <div class="hero">
    <h1>Your Professional Event Organizer</h1>
    <p>"From concept to completion, we deliver events that resonate. Let us turn your goals into unforgettable experiences."</p>
  </div>

  <div class="events">
    <div><img src="../../src/img/birthday.jpeg" alt="Birthday"><p>Birthday</p></div>
    <div><img src="../../src/img/wedding.jpeg" alt="Wedding"><p>Wedding</p></div>
    <div><img src="../../src/img/christening.jpeg" alt="Christening"><p>Christening</p></div>
    <div><img src="../../src/img/anniversary.jpeg" alt="Anniversary"><p>Anniversary</p></div>
  </div>

  <div class="packages">
    <h2>Packages:</h2>
    <div class="packages-container">
      <div class="package">
        <h3>Package 1: Deluxe Event Package</h3>
        <ul>
          <li>Venue</li>
          <li>Emcee</li>
          <li>Catering</li>
          <li>On-site staff</li>
          <li>Luxury Decorations</li>
          <li>Red carpet services</li>
          <li>Special lighting effects</li>
          <li>Transportation services</li>
          <li>Photography & Videography</li>
        </ul>
      </div>
      <div class="package">
        <h3>Package 2: Premium Event Package</h3>
        <ul>
          <li>Venue</li>
          <li>Emcee</li>
          <li>Catering</li>
          <li>On-site staff</li>
          <li>Luxury Decorations</li>
          <li>Photography & Videography</li>
        </ul>
      </div>
      <div class="package">
        <h3>Package 3: Basic Event Package</h3>
        <ul>
          <li>Venue</li>
          <li>Emcee</li>
          <li>Catering</li>
          <li>Luxury Decorations</li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
