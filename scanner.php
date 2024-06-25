<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    #qrInput {
        width: 300px;
        padding: 10px;
        font-size: 18px;
        margin: 20px 0;
    }
    </style>
</head>

<body>
    <h1>QR Code Scanner</h1>
    <form action="process_qr.php" method="POST" id="qrForm">
        <label for="qrInput">Scan QR Code:</label><br>
        <input type="text" id="qrInput" name="qr_code" autofocus>
    </form>

    <script>
    document.getElementById('qrInput').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission on Enter key
            document.getElementById('qrForm').submit(); // Submit form programmatically
        }
    });
    </script>
</body>

</html>