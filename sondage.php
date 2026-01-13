<?php
session_start();
require '../config.php';

header("Content-Type: application/json");

// Initialisation du vote
if (!isset($_SESSION['user']['voted'])) {
    $_SESSION['user']['voted'] = [];
}

// Universe ID
$universeId = $_SESSION['user']['universe_id'] ?? 0;

// POST → enregistrer le vote
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);
    $votes = $data['vote'] ?? [];

    foreach ($votes as $pollId) {
        if (!in_array($pollId, $_SESSION['user']['voted'])) {
            $stmt = $pdo->prepare("UPDATE poll_dates SET votes = votes + 1 WHERE id = :pollId");
            $stmt->bindValue(":pollId", $pollId, PDO::PARAM_INT);
            $stmt->execute();
            $_SESSION['user']['voted'][] = $pollId;
        }
    }
}

// GET ou POST → renvoyer les résultats
$stmt = $pdo->prepare("SELECT id, description, votes FROM poll_dates WHERE universe_id = :universeId");
$stmt->bindValue(":universeId", $universeId, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
exit;
