<?php
include_once 'config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center; 
        }

        
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px; 
        }

        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box; 
        }

        
        .button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 3px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s; 
        }

        .button:hover {
            background-color: #4cae4c;
        }

        
        .links {
            margin-top: 15px;
            text-align: center;
            font-size: 14px; 
        }

        .links a {
            color: #007bff;
            text-decoration: none;
            margin: 0 5px; 
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

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

</body>
</html>
