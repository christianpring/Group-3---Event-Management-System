<?php 
include_once '../../config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G3MS - Event Organizer</title>
  <link rel="stylesheet" href="../../src/css/user.css">
  <style>
    body {
      background-image: url('../../src/img/background.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      color: white;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    nav {
      background-color: rgba(15, 37, 115, 0.8);
      color: #ADE1FB;
      padding: 20px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }

    nav ul {
      list-style: none;
      display: flex;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      margin: 0 15px;
    }

    nav ul li a {
      text-decoration: none;
      color: #ADE1FB;
      font-weight: bold;
      transition: color 0.3s;
    }

    nav ul li a:hover {
      color: #FFFFFF;
    }

    .hero {
      text-align: center;
      margin: 100px auto;
      max-width: 80%;
      color: white;
    }

    .hero h1 {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 20px;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    .slider {
      position: relative;
      width: 90%;
      max-width: 800px;
      margin: 50px auto;
      overflow: hidden;
    }

    .slider-container {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .slide {
      min-width: 100%;
      box-sizing: border-box;
      text-align: center;
    }

    .slide img {
      width: 100%;
      border-radius: 10px;
    }

    .slide p {
      margin-top: 10px;
      font-size: 1.2rem;
      color: #266CA9;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
    }

    button.prev,
    button.next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(0, 0, 0, 0.6);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button.prev:hover,
    button.next:hover {
      background-color: rgba(0, 0, 0, 0.8);
    }

    button.prev {
      left: 10px;
    }

    button.next {
      right: 10px;
    }
  </style>
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

  <div class="hero">
    <h1>Your Professional Event Organizer</h1>
    <p>"From concept to completion, we deliver events that resonate. Let us turn your goals into unforgettable experiences."</p>
  </div>

  <div class="slider">
    <div class="slider-container">
      <div class="slide">
        <img src="../../src/img/birthday.jpeg" alt="Birthday">
        <p>Birthday</p>
      </div>
      <div class="slide">
        <img src="../../src/img/wedding.jpeg" alt="Wedding">
        <p>Wedding</p>
      </div>
      <div class="slide">
        <img src="../../src/img/christening.jpeg" alt="Christening">
        <p>Christening</p>
      </div>
      <div class="slide">
        <img src="../../src/img/anniversary.jpeg" alt="Anniversary">
        <p>Anniversary</p>
      </div>
    </div>
    <button class="prev">&lt;</button>
    <button class="next">&gt;</button>
  </div>

  <script>
    const sliderContainer = document.querySelector('.slider-container');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');

    let currentIndex = 0;

    function updateSlider() {
      sliderContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    nextBtn.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % slides.length;
      updateSlider();
    });

    prevBtn.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      updateSlider();
    });
  </script>
</body>
</html>
