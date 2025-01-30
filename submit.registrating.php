<?php

include ('db_conifg.php');  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_POST['user_id']; 
    $game_id = $_POST['game_id'];  

   
    $sql = "INSERT INTO registration (user_id, game_id, status) VALUES (?, ?, 'pending')";
    
   
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $user_id, $game_id); 
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
