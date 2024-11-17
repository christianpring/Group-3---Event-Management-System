<?php
include_once 'config/settings-configuration.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #2b2b2b;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #1a1a1a;
        padding: 45px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 320px;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #2b2b2b;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #1a1a1a;
        padding: 45px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 320px;
        max-width: 100%;
        text-align: center;
    }

    h1 {
        font-size: 1.4em;
        margin-bottom: 20px;
        color: #f9f9f9;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 20px;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #444;
        background-color: #333;
        color: #f9f9f9;
        border-radius: 10px;
        font-size: 1em;
        transition: border-color 0.3s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }

    .button-group {
        display: flex;
        flex-direction: column;
        margin-top: 15px;
    }

    .button {
        padding: 12px;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        color: #fff;
        font-size: 1em;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    .button:hover {
        background-color: #0056b3;
    }

    /* Flexbox container for three sections */
    .layout {
        display: flex;
        justify-content: space-around;
        width: 100%;
    }

    .left,
    .middle,
    .right {
        margin: 0 20px;
    }
</style>

<div class="layout">
    <!-- Left: Login Form -->
    <div class="container left">
        <h1>Login</h1>
        <form action="dashboard/admin/authentication/admin-class.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="button-group">
                <button type="submit" name="btn-signin" class="button">Sign In</button>
            </div>
        </form>
    </div>

    <!-- Middle: Register Form -->
    <div class="container middle">
        <h1>Register</h1>
        <form action="dashboard/admin/authentication/admin-class.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="btn-signup" class="button">Sign Up</button>
        </form>
    </div>

    <!-- Right: Forgot Password Button -->
    <div class="container right">
        <h1>Forgot Password</h1>
        <div class="button-group">
            <button type="button" class="button" onclick="window.location.href='forgot-password.php'">Reset Password</button>
        </div>
    </div>
</div>
