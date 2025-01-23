<?php
$host = 'localhost';      
$db = 'personalproject';  
$user = 'root';           
$password = '';          

try{
    $conn = new PDO("mysql:host=$host;dbname=$db",$user,$password);
}catch (PDOExpection $e) {
    echo "error: " . $e->getMessage();
} 