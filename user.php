<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../config.php';
require '../includes/CSRF.php';
require '../includes/auth.php';

// Récupération profil
$stmt = $pdo->prepare("SELECT username, pseudo, email, avatar, universe_id, role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user']['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['user'] = array_merge($_SESSION['user'], [
    'username' => $user['username'],
    'pseudo' => $user['pseudo'],
    'email' => $user['email'],
    'universe_id' => $user['universe_id'],
    'avatar' => $user['avatar'] ?? '/Common/img/Un soldat science fiction.jpg',
    'role' => $user['role']
]);

$user_id = $_SESSION['user']['user_id'];

// Récupération PDF
$stmt = $pdo->prepare("SELECT title, path, type FROM PDF WHERE user_id = ?");
$stmt->execute([$user_id]);
$pdfs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update profile
$success = '';
$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        echo json_encode(['error' => 'CSRF Token invalide']);
        exit;
    }

    // Pseudo
    if (isset($_POST['pseudo_update'])) {
        $pseudo = trim($_POST["Pseudo"]);
        if ($pseudo !== '') {
            $stmt = $pdo->prepare("UPDATE users SET pseudo = ? WHERE id = ?");
            $stmt->execute([$pseudo, $_SESSION['user']['user_id']]);
            $_SESSION['user']['pseudo'] = $pseudo;
            $success = "Pseudo mis à jour !";
        }
    }

    // Email
    if (isset($_POST['email_update'])) {
        $email = trim($_POST["Email"]);
        if ($email !== '') {
            $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmt->execute([$email, $_SESSION['user']['user_id']]);
            $_SESSION['user']['email'] = $email;
            $success = "Email mis à jour !";
        }
    }

    // Password
    if (isset($_POST['password_update'])) {
        $password = trim($_POST['Password']);
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';


        if ($password === '') {
            $error = "Le mot de passe ne peut pas être vide";
        } elseif (!preg_match($pattern, $password)) {
            $error = "Le mot de passe doit contenir:\n- une minuscule\n- une majuscule\n- un chiffre\n- un caractère spécial\n- 8 caractères minimum";
        } else {
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([password_hash($password, PASSWORD_ARGON2ID), $_SESSION['user']['user_id']]);
            $success = "Mot de passe mis à jour";
        }
    }
}
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil</title>
    <link href="/Common/CSS/bootstrap.min.css" rel="stylesheet">
    <script src="/Common/JS/bootstrap.bundle.min.js"></script>
    <link href="/Common/CSS/style.css" rel="stylesheet">
</head>

<body class="bg-light">

    <header class="py-4 mb-4 bg-white shadow-sm">
        <h1 class="text-center mb-0">Profil de <?php echo htmlspecialchars($_SESSION['user']['username']); ?></h1>
    </header>

    <main class="container justify-content-between text-center spaces">
        <section class="mb-5">
            <div class="d-flex flex-column align-items-center justify-content-center mb-4">
                <!-- Avatar -->
                <img id="profileAvatar" src="<?php echo htmlspecialchars($_SESSION['user']['avatar']); ?>"
                    class="rounded-circle"
                    style="width:100px; height:100px; object-fit:cover;">

                <!-- Bouton pour changer -->
                <button type="button" class="btn btn-outline-primary mb-5" data-bs-toggle="modal" data-bs-target="#avatarModal">
                    Changer d’avatar
                </button>
            </div>

            <!-- Modale de changement -->
            <div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="avatarForm" enctype="multipart/form-data" method="POST" action="/api/avatar.php">
                            <?php echo csrf_input(); ?>
                            <div class="modal-body">
                                <input type="file" name="avatar" id="AvatarInput" accept="image/*" class="form-control mb-3">
                                <img id="avatarPreview" src="" alt="Prévisualisation" style="max-width: 100px; display: block; margin: auto;">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Mettre à jour</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="avatarChg" class="d-none"></div>

            <div class="mx-auto" style="max-width: 400px;">
                <h5 class="mb-3">Informations personnelles</h5>
                <form method="POST" class="text-start">
                    <?php echo csrf_input(); ?>

                    <div class="mb-3">
                        <label for="pseudo" class="form-label"><strong>Pseudonyme :</strong></label>
                        <input type="text" id="pseudo" name="Pseudo"
                            class="form-control"
                            value="<?php echo htmlspecialchars($_SESSION['user']['pseudo']); ?>">
                        <button type="submit" name="pseudo_update" class="btn btn-primary w-100 mt-2">Modifier Pseudo</button>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><strong>Email :</strong></label>
                        <input type="email" id="email" name="Email"
                            class="form-control"
                            value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>">
                        <button type="submit" name="email_update" class="btn btn-primary w-100 mt-2">Modifier Email</button>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label"><strong>Mot de passe :</strong></label>
                        <input type="password" id="password" name="Password" class="form-control">
                        <button type="submit" name="password_update" class="btn btn-primary w-100 mt-2">Enregistrer Mot de passe</button>
                    </div>
                </form>

                <?php if ($success): ?>
                    <div class="alert alert-success mt-3"><?php echo $success ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger mt-3"><?php echo nl2br(htmlspecialchars($error)) ?></div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Menus PDF et campagnes -->
        <section class="text-center mb-5">
            <div class="mb-3">
                <button class="btn btn-outline-secondary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#pdfsCollapse">
                    Voir personnages (PDF)
                </button>
                <div class="collapse" id="pdfsCollapse">
                    <div class="card card-body">
                        <?php foreach ($pdfs as $pdf) {
                            echo "<a href='{$pdf['path']}'>{$pdf['title']}</a><br>";
                        } ?>
                    </div>
                </div>
            </div>



            <div class="mb-3">
                <button class="btn btn-outline-secondary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#persosCollapse">
                    Voir personnages (online)
                </button>
                <div class="collapse" id="persosCollapse">
                    <div class="card card-body">
                        Pas encore de personnages
                    </div>
                </div>
            </div>


            <div class="mb-3">
                <button class="btn btn-outline-secondary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#campsCollapse">
                    Voir campagnes jouées
                </button>
                <div class="collapse" id="campsCollapse">
                    <div class="card card-body">
                        Pas encore de campagnes.
                    </div>
                </div>
            </div>
        </section>

        <?php if ($_SESSION['user']['role'] === 3): ?>
            <div class="mt-4 text-center">
                <a href="../dashboard/CG.php" class="btn btn-primary btn-lg">
                    Dashboard Chef de groupe
                </a>
                <p class="text-muted mt-2">Accès réservé aux chefs de groupe</p>
            </div>
        <?php endif; ?>

        <?php if ($_SESSION['user']['role'] === 2): ?>
            <div class="mt-4 text-center">
                <a href="../dashboard/MJ.php" class="btn btn-primary btn-lg">
                    Dashboard MJ
                </a>
                <p class="text-muted mt-2">Accès réservé aux MJs</p>
            </div>
        <?php endif; ?>

        <?php if ($_SESSION['user']['role'] === 1): ?>
            <div class="mt-4 text-center">
                <a href="../dashboard/Admin.php" class="btn btn-primary btn-lg">
                    Dashboard Admin
                </a>
                <p class="text-muted mt-2">Accès réservé aux Admins</p>
            </div>
        <?php endif; ?>

    </main>

    <footer class="bg-white py-3 text-center shadow-sm">
        &copy; 2025 Moi
        <div class="text-end mt-2">
            <button type="button" class="btn btn-secondary" onclick="history.back();">
                ← Retour
            </button>
        </div>
    </footer>

    <script>
        // Prévisualisation avatar avant upload
        document.getElementById('AvatarInput').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('avatarPreview').src = URL.createObjectURL(file);
            }
        });
    </script>

</body>

</html>