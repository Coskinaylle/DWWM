<?php
session_start();

if (!isset($_SESSION['user']['user_id'])) {
    header("Location: SW_Login.php?error=unauthorized");
    exit;
}

$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang=fr-en>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/Universes/SW/CSS/SWstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <script defer src="/Common/JS/script.js"></script>
    <title>BASE DE DONNEES GALACTIQUE</title>
</head>

<body>
    <main style="text-align: center; margin: 2rem">
        <h1>Connection établie</h1>
        <br>
        <p>Bienvenue, utilisateur <?php echo htmlspecialchars($username); ?>.</p>
        <br>
        <p>Veuillez patienter <span id="Timer"></span> secondes galactiques standard. </p>

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
                    window.location.href = "SW_Main.html";
                }
            }, 1000);
        </script>
    </main>

</body>
