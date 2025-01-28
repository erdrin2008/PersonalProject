<?php 

session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: ../login.php'); 
    exit;
}

$user_id = $_SESSION['user_id']; 


$sql = "SELECT b.id, m.title, b.show_time, b.status
        FROM registration b
        INNER JOIN games m ON b.game_id = m.id
        WHERE b.user_id = $user_id";

$result = $conn->query($sql);


if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<div class="container mt-5">
    <h1 class="text-center">User Dashboard</h1>

    <h2 class="table tables-bordered mt-3">My Pre-Registration</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>dark soul</th>
                <th>Show Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['show_time']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No pre-registrations found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
