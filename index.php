<?php
session_start();
include 'db.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $gender = isset($_GET['gender']) ? $_GET['gender'] : null;
    $fragrance_type = isset($_GET['fragrance_type']) ? $_GET['fragrance_type'] : null;

    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    if ($gender) {
        $sql .= " AND gender = :gender";
        $params[':gender'] = $gender;
    }

    if ($fragrance_type) {
        $sql .= " AND fragrance_type = :fragrance_type";
        $params[':fragrance_type'] = $fragrance_type;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

if (!isset($products) || !is_array($products)) {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume List</title>
    <link rel="stylesheet" href="style/style.css">
    <script>
        function filterProducts() {
            let gender = document.querySelector('input[name="gender"]:checked')?.value;
            let fragranceType = document.querySelector('input[name="fragrance_type"]:checked')?.value;
            let url = 'index.php';

            if (gender) {
                url += `?gender=${gender}`;
            }

            if (fragranceType) {
                url += `&fragrance_type=${fragranceType}`;
            }

            window.location.href = url; 
        }
    </script>
</head>
<body>
<nav>
    <div class="nav-container">
        <ul class="nav-left">
            <li class="logo">
                <a href="index.php">
                    <img src="uploads/LOGO.jpg" alt="Perfume Store Logo">
                </a>
            </li>
            <li><a href="index.php">Home</a></li>
            <li><a href="perfumes.php">Perfumes</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="add.php">Add Product</a></li>
        </ul>
        
        <ul class="nav-right">
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php" class="btn">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<h1>Explore Perfumes 
    <?php 
    if (isset($_GET['gender'])) {
        echo "for " . ucfirst($_GET['gender']);
    } elseif (isset($_GET['fragrance_type'])) {
        echo "with " . ucfirst($_GET['fragrance_type']) . " Fragrance";
    }
    ?>
</h1>
<?php if (isset($_SESSION['user_id'])): ?>
    <div class="user-info">
        <p>Welcome, blert crud e ki kur te bon ni product nese nuk e bon ni product crudin nuk munesh me pa <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
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
        <li><input type="radio" name="gender" value="men" onclick="filterProducts()" <?php echo (isset($_GET['gender']) && $_GET['gender'] === 'men') ? 'checked' : ''; ?>> Men</li>
        <li><input type="radio" name="gender" value="women" onclick="filterProducts()" <?php echo (isset($_GET['gender']) && $_GET['gender'] === 'women') ? 'checked' : ''; ?>> Women</li>
        <li><input type="radio" name="gender" value="unisex" onclick="filterProducts()" <?php echo (isset($_GET['gender']) && $_GET['gender'] === 'unisex') ? 'checked' : ''; ?>> Unisex</li>
    </ul>
</section>

<section>
    <h2>FRAGRANCE TYPES</h2>
    <ul>
        <li><input type="radio" name="fragrance_type" value="floral" onclick="filterProducts()" <?php echo (isset($_GET['fragrance_type']) && $_GET['fragrance_type'] === 'floral') ? 'checked' : ''; ?>> Floral</li>
        <li><input type="radio" name="fragrance_type" value="woody" onclick="filterProducts()" <?php echo (isset($_GET['fragrance_type']) && $_GET['fragrance_type'] === 'woody') ? 'checked' : ''; ?>> Woody</li>
        <li><input type="radio" name="fragrance_type" value="citrus" onclick="filterProducts()" <?php echo (isset($_GET['fragrance_type']) && $_GET['fragrance_type'] === 'citrus') ? 'checked' : ''; ?>> Citrus</li>
        <li><input type="radio" name="fragrance_type" value="oriental" onclick="filterProducts()" <?php echo (isset($_GET['fragrance_type']) && $_GET['fragrance_type'] === 'oriental') ? 'checked' : ''; ?>> Oriental</li>
        <li><input type="radio" name="fragrance_type" value="fresh" onclick="filterProducts()" <?php echo (isset($_GET['fragrance_type']) && $_GET['fragrance_type'] === 'fresh') ? 'checked' : ''; ?>> Fresh</li>
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
        <p>No products found.</p>
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
