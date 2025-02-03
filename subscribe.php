<?php



include 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    if (empty($email)) {
        die("Email is required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    try {

        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (:email)");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

   
        echo "Thank you for subscribing!";
    } catch (PDOException $e) {
  
        die("Subscription failed: " . $e->getMessage());
    }
} else {
  
    header("Location: index.php");
    exit();
header("Location: thank_you.php");
exit();
}
