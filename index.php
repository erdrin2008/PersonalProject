<?php
session_start();
include 'db.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

    <h1>Product List</h1>

    <!-- User Info and Logout Button -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-info">
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    <?php endif; ?>

    <!-- Product List Display -->
    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p>Price: $<?php echo isset($product['price']) ? number_format((float)$product['price'], 2) : '0.00'; ?></p>
                <img src="uploads/<?php echo htmlspecialchars($product['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100">
                
                <div class="actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="buy.php?id=<?php echo $product['id']; ?>" class="btn">Buy</a>
                    <?php else: ?>
                        <a href="login.php" class="btn">Log in to Buy</a>
                    <?php endif; ?>
                    
                    <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn">Edit</a>
                    <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>