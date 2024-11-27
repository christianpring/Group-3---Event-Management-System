<?php
include_once '../../config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G3MS - Event Organizer</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    header {
      background-color: #0056b3;
      color: white;
      padding: 10px 0;
    }

    header .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    header .nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
    }

    header .nav a:hover {
      text-decoration: underline;
    }

    header button {
      background-color: #0056b3;
      color: white;
      border: 1px solid white;
      padding: 5px 10px;
      cursor: pointer;
    }

    header button:hover {
      background-color: white;
      color: #0056b3;
    }

    .hero {
      padding: 40px 20px;
    }

    .hero h1 {
      font-size: 2em;
      color: #0056b3;
      font-style: "Times New Roman"
      ;
    }

    .hero p {
      color: #555;
      max-width: 800px;
      margin: 0 auto;
    }

    .events {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 20px 0;
      flex-wrap: wrap;
    }

    .events img {
      width: 200px;
      height: 150px;
      object-fit: cover;
      border-radius: 10px;
    }

    .packages {
      background-color: #f8f9fa;
      padding: 20px;
    }

    .packages h2 {
      color: #0056b3;
    }

    .packages-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .package {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      width: 300px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      text-align: left;
    }

    .package ul {
      list-style-type: none;
      padding: 0;
    }

    .package li {
      margin: 5px 0;
    }
  </style>
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
    <div><img src="img/birthday.jpeg" alt="Birthday"><p>Birthday</p></div>
    <div><img src="img/wedding.jpeg" alt="Wedding"><p>Wedding</p></div>
    <div><img src="img/christening.jpeg" alt="Christening"><p>Christening</p></div>
    <div><img src="img/anniversary.jpeg" alt="Anniversary"><p>Anniversary</p></div>
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
