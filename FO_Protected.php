<?php
session_start();

if (!isset($_SESSION['user']["user_id"])) {
    header("Location: FO_Login.php?error=unauthorized");
    exit;
}

$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="/Universes/FO/CSS/FOstyle.css" />
    <script defer src="/Common/JS/script.js"></script>
    <title>VALIDATION DONNEES</title>
</head>

<body>
    <main>
        <h1>CONFIRMATION DONNEES BIOMETRIQUES</h1>
        <h2>Bonjour, <?php echo htmlspecialchars($username) ?>.</h2>
        <p>Bienvenue sur l'interface de votre PipBoy 2000</p>
        <p>Veuillez patienter pendant le chargement du PipBoy OS</p>
<br>
        <!-- Progress bar -->
        <div id="progress-container" style="width: 100%; background-color: #ccc; height: 20px; border-radius: 10px;">
            <div id="progress-bar" style="width: 100%; height: 100%; background-color: #4caf50; border-radius: 10px;"></div>
        </div>

    </main>
</body>

<script>
    function redirectWithProgress(targetURL = "FO_Main.html", totalTime = 5) {
        const progressBar = document.getElementById("progress-bar");
        if (!progressBar) return;

        let timeLeft = totalTime;

        const interval = 100; // 100ms
        const steps = totalTime * 1000 / interval;
        let currentStep = 0;

        const countdown = setInterval(() => {
            currentStep++;

            // Compteur update
            timeLeft = Math.ceil(totalTime - (currentStep * interval / 1000));

            // Progress update
            let progressPercent = (currentStep / steps * 100);
            progressBar.style.width = progressPercent + "%";

            if (currentStep >= steps) {
                clearInterval(countdown);
                window.location.href = targetURL;
            }
        }, interval);
    }

    document.addEventListener("DOMContentLoaded", () => {
        redirectWithProgress("FO_Main.html");
    });
</script>

</html>