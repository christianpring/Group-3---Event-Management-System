<?php

require_once '../admin/authentication/admin-class.php';

// Ensure you have the correct PDO connection
$pdo = new PDO("mysql:host=localhost;dbname=itelec2", "root", "");

// Fetch the event and package details using their IDs
$eventId = $_GET['event_id'] ?? 0;
$packageId = $_GET['package_id'] ?? 0;

// Fetch event details
$eventStmt = $pdo->prepare("SELECT name FROM events WHERE id = :event_id");
$eventStmt->execute([':event_id' => $eventId]);
$event = $eventStmt->fetch(PDO::FETCH_ASSOC);
$eventName = $event['name'] ?? 'Unknown Event';

// Fetch package details
$packageStmt = $pdo->prepare("SELECT name FROM packages WHERE id = :package_id");
$packageStmt->execute([':package_id' => $packageId]);
$package = $packageStmt->fetch(PDO::FETCH_ASSOC);
$packageName = $package['name'] ?? 'Unknown Package';

// Fetch booked dates from the database
$stmt = $pdo->prepare("SELECT event_date FROM bookings WHERE status = 'confirmed'");
$stmt->execute();
$bookedDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare a list of booked dates
$bookedDatesArray = array_map(function($row) {
    return $row['event_date'];
}, $bookedDates);

// Convert the booked dates array to a JSON format for use in JavaScript
$bookedDatesJson = json_encode($bookedDatesArray);

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventDate = $_POST['selected_date'];

    // Save booking to the database
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, event_id, package_id, event_date, status)
                           VALUES (:user_id, :event_id, :package_id, :event_date, 'pending')");
    $stmt->execute([
        ':user_id' => $_SESSION['adminSession'],
        ':event_id' => $eventId,
        ':package_id' => $packageId,
        ':event_date' => $eventDate
    ]);

    $bookingId = $pdo->lastInsertId();

    header("Location: payment.php?booking_id=$bookingId");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Event</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
        }
        .info h1 {
            margin: 0;
        }
        .info p {
            font-size: 16px;
            color: #555;
        }
        .fc-day-today {
            background-color: rgba(0, 123, 255, 0.3) !important; /* Light blue background for today's date */
        }
        .fc-day-selected {
            background-color: rgba(255, 193, 7, 0.5) !important; /* Yellow background for selected date */
        }
        .fc-day-disabled {
            background-color: rgba(128, 128, 128, 0.2) !important; /* Gray-out booked/past dates */
            cursor: not-allowed; /* Change cursor to indicate non-clickable */
            text-decoration: line-through; /* Strike-through for clarity */
        }
    </style>
</head>
<body>
    <div class="info">
        <h1>Schedule Your Event</h1>
        <p><strong>Event:</strong> <?= htmlspecialchars($eventName) ?> | <strong>Package:</strong> <?= htmlspecialchars($packageName) ?></p>
    </div>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const bookedDates = <?php echo $bookedDatesJson; ?>;  // Insert booked dates from PHP into JavaScript
            const today = new Date(); // Today's date

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                dayCellDidMount: function (info) {
                    const cellDate = info.date.toISOString().split('T')[0];

                    // Disable past dates or booked dates
                    if (cellDate < today.toISOString().split('T')[0] || bookedDates.includes(cellDate)) {
                        info.el.classList.add('fc-day-disabled');
                    }
                },
                dateClick: function (info) {
                    const selectedDate = info.dateStr;

                    // Prevent selection of past or booked dates
                    if (bookedDates.includes(selectedDate)) {
                        alert("This date is unavailable for booking.");
                        return;
                    }

                    if (confirm(`Do you want to book this date: ${selectedDate}?`)) {
                        window.location.href = `payment.php?event_id=<?= $eventId ?>&package_id=<?= $packageId ?>&date=${selectedDate}`;
                    }
                },
            });

            calendar.render();
        });
    </script>
</body>
</html>
