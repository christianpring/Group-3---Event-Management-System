<?php
// Enable error reporting to help debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure no output before starting JSON response
ob_start();

// Start session
session_start();

// Ensure user is logged in
if (!isset($_SESSION['adminSession'])) {
    echo json_encode(['error' => 'User is not logged in.']);
    exit;
}

$userId = $_SESSION['adminSession']; // Logged-in user ID

// Use PDO to interact with the database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=itelec2", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    error_log('PDO Connection failed: ' . $e->getMessage());
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

// Decode the incoming JSON data from PayPal
$inputData = json_decode(file_get_contents('php://input'), true);

// Validate necessary data is present
if (!isset($inputData['orderId'], $inputData['event'], $inputData['package'], $inputData['date'], $inputData['amount'])) {
    error_log('Missing data in the payment request: ' . print_r($inputData, true));
    echo json_encode(['error' => 'Missing payment information.']);
    exit;
}

$orderId = $inputData['orderId'];
$eventName = $inputData['event'];
$packageName = $inputData['package'];
$eventDate = $inputData['date'];
$amount = $inputData['amount'];

// Log received input for debugging
error_log("Received payment details: Order ID: $orderId, Event: $eventName, Package: $packageName, Date: $eventDate, Amount: $amount");

try {
    // Begin database transaction
    $pdo->beginTransaction();

    // Fetch event ID from the event name
    $stmt = $pdo->prepare("SELECT id FROM events WHERE name = :event_name");
    $stmt->execute([':event_name' => $eventName]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        error_log("Event not found for: $eventName");
        throw new Exception("Event not found for '$eventName'.");
    }

    $eventId = $event['id'];

    // Fetch package ID and price
    $stmt = $pdo->prepare("SELECT id, price FROM packages WHERE name = :package_name AND event_id = :event_id");
    $stmt->execute([':package_name' => $packageName, ':event_id' => $eventId]);
    $package = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$package) {
        error_log("Package not found for: $packageName");
        throw new Exception("Package not found for '$packageName'.");
    }

    // Insert booking into the bookings table
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, event_id, package_id, event_date, status) VALUES (:user_id, :event_id, :package_id, :event_date, 'confirmed')");
    $stmt->execute([
        ':user_id' => $userId,
        ':event_id' => $eventId,
        ':package_id' => $package['id'],
        ':event_date' => $eventDate
    ]);
    $bookingId = $pdo->lastInsertId();
    error_log("Booking inserted with ID: $bookingId");

    // Update package with payment ID
    $stmt = $pdo->prepare("UPDATE packages SET payment_id = :payment_id WHERE id = :package_id");
    $stmt->execute([
        ':payment_id' => $orderId,
        ':package_id' => $package['id']
    ]);
    error_log("Package updated with payment ID: $orderId");

    //insert logs
    $activityDesc = "Confirmed ".$packageName." with ID: "$package['id'];
    $stmt = $pdo->prepare("INSERT INTO logs (user_id, activity) values (?, ?");
    $stmt->execute([$userId, $activityDesc]);
    error_log("Insert log with payment ID: $orderId");

    // Commit transaction
    $pdo->commit();

    // Respond with success and redirect URL
    echo json_encode(['redirect' => 'success.php?booking_id=' . $bookingId]);

} catch (Exception $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    error_log('Error during payment processing: ' . $e->getMessage());
    echo json_encode(['error' => 'An error occurred during payment: ' . $e->getMessage()]);
    exit;
}

// End output buffer
ob_end_flush();
?>
