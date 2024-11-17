<?php
session_start();

require_once __DIR__ . '/../ITELEC 2/database/dbconnection.php';

$token = filter_input(INPUT_GET, 'token');

if (!$token) {
    die("Invalid token.");
}

$token_hash = hash("sha256", $token);

$database = new Database();
$mysqli = $database->dbConnection(); 

$sql = "SELECT * FROM user WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);

$stmt->bindValue(1, $token_hash, PDO::PARAM_STR);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result === false) {
    die("Token not found.");
}

if (strtotime($result["reset_token_expires_at"]) <= time()) {
    die("Token has expired.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        body {
            background-color: #2c2c2c;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 60;
        }
        h1 {
            text-align: center;
            color: #f0f0f0;
        }
        .form-container {
            background-color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            color: #f0f0f0;
            margin-bottom: 5px;
        }
        input {
            background-color: #444;
            color: #f0f0f0;
            border: 1px solid #666;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        input:focus {
            outline-color: #888;
        }
        button {
            background-color: #555;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Reset Password</h1>
        <form method="post" action="process-reset-password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Repeat Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
