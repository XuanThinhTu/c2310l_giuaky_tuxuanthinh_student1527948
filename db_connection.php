<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aptech_midterm_tuxuanthinh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
