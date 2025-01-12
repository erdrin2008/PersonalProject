<?php
$host = 'localhost';      // Database host (localhost for local development)
$db = 'game_preregistration';  // Name of your database
$user = 'root';           // MySQL username (default is 'root' for local servers)
$password = '';           // MySQL password (default is empty for local servers)

// Create connection
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
