<?php $isLoggedIn = isset($_COOKIE['id']); ?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Balázs Fans</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/fooldal.css">
  <link rel="icon" href="img/fav.png" type="image/png">
</head>
<body>

<!-- Navigáció -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="index.php">Balázs <span>Rúgások</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto">
        <?php if ($isLoggedIn):?>
        <li class="nav-item"><a class="nav-link" href="roll.php">Pörgetés</a></li>
        <?php endif; ?>
           <?php if ($isLoggedIn): 
            $id = $_COOKIE['id'];?>
        <li class="nav-item"><a class="nav-link" href="profilok.php?userid=<?= $id; ?>">Csere</a></li>
          <li class="nav-item"><a class="nav-link" href="profil.php">Profilom</a></li>
        <?php endif; ?>
         <?php if (!$isLoggedIn): ?>
        <li class="nav-item"><a class="nav-link login-btn" href="reglog.php">Bejelentkezés/Regisztráció</a></li>
        <?php endif; ?>
        <?php if ($isLoggedIn):?>
        <li class="nav-item"><a class="nav-link" href="logout.php">Kijelentkezés</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero szakasz -->
<header class="hero">
  <div class="container text-center">
    <h1>🔞 Balázs Rúgások ⚽</h1>
    <p>Balázs? Gambling? Lessgo</p>
  </div>
</header>
<section class="main-content">
  <div class="container">
<h1>Ki is az a balázs?</h1>
<p>Balázs tanár úr még csak 24 éves, de már most legendának számít az iskolában. Ő az, aki nem csak PHP-t tanít, hanem egy egész életfilozófiát ad át — aminek nagy része a kaszinózásról és a Skodázásról szól. Minden reggel úgy kezdi a napot, hogy egy dupla energiaital és egy erős kávé keverékével tölti fel az „üzemanyag-tartályát”, mert hát a PHP kódok mellett szükség van némi koffeinre, hogy túlélje a b-seket. 
</p>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
