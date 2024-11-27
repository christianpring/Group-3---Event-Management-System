<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pay with GCash</title>
   <link rel="stylesheet" href="../../src/css/user.css">
</head>
<body>

<button id="pay-button">Pay with GCash</button>

<script>
document.getElementById('pay-button').addEventListener('click', function () {
    fetch('create-payment-link.php')  // This is the PHP script that generates the payment link
        .then(response => response.json())
        .then(data => {
            if (data.url) {
                window.location.href = data.url;  // Redirect to the GCash payment page
            } else {
                alert('Error creating payment link');
            }
        })
        .catch(error => console.error('Error:', error));
});
</script>

</body>
</html>
