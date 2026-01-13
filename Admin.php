<?php
require_once '../config.php';
require_once '../includes/CSRF.php';
require_once '../includes/auth.php';

if (!isset($_SESSION['user']['user_id'])) {
    http_response_code(401);
    echo 'Utilisateur non connecté';
    exit;
}

if ($_SESSION['user']['role'] !== 1) {
    http_response_code(403);
    echo "Accès non autorisé";
    exit;
};

?>

<!DOCTYPE html>
<html lang=fr>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
    <link href="/Common/CSS/bootstrap.min.css" rel="stylesheet">
    <script src="/Common/JS/bootstrap.bundle.min.js"></script>
    <script src="/Common/JS/script.js"></script>
    <link href="/Common/CSS/style.css" rel="stylesheet">
</head>

<body>
    <header class="bg-light py-4 mb-4 shadow-sm">
        <div class="container">
        <h1>Dashboard Admin de <?php echo htmlspecialchars($_SESSION['user']['username']); ?></h1>
        <!-- Badge admin --><img src="">
        </div>
    </header>

    <main>
    <section>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Pseudo</th>
      <th scope="col">Email</th>
      <th scope="col">Rôle</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody id="users">
  </tbody>
</table>
    <div id="alert"></div>
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