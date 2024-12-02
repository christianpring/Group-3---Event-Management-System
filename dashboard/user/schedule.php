<?php
$eventType = $_GET['event'] ?? 'Unknown Event';
$packageName = $_GET['package'] ?? 'Unknown Package';
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
    </style>
</head>
<body>
    <div class="info">
        <h1>Schedule Your Event</h1>
        <p><strong>Event:</strong> <?= htmlspecialchars($eventType) ?> | <strong>Package:</strong> <?= htmlspecialchars($packageName) ?></p>
    </div>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                dateClick: function (info) {
                    // Clear previous selections
                    document.querySelectorAll('.fc-day-selected').forEach(cell => {
                        cell.classList.remove('fc-day-selected');
                    });

                    // Highlight the selected date
                    const selectedCell = document.querySelector(`[data-date="${info.dateStr}"]`);
                    if (selectedCell) {
                        selectedCell.classList.add('fc-day-selected');
                    }

                    // Ask for confirmation and redirect
                    if (confirm(`Do you want to book this date: ${info.dateStr}?`)) {
                        window.location.href = `payment.php?event=<?= urlencode($eventType) ?>&package=<?= urlencode($packageName) ?>&date=${info.dateStr}`;
                    }
                },
            });

            calendar.render();
        });
    </script>
</body>
</html>
