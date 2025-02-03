<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
            <li><a href="add.php">Add new product</a></li>
            
        </ul>
        <ul class="nav-right">
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php" class="btn">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <h1>Contact Us</h1>

    

    <section>
        <h2>Get in Touch</h2>
        <form action="submit_contact.php" method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>
    </section>

    <section>
        <h2>Our Contact Details</h2>
        <p>If you have any questions or need assistance, feel free to reach out to us:</p>
        <ul>
            <li><strong>Address:</strong> RBS Markets Street, Las Vegas, LA 94530, United States</li>
            <li><strong>Email:</strong> <a href="erdrindemi@icloud.com">erdrindemi@icloud.com</a></li>
            <li><strong>Phone:</strong> (x) 950-385-5862</li>
        </ul>
    </section>

    <footer>
        <p>&copy; 2025 BOwER. All rights reserved.</p>
    </footer>

   
</body>
</html>