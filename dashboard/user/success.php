<?php
// Ensure the session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure the booking_id parameter is present in the URL
if (!isset($_GET['booking_id'])) {
    die("Invalid booking ID. The booking_id parameter is missing from the URL.");
}

$bookingId = $_GET['booking_id'];

// If bookingId is invalid or 0, show an error
if ($bookingId === '0') {
    die("Booking ID is 0, which indicates an issue with the URL parameter.");
}

// Now connect to the database and fetch the booking details using prepared statements
try {
    $pdo = new PDO("mysql:host=localhost;dbname=itelec2", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the query with a parameterized booking ID
    $stmt = $pdo->prepare("SELECT b.id, e.name AS event_name, p.name AS package_name, b.event_date, b.status, b.created_at, u.username, u.email, p.price AS amount
                           FROM bookings b
                           JOIN user u ON b.user_id = u.id
                           JOIN events e ON b.event_id = e.id
                           JOIN packages p ON b.package_id = p.id
                           WHERE b.id = :booking_id");
    // Execute the query with the provided booking ID
    $stmt->execute([':booking_id' => $bookingId]);

    // Fetch the booking record
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    // If booking not found, display an error
    if (!$booking) {
        die("Booking not found. No booking found with ID: $bookingId");
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful</title>
    <link rel="stylesheet" href="../../src/css/success.css">
</head>
<body>
    <div class="container">
        <h1>Booking Confirmed!</h1>
        <p>Thank you, <strong><?= htmlspecialchars($booking['username']) ?></strong>.</p>
        <p>Your booking has been successfully confirmed. Details are below:</p>
        <div class="receipt">
            <p><strong>Event:</strong> <?= htmlspecialchars($booking['event_name']) ?></p>
            <p><strong>Package:</strong> <?= htmlspecialchars($booking['package_name']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($booking['event_date']) ?></p>
            <p><strong>Amount Paid:</strong> $<?= number_format($booking['amount'], 2) ?></p>
        </div>
        <a href="bookEvent.php" class="btn">Book Another Event</a>
    </div>
</body>
</html>
