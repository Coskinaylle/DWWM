<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . "/../../includes/CSRF.php"
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" lang="fr" />
  <meta name="csrf_token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/Universes/FO/CSS/FOstyle.css" />
  <script defer src="/Common/JS/script.js"></script>
  <script>
    const userId = <?= $_SESSION['user']['user_id'] ?>;
    const username = "<?= htmlspecialchars($_SESSION['user']['username']) ?>";
  </script>
  <title>Agenda</title>
</head>

<body>
  <header>
    <a href="/index.html"><img id="main" src="/Universes/FO/img/FalloutLogo.png" alt="" /></a>
    <h1 id="titre"></h1>
    <img src="/Universes/FO/icons/FOmenu-burger.svg" id="btnburger" alt="" />

    <nav id="menuburger">
      <a href="/Universes/FO/FO_Main.html">Accueil</a>
      <a href="/Universes/FO/FO_Ressources.html">Ressources</a>
      <a href="/Universes/FO/FO_Résumé.html">Résumé</a>
      <a href="/Universes/FO/FO_Timeline.html">Timeline</a>
      <a href="/Universes/FO/FO_Calendrier.php" class="selected">Agenda</a>
      <a href="/api/user.php">Compte</a>
    </nav>
  </header>

  <main class="social">
    <section id="dateSelected"></section>
    <section id="voteResults"></section>
    <section class="pollChoices">
      <h2>Disponibilités</h2>
      <p id="pollMonth"></p>
      <div id="dates"></div>
      <button type="submit" id="Votesubmit">Voter</button>
    </section>

      <!-- Menu latéral -->
      <div id="game_menu">
      <button id="toggle_button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 32" width="64" height="32">
          <path class="pipboy" d="M20 4 L6 16 L20 28" />
          <path class="pipboy" d="M20 8 H58 V24 H20" />
        </svg>
      </button>
      <div id="menu">
        <p>Jet de dés</p>
        <button>D2</button>
        <button>D4</button>
        <button>D6</button>
        <button>D8</button>
        <button>D10</button>
        <button>D12</button>
        <button>D20</button>
        <button>D100</button>
        <p id="result"></p>
      </div>
    </div>

    <!-- Chat -->
    <article class="forum">
      <h2> Pipboy Integrated Instant Messaging System</h2>
      <h3>Vos amis vous écriront ici.</h3>
      <br />
      <div id="chatbox"></div>

      <form id="chatmsg">
        <textarea id="message" placeholder="Exprimez-vous"></textarea><br />
        <button type="submit">Envoyer</button>
      </form>
    </article>

    <img
      src="/Universes/FO/img/IlluCalendar.webp"
      alt=""
      style="max-width: 100%; justify-self: center" />
  </main>



  <footer class="footer">
    ROBCO INDUSTRIES UNIFIED OPERATING SYSTEM <br />
    COPYRIGHT 2075-2077 ROBCO-INDUSTRIES <br />
    -Display 1-
  </footer>
</body>

</html>