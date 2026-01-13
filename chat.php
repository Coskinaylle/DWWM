<?php
    session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/CSRF.php';


    header('Content-Type: application/json; charset=utf-8');

    // Vérif connection
    if (!isset($_SESSION['user']['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Utilisateur non connecté']);
        exit;
    }

    // Envoi
    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset ($_POST['message'])) {

        // CSRF
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            echo json_encode(['error' => 'CSRF Token invalide']);
            exit;
        }

        $message = trim($_POST['message']);
        if ($message !== '') {
            $stmt = $pdo->prepare('INSERT INTO messages (user_id, message, universe_id) VALUES (?, ?, ?)');
            $stmt->execute([$_SESSION['user']['user_id'], ($message), $_SESSION['user']['universe_id']]);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Message vide']);
        } 
        exit;
    }

    // Récup
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset ($_GET['action']) && ($_GET['action'] === 'fetch')) {
        $stmt = $pdo->prepare('
        SELECT m.message, m.created_at, u.pseudo
        FROM messages m
        JOIN users u ON m.user_id = u.id
        WHERE m.universe_id = ?
        ORDER BY m.created_at DESC
        LIMIT 20
        ');
        $stmt -> execute([$_SESSION['user']['universe_id']]);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($messages as &$msg) {
            unset($msg['created_at']);
        }
        unset($msg);

        echo json_encode([
        'universe_id' => $_SESSION['user']['universe_id'],
        'messages' => array_reverse($messages)
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    //Erreurs
    http_response_code(400);
    echo json_encode(['error' => 'Action non valide']);