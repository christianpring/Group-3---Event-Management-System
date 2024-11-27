<?php
// Include your header, navbar, or any other necessary PHP files
include_once("header.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Offers Overview</title>
    <link rel="stylesheet" href="../src/css/user.css">
</head>
<body>
    <!-- Main Content -->
    <div class="event-offers-container">
        <div class="event-header">
            <h1>Event Offers Overview</h1>
            <p>Choose from our exclusive event packages for your celebration!</p>
        </div>

        <!-- Event Packages Overview Section -->
        <div class="events">
            <?php
            $events = [
                ["name" => "Wedding", "image" => "wedding.jpg", "id" => 1],
                ["name" => "Birthday", "image" => "birthday.jpg", "id" => 2],
                ["name" => "Party", "image" => "party.jpg", "id" => 3],
                ["name" => "Christening", "image" => "christening.jpg", "id" => 4]
            ];
            
            foreach ($events as $event) {
                echo '<div class="event-card" style="background-image: url(\'../src/images/' . $event['image'] . '\');">';
                echo '<div class="event-details">';
                echo '<h2>' . $event['name'] . '</h2>';
                echo '<ul>';
                echo '<li>Package 1: Venue, Emcee, Catering, On-site staff, Luxury Decorations, Red Carpet, Special Lighting, Photography & Videography</li>';
                echo '<li>Package 2: Venue, Emcee, Catering, On-site staff, Luxury Decorations, Photography & Videography</li>';
                echo '<li>Package 3: Venue, Emcee, Catering, Luxury Decorations</li>';
                echo '</ul>';
                echo '<button class="choose-event-btn" onclick="chooseEvent(' . $event['id'] . ')">Choose Event</button>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- JavaScript for confirmation before proceeding -->
    <script>
        function chooseEvent(eventId) {
            const confirmation = confirm("Do you want to proceed with booking this event?");
            if (confirmation) {
                window.location.href = 'bookEvent.php?event_id=' + eventId;
            }
        }
    </script>

    <!-- Include your footer here -->
    <?php include_once("footer.php"); ?>
</body>
</html>
