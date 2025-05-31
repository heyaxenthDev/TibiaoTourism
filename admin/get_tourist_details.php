<?php
try {
    include "includes/conn.php";

    header('Content-Type: application/json');

    if (!isset($_GET['code'])) {
        throw new Exception('Guest code is required');
    }

    $guest_code = $_GET['code'];

    // Get main guest
    $main_guest_sql = "SELECT g.*, DATE_FORMAT(g.arrival_date_time, '%M %d, %Y %h:%i %p') as formatted_arrival_time 
                       FROM guests g 
                       WHERE g.guest_code = ?";
    $stmt = $conn->prepare($main_guest_sql);
    if (!$stmt) throw new Exception('Database error: ' . $conn->error);
    $stmt->bind_param("s", $guest_code);
    $stmt->execute();
    $main_guest_result = $stmt->get_result();
    $main_guest = $main_guest_result->fetch_assoc();
    if (!$main_guest) throw new Exception('Guest not found');

    // Get destinations
    $destinations_sql = "SELECT d.*, r.name as resort_name 
                         FROM guest_destinations d 
                         JOIN resorts r ON d.destination = r.name 
                         WHERE d.guest_code = ?";
    $stmt = $conn->prepare($destinations_sql);
    if (!$stmt) throw new Exception('Database error: ' . $conn->error);
    $stmt->bind_param("s", $guest_code);
    $stmt->execute();
    $destinations_result = $stmt->get_result();
    $destinations = [];
    while ($row = $destinations_result->fetch_assoc()) {
        $destinations[] = $row;
    }

    // Get tourists
    $tourists_sql = "SELECT * FROM additional_guests WHERE guest_code = ?";
    $stmt = $conn->prepare($tourists_sql);
    if (!$stmt) throw new Exception('Database error: ' . $conn->error);
    $stmt->bind_param("s", $guest_code);
    $stmt->execute();
    $tourists_result = $stmt->get_result();
    $tourists = [];
    while ($row = $tourists_result->fetch_assoc()) {
        $tourists[] = $row;
    }

    // Final response
    echo json_encode([
        'status' => 'success',
        'data' => [
            'main_guest' => $main_guest,
            'destinations' => $destinations,
            'tourists' => $tourists
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

?>