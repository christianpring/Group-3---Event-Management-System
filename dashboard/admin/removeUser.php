<?php
require_once 'authentication/admin-class.php';

$admin = new ADMIN();

if (!$admin->isUserLoggedIn()) {
    $admin->redirect('../../');
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "itelec2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    $action = $_POST['action'];

    if ($action === 'delete') {
        $sql = "UPDATE user SET status = 'disabled' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }

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

function confirmDelete() {
    return confirm("Are you sure you want to delete this user?");
}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../src/css/admin.css">
    <link rel="stylesheet" href="../../src/css/admin css/removeUser.css">
    <style>
        .btn.delete {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }
        .btn.delete:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
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
        <h1>Manage Users</h1>
        <div id="userTable">
            <?php
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, username, email, status FROM user WHERE status = 'active'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Status</th><th>Actions</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    $statusLabel = $row['status'] === 'active' ? 'Active' : 'Disabled';
                    $deleteButton = $row['status'] === 'active' 
                        ? "<form method='POST' style='display:inline-block;'>
                               <input type='hidden' name='user_id' value='{$row['id']}'>
                               <button type='submit' name='action' value='delete' class='btn delete' onclick='return confirmDelete()'>Delete</button>
                           </form>"
                        : "";

                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$statusLabel}</td>
                            <td class='actions'>{$deleteButton}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No users found.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
