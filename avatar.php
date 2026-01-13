<?php
session_start();
require_once '../config.php';

header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

// Vérifier CSRF
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['error' => 'CSRF Token invalide']);
    exit;
}

// Vérifier le fichier
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Aucun fichier ou erreur lors de l’upload']);
    exit;
}

$file = $_FILES['avatar'];

// Vérifier le type mime
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array(mime_content_type($file['tmp_name']), $allowed_types)) {
    http_response_code(400);
    echo json_encode(['error' => 'Format d’image non autorisé']);
    exit;
}

// Vérifier la taille max (2 Mo)
if ($file['size'] > 2 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(['error' => 'Fichier trop volumineux (max 2 Mo)']);
    exit;
}

// Créer le dossier s’il n’existe pas
$upload_dir = __DIR__ . '/../Common/img/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Générer un nom unique
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'avatar_' . $_SESSION[['user']['user_id']] . '_' . time() . '.' . $ext;
$destination = $upload_dir . $filename;

// Déplacer le fichier
if (!move_uploaded_file($file['tmp_name'], $destination)) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l’enregistrement du fichier']);
    exit;
}

// Mettre à jour la base de données
$path_db = '/Common/img/' . $filename;
$stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
$stmt->execute([$path_db, $_SESSION['user']['user_id']]);

// Mettre à jour la session
$_SESSION['avatar'] = $path_db;

// Réponse JSON
echo json_encode([
    'success' => 'Avatar mis à jour',
    'path' => $path_db
]);