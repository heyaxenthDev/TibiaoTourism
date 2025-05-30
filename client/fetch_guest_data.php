<?php
// Connect to your database
include 'includes/conn.php'; // Ensure this file correctly establishes $conn
include "authentication.php";
checkLogin();

$resort_name = $_SESSION['resort_name'];

// Set response type as JSON
header('Content-Type: application/json');

// SQL query to fetch guest count by destination
$sql = "SELECT 
            g.type_of_stay,
            COUNT(*) as guest_count
        FROM guests g
        JOIN guest_destinations d ON g.guest_code = d.guest_code
        WHERE d.destination = ?
        AND DATE(g.arrival_date_time) = CURDATE()
        GROUP BY g.type_of_stay";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $resort_name);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'type_of_stay' => $row['type_of_stay'],
        'guest_count' => (int)$row['guest_count']
    ];
}

echo json_encode($data);

// Close the database connection
$conn->close();
?>