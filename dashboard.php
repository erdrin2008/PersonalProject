<?php 




if(!isset($_SESSION['user.id']) || $_SESSION['role'] !='user'){
    header('location: ../login.php'); 
    exit;
}



$user_id = $_SESSION['user_id'];
$sql = "SELECT b.id, m.title, b.show_time b.status
        FROM registration
        INNER JOIN games m ON game.id = m.id
        WHERE b.user_id = $user_id";
        $result = $conn->query($sql);

?>

<div class="container mt-5">
    <h1 class="text-center">User dashboard</h1>

    <h2 class="table tables-borded mt-3">my pre-registration</h2>

    
<table class="table">
  <thead>
    <tr>
        <th>#</th>
        <th>Data</th>
        <th>Time</th>
        <th>Status</th>
    </tr>
  </thead>
  <tbody>
</div>