<?php
session_start();
require_once 'config.php';

// Generate a session ID if not exists
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = session_id();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $session_id = $_SESSION['user_id'];

    $sql = "INSERT INTO submissions (name, email, message, session_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$name, $email, $message, $session_id]);
        $success_message = "Message sent successfully!";
    } catch(PDOException $e) {
        $error_message = "Error sending message: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minecraft Adventures</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <script src="script.js" defer></script>
</head>
<body>
  <!-- Header with Logo and Navbar -->
  <header>
    <div class="header-content">
      <a href="index.php"><img src="assets/logo.svg" alt="Minecraft Logo" class="logo"></a>
      <!-- Hamburger Menu Icon -->
      <button class="hamburger" aria-label="Toggle navigation">
        <span class="hamburger-icon"></span>
      </button>
      <!-- Navbar Links -->
      <nav class="navbar">
        <ul>
          <li><a href="#about">About</a></li>
          <li><a href="#games">Games</a></li>
          <li><a href="#trailers">Trailers</a></li>
          <li><a href="#contact">Contact Us</a></li>
          <li><a href="view_submissions.php">View Messages</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to Minecraft Adventures!</h1>
      <p>Explore, build, and survive in the blocky world of Minecraft.</p>
      <a href="#about" class="btn">Learn More</a>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="section">
    <h2>About Minecraft</h2>
    <p>Minecraft is a sandbox game where you can build, explore, and survive in a blocky, pixelated world. Create your own adventures, fight mobs, and craft amazing structures!</p>
    <img src="assets/about.png" alt="Minecraft World" class="about-image">
  </section>

  <!-- Games Section -->
  <section id="games" class="section">
    <h2>Games</h2>
    <div class="games-grid">
      <div class="game-card">
        <a href="https://www.minecraft.net/en-us/about-minecraft"><img src="assets/Minecraft.jpg" alt="Minecraft Ed"></a>
        <h3>Minecraft Education</h3>
        <p>Explore custom maps and complete challenges created by the community.</p>
      </div>
      <div class="game-card">
        <a href="https://www.minecraft.net/en-us/about-dungeons"><img src="assets/dungeons.webp" alt="Minecraft Dungeons"></a>
        <h3>Minecraft Dungeons</h3>
        <p>Gather resources, craft tools, and survive against mobs in this challenging mode.</p>
      </div>
      <div class="game-card">
        <a href="https://www.minecraft.net/en-us/about-legends"><img src="assets/legends.webp" alt="Minecraft Legends"></a>
        <h3>Minecraft Legends</h3>
        <p>Unleash your creativity with unlimited resources and the ability to fly.</p>
      </div>
      <div class="game-card">
        <a href="https://education.minecraft.net/en-us"><img src="assets/education.png" alt="Minecraft Ed"></a>
        <h3>Minecraft Education</h3>
        <p>Explore custom maps and complete challenges created by the community.</p>
      </div>
    </div>
  </section>
 
  <!-- Trailers Section -->
  <section id="trailers" class="section">
    <h2>Trailers</h2>
    <div class="trailers-grid">
      <iframe src="https://www.youtube.com/embed/0Cbw1b2mkGk?si=hcB-pWno8coFgubz" title="Minecraft Trailer 1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/CoZ2V7XsSYk?si=9ZhOKS1HPMUiSDmA" title="Minecraft Trailer 2" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/VXC9NPueCd4?si=xpMKahVyOnv1sbJN" title="Minecraft Trailer 3" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/309qoKYlgTI?si=U1C2IH1ESey8MRXI" title="Minecraft Trailer 3" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/Rla3FUlxJdE?si=Nxmrt_hQm9pmgZ3s" title="Minecraft Trailer 3" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe src="https://www.youtube.com/embed/XwQsEvYOLzM?si=QxYGN4y2n-wgS7n8" title="Minecraft Trailer 3" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="section">
    <h2>Contact Us</h2>
    <?php if (isset($success_message)): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" placeholder="Steve" required>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="steve@minecraft.com" required>
      
      <label for="message">Message:</label>
      <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>
      
      <button type="submit" class="btn">Send</button>
    </form>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2004 Minecraft Adventures. All rights reserved.</p>
  </footer>
</body>
</html> 