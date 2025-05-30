<?php 

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "tibiaotourism_db";

// Create connection
$conn = new mysqli($host,$dbusername,$dbpassword,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}
//echo "Connected successfully";

// Close Connection
//$conn->close();
?>