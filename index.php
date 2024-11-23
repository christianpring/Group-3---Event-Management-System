<?php
include_once 'config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - G3MS</title>
    <link rel="stylesheet" href="src/css/loginStyle.css">
    
</head>

<body>

    <nav>
        <div class="logo">G3MS</div>
    </nav>

    <div class="container">
        <div class="info">
            <h2>Welcome to G3MS</h2>
            <p>
                Discover the best event management services tailored for your special moments.<br> From corporate events to personal celebrations, <br>G3MS provides exceptional packages and offers to suit your needs.
            </p>
        </div>
        <div class="container1">
        <form action="dashboard/admin/authentication/admin-class.php" method="POST">
            <h1>Login</h1>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="btn-signin" class="button">Log in</button>

            <div class="links">
                <p>Do you have an account? <a href="register.php">Sign up here</a></p>
                <p><a href="forgot-pass/forgot-password.php">Forgot Password?</a></p>
            </div>
        </form>
        </div>
    </div>

</body>

</html>
