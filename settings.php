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
        $_SESSION['user'] = $new_username;  // Update username in session
        $_SESSION['email'] = $new_email;
        $_SESSION['password'] = $new_password;

        $message = "Your information has been updated successfully!";
    } else {
        $error = "Please fill in all fields.";
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
        body {
            font-family: Arial, sans-serif;
            background-image: url('assets/background.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            color: white;
        }
        
        header {
            background-color: #333;
            padding: 10px 0;
            text-align: center;
        }

        header .nav-links {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        header .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        header .nav-links a:hover {
            background-color: #555;
        }

        header .nav-links a:active {
            transform: scale(0.98);
            background-color: #444;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            background: rgba(0, 0, 0, 0.8);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .form-input {
            margin: 1rem 0;
            padding: 10px;
            font-size: 1rem;
            width: 100%;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-button {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            font-size: 1.2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
        }

        .form-button:hover {
            background-color: #555;
        }

        .error-message {
            color: red;
            font-size: 1rem;
        }

        .success-message {
            color: green;
            font-size: 1rem;
        }

        #loading {
            display: none;
            color: white;
            font-size: 1.2rem;
            text-align: center;
            margin-top: 20px;
        }

        /* Sidebar styling */
        #side-panel {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100%;
            background-color: #222;
            padding: 20px;
            color: white;
        }

        #side-panel a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        #side-panel a:hover {
            background-color: #555;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 2rem;
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            color: white;
        }

        .modal input {
            margin-bottom: 10px;
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal button {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal button:hover {
            background-color: #555;
        }
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
        <input type="password" name="password" class="form-input" placeholder="New Password" value="<?php echo htmlspecialchars($_SESSION['password']); ?>" required>
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
    <input type="password" id="old-password" placeholder="Old Password">
    <input type="password" id="new-password" placeholder="New Password">
    <button id="save-password" class="modal-btn">Save</button>
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
        document.getElementById("submit-button").textContent = "Done!";
        setTimeout(function() {
            document.getElementById("change-username-modal").style.display = "none";
        }, 500);
    }

    document.getElementById("save-email").onclick = function() {
        document.getElementById("submit-button").textContent = "Done!";
        setTimeout(function() {
            document.getElementById("change-email-modal").style.display = "none";
        }, 500);
    }

    document.getElementById("save-password").onclick = function() {
        document.getElementById("submit-button").textContent = "Done!";
        setTimeout(function() {
            document.getElementById("change-password-modal").style.display = "none";
        }, 500);
    }
</script>

</body>
</html>
