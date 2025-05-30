<?php
require_once 'includes/conn.php'; // Include your database connection file

$query = "UPDATE `notifications` SET `status` = 'read' WHERE `status` = 'unread'";
$conn->query($query);

echo "Success";
?>