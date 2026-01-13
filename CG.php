<?php
require '../config.php';
require '../includes/CSRF.php';
require '../includes/auth.php';

$success = '';

if (!isset($_SESSION['user']['user_id'])) {
    http_response_code(401);
    echo 'Utilisateur non connecté';
    exit;
}

if ($_SESSION['user']['role'] !== 3) {
    http_response_code(403);
    echo "Accès non autorisé";
    exit;
};

$pseudo = $_SESSION['user']['pseudo'];
$user_id = $_SESSION['user']['user_id'];
$universe_id = $_SESSION['user']['universe_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        echo 'CSRF invalide';
        exit;
    };

    if (isset($_POST['notes'])) {
        $notes = trim($_POST['notes']);

        if ($notes !== '') {
            $stmt = $pdo->prepare('INSERT INTO notes (user_id, pseudo, notes, universe_id) VALUES (?, ?, ?, ?)');
            $stmt->execute([$user_id, $pseudo, $notes, $universe_id]);
            $success = '<div class="alert alert-success">Écriture réussie</div>';
        } else {
            $success = '<div class="alert alert-danger">Écriture impossible</div>';
            exit;
        }
    }
}

$notes_list = [];

    $stmt = $pdo->prepare('
    SELECT n.notes, n.created_at, n.pseudo, n.universe_id
    FROM notes n
    WHERE n.universe_id = ?
    ORDER BY n.created_at DESC
    LIMIT 100
    ');
    $stmt->execute([$_SESSION['user']['universe_id']]);
    $notes_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
;

$journal = '';

if ($notes_list !== []) {
    foreach ($notes_list as $note) {
        $pseudo_note = htmlspecialchars($note['pseudo']);
        $date_note = date('d/m/Y H:i', strtotime($note['created_at']));
        $texte_note = nl2br(htmlspecialchars($note['notes']));
        $journal .= '<div class="card mb-2 p-2 shadow-sm border-start border-4 border-primary bg-white">';
        $journal .= "<strong>$pseudo_note</strong> <em>($date_note)</em>";
        $journal .= "<p>$texte_note</p>";
        $journal .= '</div>';
    }
}

// Récupération groupe
$stmt = $pdo->prepare('
SELECT username
FROM users AS u
WHERE universe_id = ?
AND u.role != 3
');
$stmt->execute([$universe_id]);
$joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération PDF
$stmt = $pdo->prepare("
SELECT pdf.title, pdf.path, pdf.type, u.id as user_id, u.role
FROM PDF AS pdf
JOIN users AS u ON pdf.user_id = u.id
WHERE pdf.universe_id = ?
  AND u.role = 4");
$stmt->execute([$universe_id]);
$pdfs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang=fr>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Chef de groupe</title>
    <link href="/Common/CSS/bootstrap.min.css" rel="stylesheet">
    <script src="/Common/JS/bootstrap.bundle.min.js"></script>
    <link href="/Common/CSS/style.css" rel="stylesheet">
</head>

<body>
    <header class="bg-light py-4 mb-4 shadow-sm">
        <div class="container">
        <h1>Dashboard chef de groupe de <?php echo htmlspecialchars($_SESSION['user']['username']); ?></h1>
        <!-- Badge chef de groupe --><img src="">
        </div>
    </header>

    <main>
        <!-- Notes -->
        <section class="container mb-5">
            <form class="card p-3 shadow-sm" action="" method="POST">
                <?php echo csrf_input() ?>
                <label for="groupNotes"> Journal du groupe :</label>
                <textarea class="form-control mb-3" name="notes" id="groupNotes" rows="5"></textarea>
                <button class="btn btn-success" type="submit" name="Notes_update">Enregistrer</button>
            </form>
                <?= $success ?>

        </section>
        <section class="container mb-5">
            <h3 class="mb-3">Historique des notes</h3>
            <?= $journal ?>
        </section>
        <!-- Groupe -->
        <section class="container mb-5">
            <div class="card p-3 shadow-sm">
                <h1>Group name</h1>
                <ul class="list-group">
    <?php foreach ($joueurs as $joueur): ?>
        <li class="list-group-item"><?= htmlspecialchars($joueur['username']) ?></li>
    <?php endforeach ?>
            </ul>
                <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#persosCollapse">
                    Voir personnages (online)
                </button>
                <div class="collapse" id="persosCollapse">
                    <div class="card card-body mt-2">
                        Pas encore de personnages
                    </div>
                </div>
            </div>

            <section class="text-center mb-5">
                <div class="mb-3">
                    <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#pdfsCollapse">
                        Voir personnages (PDF)
                    </button>
                    <div class="collapse" id="pdfsCollapse">
                        <div class="card card-body mt-2">
                            <?php foreach ($pdfs as $pdf) {
                                echo "<a href='{$pdf['path']}'>{$pdf['title']}</a><br>";
                            } ?>
                        </div>
                    </div>
                </div>


            </section>

    </main>

    <footer class="bg-white py-3 text-center shadow-sm mt-5 small text-muted">
        &copy; 2025 Moi
        <div class="text-end mt-2">
            <button type="button" class="btn btn-secondary" onclick="history.back();">
                ← Retour
            </button>
        </div>
    </footer>
</body>

</html>