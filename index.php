<?php 
session_start();
include "includes/conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tibiao Tourism</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet" />

</head>

<body class="index-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <img src="assets/img/apple-touch-icon.png" alt="" />
                <h1 class="sitename">Tibiao Tourism</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="scanner"><i class="bi bi-qr-code-scan"></i></a></li>
                </ul>
            </nav>

            <a class="btn-getstarted" href="index#register">Get Started</a>
        </div>
    </header>

    <?php 
    include "includes/alert.php";
    ?>
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="hero-bg">
                <img src="assets/img/hero-bg-light.webp" alt="" />
            </div>
            <div class="container text-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h1 data-aos="fade-up">Welcome to <span>Tibiao Tourism Website</span></h1>
                    <p data-aos="fade-up" data-aos-delay="100">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.<br />
                    </p>
                    <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                        <a href="#register" class="btn-get-started">Get Started</a>
                        <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ"
                            class="glightbox btn-watch-video d-flex align-items-center"><i
                                class="bi bi-play-circle"></i><span>Watch Video</span></a>
                    </div>
                    <img src="assets/img/undraw_traveling_yhxq.svg" class="img-fluid hero-img mt-3" alt=""
                        data-aos="zoom-out" data-aos-delay="300" />
                </div>
            </div>
        </section>
        <!-- /Hero Section -->

        <!-- About Section -->
        <section id="register" class="register section">

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p class="who-we-are">Be Our Guest</p>
                        <h3>Start Your Registration Here</h3>

                        <!-- Guest Registration Form -->
                        <form class="row g-3" action="login-code.php" method="POST">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="floatingFirstName"
                                        name="first_name" placeholder="First Name" required>
                                    <label for="floatingFirstName">First Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="floatingLastName"
                                        name="last_name" placeholder="Last Name" required>
                                    <label for="floatingLastName">Last Name</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="number" class="form-control form-control-sm" id="floatingAge"
                                        name="age" placeholder="Age" required>
                                    <label for="floatingAge">Age</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select form-select-sm" id="contactPreference"
                                        name="contact_preference" aria-label="Contact Preference" required>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone</option>
                                    </select>
                                    <label for="contactPreference">Contact Preference</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="floatingContact"
                                        name="contact" placeholder="Phone/Email" required>
                                    <label for="floatingContact" id="contactLabel">Phone/Email</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-select form-select-sm" id="floatingDestination"
                                        name="destination" aria-label="Destination" required>
                                        <option selected disabled value="">Select Destination</option>
                                        <?php

                                        // Fetch destinations from the database
                                        $sql = "SELECT name FROM resorts";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</option>";
                                            }
                                        }

                                        // Close connection
                                        // $conn->close();
                                        ?>
                                    </select>
                                    <label for="floatingDestination">Destination</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Stay Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="stay_type" id="dayIn"
                                        value="Day In" required>
                                    <label class="form-check-label" for="dayIn">Day In</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="stay_type" id="overnight"
                                        value="Over Night Stay" required>
                                    <label class="form-check-label" for="overnight">Over Night Stay</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn read-more" name="GuestRegistration">Register</button>
                            </div>
                        </form><!-- End Guest Registration Form -->

                        <script>
                        // JavaScript to dynamically update the placeholder and label text for the contact input
                        document.getElementById('contactPreference').addEventListener('change', function() {
                            var contactInput = document.getElementById('floatingContact');
                            var contactLabel = document.getElementById('contactLabel');
                            if (this.value === 'phone') {
                                contactInput.placeholder = 'Phone';
                                contactLabel.textContent = 'Phone';
                            } else {
                                contactInput.placeholder = 'Email';
                                contactLabel.textContent = 'Email';
                            }
                        });
                        </script>



                    </div>

                    <div class="col-lg-6 register-images mt-5 pt-5" data-aos="fade-up" data-aos-delay="200">
                        <div class="row gy-4">
                            <div class="col-lg-6">
                                <img src="assets/img/featured00.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="row gy-4">
                                    <div class="col-lg-12">
                                        <img src="assets/img/tibiao2.webp" class="img-fluid" alt="">
                                    </div>
                                    <div class="col-lg-12">
                                        <img src="assets/img/tibiao9.webp" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section><!-- /About Section -->

    </main>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>