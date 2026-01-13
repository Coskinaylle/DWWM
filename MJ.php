<?php
require '../config.php';
require '../includes/CSRF.php';
require '../includes/auth.php';

if (!isset($_SESSION['user']['user_id'])) {
    http_response_code(401);
    echo 'Utilisateur non connecté';
    exit;
}

if ($_SESSION['user']['role'] !== 2) {
    http_response_code(403);
    echo "Accès non autorisé";
    exit;
};

$universe_id = $_SESSION['user']['universe_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare('
    SELECT n.notes, n.created_at, n.pseudo, n.universe_id
    FROM notes n
    WHERE n.universe_id = ?
    ORDER BY n.created_at DESC
    LIMIT 100
    ');
    $stmt->execute([$_SESSION['user']['universe_id']]);
    $notes_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
};

$journal = '';

if ($notes_list !== '') {
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
AND u.role != 2
');
$stmt->execute([$universe_id]);
$joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération PDF
$stmt = $pdo->prepare("
SELECT pdf.title, pdf.path, pdf.type
FROM PDF AS pdf
WHERE pdf.universe_id = ?
");
$stmt->execute([$universe_id]);
$pdfs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang=fr>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Maître de jeu</title>
    <link href="/Common/CSS/bootstrap.min.css" rel="stylesheet">
    <script src="/Common/JS/bootstrap.bundle.min.js"></script>
    <link href="/Common/CSS/style.css" rel="stylesheet">
</head>

<body>
    <header class="bg-light py-4 mb-4 shadow-sm">
        <div class="container">
        <h1>Dashboard MJ de <?php echo htmlspecialchars($_SESSION['user']['username']); ?></h1>
        <!-- Badge chef de groupe --><img src="">
        </div>
    </header>

    <main>
        <!-- Notes -->
        </section>
        <section class="container mb-5">
            <h3 class="mb-3">Historique des notes</h3>
            <?= $journal ?>
        </section>
        <!-- Groupe -->
        <section class="container mb-5">
            <div class="card p-3 shadow-sm">
                <h1>Group name</h1>
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