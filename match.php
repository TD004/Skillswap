<?php
require_once 'backend/auth.php';
require_once 'backend/match_algo.php';
ensure_logged_in();
$user = current_user();
$matches = find_matches_for_user($user['id']);
header('Content-Type: application/json');
echo json_encode($matches);
