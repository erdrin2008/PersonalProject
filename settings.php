<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php"); 
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_password = trim($_POST['password']);

   
    if (!empty($new_username) && !empty($new_email) && !empty($new_password)) {
       
        $_SESSION['user'] = $new_username;
        $_SESSION['email'] = $new_email;
        $_SESSION['password'] = password_hash($new_password, PASSWORD_DEFAULT);  // Store hashed password
        
        $message = "Your information has been updated successfully!";
    } else {
        $error = "Please fill in all fields.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['old_password']) && isset($_POST['new_password'])) {
    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    
  
    if (password_verify($old_password, $_SESSION['password']) && !empty($new_password)) {
    
        $_SESSION['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        $message = "Password has been updated successfully!";
    } else {
        $error = "Incorrect old password or empty new password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
      
    </style>
</head>
<body>

<header>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="settings.php">Settings</a>
    </div>
</header>

<div id="side-panel">
    <h2>Settings</h2>
    <a href="#" id="change-username">Change Username</a>
    <a href="#" id="change-email">Change Email</a>
    <a href="#" id="change-password">Change Password</a>
</div>

<div class="container">
    <h1>Settings</h1>

    <?php if ($message): ?>
        <p class="success-message"><?php echo $message; ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

 
    <form method="POST" action="settings.php">
        <input type="text" name="username" class="form-input" placeholder="New Username" value="<?php echo htmlspecialchars($_SESSION['user']); ?>" required>
        <input type="email" name="email" class="form-input" placeholder="New Email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
        <input type="password" name="password" class="form-input" placeholder="New Password" required>
        <button type="submit" class="form-button" id="submit-button">Save</button>
    </form>
</div>


<div id="change-username-modal" class="modal">
    <h2>Change Username</h2>
    <input type="text" id="new-username" placeholder="New Username">
    <button id="save-username" class="modal-btn">Save</button>
</div>

<div id="change-email-modal" class="modal">
    <h2>Change Email</h2>
    <input type="email" id="new-email" placeholder="New Email">
    <button id="save-email" class="modal-btn">Save</button>
</div>

<div id="change-password-modal" class="modal">
    <h2>Change Password</h2>
    <form method="POST" action="settings.php">
        <input type="password" name="old_password" class="form-input" placeholder="Old Password" required>
        <input type="password" name="new_password" class="form-input" placeholder="New Password" required>
        <button type="submit" id="save-password" class="modal-btn">Save</button>
    </form>
</div>

<script>
    document.getElementById("change-username").onclick = function() {
        document.getElementById("change-username-modal").style.display = "block";
    }
    document.getElementById("change-email").onclick = function() {
        document.getElementById("change-email-modal").style.display = "block";
    }
    document.getElementById("change-password").onclick = function() {
        document.getElementById("change-password-modal").style.display = "block";
    }

    
    document.getElementById("save-username").onclick = function() {
        var newUsername = document.getElementById("new-username").value;
        if (newUsername) {
           
            alert("Username updated to: " + newUsername);
            document.getElementById("change-username-modal").style.display = "none";
        }
    }

    document.getElementById("save-email").onclick = function() {
        var newEmail = document.getElementById("new-email").value;
        if (newEmail) {
           
            alert("Email updated to: " + newEmail);
            document.getElementById("change-email-modal").style.display = "none";
        }
    }

    document.getElementById("save-password").onclick = function() {
        
        var oldPassword = document.getElementsByName("old_password")[0].value;
        var newPassword = document.getElementsByName("new_password")[0].value;
        if (oldPassword && newPassword) {
            alert("Password updated successfully.");
            document.getElementById("change-password-modal").style.display = "none";
        }
    }
</script>

</body>
</html>
