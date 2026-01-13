<?php
require_once '../config.php';
require_once '../includes/CSRF.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "GET") {

$stmt = $pdo -> prepare("
SELECT users.id, users.username, users.email, users.role, roles.role AS role_name
FROM users
JOIN roles ON users.role = roles.id");
$stmt -> execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
$data = json_decode(file_get_contents('php://input'), true);

$action = $data['action'];
$user_id = $data['user_id'];

if (!isset($action) || !isset($user_id)) {
http_response_code(400);
echo json_encode(['error'=>'Erreur JSON']);
exit;}

switch($action) {
    case 'delete_user':
        
        if ($_SESSION['user']['user_id'] === $user_id) {
            http_response_code(406);
            echo json_encode(["error" => "Suppression impossible"]);
            exit;
        }

        $stmt = $pdo -> prepare('DELETE FROM users WHERE id = ?');
        $stmt -> execute([$user_id]);
        echo json_encode(["success" => true, "message" => "Utilisateur supprimé"]);

        break;

    case 'reset_password':

        $defaultpassword = "123456";
        $hashedpassword = password_hash($defaultpassword, PASSWORD_ARGON2ID);

        $stmt = $pdo -> prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt -> execute([$hashedpassword, $user_id]);
        echo json_encode(["success" => true, "message" => "Password remis à zéro"]);
        break;

    default:
    http_response_code(400);
    echo json_encode(['error'=>'Action invalide']);
    exit;
}
} // fin POST
?>