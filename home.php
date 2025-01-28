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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Pre-Registering</title>
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

        #loading {
            display: none;
            color: white;
            font-size: 1.2rem;
            text-align: center;
            margin-top: 20px;
        }

        #gameVideo {
            width: 80%;
            max-width: 640px;
            margin: 20px 0;
            border-radius: 8px;
            transition: width 0.3s ease;
        }

        #gameVideo.extended {
            width: 100%;
        }

        #toggleVideoSize {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        #toggleVideoSize:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="settings.php">Settings</a>
            <a href="?logout">Logout</a>
        </div>
    </header>

    <div class="container">
        <h1>Thank You for Pre-Registering, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
        <p>We appreciate your interest in our game. Please be patient while we work on getting the game ready for launch.</p>
        <p>Stay tuned for updates, and thank you again for your support!</p>

      
        <video id="gameVideo" controls>
            <source src="assets/game-preview.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

       
        <button id="toggleVideoSize">Toggle Video Size</button>
    </div>

    <script>
       
        document.getElementById("toggleVideoSize").addEventListener("click", function() {
            var video = document.getElementById("gameVideo");
            video.classList.toggle("extended"); 
        });
    </script>
</body>
</html>
