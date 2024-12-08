<?php
require_once 'authentication/admin-class.php';

$admin = new ADMIN();

if(!$admin->isUserLoggedIn())
{
    $admin->redirect('../../');
}
// Initialize variables
$error_message = "";
$success_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitize and validate inputs
        $event_name = filter_input(INPUT_POST, 'event_name', FILTER_SANITIZE_STRING);
        $event_date = filter_input(INPUT_POST, 'event_date', FILTER_SANITIZE_STRING);
        $event_description = filter_input(INPUT_POST, 'event_description', FILTER_SANITIZE_STRING);
        $event_location = filter_input(INPUT_POST, 'event_location', FILTER_SANITIZE_STRING);
        $venue_type = filter_input(INPUT_POST, 'venue_type', FILTER_SANITIZE_STRING);
        $mc = filter_input(INPUT_POST, 'mc', FILTER_SANITIZE_STRING);
        $catering = filter_input(INPUT_POST, 'catering', FILTER_SANITIZE_STRING);
        $services = isset($_POST['services']) ? $_POST['services'] : [];

        // Check required fields
        if (!$event_name || !$event_date || !$venue_type || !$mc || !$catering) {
            throw new Exception("Please fill in all required fields.");
        }

        // Convert additional services array into a string for storage
        $services_str = implode(', ', array_map('htmlspecialchars', $services));

        // Insert event details into the database
        $pdo = new PDO($dsn, $db_user, $db_pass); // Use your database credentials
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO events (
                    event_name, 
                    event_date, 
                    event_description, 
                    event_location, 
                    venue_type, 
                    mc, 
                    catering, 
                    services
                ) VALUES (
                    :event_name, 
                    :event_date, 
                    :event_description, 
                    :event_location, 
                    :venue_type, 
                    :mc, 
                    :catering, 
                    :services
                )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':event_name', $event_name);
        $stmt->bindParam(':event_date', $event_date);
        $stmt->bindParam(':event_description', $event_description);
        $stmt->bindParam(':event_location', $event_location);
        $stmt->bindParam(':venue_type', $venue_type);
        $stmt->bindParam(':mc', $mc);
        $stmt->bindParam(':catering', $catering);
        $stmt->bindParam(':services', $services_str);

        $stmt->execute();

        // Success message
        $success_message = "Event created successfully!";
    } catch (Exception $e) {
        // Error message
        $error_message = "Error: " . $e->getMessage();
    }
}
?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const dropdownButtons = document.querySelectorAll('.dropdown-btn');

    dropdownButtons.forEach(button => {
        button.addEventListener('click', () => {
            const dropdownMenu = button.nextElementSibling;
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            } else {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
                dropdownMenu.classList.add('show');
            }
        });
    });
});
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../src/css/admin.css">
    <link rel="stylesheet" href="../../src/css/admin css/createEvent.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="logo">G3MS</div>
    <ul class="sidebar-nav">
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-btn">User Management</a>
            <ul class="dropdown-menu">
                <li><a href="viewUser.php">View User</a></li>
                <li><a href="removeUser.php">Remove User</a></li>
                <li><a href="userLogs.php">User Logs</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-btn">Event Management</a>
            <ul class="dropdown-menu">
            <li><a href="mngEvent.php">Manage Events</a></li>
            <li><a href="crtEvent.php">Create Events</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-btn">Ticket Management</a>
            <ul class="dropdown-menu">
            <li><a href="viewTrans.php">View Transaction</a></li>
            <li><a href="auditTrail.php">Audit Trail</a></li>
            </ul>
        </li>
    </ul>
    <a href="../admin/authentication/admin-class.php?admin_signout" class="sign-out-btn">Sign Out</a>
</div>
    <!-- Main Content Area -->
    <div class="content">
        <!-- You can add more content here -->
        <h1></h1>
        <form action="save_event.php" method="post">
        
        <!-- Event Information Section -->
        <h2>Event Information</h2>
        
        <!-- Event Name -->
        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" required placeholder="Enter event name">

        <!-- Event Date -->
        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required>

        <!-- Event Description -->
        <label for="event_description">Event Description:</label>
        <textarea id="event_description" name="event_description" rows="4" placeholder="Describe the event"></textarea>

        <!-- Event Location -->
        <label for="event_location">Event Location:</label>
        <input type="text" id="event_location" name="event_location" placeholder="Enter event location">

         <!-- Venue Type Dropdown -->
         <label for="venue_type">Choose Venue Type:</label>
        <select id="venue_type" name="venue_type" required>
            <option value="" disabled selected>Select a venue</option>
            <option value="Hotel">Hotel</option>
            <option value="Resort">Resort</option>
            <option value="Restaurant">Restaurant</option>
            <option value="Banquet Hall">Banquet Hall</option>
            <option value="Outdoor">Outdoor</option>
        </select>
        <hr>

        <!-- Add MC Dropdown -->
        <label for="add_mc">Would you like an MC?</label>
        <select id="add_mc" name="mc" required>
            <option value="" disabled selected>Choose an option</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
        <hr>

        <!-- Catering Options Dropdown -->
        <label for="catering">Choose Catering Cuisine:</label>
        <select id="catering" name="catering" required>
            <option value="" disabled selected>Select a cuisine</option>
            <option value="Continental">Continental</option>
            <option value="Chinese">Chinese</option>
            <option value="Indian">Indian</option>
            <option value="Italian">Italian</option>
            <option value="japanese">Japanese</option>
            <option value="korean">Korean</option>
            <option value="filipino">Filipino Style</option>
            <option value="Multi-Cuisine">Multi-Cuisine</option>
        </select>

        <hr>

        <!-- Additional Services Section -->
        <h2>Additional Services</h2>

        <div class="checkbox-group">
            <label><input type="checkbox" name="services[]" value="On-site staff"> On-site staff</label>
            <label><input type="checkbox" name="services[]" value="Luxury Decorations"> Luxury Decorations</label>
            <label><input type="checkbox" name="services[]" value="Red Carpet Services"> Red Carpet Services</label>
            <label><input type="checkbox" name="services[]" value="Special Lighting Effects"> Special Lighting Effects</label>
            <label><input type="checkbox" name="services[]" value="Transportation Services"> Transportation Services</label>
            <label><input type="checkbox" name="services[]" value="Photography & Videography"> Photography & Videography</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="submit_event">Create Event</button>
    </form>
    </div>
</body>
</html>