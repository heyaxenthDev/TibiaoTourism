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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Template Main CSS File -->
    <link href="assets/css/login.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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

                                <div class="card-body">

                                    <div class="d-flex justify-content-center py-2 mt-2">
                                        <a href="index" class="logo d-flex align-items-center w-auto">
                                            <img src="assets/img/apple-touch-icon.png" alt="">
                                        </a>
                                    </div><!-- End Logo -->

                                    <div class="pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <form class="row g-3" action="login-code.php" method="POST">

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="yourEmail"
                                                value="<?php if(isset($_SESSION['entered_email'])){echo $_SESSION['entered_email'];} unset($_SESSION['entered_email']);?>"
                                                required>
                                        </div>

                                        <div class="col-12 position-relative">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                            <i class="bi bi-eye" id="togglePassword"
                                                style="position: absolute; top: 38px; right: 15px; cursor: pointer; display: none;"></i>
                                        </div>

                                        <script>
                                        // Show the eye icon when the user types
                                        document.getElementById("yourPassword").addEventListener("input", function() {
                                            const toggleIcon = document.getElementById("togglePassword");
                                            toggleIcon.style.display = this.value ? "block" : "none";
                                        });

                                        // Toggle visibility
                                        document.getElementById("togglePassword").addEventListener("click", function() {
                                            const passwordInput = document.getElementById("yourPassword");
                                            const isPassword = passwordInput.type === "password";
                                            passwordInput.type = isPassword ? "text" : "password";

                                            // Toggle icon style
                                            this.classList.toggle("bi-eye");
                                            this.classList.toggle("bi-eye-slash");
                                        });
                                        </script>


                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit"
                                                name="LoginAdmin">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="register">Create an
                                                    account</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <!-- <div class="credits">
                Designed by <a href="#">BootstrapMade</a>
              </div> -->

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