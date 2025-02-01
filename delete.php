<?php
include 'db.php';

// Check if an ID is provided
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Delete the product from the database
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

// Redirect back to index page
header("Location: index.php");
exit;
?>
