<?php
require_once "../../config.php";
require_once '../../includes/CSRF.php';

$error = $_GET["error"] ?? null;
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" lang="fr">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Universes/FO/CSS/FOstyle.css" />
    <script defer src="/Common/JS/script.js"></script>
  <title>VAULT-TEC BIOMETRIC SECURITY</title>
</head>

<body>
  <header>
    <h1>SCANNING BIOMETRIC DATA</h1>
<br>
    <!-- Progress bar -->
    <div id="progress-container">
      <div id="progress-bar"></div>
    </div>


  </header>
  <main>
    <form id="login" action="../../api/Process_login.php" method="POST">
      <?php echo csrf_input(); ?>
      <div style="margin: 1rem;">
      <label for="username"> Utilisateur: </label>
      <input type="text" id="username" name="username" required>
      </div>
      <div>
      <label for="password"> Password: </label>
      <input type="password" id="password" name="password" required>
      </div>
      <button id="valid" type="submit">VALIDATION</button>
    </form>
    <br>

        <!-- PHP -->
        <?php if ($error === 'missing'): ?>
          <p> Veuillez remplir tous les champs.</p>

        <?php elseif ($error === 'badcredentials'): ?>
          <p> Données biométriques incorrectes. </p>

        <?php elseif ($error === 'unauthorized'): ?>
          <p> Utilisateur non enregistré.</p>

        <?php endif; ?>
        <!-- FIN PHP -->
  </main>
</body>
<script>
  function progress(totalTime = 10) {
    const progressbar = document.getElementById("progress-bar");
    const form = document.getElementById("login");
    if (!progressbar) return;

    let timeLeft = totalTime;

    const interval = 100;
    const steps = totalTime * 1000 / interval;
    let currentstep = 0;

    const countdown = setInterval(() => {
      currentstep++;

      // Temps restant
      timeLeft = Math.ceil(totalTime - (currentstep * interval / 1000));

      // progress bar update
      let progresspercent = (currentstep / steps * 100);
      progressbar.style.width = progresspercent + "%";

      if (currentstep >= steps) {
        clearInterval(countdown);
        form.style.visibility = "visible"
      }
    }, interval); // setInterval end !! Ne pas oublier l'interval
  }

  document.addEventListener("DOMContentLoaded", () => {
    progress();
  });
</script>

</html>