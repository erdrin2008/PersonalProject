<?php
include ('db_conifg.php');

$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'personalproject';

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection successful";
?>


