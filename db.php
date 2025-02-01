<?php
$host = 'localhost'; // Typically 'localhost' for local server
$dbname = 'personalproject'; // Replace with your actual database name
$username = 'root'; // Default MySQL username in XAMPP
$password = ''; // Default MySQL password in XAMPP is empty

try {
    // Create PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
