<?php
require_once 'backend/auth.php';
ensure_logged_in();
$user = current_user();
$other_id = isset($_GET['with']) ? intval($_GET['with']) : 0;

// find or create a match record (simplified)
$stmt = $pdo->prepare('SELECT id FROM matches WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?) LIMIT 1');
$stmt->execute([$user['id'],$other_id,$other_id,$user['id']]);
$match = $stmt->fetch();
if (!$match) {
    $ins = $pdo->prepare('INSERT INTO matches (user1_id,user2_id,status) VALUES (?,?,?)');
    $ins->execute([$user['id'],$other_id, 'pending']);
    $match_id = $pdo->lastInsertId();
} else {
    $match_id = $match['id'];
}

// handle new message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $msg = trim($_POST['message']);
    $st = $pdo->prepare('INSERT INTO messages (match_id,sender_id,message) VALUES (?,?,?)');
    $st->execute([$match_id, $user['id'], $msg]);
    header('Location: chat.php?with=' . $other_id); exit;
}

// fetch messages
$ms = $pdo->prepare('SELECT m.*, u.name FROM messages m JOIN users u ON u.id = m.sender_id WHERE m.match_id = ? ORDER BY m.created_at ASC');
$ms->execute([$match_id]);
$messages = $ms->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Chat - SkillSwap</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="chat-shell">
    <a href="dashboard.php" class="btn-ghost">← Back</a>
    <div class="chat-box">
      <?php foreach($messages as $m): ?>
        <div class="msg <?php echo ($m['sender_id']==$user['id'])? 'out' : 'in'; ?>">
          <div class="meta"><?php echo htmlspecialchars($m['name']); ?> • <span class="muted"><?php echo $m['created_at']; ?></span></div>
          <div class="text"><?php echo nl2br(htmlspecialchars($m['message'])); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
    <form method="post" class="chat-form">
      <textarea name="message" placeholder="Type a message" required></textarea>
      <button class="btn-primary" type="submit">Send</button>
    </form>
  </div>
</body>
</html>
