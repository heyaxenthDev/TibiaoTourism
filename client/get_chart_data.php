<?php
include "includes/conn.php";
include "authentication.php";
checkLogin();

$resort_name = $_SESSION['resort_name'];

// Get daily check-in data for the last 7 days
$sql = "SELECT 
            DATE(arrival_date_time) as date,
            COUNT(*) as count
        FROM guests g
        JOIN guest_destinations d ON g.guest_code = d.guest_code
        WHERE d.destination = ?
        AND arrival_date_time >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(arrival_date_time)
        ORDER BY date";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $resort_name);
$stmt->execute();
$result = $stmt->get_result();

$data = [
    'daily' => []
];

while ($row = $result->fetch_assoc()) {
    $data['daily'][] = [
        'date' => $row['date'],
        'count' => (int)$row['count']
    ];
}

// Fill in missing dates with zero counts
$dates = [];
$current_date = date('Y-m-d');
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $dates[$date] = 0;
}

foreach ($data['daily'] as $entry) {
    $dates[$entry['date']] = $entry['count'];
}

$data['daily'] = [];
foreach ($dates as $date => $count) {
    $data['daily'][] = [
        'date' => $date,
        'count' => $count
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>