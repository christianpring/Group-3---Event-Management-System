<?php
require_once 'authentication/admin-class.php';

$admin = new ADMIN();

if(!$admin->isUserLoggedIn())
{
    $admin->redirect('../../');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin || Event Management System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Admin Dashboard</h1>
    
    
    <div class="text-right mb-3">
    <a href="authentication/admin-class.php?admin_signout" class = "btn btn-danger">SIGN OUT</a>
    </div>

    <div class="row">
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>User Management</h4>
                </div>
                <div class="card-body">
                    <a href="view_users.php" class="btn btn-primary btn-block">View Users</a>
                    <a href="ban_users.php" class="btn btn-danger btn-block">Ban/Remove Users</a>
                </div>
            </div>
        </div>

       
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Event Management</h4>
                </div>
                <div class="card-body">
                    <a href="manage_events.php" class="btn btn-primary btn-block">Manage Events</a>
                    <a href="create_event.php" class="btn btn-success btn-block">Create Event</a>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Ticket Management</h4>
                </div>
                <div class="card-body">
                    <a href="manage_tickets.php" class="btn btn-primary btn-block">Manage Tickets</a>
                    <a href="view_transactions.php" class="btn btn-info btn-block">View Transactions</a>
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