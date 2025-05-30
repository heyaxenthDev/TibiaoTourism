<?php
// Prevent any output before JSON response
error_reporting(E_ALL);
ini_set('display_errors', 0);

include "includes/conn.php";
include "authentication.php";
checkLogin();

header('Content-Type: application/json');

try {
    if(!isset($_POST['guest_code'])) {
        throw new Exception('Guest code is required');
    }

    $guest_code = $_POST['guest_code'];
    
    // Get main guest information
    $main_guest_sql = "SELECT * FROM guests WHERE guest_code = ?";
    $stmt = $conn->prepare($main_guest_sql);
    if(!$stmt) {
        throw new Exception('Database error: ' . $conn->error);
    }
    $stmt->bind_param("s", $guest_code);
    $stmt->execute();
    $main_guest_result = $stmt->get_result();
    $main_guest = $main_guest_result->fetch_assoc();

    if(!$main_guest) {
        throw new Exception('Guest not found');
    }

    // Get all destinations
    $destinations_sql = "SELECT * FROM guest_destinations WHERE guest_code = ?";
    $stmt = $conn->prepare($destinations_sql);
    if(!$stmt) {
        throw new Exception('Database error: ' . $conn->error);
    }
    $stmt->bind_param("s", $guest_code);
    $stmt->execute();
    $destinations_result = $stmt->get_result();
    $destinations = [];
    while($row = $destinations_result->fetch_assoc()) {
        $destinations[] = $row;
    }

    // Get all tourists
    $tourists_sql = "SELECT * FROM tourists WHERE guest_code = ?";
    $stmt = $conn->prepare($tourists_sql);
    if(!$stmt) {
        throw new Exception('Database error: ' . $conn->error);
    }
    $stmt->bind_param("s", $guest_code);
    $stmt->execute();
    $tourists_result = $stmt->get_result();
    $tourists = [];
    while($row = $tourists_result->fetch_assoc()) {
        $tourists[] = $row;
    }

    // Format the response
    $response = [
        'status' => 'success',
        'data' => [
            'main_guest' => $main_guest,
            'destinations' => $destinations,
            'tourists' => $tourists
        ]
    ];

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>