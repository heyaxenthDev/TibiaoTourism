<?php
// Connect to your database
include 'includes/conn.php'; // Adjust this according to your database connection method

// SQL query to fetch guest count by destination
$sql = "SELECT `destination`, COUNT(*) AS `guest_count`
        FROM `guests`
        WHERE DATE(`date_created`) = DATE(NOW()) AND `arrival_date_time` IS NOT NULL
        GROUP BY `destination`";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(array()); // Return empty array if no data found
}

$conn->close();
?>