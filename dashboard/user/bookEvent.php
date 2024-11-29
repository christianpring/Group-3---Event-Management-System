<?php
session_start();

// Updated package details
$packages = [
    'Birthday' => [
        ['name' => 'Package 1', 'price' => 1500, 'details' => '• Venue • Emcee • Catering • On-site staff • Luxury Decorations • Red carpet services • Special lightning effect • Transportation services • Photography & Videography'],
        ['name' => 'Package 2', 'price' => 1000, 'details' => '• Venue • Emcee • Catering • On-site staff • Luxury Decorations • Photography & Videography'],
        ['name' => 'Package 3', 'price' => 700, 'details' => '• Venue • Emcee • Catering • Luxury Decorations']
    ],
    'Wedding' => [
        ['name' => 'Package 1', 'price' => 5000, 'details' => '• Venue • Emcee • Catering • On-site staff • Luxury Decorations • Red carpet services • Special lightning effect • Transportation services • Photography & Videography'],
        ['name' => 'Package 2', 'price' => 3500, 'details' => '• Venue • Emcee • Catering • On-site staff • Luxury Decorations • Photography & Videography'],
        ['name' => 'Package 3', 'price' => 2500, 'details' => '• Venue • Emcee • Catering • Luxury Decorations']
    ],
    'Christening' => [
        ['name' => 'Package 1', 'price' => 2000, 'details' => '• Venue • Emcee • Catering • On-site staff • Luxury Decorations • Red carpet services • Special lightning effect • Transportation services • Photography & Videography'],
        ['name' => 'Package 2', 'price' => 1500, 'details' => '• Venue • Emcee • Catering • On-site staff • Luxury Decorations • Photography & Videography'],
        ['name' => 'Package 3', 'price' => 1000, 'details' => '• Venue • Emcee • Catering • Luxury Decorations']
    ],
    'Anniversary' => [
        ['name' => 'Package 1', 'price' => 3000, 'details' => '• Venue • Emcee • Catering • On-site staff • Luxury Decorations • Red carpet services • Special lightning effect • Transportation services • Photography & Videography'],
        ['name' => 'Package 2', 'price' => 2000, 'details' => '• Venue • Emcee • Catering • On-site staff • Luxury Decorations • Photography & Videography'],
        ['name' => 'Package 3', 'price' => 1500, 'details' => '• Venue • Emcee • Catering • Luxury Decorations']
    ]
];

// Event background images for each event
$event_images = [
    'Birthday' => '../../src/images/Birthday 1_2.jpeg',
    'Wedding' => '../../src/images/Wedding 1_2.jpeg',
    'Christening' => '../../src/images/Christening 1_2.jpeg',
    'Anniversary' => '../../src/images/Party 1_1.jpeg',
];


// Main logic
$step = $_GET['step'] ?? 'overview';
$event = $_SESSION['event'] ?? null;
$package = $_SESSION['package'] ?? null;
$date = $_SESSION['date'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['event'])) {
        $_SESSION['event'] = $_POST['event'];
        $step = 'choose_package';
    } elseif (isset($_POST['package'])) {
        $_SESSION['package'] = $_POST['package'];
        $step = 'schedule_date';
    } elseif (isset($_POST['date'])) {
        $_SESSION['date'] = $_POST['date'];
        $step = 'confirm_selection';
    } elseif (isset($_POST['confirm_selection'])) {
        $step = 'payment';
    } elseif (isset($_POST['complete_payment'])) {
        // Redirect to index.php after confirming payment
        echo "<h2>Transaction Complete!</h2>";
        session_destroy();
        header("Location: index.php");
        exit;
    } elseif (isset($_POST['back'])) {
        // Logic for going back to the previous step
        if ($step === 'choose_package') {
            $step = 'overview';
            unset($_SESSION['event']);
        } elseif ($step === 'schedule_date') {
            $step = 'choose_package';
            unset($_SESSION['package']);
        } elseif ($step === 'confirm_selection') {
            $step = 'schedule_date';
            unset($_SESSION['date']);
        } elseif ($step === 'payment') {
            $step = 'confirm_selection';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking</title>
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

    <!-- Header Section -->
    <header>
        <h1>Welcome to G3MS Event Booking</h1>
        <h3>Plan and book your events with ease. Choose from our range of packages designed to make your event unforgettable.</h3>
    </header>

    <?php if ($step === 'overview'): ?>
        <h2>Choose an Event</h2>
        <div class="event-container">
            <?php foreach (array_keys($packages) as $event): ?>
                <form method="post" class="event-card" style="background-image: url('<?= $event_images[$event] ?>');">
                    <h3><?= htmlspecialchars($event, ENT_QUOTES, 'UTF-8') ?></h3>
                    <p>Click to choose this event</p>
                    <button type="submit" name="event" value="<?= htmlspecialchars($event, ENT_QUOTES, 'UTF-8') ?>">Select</button>
                </form>
            <?php endforeach; ?>
        </div>
    <?php elseif ($step === 'choose_package'): ?>
        <h2>Choose Your Package</h2>
        <div class="package-container">
            <?php foreach ($packages[$_SESSION['event']] as $index => $package): ?>
                <form method="post" class="package-card">
                    <h3><?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p>Price: $<?= number_format($package['price']) ?></p>
                    <p><?= htmlspecialchars($package['details'], ENT_QUOTES, 'UTF-8') ?></p>
                    <button type="submit" name="package" value="<?= $index ?>">Select Package</button>
                </form>
            <?php endforeach; ?>
        </div>
        <form method="post">
            <button type="submit" name="back">Back</button>
        </form>
    <?php elseif ($step === 'schedule_date'): ?>
        <h2>Schedule Your Event</h2>
        <form method="post">
            <label for="date">Event Date:</label>
            <input type="date" id="date" name="date" required>
            <button type="submit" name="date">Confirm Date</button>
        </form>
        <form method="post">
            <button type="submit" name="back">Back</button>
        </form>
    <?php elseif ($step === 'confirm_selection'): ?>
        <h2>Confirm Your Selection</h2>
        <div class="p1-container">
            <p1>Event: <?= htmlspecialchars($_SESSION['event'], ENT_QUOTES, 'UTF-8') ?></p1>
            <p1>Package: <?= htmlspecialchars($packages[$_SESSION['event']][$_SESSION['package']]['name'], ENT_QUOTES, 'UTF-8') ?></p1>
            <p1>Price: $<?= number_format($packages[$_SESSION['event']][$_SESSION['package']]['price']) ?></p1>
            <p1>Date: <?= htmlspecialchars($_SESSION['date'], ENT_QUOTES, 'UTF-8') ?></p1>
        </div>
        <form method="post">
            <button type="submit" name="confirm_selection">Confirm and Proceed to Payment</button>
            <button type="submit" name="back">Back</button>
        </form>
    <?php elseif ($step === 'payment'): ?>
        <h2>Payment</h2>
        <p>Your event is ready to be booked. Please complete the payment to finalize your booking.</p>
        <form method="post">
            <button type="submit" name="complete_payment">Complete Payment</button>
        </form>
    <?php endif; ?>
</body>
</html>