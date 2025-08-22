<?php
require_once 'backend/auth.php';
require_once 'backend/match_algo.php';
ensure_logged_in();
$user = current_user();
$matches = find_matches_for_user($user['id']);

// fetch user's skills
$stmt = $pdo->prepare('SELECT * FROM skills_offered WHERE user_id = ?');
$stmt->execute([$user['id']]);
$offered = $stmt->fetchAll();
$stmt = $pdo->prepare('SELECT * FROM skills_wanted WHERE user_id = ?');
$stmt->execute([$user['id']]);
$wanted = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard - SkillSwap</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <h1 class="brand">SkillSwap</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main class="container dashboard">
    <h2>Hello, <?php echo htmlspecialchars($user['name']); ?></h2>

    <section class="panel">
      <div class="panel-left">
        <h3>Your Skills Offered</h3>
        <div class="skill-grid">
          <?php if(empty($offered)): ?>
            <p class="muted">You haven't added any offered skills yet.</p>
          <?php endif; ?>
          <?php foreach($offered as $s): ?>
            <div class="skill-card">
              <h4><?php echo htmlspecialchars($s['skill_name']); ?></h4>
              <p class="level"><?php echo htmlspecialchars($s['level']); ?></p>
              <p><?php echo htmlspecialchars(substr($s['description'],0,120)); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
        <a href="add_skill.php" class="btn-ghost">Add / Manage Skills</a>
      </div>

      <div class="panel-right">
        <h3>Matches For You</h3>
        <div id="matches">
          <?php if(empty($matches)): ?>
            <p class="muted">No matches found yet. Add more skills to improve matches.</p>
          <?php else: ?>
            <?php foreach($matches as $m): ?>
              <div class="match-row">
                <div>
                  <strong><?php echo htmlspecialchars($m['name']); ?></strong>
                  <div class="muted"><?php echo htmlspecialchars($m['location']); ?></div>
                </div>
                <div class="match-skills">
                  <?php echo htmlspecialchars($m['offered_skill']); ?> → you
                </div>
                <a href="chat.php?with=<?php echo $m['other_id']; ?>" class="btn-small">Chat</a>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

<script src="assets/js/script.js"></script>
</body>
</html>
