<?php
require_once 'authentication/admin-class.php';
require_once __DIR__.'/../../database/dbconnection.php'; // Include the database connection

$admin = new ADMIN();

if (!$admin->isUserLoggedIn()) {
    $admin->redirect('../../');
}

// Create an instance of the Database class
$database = new Database();
$conn = $database->dbConnection();

// Initialize variables to prevent undefined index warnings
$event_name = $event_description = $image_path = '';
$message = $messageType = '';

// Handle form submission for creating a new event and packages
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_event'])) {
    $event_name = $_POST['name'] ?? '';
    $event_description = $_POST['description'] ?? '';
    $num_packages = (int)($_POST['num_packages'] ?? 0);

    // Handle the photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $photo = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $uploadDir = __DIR__ . '/../../src/img/';
        $photo_new_name = uniqid('event_', true) . '.' . pathinfo($photo, PATHINFO_EXTENSION);
        $photo_path = '../../src/img/' . $photo_new_name;

        if (!move_uploaded_file($photo_tmp, $uploadDir . $photo_new_name)) {
            $message = "Error uploading the image.";
            $messageType = "error";
            echo $message;
            exit;
        }
    } else {
        $message = "Please upload a photo.";
        $messageType = "error";
        echo $message;
        exit;
    }

    // Validate other inputs
    if (!empty($event_name) && !empty($event_description) && $num_packages > 0) {
        try {
            $conn->beginTransaction();

            // Insert the event into the database
            $stmt = $conn->prepare("INSERT INTO events (name, description, image) VALUES (:name, :description, :image)");
            $stmt->bindParam(':name', $event_name);
            $stmt->bindParam(':description', $event_description);
            $stmt->bindParam(':image', $photo_path);
            $stmt->execute();

            $event_id = $conn->lastInsertId();

            // Insert the selected number of packages
            for ($i = 1; $i <= $num_packages; $i++) {
                $package_name = $_POST["package_name_$i"] ?? '';
                $package_description = $_POST["package_description_$i"] ?? '';
                $package_price = $_POST["package_price_$i"] ?? '';

                if (!empty($package_name) && !empty($package_description) && !empty($package_price)) {
                    $stmt = $conn->prepare("INSERT INTO packages (event_id, name, description, price) VALUES (:event_id, :name, :description, :price)");
                    $stmt->bindParam(':event_id', $event_id);
                    $stmt->bindParam(':name', $package_name);
                    $stmt->bindParam(':description', $package_description);
                    $stmt->bindParam(':price', $package_price);
                    $stmt->execute();
                } else {
                    throw new Exception("All package fields must be filled.");
                }
            }

            $conn->commit();

            $message = "Event and packages created successfully!";
            $messageType = "success";
        } catch (Exception $e) {
            $conn->rollBack();
            $message = "Error: " . $e->getMessage();
            $messageType = "error";
        }
    } else {
        $message = "All fields are required, including at least one package.";
        $messageType = "error";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event and Packages</title>
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

    <div class="content">
        <h1>Create New Event and Packages</h1>

        <?php if (isset($message)): ?>
            <div class="alert-container alert-<?php echo $messageType; ?>">
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>

        <form action="crtEvent.php" method="POST" enctype="multipart/form-data">
            <h3>Event Details</h3>
            <label for="name">Event Name:</label>
            <input type="text" name="name" id="name" placeholder="Enter Event Name" value="<?php echo htmlspecialchars($event_name); ?>" required><br>

            <label for="description">Event Description:</label>
            <textarea name="description" id="description" placeholder="Enter Event Description" required><?php echo htmlspecialchars($event_description); ?></textarea><br>

            <label for="photo">Event Photo:</label>
            <input type="file" name="photo" id="photo" required><br>

            <h3>Package Details</h3>
            <label for="num_packages">Number of Packages:</label>
            <select name="num_packages" id="num_packages" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select><br>

            <!-- Package Sections -->
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div id="package_<?php echo $i; ?>" class="package-section" style="display: none;">
                    <h4>Package <?php echo $i; ?></h4>
                    <label for="package_name_<?php echo $i; ?>">Package Name:</label>
                    <input type="text" name="package_name_<?php echo $i; ?>" id="package_name_<?php echo $i; ?>" placeholder="Enter Package Name"><br>

                    <label for="package_description_<?php echo $i; ?>">Package Description:</label>
                    <textarea name="package_description_<?php echo $i; ?>" id="package_description_<?php echo $i; ?>" placeholder="Enter Package Description"></textarea><br>

                    <label for="package_price_<?php echo $i; ?>">Package Price:</label>
                    <input type="number" name="package_price_<?php echo $i; ?>" id="package_price_<?php echo $i; ?>" placeholder="Enter Package Price"><br>
                </div>
            <?php endfor; ?>

            <button type="submit" name="create_event">Create Event and Packages</button>
        </form>
    </div>

    <script>
    document.getElementById('num_packages').addEventListener('change', function () {
        const numPackages = parseInt(this.value);
        for (let i = 1; i <= 3; i++) {
            const packageSection = document.getElementById(`package_${i}`);
            if (i <= numPackages) {
                packageSection.style.display = 'block';
            } else {
                packageSection.style.display = 'none';
            }
        }
    });
    </script>
</body>
</html>