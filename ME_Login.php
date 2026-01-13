<?php
require '../../config.php';
require '../../includes/CSRF.php';

$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" lang="fr">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/Universes/ME/CSS/MEstyle.css" />
    <script defer src="/Common/JS/script.js"></script>
  <title>CITADEL MILITARY PERSONEL DATABASE</title>
</head>

<body>
  <header>
    <a href="/index.html"><img id="main" src="/Universes/ME/img/MELogo.png" alt=""></a>
    <img src="/Universes/ME/icons/MEmenu-burger.svg" id="btnburger" alt="">
  </header>

  
  <main>
    <h1>/ CITADEL MILITARY PERSONEL DATABASE / <br> / ESTABLISHING SECURE CONNECTION /</h1>

    <form action="/api/Process_login.php" method="POST">
      <?php echo csrf_input() ?>
      <label for="username"> Utilisateur : </label>
      <input type="text" id="username" name="username" required>
      <label for="password"> Password : </label>
      <input type="password" name="password" required>
      <button type="submit">CONNECTION</button>
    </form>


    <!-- PHP -->
    <?php if ($error === 'missing'): ?>
      <p> Veuillez remplir tous les champs.</p>

    <?php elseif ($error === 'badcredentials'): ?>
      <p> Identifiants incorrects. </p>

    <?php elseif ($error === 'unauthorized'): ?>
      <p> Utilisateur non autorisé.</p>

    <?php endif; ?>
    <!-- FIN PHP -->

    <img id="CSEC" src="/Universes/ME/img/C-SEC_logo.webp" alt="">

  </main>

  <footer class="footer">
    COPYRIGHT Renaud Lottiaux<br>
    COPYRIGHT Bioware <br>
  </footer>

</body>

</html>