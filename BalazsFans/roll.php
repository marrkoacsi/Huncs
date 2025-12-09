<?php
require "config.php";
session_start();

if (!isset($_COOKIE['id'])) {
    header("Location: reglog.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kártya Pörgetés</title>
    <link rel="stylesheet" href="css/porgetes.css">
    <link rel="icon" href="img/fav.png" type="image/png">
</head>
<body>
    <nav class="navbar">
    <a href="index.php" class="navbar-brand">Balázs<span>Rúgások</span></a>
     <ul class="nav-links">
    <li><a href="index.php" class="nav-link">Főoldal</a></li>
    <li><a href="profil.php" class="nav-link active">Gyűjtemény</a></li>
     </ul>
    </nav>

    <audio id="crateSound" preload="auto">
        <source src="sounds/crate_open.mp3" type="audio/mpeg">
    </audio>

    <div class="cardWrapper">
        <div class="cardFrame">
            <div class="cardList">
                <div class="card common" data-card-id="balazs_foz"><img src="cards/balazs_foz.png">Balázs főzős kártya</div>
                <div class="card rare" data-card-id="balazs_meno"><img src="cards/balazs_meno.png">Balázs menő kártya</div>
                <div class="card mythical" data-card-id="balazs_baratkozik"><img src="cards/balazs_baratkozik.png">Balázs barátkozik kártya</div>
                <div class="card legendary" data-card-id="balazs_ultimate"><img src="cards/balazs_ultimate.png">Balázs ultimate kártya</div>
            </div>
        </div>
        <button id="spin">Pörgess!</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script/porgetes.js"></script>
</body>
</html>
