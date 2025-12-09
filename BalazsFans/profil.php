<?php
require "config.php";
session_start();

if (!isset($_COOKIE['id'])) {
    header("Location: reglog.php");
    exit;
}

$lekerdezes = "SELECT * FROM user WHERE id='$_COOKIE[id]'";
$talalt_felhasznalo = $conn->query($lekerdezes);
$felhasznalo = $talalt_felhasznalo->fetch_assoc();

// Kártyanevek leképezése a szép megjelenítéshez
$cardDisplayNames = [
    'balazs_foz' => 'Balázs főzős kártya',
    'balazs_meno' => 'Balázs menő kártya',
    'balazs_baratkozik' => 'Balázs barátkozik kártya',
    'balazs_ultimate' => 'Balázs ultimate kártya'
];
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Profilom</title>
    <link rel="stylesheet" href="css/profil.css"> 
    <link rel="icon" href="img/fav.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Navigáció -->
<nav class="navbar">
  <div class="container">
    <a class="navbar-brand" href="index.php"><span>Balázs</span>Rúgások</a>
    <div class="nav-links">
      <a class="nav-link active" href="index.php">Főoldal</a>
      <a class="nav-link" href="roll.php">Pörgetés</a>
    </div>
  </div>
</nav>

<!-- Tartalom -->
<main>
  <h1>Üdv, <?= htmlspecialchars($felhasznalo['user']) ?>!</h1>

  <?php if (!empty($felhasznalo['ppicture'])): ?>
      <img src="user/<?= htmlspecialchars($felhasznalo['user']) ?>/<?= htmlspecialchars($felhasznalo['ppicture']) ?>" alt="Profilkép">
  <?php else: ?>
      <img src="stockpictures/stock_profile_picture.png" alt="Alap profilkép">
  <?php endif; ?>

  <div class="links">
      <a href="profilpicture.php?profil=<?= $felhasznalo['id'] ?>">Profilkép váltás</a>
      <a href="profilok.php?userid=<?= $felhasznalo['id']; ?>">Felhasználók</a>
      <a><?= $felhasznalo['coin'] ?> Kredit</a>
  </div>

  <h2>Kártyáid</h2>
  <div class="card-inventory">
      <?php 
      $lekerdezes = "SELECT * FROM card_results WHERE user_id='$_COOKIE[id]' ORDER BY created_at DESC";
      $talalt_kartyak = $conn->query($lekerdezes);
      while ($kartyak = $talalt_kartyak->fetch_assoc()):
          $cardName = htmlspecialchars($kartyak['card_name']);
          $displayName = $cardDisplayNames[$cardName] ?? $cardName;
      ?>
          <a href='cards/<?= $cardName ?>.php'>
              <div><?= $displayName ?></div>
              <img src="cards/<?= $cardName ?>.png" alt="<?= $displayName ?>">
          </a>
      <?php endwhile; ?>
  </div>
</main>

</body>
</html>