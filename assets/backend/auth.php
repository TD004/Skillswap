<?php
session_start();
require_once __DIR__ . '/db.php';

function register_user($name, $email, $password) {
    global $pdo;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
    return $stmt->execute([$name, $email, $hash]);
}

function login_user($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        // set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        return true;
    }
    return false;
}

function current_user() {
    global $pdo;
    if (!isset($_SESSION['user_id'])) return null;
    $stmt = $pdo->prepare('SELECT id,name,email,location,bio,rating FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function ensure_logged_in() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
