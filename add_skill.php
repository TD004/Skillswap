<?php
require_once 'backend/auth.php';
ensure_logged_in();
$user = current_user();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type']; // 'offer' or 'want'
    $skill = trim($_POST['skill']);
    $level = $_POST['level'];
    $desc = $_POST['desc'] ?? '';
    if ($type === 'offer') {
        $stmt = $pdo->prepare('INSERT INTO skills_offered (user_id, skill_name, level, description) VALUES (?, ?, ?, ?)');
        $stmt->execute([$user['id'], $skill, $level, $desc]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO skills_wanted (user_id, skill_name, level) VALUES (?, ?, ?)');
        $stmt->execute([$user['id'], $skill, $level]);
    }
    header('Location: dashboard.php'); exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Skill - SkillSwap</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
  <div class="auth-box">
    <h2>Add a Skill</h2>
    <form method="post">
      <label>Type</label>
      <select name="type">
        <option value="offer">I can teach (Offer)</option>
        <option value="want">I want to learn (Want)</option>
      </select>
      <input name="skill" placeholder="Skill name (e.g., Guitar)" required>
      <select name="level">
        <option>Beginner</option>
        <option>Intermediate</option>
        <option>Advanced</option>
      </select>
      <textarea name="desc" placeholder="Short description (only for offers)"></textarea>
      <button class="btn-primary" type="submit">Save Skill</button>
    </form>
    <p class="muted"><a href="dashboard.php">Back to dashboard</a></p>
  </div>
</body>
</html>
