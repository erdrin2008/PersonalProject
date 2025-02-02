<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nav</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    
</body>
</html>
<nav>
    <div class="nav-container">
        <ul class="nav-left">
            <li class="logo">
                <a href="index.php">
                    <img src="uploads/LOGO,jpg" alt="Perfume Store Logo">
                </a>
            </li>
            <li><a href="index.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>>Home</a></li>
            <li><a href="perfumes.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'perfumes.php') ? 'class="active"' : ''; ?>>Perfumes</a></li>
            <li><a href="aboutus.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'aboutus.php') ? 'class="active"' : ''; ?>>About Us</a></li>
            <li><a href="contact.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'class="active"' : ''; ?>>Contact</a></li>
            <li><a href="add.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'add.php') ? 'class="active"' : ''; ?>>Add Product</a></li>
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