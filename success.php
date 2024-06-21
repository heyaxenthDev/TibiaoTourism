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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


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
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="card mb-3">

                                <div class="card-body p-4" id="htmlContent">

                                    <div class="d-flex justify-content-center py-2 mt-2">
                                        <a href="index" class="logo d-flex align-items-center w-auto">
                                            <img src="assets/img/apple-touch-icon.png" alt="">
                                        </a>
                                    </div><!-- End Logo -->

                                    <div class="pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Success!</h5>
                                        <p class="text-center small">Thank you for registering, kindly save your QR code
                                            upon you arrival at your destination.</p>
                                    </div>

                                    <center>
                                        <input id="text" type="hidden"
                                            value="<?php if(isset($_GET['GuestCode'])){ echo $_GET['GuestCode'];} ?>"
                                            style="width:80%" /><br />
                                        <div id="qrcode"
                                            style="width:200px; height:200px; margin-top:5px; margin-bottom:10px;">
                                        </div>
                                        <span><?php echo $_GET['GuestCode']; ?></span>
                                    </center>

                                    <div class="d-grid gap-2 mt-4">
                                        <button class="btn btn-primary" type="button" id="download">Download QR</button>
                                        <a href="index" class="btn btn-secondary" id="return" role="button">Return</a>
                                    </div>

                                    <script type="text/javascript">
                                    var qrcode = new QRCode(document.getElementById("qrcode"), {
                                        width: 200,
                                        height: 200
                                    });

                                    function makeCode() {
                                        var elText = document.getElementById("text");
                                        qrcode.makeCode(elText.value);
                                    }

                                    makeCode();

                                    $("#text").
                                    on("blur", function() {
                                        makeCode();
                                    }).
                                    on("keydown", function(e) {
                                        if (e.keyCode == 13) {
                                            makeCode();
                                        }
                                    });
                                    </script>

                                    <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#download").on('click', function() {
                                            // Hide the download button
                                            $("#download").hide();
                                            $("#return").hide();

                                            // Capture the content of the div
                                            html2canvas(document.getElementById("htmlContent")).then(
                                                function(canvas) {
                                                    // Create a temporary link element
                                                    var link = document.createElement('a');
                                                    link.download = 'image.png';
                                                    link.href = canvas.toDataURL("image/png");

                                                    // Trigger the download
                                                    link.click();

                                                    // Show the download button again
                                                    $("#download").show();
                                                    $("#return").show();
                                                });
                                        });
                                    });
                                    </script>

                                </div>


                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

</body>

</html>