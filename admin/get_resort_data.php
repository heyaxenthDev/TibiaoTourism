<?php
include "includes/conn.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);


$resortId = $_POST['resort_id']; // Assuming resort_id is sent via POST

// Query to fetch resort data
$sql = "SELECT g.id, g.firstname, g.lastname, DATE_FORMAT(g.arrival_date_time, '%M %d, %Y %h:%i %p') AS formatted_arrival_time, g.destination, g.email, g.phone, r.name
        FROM guests g
        JOIN resorts r ON g.destination = r.name
        WHERE r.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $resortId);
$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>