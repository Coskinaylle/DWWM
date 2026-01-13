<?php
session_start();
require_once '../config.php';
require_once '../includes/CSRF.php';


// Requete POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = ($_POST['password'] ?? '');

        // CSRF
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            echo json_encode(['error' => 'CSRF Token invalide']);
            exit;
        }

    // Requête user + univers
    $stmt = $pdo->prepare("
    SELECT
     users.id,
     users.username,
     users.password,
     users.universe_id,
     users.role,
     universe.name AS universe_name
     FROM users
    JOIN universe ON users.universe_id = universe.id
    WHERE users.username = ?"
);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verif credentials
    if (!$user || !password_verify($password, $user['password'])) {
        $referrer = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: {$referrer}?error=badcredentials");
        exit;
    }


    session_regenerate_id(true);
    $_SESSION['user'] = [
    'user_id' => $user['id'],
    'username' => $user['username'],
    'universe_id' => $user['universe_id'],
    'role' => $user['role']
    ];

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));


    $univers = $user['universe_name'];
    // Docker
    header("Location: /Universes/$univers/{$univers}_protected.php");
    // Hebergeur
    // header("Location: htdocs/HTML/$univers/{$univers}_protected.php")
    
    exit;


} else {
    http_response_code(405);
    echo 'Méthode non autorisée';
}
?>