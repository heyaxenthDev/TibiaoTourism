<?php 
session_start();
include "includes/conn.php";

if (isset($_POST['RegAdmin'])) {

    // Get form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

    // Check if passwords match
    if ($password !== $confirmPassword) {
         // Handle password mismatch error
         $_SESSION['status'] = "Password Error";
         $_SESSION['status_text'] = "Passwords do not match. Please try again.";
         $_SESSION['status_code'] = "error";
         $_SESSION['status_btn'] = "Back";
         header("Location: {$_SERVER['HTTP_REFERER']}");
         exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into database
    $sql = "INSERT INTO admin (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Admin registered successfully.";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
        // Redirect to login page
        header("Location: login.php");
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error registering new user.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

}

if (isset($_POST['LoginAdmin'])) {

    // Get form data
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query the database for the user
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct
            $_SESSION['admin_auth'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_email'] = $row['email'];
            // Redirect to dashboard or any other page
            $_SESSION['logged'] = "Logged in successfully";
            $_SESSION['logged_icon'] = "success";
            header("Location: admin/dashboard.php");
        } else {
            // Password is incorrect, display an error message
            $_SESSION['entered_email'] = $email;
            $_SESSION['status'] = "Password Error";
            $_SESSION['status_text'] = "Incorrect password. Please try again.";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Back";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    } else {
        // User not found
        $_SESSION['status'] = "Login Error";
        $_SESSION['status_text'] = "No user found with this email.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    // Close connection
    $conn->close();
}
?>