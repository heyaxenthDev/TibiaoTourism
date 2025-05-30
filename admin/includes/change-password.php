<?php
session_start();
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['currentpassword'];
    $new_password = $_POST['newpassword'];
    $renew_password = $_POST['renewpassword'];
    $user_type = $_SESSION['user_type'];
    $user_id = $_SESSION['user_id'];

    // Validate passwords
    if ($new_password !== $renew_password) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "New passwords do not match!";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    if (strlen($new_password) < 6) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Password must be at least 6 characters long!";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    // Get current user's password from database
    if ($user_type == 'admin') {
        $sql = "SELECT password FROM admin WHERE id = ?";
    } else {
        $sql = "SELECT password FROM resorts WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify current password
    if (!password_verify($current_password, $user['password'])) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Current password is incorrect!";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in database
    if ($user_type == 'admin') {
        $update_sql = "UPDATE admin SET password = ? WHERE id = ?";
    } else {
        $update_sql = "UPDATE resorts SET password = ? WHERE id = ?";
    }

    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $hashed_password, $user_id);

    if ($update_stmt->execute()) {
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

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>