<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $platform = $conn->real_escape_string($_POST['platform']);

    $sql = "INSERT INTO registrations (name, email, platform) VALUES ('$name', '$email', '$platform')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Thank you for pre-registering, $name! You will receive updates at $email.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
