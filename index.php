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
                                        name="contact_preference" required>
                                        <option selected disabled value="">Select Contact Preference</option>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone</option>
                                    </select>
                                    <label for="contactPreference">Contact Preference</label>
                                </div>
                            </div>
                            <div class="col-md-12" id="contactInputDiv" style="display: none;">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="floatingContact"
                                        name="contact" placeholder="" required>
                                    <label for="floatingContact" id="contactLabel">Contact</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Destination Selection</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="destination_type"
                                        id="singleDestination" value="single" checked>
                                    <label class="form-check-label" for="singleDestination">Single Destination</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="destination_type"
                                        id="multipleDestinations" value="multiple">
                                    <label class="form-check-label" for="multipleDestinations">Multiple
                                        Destinations</label>
                                </div>
                            </div>
                            <div class="col-md-12" id="singleDestinationDiv">
                                <div class="form-floating">
                                    <select class="form-select form-select-sm" id="floatingDestination"
                                        name="destination" required>
                                        <option selected disabled value="">Select Destination</option>
                                        <?php
                                $sql = "SELECT name FROM resorts";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</option>";
                                    }
                                }
                                ?>
                                    </select>
                                    <label for="floatingDestination">Destination</label>
                                </div>
                            </div>
                            <div class="col-md-12" id="multipleDestinationsDiv" style="display: none;">
                                <label class="form-label">Select Multiple Destinations</label>
                                <div class="form-check">
                                    <?php
                            $sql = "SELECT name FROM resorts";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $destinationName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                                    echo "<div class='form-check'>";
                                    echo "<input class='form-check-input' type='checkbox' name='destinations[]' value='$destinationName' id='$destinationName'>";
                                    echo "<label class='form-check-label' for='$destinationName'>$destinationName</label>";
                                    echo "</div>";
                                }
                            }
                            ?>
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

                            <!-- Additional Guests Section -->
                            <div class="col-md-12">
                                <label class="form-label">Additional Guests</label>
                                <div id="additionalGuestsDiv">
                                    <div class="row g-3 additionalGuest">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="additional_guest_first_name[]" placeholder="First Name">
                                                <label>First Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="additional_guest_last_name[]" placeholder="Last Name">
                                                <label>Last Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-floating">
                                                <input type="number" class="form-control form-control-sm"
                                                    name="additional_guest_age[]" placeholder="Age">
                                                <label>Age</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-3" id="addGuestButton">Add
                                    Another
                                    Guest</button>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn read-more" name="GuestRegistration">Register</button>
                            </div>
                        </form>

                        <script>
                        document.getElementById('contactPreference').addEventListener('change', function() {
                            var contactInputDiv = document.getElementById('contactInputDiv');
                            var contactInput = document.getElementById('floatingContact');
                            var contactLabel = document.getElementById('contactLabel');

                            if (this.value) {
                                contactInputDiv.style.display = 'block';
                                contactInput.placeholder = this.value === 'phone' ? 'Phone' : 'Email';
                                contactLabel.textContent = this.value === 'phone' ? 'Phone' : 'Email';
                            } else {
                                contactInputDiv.style.display = 'none';
                            }
                        });
                        document.querySelectorAll("input[name='destination_type']").forEach(radio => {
                            radio.addEventListener('change', function() {
                                var singleDestinationDiv = document.getElementById(
                                    'singleDestinationDiv');
                                var multipleDestinationsDiv = document.getElementById(
                                    'multipleDestinationsDiv');
                                var singleDestinationSelect = document.getElementById(
                                    'floatingDestination');
                                var checkboxes = document.querySelectorAll(
                                    "input[name='destinations[]']");

                                if (this.value === 'single') {
                                    singleDestinationDiv.style.display = 'block';
                                    multipleDestinationsDiv.style.display = 'none';
                                    singleDestinationSelect.required = true;
                                    checkboxes.forEach(checkbox => checkbox.required = false);
                                } else {
                                    singleDestinationDiv.style.display = 'none';
                                    multipleDestinationsDiv.style.display = 'block';
                                    singleDestinationSelect.required = false;
                                    checkboxes.forEach(checkbox => checkbox.required = false);
                                }
                            });
                        });

                        document.getElementById('addGuestButton').addEventListener('click', function() {
                            var additionalGuestsDiv = document.getElementById('additionalGuestsDiv');
                            var newGuestDiv = document.createElement('div');
                            newGuestDiv.className = 'row g-3 additionalGuest';
                            newGuestDiv.innerHTML = `
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" name="additional_guest_first_name[]" placeholder="First Name">
                                        <label>First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" name="additional_guest_last_name[]" placeholder="Last Name">
                                        <label>Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control form-control-sm" name="additional_guest_age[]" placeholder="Age">
                                        <label>Age</label>
                                    </div>
                                </div>
                            `;
                            additionalGuestsDiv.appendChild(newGuestDiv);
                        });
                        </script>
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