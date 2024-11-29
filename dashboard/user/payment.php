<?php
$eventType = $_GET['event'] ?? 'Unknown Event';
$packageName = $_GET['package'] ?? 'Unknown Package';
$selectedDate = $_GET['date'] ?? 'Unknown Date';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save the booking details to the database (example placeholder)
    // $db->saveBooking($eventType, $packageName, $selectedDate);

    echo "<h1>Booking Confirmed!</h1>";
    echo "<p>Thank you for booking the <strong>{$eventType}</strong> event with <strong>{$packageName}</strong> on <strong>{$selectedDate}</strong>.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
    <link rel="stylesheet" href="../../src/css/payment.css">
</head>
<body>
    <div class="container">
        <h1>Booking Confirmation</h1>
        <div class="receipt">
            <h5>Review Your Choice...</h5>
            <p><strong>Event:</strong> <?= htmlspecialchars($eventType) ?></p>
            <p><strong>Package:</strong> <?= htmlspecialchars($packageName) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($selectedDate) ?></p>
        </div>
        <div class="button-container">
            <form method="POST">
                <button type="submit">Confirm Booking</button>
            </form>
        </div>
    </div>
</body>
</html>
