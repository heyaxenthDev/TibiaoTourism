<?php
session_start();

include_once('includes/conn.php');

// Check if user is authenticated as an admin
if (isset($_SESSION['resort_auth'])) {
     // Set session variables for status message
     $_SESSION['status'] = "Logged Out Successfully!";
     $_SESSION['status_text'] = "You have been logged out.";
     $_SESSION['status_code'] = "success";
     $_SESSION['status_btn'] = "Done";

    // Unset session variables
    session_destroy();


    // Redirect to index page
    header("Location: index");
    exit; // Exit script to prevent further execution
}