<?php 
session_start();
include "includes/conn.php";

if (isset($_POST['NewResort'])) {

    // Get form data
    $resortName = $conn->real_escape_string($_POST['resort_name']);
    $resortAddress = $conn->real_escape_string($_POST['resort_address']);

    // Generate a 5-digit random number
    $randomNumber = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

    // Insert the resort data without the resort_code
    $stmt = $conn->prepare("INSERT INTO `resorts` (`name`, `address`) VALUES (?, ?)");
    $stmt->bind_param("ss", $resortName, $resortAddress);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the last inserted ID
        $lastId = $stmt->insert_id;

        // Generate the resort_code
        $resortCode = "resort-$randomNumber-$lastId";

        // Update the row with the resort_code
        $updateStmt = $conn->prepare("UPDATE `resorts` SET `resort_code` = ? WHERE `id` = ?");
        $updateStmt->bind_param("si", $resortCode, $lastId);

        // Execute the update statement
        if ($updateStmt->execute()) {
            $_SESSION['status'] = "Success";
            $_SESSION['status_text'] = "New resort data has been added successfully.";
            $_SESSION['status_code'] = "success";
            $_SESSION['status_btn'] = "Done";
            header("Location: {$_SERVER['HTTP_REFERER']}");
        } else {
            $_SESSION['status'] = "Error";
            $_SESSION['status_text'] = "Error updating resort code: " . $updateStmt->error;
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "ok";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }

        // Close the update statement
        $updateStmt->close();
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    // Close the statement
    $stmt->close();
}


?>