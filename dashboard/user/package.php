<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Package</title>
    <link rel="stylesheet" href="../../src/css/package.css">
</head>
<body>
    <nav>
        <div class="logo">G3MS</div>
        <ul class="main-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="bookEvent.php">Book Event</a></li>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
        <a href="../admin/authentication/admin-class.php?admin_signout" class="sign-out-btn">Sign Out</a>
    </nav>

    <h1>Select a Package for Your Event</h1>

    <div class="package-container">
        <div class="package-card" onclick="selectPackage('Package 1')">
            <h2>Package 1</h2>
            <p>Premium features for an unforgettable experience.</p>
        </div>
        <div class="package-card" onclick="selectPackage('Package 2')">
            <h2>Package 2</h2>
            <p>Great value with everything you need for your event.</p>
        </div>
        <div class="package-card" onclick="selectPackage('Package 3')">
            <h2>Package 3</h2>
            <p>A budget-friendly option for a wonderful event.</p>
        </div>
    </div>

    <script>
        function selectPackage(packageName) {
    const urlParams = new URLSearchParams(window.location.search);
    const eventType = urlParams.get('event');

    const confirmation = confirm(`Do you want to continue with the ${eventType} event and choose ${packageName}?`);

    if (confirmation) {
        window.location.href = `schedule.php?event=${eventType}&package=${packageName}`;
    }
}
    </script>
</body>
</html>
