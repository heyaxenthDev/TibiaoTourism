<?php
include "includes/conn.php";

$resortId = $_POST['resort_id']; // Assuming resort_id is sent via POST

// Query to fetch resort data
$sql = "SELECT g.id, g.firstname, g.lastname, g.arrival_date_time, g.destination, g.email, g.phone
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