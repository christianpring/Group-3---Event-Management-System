<?php
include_once 'config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
    body {
        background-color: #121212; 
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: #1e1e1e; 
        padding: 60px;
        border-radius: 25px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        text-align: center;
        width: 300px;
    }

    h1 {
        font-size: 1.5em;
        color: #ffffff; 
        margin-bottom: 20px;
        font-weight: normal; 
    }

    input[type="email"] {
        width: 100%;
        padding: 15px;
        margin-bottom: 10px;
        border: 1px solid #555; 
        border-radius: 100px;
        background-color: #333; 
        color: #ffffff; 
    }

    input[type="email"]:focus {
        border-color: #888; 
        outline: none;
    }

    button {
        width: 50%;
        padding: 12px;
        background-color: #444; 
        border: none;
        border-radius: 4px;
        color: #ffffff; 
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #555; 
    }

    .message {
        margin-top: 15px;
        font-size: 0.9em;
        color: #aaaaaa; 
    }
</style>


</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <form action="process-forgot-password.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" name="btn-reset">Send Reset Link</button>
        </form>
        <div class="message">
            <p>We'll send you a link to reset your password.</p>
        </div>
    </div>
</body>
</html>
