<?php
include_once 'config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="src/css/registerStyle.css">
</head>
<body>

<nav>
        <div class="logo">G3MS</div>
    </nav>
    <div class="container">
    <form action="dashboard/admin/authentication/admin-class.php" method="POST">
        <h1>Register</h1>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" name="btn-signup" class="button">Sign Up</button>
        
        <div class="links">
            <p>Already have an account? <a href="index.php">Log in</a></p>
        </div>
    </form>
    </div>
</body>
</html>