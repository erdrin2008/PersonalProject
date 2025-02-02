<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $image = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock, $image]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

    <h1>Add New Product</h1>
    <div class="form-container">
        <form action="add.php" method="POST" enctype="multipart/form-data">
            <label>Product Name:</label>
            <input type="text" name="name" required>

            <label>Description:</label>
            <textarea name="description" required></textarea>

            <label>Price ($):</label>
            <input type="number" name="price" step="0.01" required>

            <label>Stock Quantity:</label>
            <input type="number" name="stock" required>

            <label>Product Image:</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Add Product</button>
        </form>
    </div>

    <br>
    <a href="index.php" class="add-btn">Back to Product List</a>

</body>
</html>
