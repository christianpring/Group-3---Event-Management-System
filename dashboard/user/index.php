<?php
require_once '../admin/authentication/admin-class.php';

$admin = new ADMIN();



$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Welcome User <?php echo htmlspecialchars($user_data['email']); ?></h1>
    
    
    <div class="text-right mb-3">
        <a href="../admin/authentication/admin-class.php?admin_signout" class="btn btn-danger">Sign Out</a>
    </div>

    <div class="row">
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>User Profile</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user_data['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($user_data['role']); ?></p>
                    <a href="edit_profile.php" class="btn btn-warning btn-block">Edit Profile</a>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Event Management</h4>
                </div>
                <div class="card-body">
                    <a href="view_events.php" class="btn btn-primary btn-block">View Events</a>
                    <a href="register_event.php" class="btn btn-success btn-block">Register for Event</a>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Ticket Management</h4>
                </div>
                <div class="card-body">
                    <a href="manage_tickets.php" class="btn btn-primary btn-block">Manage My Tickets</a>
                    <a href="view_transactions.php" class="btn btn-info btn-block">View My Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>