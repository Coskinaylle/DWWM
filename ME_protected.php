<?php
session_start();

if (!isset($_SESSION["user"]["user_id"])) {
  header("Location: ME_Login.php?error=unauthorized");
  exit;
}

$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" lang="fr">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/Universes/ME/CSS/MEstyle.css" />
  <script defer src="/Common/JS/script.js"></script>
  <title>Connection sécurisée</title>
</head>

<body id="protected">

  <div id="spectre">
    <img src="/Universes/ME/img/SPECTRE.png" alt="">
  </div>
  <div class="login">
    <h1>SPECIAL TACTICS AND RECONNAISSANCE</h1>
    <br>
    <h2>Bienvenue <?php echo htmlspecialchars($username); ?>.</h2>
    <br>
    <p>Accès autorisé prioritaire à la base de données sécurisée du Conseil de la Citadelle.</p>

    <p>Temps restant: <span id="Timer"></span> secondes</p>
  </div>

  <script>
    // Redirection
    const timer = document.getElementById("Timer");
    let timeLeft = 5;
    timer.textContent = timeLeft;

    const countdown = setInterval(() => {
      timeLeft--;
      timer.textContent = timeLeft;

      if (timeLeft <= 0) {
        clearInterval(countdown);
        window.location.href = "ME_Main.html";
      }
    }, 1000);
  </script>
</body>

</html>