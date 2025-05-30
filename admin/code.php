<?php 
session_start();
include "includes/conn.php";

if (isset($_POST['NewResort'])) {

    // Get form data
    $resortName = $conn->real_escape_string($_POST['resort_name']);
    $resortAddress = $conn->real_escape_string($_POST['resort_address']);
    $resortPassword = $conn->real_escape_string($_POST['password']);

    // Generate a 5-digit random number
    $randomNumber = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

    // Hash the password
    $hashedPassword = password_hash($resortPassword, PASSWORD_DEFAULT);

    // Insert the resort data without the resort_code
    $stmt = $conn->prepare("INSERT INTO `resorts` (`name`, `address`, `password`) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $resortName, $resortAddress, $hashedPassword);

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

if (isset($_POST['EditResort'])) {
    $id = $_POST['edit_id'];
    $resortName = $conn->real_escape_string($_POST['resort_name']);
    $resortAddress = $conn->real_escape_string($_POST['resort_address']);
    $resortPassword = $conn->real_escape_string($_POST['password']);

    // Hash the password
    $hashedPassword = password_hash($resortPassword, PASSWORD_DEFAULT);

    // Update the resort data
    $stmt = $conn->prepare("UPDATE `resorts` SET `name` = ?, `address` = ?, `password` = ? WHERE `id` = ?");
    $stmt->bind_param("sssi", $resortName, $resortAddress, $hashedPassword, $id);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Resort data has been updated successfully.";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
        header("Location: {$_SERVER['HTTP_REFERER']}");
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

if (isset($_POST['DeleteResort'])) {
    $id = $_POST['delete_id'];

    // Delete the resort data
    $stmt = $conn->prepare("DELETE FROM `resorts` WHERE `id` = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Resort data has been deleted successfully.";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }   

    // Close the statement
    $stmt->close();
}

if (isset($_POST['get_resort'])) {
    $id = $_POST['id'];
    
    // Fetch the resort data
    $stmt = $conn->prepare("SELECT id, name, address, password FROM resorts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Resort not found']);
    }
    
    $stmt->close();
    exit;
}

?>