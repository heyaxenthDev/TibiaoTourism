<?php
// Connect to your database
include 'includes/conn.php'; // Ensure this file correctly establishes $conn

// Set response type as JSON
header('Content-Type: application/json');

// SQL query to fetch guest count by destination
$sql = "SELECT d.destination, COUNT(*) AS guest_count
        FROM guest_destinations d
        JOIN guests g ON d.guest_code = g.guest_code
        WHERE DATE(g.date_created) = CURDATE() 
        AND g.arrival_date_time IS NOT NULL
        GROUP BY d.destination";

$result = $conn->query($sql);

$data = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(array("error" => $conn->error)); // Return error message if query fails
}

// Close the database connection
$conn->close();
?>