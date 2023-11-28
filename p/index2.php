<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $users = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Game store </title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Game store </h1>
    
    <?php if (isset($users)): ?>
        
        <p>Hello <?= htmlspecialchars($users["name"]) ?></p>

        <p> Your Response Has Been Recorded . We Will Answer Your query with in 24 Hours  on your mail  <?= htmlspecialchars($users["email"]) ?> <br>
      <br>

        <p><a href="logout.php">GO BacK </a></p>
        
    <?php else: ?>
        
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        
    <?php endif; ?>
    
</body>
</html>
    
    
    
    
    
    
    
    
    
    
    