<?php
    require "config.php";

    if(!isset($_COOKIE['id'])){
        header("Location: reglog.php");
    }
    $isLoggedIn = isset($_COOKIE['id']);

    $id = $_GET['userid'];

    $lekerdezes = "SELECT * FROM user WHERE id != $id ORDER BY RAND()";
    $lekerdezett_felhasznalo = $conn->query($lekerdezes);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profilok.css">
    <link rel="icon" href="img/fav.png" type="image/png">
    <title>Felhasználók</title>
</head>
<body class="users-page">
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="navbar-brand">Balázs<span>Rúgások</span></a>
            <ul class="nav-links">
                <li><a href="index.php" class="nav-link">Főoldal</a></li>
                <?php if($isLoggedIn): ?>
                    <li><a href="roll.php" class="nav-link">Pörgetés</a></li>
                    <li><a href="profil.php" class="nav-link">Profil</a></li>
                    <li><a href="logout.php" class="nav-link login-btn">Kijelentkezés</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="main-container">
        <h1>Felhasználók</h1>
        
        <div class="users-grid">
            <?php while($felhasznalo = $lekerdezett_felhasznalo->fetch_assoc()): ?>
                <div class="user-card">
                    <div class="user-avatar">
                        <?php if(!empty($felhasznalo['ppicture'])): ?>
                            <img src="user/<?= $felhasznalo['user'] ?>/<?= $felhasznalo['ppicture'] ?>" alt="Profilkép">
                        <?php else: ?>
                            <img src="stockpictures/stock_profile_picture.png" alt="Alapértelmezett profilkép">
                        <?php endif; ?>
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars($felhasznalo['user']) ?></h3>
                        <a href="trade.php?userid=<?= $id ?>&tradeid=<?= $felhasznalo['id'] ?>" class="trade-btn">Csere</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>