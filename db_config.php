<?php
// Hostinger Live Database Connection
$servername = "localhost"; // Hostinger usually uses localhost
$username = "root"; // Change to your Hostinger DB username
$password = ""; // Change to your Hostinger DB password
$dbname = "dj_wilgen_db"; // Change to your Hostinger DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>