<?php
$host = "localhost";
$username = "root";
$password = "Meet@2007";   // MUST match what you just set
$database = "sevasetu";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
