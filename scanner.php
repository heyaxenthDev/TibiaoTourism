<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - Tibiao Tourism</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/login.css" rel="stylesheet">

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/qrcode.js"></script>
    <script type="text/javascript" src="assets/js/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>



</head>

<body>
    <?php 
    include "includes/alert.php";
    ?>
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items center justify-content-center">

                            <div class="card mb-3 p-4">
                                <h1 class="card-title text-center">Tibiao Tourism Scanner</h1>
                                <p class="text-center">Scanner is currently active.</p>
                                <div class="card-body" id="htmlContent">
                                    <div class="d-flex justify-content-center">

                                        <form action="login-code.php" method="POST" id="qrForm">
                                            <dotlottie-player
                                                src="https://lottie.host/c5a4b3e2-7c24-4f96-a463-567a6ebbf16f/W1GAfFygj7.lottie"
                                                background="transparent" speed="1" style="width: 350px; height: 350px;"
                                                loop autoplay></dotlottie-player>

                                            <label for="qrInput">Scan QR Code:</label><br>
                                            <input type="text" class="form-control" id="qrInput" name="qr_code"
                                                autofocus>
                                        </form>
                                    </div>

                                    <script>
                                    document.getElementById('qrInput').addEventListener('input', function() {
                                        // Check if the input field is not empty
                                        if (this.value.trim() !== '') {
                                            const formData = new FormData(document.getElementById('qrForm'));

                                            fetch('login-code.php', {
                                                    method: 'POST',
                                                    body: formData
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        Swal.fire({
                                                            title: "Guest Information",
                                                            html: `
                                                                <p><strong>Name:</strong> ${data.firstname} ${data.lastname}</p>
                                                                <p><strong>Age:</strong> ${data.age}</p>
                                                                <p><strong>Email:</strong> ${data.email}</p>
                                                                <p><strong>Phone:</strong> ${data.phone}</p>
                                                                <p><strong>Destination:</strong> ${data.destination}</p>
                                                                <p><strong>Type of Stay:</strong> ${data.type_of_stay}</p>
                                                                <p><strong>Arrival Date/Time:</strong> ${data.arrival_date_time}</p>
                                                            `,
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Confirm Arrival',
                                                            cancelButtonText: 'Cancel'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Update arrival_date_time in the database
                                                                fetch('update-arrival.php', {
                                                                        method: 'POST',
                                                                        body: JSON.stringify({
                                                                            guest_code: data
                                                                                .guest_code
                                                                        })
                                                                    })
                                                                    .then(response => response
                                                                        .json())
                                                                    .then(updateData => {
                                                                        if (updateData
                                                                            .success) {
                                                                            Swal.fire(
                                                                                'Confirmed!',
                                                                                'Guest arrival time has been updated.',
                                                                                'success');
                                                                        } else {
                                                                            Swal.fire('Error!',
                                                                                'Could not update arrival time.',
                                                                                'error');
                                                                        }
                                                                    });
                                                            }
                                                        });
                                                    } else {
                                                        Swal.fire('Error!', 'Guest not found.', 'error');
                                                    }
                                                });
                                        }
                                    });
                                    </script>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        </section>

        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

</body>

</html>