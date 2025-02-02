<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id']; // Sanitize the ID

try {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header("Location: index.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $image = $product['image']; // Keep the old image by default

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowedTypes)) {
            die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        $image = uniqid() . "." . $imageFileType;
        $targetFilePath = $targetDir . $image;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            die("Error: Failed to upload the image.");
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $stock, $image, $id]);

        $_SESSION['success_message'] = "Product updated successfully!";
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

    <h1>Edit Product</h1>
    <div class="form-container">
        <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label for="price">Price ($):</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>

            <label for="stock">Stock Quantity:</label>
            <input type="number" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>

            <label>Current Image:</label>
            <br>
            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" width="100">
            <br><br>

            <label for="image">Upload New Image (Optional):</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit">Update Product</button>
        </form>
    </div>

    <br>
    <a href="index.php" class="add-btn">Back to Product List</a>

</body>
</html>