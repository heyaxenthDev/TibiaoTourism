<?php
session_start();
include_once "includes/conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);
    $id = $conn->real_escape_string($data['guest_code']);
    $current_time = date('Y-m-d H:i:s');
    $query = "UPDATE `guests` SET `arrival_date_time` = '$current_time' WHERE `guest_code` = '$id'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $conn->close();
}
?>