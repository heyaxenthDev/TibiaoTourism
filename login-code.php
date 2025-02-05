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

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['GuestRegistration'])) {

    // Get form data
    $firstName = $conn->real_escape_string($_POST['first_name']);
    $lastName = $conn->real_escape_string($_POST['last_name']);
    $age = $conn->real_escape_string($_POST['age']);
    $contactPreference = $conn->real_escape_string($_POST['contact_preference']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $stayType = $conn->real_escape_string($_POST['stay_type']);
    $destinationType = $_POST['destination_type']; // single or multiple

    // Check for multiple destinations
    if ($destinationType == "multiple" && isset($_POST['destinations'])) {
        $destinations = $_POST['destinations']; // Array of destinations
    } else {
        $destinations = [$_POST['destination']]; // Single destination as array
    }

    $emptyString = null;

    // Generate guest code
    $randomNumbers = rand(10000, 99999);
    $guestCode = 'guest-' . $randomNumbers;

    // Insert guest into `guests` table
    $stmt = $conn->prepare("INSERT INTO `guests` (`guest_code`, `firstname`, `lastname`, `age`, `email`, `phone`, `type_of_stay`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($contactPreference == 'email') {
        $stmt->bind_param("sssssss", $guestCode, $firstName, $lastName, $age, $contact, $emptyString, $stayType);
    } else {
        $stmt->bind_param("sssssss", $guestCode, $firstName, $lastName, $age, $emptyString, $contact, $stayType);
    }

    if ($stmt->execute()) {
        
        // Insert destinations into `guest_destinations` table
        $stmtDestination = $conn->prepare("INSERT INTO `guest_destinations` (`guest_code`, `destination`) VALUES (?, ?)");

        foreach ($destinations as $destination) {
            $cleanDestination = $conn->real_escape_string($destination);
            $stmtDestination->bind_param("ss", $guestCode, $cleanDestination);
            $stmtDestination->execute();
        }

        // Close destination statement
        $stmtDestination->close();

        // Set success message and redirect
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "New guest registered successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
        header("Location: success?GuestCode=$guestCode");
        exit;
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "OK";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

    // Close connections
    $stmt->close();
}


function addNotification($conn, $guestCodeNotif, $description, $status) {
    $stmt = $conn->prepare("INSERT INTO `notifications` (`guest_code`,`description`, `status`) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $guestCodeNotif, $description, $status);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['qr_code'])) {
    $qr_code = $conn->real_escape_string($_POST['qr_code']);
    $query = "SELECT * FROM `guests` WHERE guest_code = '$qr_code'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if guest has multiple destinations
        $destinations = [];
        $destinationQuery = "SELECT destination FROM `guest_destinations` WHERE guest_code = '{$row['guest_code']}'";
        $destinationResult = $conn->query($destinationQuery);

        if ($destinationResult->num_rows > 0) {
            while ($destinationRow = $destinationResult->fetch_assoc()) {
                $destinations[] = $destinationRow['destination'];
            }
        }

        // Add notification
        $description = "Guest with code " . $row['guest_code'] . " has confirmed their arrival.";
        $status = "unread"; // Or any status you want to set
        $guestCodeNotif = $guestCode;
        addNotification($conn, $guestCodeNotif, $description, $status);

        echo json_encode([
            'success' => true,
            'guest_code' => $row['guest_code'],
            'id' => $row['id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'age' => $row['age'],
            'email' => $row['email'] ?? "Not Applicable",
            'phone' => $row['phone'] ?? "Not Applicable",
            'destination' => $destinations, // Now an array
            'type_of_stay' => $row['type_of_stay'],
            'arrival_date_time' => $row['arrival_date_time'] ?? "Not yet Checked In"
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}

$conn->close();
?>