<?php
session_start();
include 'db.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM products WHERE category = 'perfume'");
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
    <title>Perfume Collection</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

    <nav>
        <ul>
             <div class="nav-container">
        <ul class="nav-left">
            <li class="logo">
                <a href="index.php">
                    <img src="uploads/LOGO.jpg" alt="Perfume Store Logo">
                </a>
            <li><a href="index.php">Home</a></li>
            <li><a href="perfumes.php">Perfumes</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>

        </ul>
    </nav>

    <h1>Explore Our Perfume Collection</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-info">
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        </div>
    <?php endif; ?>

    <section>
        <h2>CATEGORIES</h2>
        <ul>
            <li>Perfumes</li>
        </ul>
    </section>

    <section>
        <h2>GENDER</h2>
        <ul>
            <li>Men</li>
            <li>Women</li>
            <li>Unisex</li>
        </ul>
    </section>

    <section>
        <h2>FRAGRANCE TYPES</h2>
        <ul>
            <li>Floral</li>
            <li>Woody</li>
            <li>Citrus</li>
            <li>Oriental</li>
            <li>Fresh</li>
        </ul>
    </section>

    <section>
        <h2>PRICE RANGE</h2>
        <ul>
            <li>$50 - $100</li>
            <li>$100 - $200</li>
            <li>$200+</li>
        </ul>
    </section>

    <div class="product-list">
        <?php if (empty($products)): ?>
            <p>No perfumes found.</p>
        <?php else: ?>
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
        <?php endif; ?>
    </div>

    <section>
        <h2>Get Weekly Updates</h2>
        <form action="subscribe.php" method="post">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Subscribe</button>
        </form>
    </section>

    <section>
        <h2>Support</h2>
        <p>RBS Markets Street, Las Vegas, LA 94530, United States.</p>
        <p>Email: <a href="erdrindemi@icloud.com">erdrindemi@icloud.com</a></p>
        <p>Phone: (x) 950-385-5862</p>
    </section>


</body>
</html>