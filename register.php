<?php
require_once 'backend/auth.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6) {
        if (register_user($name, $email, $password)) {
            header('Location: login.php'); exit;
        } else {
            $error = 'Registration failed — email might be taken.';
        }
    } else {
        $error = 'Please provide a valid email and password (min 6 chars).';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register - SkillSwap</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
  <div class="auth-box">
    <h2>Create an account</h2>
    <?php if(!empty($error)) echo "<p class='error'>".htmlspecialchars($error)."</p>"; ?>
    <form method="post">
      <input name="name" placeholder="Your name" required>
      <input name="email" placeholder="Email" type="email" required>
      <input name="password" placeholder="Password" type="password" required>
      <button class="btn-primary" type="submit">Register</button>
    </form>
    <p class="muted">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
