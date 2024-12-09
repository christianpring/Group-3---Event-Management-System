<?php
// Database connection
$servername = "localhost"; 
$username = "root";        
$password = "";            
$database = "itelec2";     

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get newly added rows
$sql = "SELECT 
            u.username, 
            b.event_date, 
            e.name AS event_name, 
            p.description AS package_description, 
            b.status
        FROM bookings b
        JOIN user u ON b.user_id = u.id
        JOIN events e ON b.event_id = e.id
        JOIN packages p ON b.package_id = p.id
        WHERE b.created_at >= NOW() - INTERVAL 1 DAY";

$result = $conn->query($sql);

// HTML Structure and Styling
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../src/css/bookEvent.css">
    <title>User Transactions</title>
    <nav>
        <div class="logo">G3MS</div>
        <ul class="main-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="bookEvent.php">Book Event</a></li>
            <li><a href="userTransaction.php">My Transaction</a></li>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
        <a href="../admin/authentication/admin-class.php?admin_signout" class="sign-out-btn">Sign Out</a>
    </nav>

    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
    }
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        table-layout: fixed;
    }
    colgroup col {
        width: 30%;
    }
    colgroup col.username {
        width: 15%;
    }
    colgroup col.event-date,
    colgroup col.event-name,
    colgroup col.status {
        width: 12%;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
        word-wrap: break-word;
    }
    table th {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }
    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    table tr:hover {
        background-color: #f1f1f1;
    }
    .status-pending {
        color: #ff9900;
        font-weight: bold;
    }
    .status-confirmed {
        color: #28a745;
        font-weight: bold;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>User Transactions</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <colgroup>
                    <col class="username">
                    <col class="event-date">
                    <col class="event-name">
                    <col class="package-description">
                    <col class="status">
                </colgroup>
                <tr>
                    <th>Username</th>
                    <th>Event Date</th>
                    <th>Event Name</th>
                    <th>Package Description</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['package_description']); ?></td>
                        <td class="<?php echo 'status-' . strtolower($row['status']); ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No new transactions found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>


