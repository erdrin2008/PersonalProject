<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit;
}

$productId = $_GET['id'] ?? null;

// If no product ID is passed, redirect to the product list
if (!$productId) {
    header("Location: index.php");
    exit;
}

// Fetch product details from database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// If the product doesn't exist, redirect to product list
if (!$product) {
    header("Location: index.php");
    exit;
}

// Handle the form submission for purchase
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = $_POST['quantity'] ?? 1;

    // Check if there is enough stock
    if ($product['stock'] >= $quantity) {
        // Process the purchase (you may want to add purchase logging here)
        $newStock = $product['stock'] - $quantity;

        // Update the stock in the database
        $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->execute([$newStock, $productId]);

        // For now, we'll just show a success message
        echo "<p>Purchase successful! You bought $quantity of {$product['name']}.</p>";
        echo "<a href='index.php'>Back to Products</a>";
        exit;
    } else {
        // Not enough stock
        echo "<p>Sorry, there is not enough stock for your requested quantity.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

    <h1>Buy Product: <?php echo htmlspecialchars($product['name']); ?></h1>

    <div class="product-details">
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
        <p><strong>Stock:</strong> <?php echo $product['stock']; ?></p>
    </div>

    <h3>Enter Quantity to Buy:</h3>

    <form action="buy.php?id=<?php echo $product['id']; ?>" method="POST">
        <label>Quantity:</label>
        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" required>
        <button type="submit">Buy Now</button>
    </form>

    <br>
    <a href="index.php">Back to Products</a>

</body>
</html>
