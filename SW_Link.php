<?php
require __DIR__ . '/../../config.php';
require "../../includes/csrf.php";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" lang="fr" />
  <meta name="csrf_token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="/Universes/SW/CSS/SWstyle.css" />
  <script defer src="/Common/JS/script.js"></script>
  <script>
    const userId = <?= $_SESSION['user']['user_id'] ?>;
    const username = "<?= htmlspecialchars($_SESSION['user']['username']) ?>";
  </script>
  <title>Commlink</title>
</head>

<body>
  <header>
    <a href="/index.html"><img id="logo" src="/Universes/SW/img/Star_Wars_Logo.png" alt="" /></a>
    <h1 id="titre"></h1>

    <nav id="menuburger">
      <a href="/Universes/SW/SW_Main.html" class="menu-link" alt="">Accueil</a>
      <a href="/Universes/SW/SW_Data.html" class="menu-link">Data</a>
      <a href="/Universes/SW/SW_Link.php" class="menu-link selected">Commlink</a>
      <a href="/Universes/SW/SW_Timeline.html" class="menu-link">Timeline</a>
      <a href="/Universes/SW/SW_Groupe.html" class="menu-link">Groupe</a>
      <a href="/api/user.php" class="menu-link">Compte</a>
    </nav>
    <img src="/Universes/ME/icons/MEmenu-burger.svg" id="btnburger" alt="" />

  </header>

  <main class="comms">
    <article class="forum">
      <h1>Internal Communications </h1>
      <h3>From: friends</h3>
      <br />
      <div id="chatbox"></div>

      <form id="chatmsg">
        <textarea id="message" placeholder="Écrivez votre message..." rows="3"></textarea>
        <button type="submit">Envoyer</button>
      </form>
    </article>

    <article id="dateSelected"></article>

    <article id="voteResults"><h1>Résultats</h1></article>

    <article class="pollChoices">
      <h1>Disponibilités</h1>
      <p id="pollMonth"></p>
      <div id="dates"></div>
      <button type="submit" id="Votesubmit">Voter</button>
    </article>
    <img src="/Universes/SW/img/starwarseote.jpg" id="pic" alt="" />

    
      <!-- menu latéral -->
          <div id="game_menu">
      <button id="toggle_button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 32" width="64" height="32">
  <path d="M6 16 L20 4 L20 28 Z" stroke="#00bfff" stroke-width="3" fill="#00bfff"/>
  <rect x="20" y="10" width="40" height="12" fill="#00bfff"/>
  <line x1="28" y1="12" x2="48" y2="12" stroke="#ffffff" stroke-width="1"/>
  <line x1="28" y1="20" x2="48" y2="20" stroke="#ffffff" stroke-width="1"/>
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
  </main>



  <footer >  </footer>
</body>

</html>