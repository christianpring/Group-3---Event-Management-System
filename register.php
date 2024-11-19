<?php
include_once 'config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box; 
            font-size: 16px; 
            cursor: pointer; 
        }

        select:focus {
            border-color: #5cb85c; 
            outline: none; 
            box-shadow: 0 0 5px rgba(92, 184, 92, 0.5); 
        }

        .button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
            width: 100%;
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
            margin: 0 10px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        
        
    </style>
</head>
<body>

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

</body>
</html>