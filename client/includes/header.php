<?php 
include "includes/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Admin - Tbiao Tourism</title>
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
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <!-- <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->
    <link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body>
    <?php
      // Check if admin is logged in
      if (isset($_SESSION['resort_name']) && isset($_SESSION['resort_id'])) {
          $resort_name = $_SESSION['resort_name'];
          $id = $_SESSION['resort_id'];

          // Query to select admin details
          $select_resort = "SELECT * FROM `resorts` WHERE `name` = '$resort_name' AND `id` = '$id'";
          $result = mysqli_query($conn, $select_resort);

          if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  $name = $row['name'];
                  $address = $row['address'];
                  $resort_code = $row['resort_code'];
              }
          } else {
              echo "No resort found with the given credentials.";
          }
      } else {
          echo "No resort is logged in.";
      }

      ?>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/apple-touch-icon.png" alt="">
                <span class="d-none d-lg-block">Tibiao Tourism</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <?php
                // Fetch unread notifications for the badge
                $unreadNotificationsQuery = "SELECT * FROM `notifications` WHERE `status` = 'unread' ORDER BY `id` DESC";
                $unreadNotificationsResult = $conn->query($unreadNotificationsQuery);

                // Fetch all notifications for the dropdown menu
                $allNotificationsQuery = "SELECT * FROM `notifications` ORDER BY `id` DESC";
                $allNotificationsResult = $conn->query($allNotificationsQuery);
                ?>

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown"
                    onclick="markNotificationsAsRead(); return false;">
                    <i class="bi bi-bell"></i>
                    <?php if ($unreadNotificationsResult->num_rows > 0): ?>
                    <span
                        class="badge bg-primary badge-number"><?php echo $unreadNotificationsResult->num_rows; ?></span>
                    <?php endif; ?>
                </a><!-- End Notification Icon -->


                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have <?php echo $unreadNotificationsResult->num_rows; ?> new notifications
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <?php while ($notification = $allNotificationsResult->fetch_assoc()): ?>
                    <li class="notification-item">
                        <i class="bi bi-info-circle text-primary"></i>
                        <div>
                            <h4>Notification</h4>
                            <p><?php echo htmlspecialchars($notification['description']); ?></p>
                            <p><?php echo htmlspecialchars($notification['status']); ?></p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php endwhile; ?>

                    <li class="dropdown-footer">
                        <a href="#">Show all notifications</a>
                    </li>
                </ul><!-- End Notification Dropdown Items -->
                </li><!-- End Notification Nav -->



                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/user.png" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            <?= $name ?>
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>
                                <?= $name ?>
                            </h6>
                            <span>
                                <?= $address ?>
                            </span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href=".././resort-logout.php">
                                <i class=" bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <script>
    function markNotificationsAsRead() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "mark_notifications_as_read.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                console.log("AJAX request completed with status:", xhr.status);
                if (xhr.status === 200) {
                    console.log("Server response:", xhr.responseText);
                    // Optional: Refresh the notification list without reloading the page
                    // Here you can implement functionality to update the notification list dynamically
                } else {
                    console.error("Error in AJAX request");
                }
            }
        };
        xhr.send();
    }
    </script>