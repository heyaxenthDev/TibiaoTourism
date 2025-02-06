<?php
include "includes/conn.php";

try {
    $sql = "SELECT name FROM resorts";
    $result = $conn->query($sql);

    $resorts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resorts[] = ['name' => htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8')];
        }
    }

    echo json_encode($resorts);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>