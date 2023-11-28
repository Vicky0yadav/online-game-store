<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM users
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $users = $result->fetch_assoc();
    
    if ($users) {
        
        if (password_verify($_POST["password"], $users["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $users["id"];
            
            header("Location: index1.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Game Store Login</title>
   
    
</head>
<body>

    
    <div class="video-container">
        <video autoplay muted loop id="background-video">
            <source src="video/call.mp4">  
        </video>
      
        <div class="content">
            <div class="container">
                <div class="login-box">
                    <h1>Welcome to Game Store</h1>
                    <form id="loginForm" action="login.php" method="POST">
                        <div class="form-group">
                            <input type="text" id="loginEmail" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" id="loginPassword" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit">Login</button>
                        <?php if ($is_invalid): ?>
                            <p style="color: red;">Invalid login</p>
                        <?php endif; ?>
                        <p>Don't have an account? <a href="signup.html">Sign Up</a></p>
                    </form>
                </div>
            </div>
            
        <div>  <audio   autoplay controls loop >
  <source src="audio/call.mp3" type="audio/mp3">
</audio></div>


        </div>

   
</body>

</html>
