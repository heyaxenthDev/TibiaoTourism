<?php 
session_start();

//Check if the user is not authenticated
function checkLogin(){
    if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
        //Set session variables for status message
        $_SESSION['status'] = "Denied Access!";
        $_SESSION['status_text'] = "Please Login to Access the Page";
        $_SESSION['status_code'] = "warning";
        $_SESSION['status_btn'] = "Back";

        header("Location: /TibiaoTourism/index.php");

    }
}
?>