<?php
include 'includes/conn.php';

if (isset($_POST['resort_id'])) {
    $resortId = $_POST['resort_id'];

    // Daily data
    $sqlDaily = "SELECT DATE(arrival_date_time) as date, COUNT(*) as count
                 FROM guests
                 WHERE destination = ?
                 GROUP BY DATE(arrival_date_time)";
    $stmtDaily = $conn->prepare($sqlDaily);
    $stmtDaily->bind_param('s', $resortId);
    $stmtDaily->execute();
    $resultDaily = $stmtDaily->get_result();
    $dataDaily = [];
    while ($row = $resultDaily->fetch_assoc()) {
        $dataDaily[] = $row;
    }

    // Weekly data
    $sqlWeekly = "SELECT WEEK(arrival_date_time) as week, COUNT(*) as count
                  FROM guests
                  WHERE destination = ?
                  GROUP BY WEEK(arrival_date_time)";
    $stmtWeekly = $conn->prepare($sqlWeekly);
    $stmtWeekly->bind_param('s', $resortId);
    $stmtWeekly->execute();
    $resultWeekly = $stmtWeekly->get_result();
    $dataWeekly = [];
    while ($row = $resultWeekly->fetch_assoc()) {
        $dataWeekly[] = $row;
    }

    // Monthly data
    $sqlMonthly = "SELECT MONTH(arrival_date_time) as month, COUNT(*) as count
                   FROM guests
                   WHERE destination = ?
                   GROUP BY MONTH(arrival_date_time)";
    $stmtMonthly = $conn->prepare($sqlMonthly);
    $stmtMonthly->bind_param('s', $resortId);
    $stmtMonthly->execute();
    $resultMonthly = $stmtMonthly->get_result();
    $dataMonthly = [];
    while ($row = $resultMonthly->fetch_assoc()) {
        $dataMonthly[] = $row;
    }

    $data = [
        'daily' => $dataDaily,
        'weekly' => $dataWeekly,
        'monthly' => $dataMonthly
    ];

    echo json_encode($data);
}
?>