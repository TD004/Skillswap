<?php
// Edit credentials to match your local MySQL
$db_host = 'localhost';
$db_name = 'skillswap';
$db_user = 'root';
$db_pass = ''; // set your password if any

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die('DB Connection failed: ' . $e->getMessage());
}
