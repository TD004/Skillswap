<?php
require_once __DIR__ . '/db.php';

function find_matches_for_user($user_id) {
    global $pdo;
    $sql = "SELECT o.user_id AS other_id, o.skill_name AS offered_skill, w.skill_name AS wanted_skill, u.name, u.location, u.rating
            FROM skills_offered o
            JOIN skills_wanted w ON o.skill_name = w.skill_name
            JOIN users u ON u.id = o.user_id
            WHERE w.user_id = :uid AND o.user_id != :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['uid' => $user_id]);
    return $stmt->fetchAll();
}
