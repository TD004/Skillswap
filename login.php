<?php
require_once 'backend/auth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (login_user($email, $password)) {
        header('Location: dashboard.php'); exit;
    } else {
        $error = 'Login failed — check credentials.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - SkillSwap</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
  <div class="auth-box">
    <h2>Welcome back</h2>
    <?php if(!empty($error)) echo "<p class='error'>".htmlspecialchars($error)."</p>"; ?>
    <form method="post">
      <input name="email" placeholder="Email" type="email" required>
      <input name="password" placeholder="Password" type="password" required>
      <button class="btn-primary" type="submit">Login</button>
    </form>
    <p class="muted">New to SkillSwap? <a href="register.php">Create an account</a></p>
  </div>
</body>
</html>
