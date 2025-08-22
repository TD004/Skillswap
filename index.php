<?php
require_once 'backend/auth.php';
$user = current_user();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>SkillSwap</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <h1 class="brand">SkillSwap</h1>
      <nav>
        <?php if($user): ?>
          <a href="dashboard.php">Dashboard</a>
          <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="login.php">Login</a>
          <a href="register.php" class="btn-primary">Get Started</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="hero">
    <div class="container hero-grid">
      <div class="hero-text">
        <h2>Learn & Teach — No Money. Just Swap Skills.</h2>
        <p>Find people nearby or online to exchange skills with. Teach what you know and learn what you want.</p>
        <div class="cta-row">
          <a href="register.php" class="btn-cta">Join SkillSwap</a>
          <a href="#features" class="link">How it works</a>
        </div>
      </div>
      <div class="hero-card">
        <div class="glass">
          <h3>Top swaps today</h3>
          <ul id="top-swaps">
            <li>Guitar ↔ French</li>
            <li>Web Dev ↔ Resume Review</li>
            <li>Yoga ↔ Nutrition</li>
          </ul>
        </div>
      </div>
    </div>
  </main>

  <section id="features" class="features container">
    <h3>How it works</h3>
    <div class="cards">
      <div class="card">
        <h4>Create a profile</h4>
        <p>Describe the skills you can teach and what you'd like to learn.</p>
      </div>
      <div class="card">
        <h4>Find matches</h4>
        <p>Our matching engine finds complementary partners for a swap.</p>
      </div>
      <div class="card">
        <h4>Swap & Review</h4>
        <p>Arrange sessions and leave ratings to help the community grow.</p>
      </div>
    </div>
  </section>

  <footer class="site-footer">
    <div class="container">© SkillSwap — Built with ❤️</div>
  </footer>

<script src="assets/js/script.js"></script>
</body>
</html>
