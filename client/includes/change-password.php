<?php 
session_start();
include "conn.php";

if(isset($_POST['changepassword'])){
    $currentpassword = $_POST['currentpassword'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];
    
    // Validate password length
    if(strlen($newpassword) < 6) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Password must be at least 6 characters long!";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: ../users-profile.php");
        exit;
    }

    // Check if passwords match
    if($newpassword !== $confirmpassword) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "New passwords do not match!";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: ../users-profile.php");
        exit;
    }

    // Get current password from database
    $get_old_password = "SELECT * FROM `resorts` WHERE `id` = ?";
    $stmt = $conn->prepare($get_old_password);
    $stmt->bind_param('i', $_SESSION['resort_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $old_password = $row['password'];

    // Verify current password
    if(!password_verify($currentpassword, $old_password)) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Current password is incorrect!";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: ../users-profile.php");
        exit;
    }

    // Hash new password
    $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);

    // Update password in database
    $update_password = "UPDATE `resorts` SET `password` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($update_password);
    $stmt->bind_param('si', $hashed_password, $_SESSION['resort_id']);
    
    if($stmt->execute()) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Password has been updated successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error updating password!";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
    }
    
    header("Location: ../users-profile.php");
    exit;
}
?>