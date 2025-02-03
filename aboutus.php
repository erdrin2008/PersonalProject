<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
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
            <li><a href="aboutus.php">Add new product</a></li>
        </ul>
        <ul class="nav-right">
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php" class="btn">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <h1>About Us</h1>


    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-info">
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        </div>
    <?php endif; ?>

  
    <section>
        <h2>Our Story</h2>
        <p>
            Welcome to our online store! We are passionate about providing high-quality products that cater to your needs.
            Our journey began in 2023 with a simple goal: to make premium perfumes accessible to everyone. Over the years,
            we have grown into a trusted brand, offering a wide range of fragrances for men, women, and unisex.
        </p>
    </section>

    <section>
        <h2>Our Mission</h2>
        <p>
            Our mission is to deliver exceptional products and an unforgettable shopping experience. We believe in quality,
            affordability, and customer satisfaction. Every product we offer is carefully selected to ensure it meets our
            high standards.
        </p>
    </section>

    <section>
        <h2>Why Choose Us?</h2>
        <ul>
            <li>High-quality products</li>
            <li>Affordable prices</li>
            <li>Fast and secure delivery</li>
            <li>24/7 customer support</li>
        </ul>
    </section>

 
    <footer>
        <p>&copy; 2023 Your Company Name. All rights reserved.</p>
    </footer>

</body>
</html>