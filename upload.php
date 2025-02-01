<?php
session_start();
include 'db.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Handle the uploaded image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];

        // Define the upload directory
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($imageName);

        // Check if the file is a valid image
        if (in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
            // Move the file to the server
            if (move_uploaded_file($imageTmpName, $uploadFile)) {
                // Insert the product details into the database
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $description, $price, $stock, $imageName]);

                echo "Product added successfully!";
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid image file.";
        }
    } else {
        echo "No image uploaded.";
    }
}
?>
