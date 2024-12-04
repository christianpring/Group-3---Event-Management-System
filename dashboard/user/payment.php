<?php
// Include the admin class
require_once '../admin/authentication/admin-class.php';

// Initialize the $admin object
$admin = new ADMIN();

// Debug check to ensure $admin is instantiated
if ($admin === null) {
    die("Error: ADMIN class was not instantiated.");
}

// Proceed with the rest of the code
$userId = $_SESSION['adminSession'];

// Get the event_id, package_id, and date from the URL (or session, if necessary)
$eventId = $_GET['event_id'] ?? $_SESSION['event_id']; // Fallback to session if the event_id is not in the URL
$packageId = $_GET['package_id'] ?? $_SESSION['package_id']; // Fallback to session if the package_id is not in the URL
$selectedDate = $_GET['date'] ?? 'Unknown Date'; // Get the selected date from the URL (fallback if not set)

// Fetch the event name from the database
$stmt = $admin->runQuery("SELECT name FROM events WHERE id = :event_id");
$stmt->execute([':event_id' => $eventId]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);
$eventName = $event['name'] ?? 'Unknown Event'; // Default to 'Unknown Event' if no event found

// Fetch the package details from the database
$stmt = $admin->runQuery("SELECT name, price FROM packages WHERE id = :package_id AND event_id = :event_id");
$stmt->execute([':package_id' => $packageId, ':event_id' => $eventId]);
$package = $stmt->fetch(PDO::FETCH_ASSOC);
$packageName = $package['name'] ?? 'Unknown Package'; // Default to 'Unknown Package' if no package found
$packagePrice = $package['price'] ?? 0.00; // Default to 0.00 if no price found
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AT3NPEvJjf-qR0f4p9nw8lmqIGkaeg1yonr8UVvkAI7ujASgJvg_xvR83PFYhS9OO5Uodf391q5ybbP-"></script> 
    <link rel="stylesheet" href="../../src/css/payment.css">
</head>
<body>
    <div class="container">
        <h1>Booking Confirmation</h1>
        <div class="receipt">
            <h5>Review Your Choice...</h5>
            <p><strong>Event:</strong> <?= htmlspecialchars($eventName) ?></p>
            <p><strong>Package:</strong> <?= htmlspecialchars($packageName) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($selectedDate) ?></p>
            <p><strong>Price:</strong> $<?= number_format($packagePrice, 2) ?></p>
        </div>
        <div id="paypal-button-container"></div>
    </div>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= number_format($packagePrice, 2) ?>' // Pass the package amount dynamically
                        },
                        description: "<?= htmlspecialchars($eventName) ?> - <?= htmlspecialchars($packageName) ?>"
                    }]
                });
            },
            onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
        console.log('Capture result:', details); // Log the capture result
        // Send the payment confirmation to your server
        fetch('process_payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                orderId: data.orderID,
                event: "<?= htmlspecialchars($eventName) ?>",
                package: "<?= htmlspecialchars($packageName) ?>",
                date: "<?= htmlspecialchars($selectedDate) ?>",
                amount: <?= $packagePrice ?>
            })
        }).then(response => response.json())
          .then(data => {
              console.log(data); // Log the response from your server
              if (data.redirect) {
                  window.location.href = data.redirect;
              } else {
                  alert('Payment failed or booking issue: ' + (data.error || 'Unknown error.'));
              }
          });
    });
},
            onCancel: function() {
                alert('Payment was canceled.');
            },
            onError: function(err) {
                console.error(err);
                alert('An error occurred during payment.');
            }
        }).render('#paypal-button-container'); // Render the PayPal button
    </script>
</body>
</html>
