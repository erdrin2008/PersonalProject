<?php
session_start();
include 'db.php';

$error = "";
$success = "";

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to home if logged in
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $error = "Username already taken.";
        } else {
            // Hash the password and insert the new user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);

            // Redirect to login after successful registration
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

    <h1>Create an Account</h1>
    <div class="form-container">
        <form action="register.php" method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Confirm Password:</label>
            <input type="password" name="confirmPassword" required>

            <button type="submit">Register</button>
        </form>

        <?php if ($error): ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
        <?php endif; ?>

    </div>

    <br>
    <a href="login.php" class="add-btn">Already have an account? Login</a>

</body>
</html>
