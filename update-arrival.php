<?php
session_start();
include_once "includes/conn.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['guest_code'])) {
        $guest_code = $conn->real_escape_string($data['guest_code']);
       
        // Assuming $guest_code contains your guest code (ensure it's properly sanitized)
        $query = "UPDATE `guests` SET `arrival_date_time` = NOW() WHERE `guest_code` = '$guest_code'";

        if ($conn->query($query) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request data']);
    }
}
?>