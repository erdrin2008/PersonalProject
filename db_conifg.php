<?php
$host = 'localhost';      
$db = 'game_preregistration';  
$user = 'root';           
$password = '';          


$conn = new mysql($host, $user, $password, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>



