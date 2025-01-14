<?php
$host = 'localhost';      
$db = 'game_preregistration';  
$user = 'root';           
$password = '';          

// Create connection
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
