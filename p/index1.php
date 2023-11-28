<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style1.css">
  <title>Game Store</title>
</head>
<body>
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
  
  <header>
    <nav>
      <ul class="nav-list">
        <li><a href="#">Home</a></li>
        <li><a href="#">Store</a></li>
        <li><a href="#">Sell</a></li>
      </ul>
    </nav>
    <h1>Game Store</h1>
    <div class="search-bar">
      <input type="text" id="search-input" placeholder="Search...">
      <button id="search-button">Search</button>
    </div>
  </header>
  
  <main>
    <section class="game-list">
      <div class="game">
        <img src="images/hulk.png" alt="Game 1">
        <h2>Game 1</h2>
        <p>Description of Game 1.</p>
        <button class="buy-button">Buy Now</button>
      </div>
      <div class="game">
        <img src="images/hulk.jpg" alt="Game 1">
        <h2>Game 1</h2>
        <p>Description of Game 1.</p>
        <button class="buy-button">Buy Now</button>
      </div>
      <div class="game">
        <img src="images/hulk.png" alt="Game 1">
        <h2>Game 1</h2>
        <p>Description of Game 1.</p>
        <button class="buy-button">Buy Now</button>
      </div>
      <!-- Repeat similar blocks for other games -->
    </section>
    
    <section class="upload-game">
      <h2>Upload a Game</h2>
      <form id="game-upload-form">
        <label for="game-title">Game Title</label>
        <input type="text" id="game-title" name="game-title" required>
        
        <label for="game-description">Game Description</label>
        <textarea id="game-description" name="game-description" rows="4" required></textarea>
        
        <label for="game-image">Game Image</label>
        <input type="file" id="game-image" name="game-image" accept="image/*" required>
        
        <button type="submit">Upload Game</button>
      </form>
    </section>
      
    <section class="contact-us">
      <h2>Contact Us</h2>
      <div class="contact-form">
      <form > 
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>
    
        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>
    
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea>
    
        <a href="index2.php" class="button-link">submit </a>
  
    </form>
    
      </div>
    </section>
  </main>
  
  <?php if (isset($users)): ?>
    <p>Hello <?= htmlspecialchars($users["name"]) ?></p>
    <p><a href="logout.php">Log out</a></p>
  <?php else: ?>
    <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
  <?php endif; ?>
  
  <footer>
    <p>&copy; 2023 Game Store</p>
  </footer>
  
  <script src="Javascript.js"></script>
</body>
</html>
