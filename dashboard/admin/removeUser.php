<?php
require_once 'authentication/admin-class.php';

$admin = new ADMIN();

if(!$admin->isUserLoggedIn())
{
    $admin->redirect('../../');
}

?>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "itelec2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    $action = $_POST['action'];

    if ($action === 'delete') {
        // Delete user
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        echo "<p>User with ID $user_id has been deleted.</p>";
    } elseif ($action === 'ban') {
        // Ban user
        $sql = "UPDATE user SET status = 'banned' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        echo "<p>User with ID $user_id has been banned.</p>";
    }

    // Refresh to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$conn->close();
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
    <link rel="stylesheet" href="../../src/css/admin css/removeUser.css">
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
            <li><a href="mngTickets.php">Manage Tickets</a></li>
            <li><a href="viewTrans.php">View Transaction</a></li>
            </ul>
        </li>
    </ul>
    <a href="../admin/authentication/admin-class.php?admin_signout" class="sign-out-btn">Sign Out</a>
</div>
    <!-- Main Content Area -->
    <div class="content">
        <h1>Edit User Logs</h1>
        <div id="editLogsTable">
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "itelec2";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve users
            $sql = "SELECT id, username, email, status FROM user";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Status</th><th>Actions</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['status']}</td>
                            <td class='actions'>
                        <form method='POST' style='display:inline-block;'>
                            <input type='hidden' name='user_id' value='{$row['id']}'>
                            <button type='submit' name='action' value='delete' class='btn delete' onclick='return confirmDeletion()'>Delete</button>
                        </form>
                        <form method='POST' style='display:inline-block;'>
                            <input type='hidden' name='user_id' value='{$row['id']}'>
                            <button type='submit' name='action' value='ban' class='btn ban'>Ban</button>
                        </form>
                    </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No users found.</p>";
            }

            $conn->close();
            ?>
        </div>
        <script>
function confirmDeletion() {
    return confirm("Are you sure you want to delete this user? This action cannot be undone.");
}
</script>
</body>
</html>
