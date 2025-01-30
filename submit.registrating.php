<?php
include('db_conifg.php');  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = $_POST['name']; 
    $email = $_POST['email'];  
    $platform = $_POST['platform'];  

   
    $sql = "INSERT INTO registrations (name, email, platform, status) VALUES (?, ?, ?, 'pending')";

   
    $stmt = $conn->prepare($sql);
    if ($stmt) {
       
        $stmt->bind_param("sss", $name, $email, $platform);
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error; 
        }
    } else {
        echo "Error preparing statement: " . $conn->error; 
    }
}
?>
