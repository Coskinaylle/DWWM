<?php
require "../../config.php";
require "../../includes/CSRF.php";

$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Universes/SW/CSS/SWstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <script defer src="/Common/JS/script.js"></script>
    <title>CONNECT TO: GALACTIC DATABASE</title>
</head>

<body>
    <h1 style="text-align: center;">
PRESENTEZ VOTRE PUCE D'ACCRÉDITATION OU ENTREZ VOS IDENTIFIANTS
    </h1>

    <main id="main">

<img id="Galactic" src="/Universes/SW/img/Galactic_Republic.svg" alt="">
        <form action="/api/Process_login.php" method="POST">
            <?php echo csrf_input() ?>
            <p class="login"><label for="username"> Utilisateur: </label>
            <input type="text" id="username" name="username" required>
            </p>
            <p class="login">
            <label for="password"> Password:  </label>
            <input type="password" id="password" name="password" required>
            </p>
            <p class="header">
            <button type="submit">CONNECTION</button>
            </p>
        </form>
</div>

        <!-- PHP -->
        <?php if ($error === "missing"): ?>
            <p>Veuillez remplir tous les champs</p>

        <?php elseif ($error === "badcredentials"): ?>
            <p>Identifiants incorrects</p>

        <?php elseif ($error === "unauthorized"): ?>
            <p>Accès non autorisé</p>

        <?php endif; ?>
        <!-- FIN PHP -->

    </main>

</body>

</html>