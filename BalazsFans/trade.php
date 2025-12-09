<?php
require "config.php";

$id = $_GET['userid'];
$tradeid = $_GET['tradeid'];

$lekerdezett_kartya = $conn->query("SELECT * FROM card_results WHERE user_id = $id");
$lekerdezett_kartyak = $conn->query("SELECT * FROM card_results WHERE user_id = $tradeid");
$felhasznalo = $conn->query("SELECT * FROM user WHERE id = $tradeid")->fetch_assoc();

$cardDisplayNames = [
    'balazs_foz' => 'Balázs főzős kártya',
    'balazs_meno' => 'Balázs menő kártya',
    'balazs_baratkozik' => 'Balázs barátkozik kártya',
    'balazs_ultimate' => 'Balázs ultimate kártya'
];

if (isset($_POST['trade'])) {
    $enKartyak = $_POST['en_kartyam'] ?? [];
    $masikKartyai = $_POST['masik_kartyaja'] ?? [];

    foreach ($enKartyak as $kartyaId) {
        $conn->query("UPDATE card_results SET user_id = $tradeid WHERE id = " . (int)$kartyaId . " AND user_id = $id");
    }

    foreach ($masikKartyai as $kartyaId) {
        $conn->query("UPDATE card_results SET user_id = $id WHERE id = " . (int)$kartyaId . " AND user_id = $tradeid");
    }

    echo "<script>
        alert('Kártyák sikeresen cserélve!');
        window.location.href = 'profil.php';
        </script>";
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/fooldal.css">
    <link rel="stylesheet" href="css/trade.css">
    <link rel="icon" href="img/fav.png" type="image/png">
    <title>Csere</title>
</head>
<body class="trade-page">
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="navbar-brand">Balázs<span>Kártya</span></a>
            <ul class="nav-links">
                <li><a href="profil.php" class="nav-link">Vissza a profilra</a></li>
            </ul>
        </div>
    </nav>

    <div class="trade-container">
        <form method="post" class="trade-form">
            <div class="cards-section">
                <h2>Kártyáim</h2>
                <div class="cards-grid">
                    <?php while ($kartyaim = $lekerdezett_kartya->fetch_assoc()): 
                        $displayName = $cardDisplayNames[$kartyaim['card_name']] ?? $kartyaim['card_name'];
                    ?>
                        <div class="trade-card">
                            <label class="card-checkbox">
                                <input type="checkbox" name="en_kartyam[]" value="<?= $kartyaim['id'] ?>">
                                <span class="checkmark"></span>
                            </label>
                            <img src="cards/<?= htmlspecialchars($kartyaim['card_name']) ?>.png" alt="<?= htmlspecialchars($displayName) ?>">
                            <div class="card-name"><?= htmlspecialchars($displayName) ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="divider">
                <div class="arrow-icon">⇄</div>
            </div>

            <div class="cards-section">
                <h2><?= htmlspecialchars($felhasznalo['user']) ?> kártyái</h2>
                <div class="cards-grid">
                    <?php while ($kartyak = $lekerdezett_kartyak->fetch_assoc()): 
                        $displayName = $cardDisplayNames[$kartyak['card_name']] ?? $kartyak['card_name'];
                    ?>
                        <div class="trade-card">
                            <label class="card-checkbox">
                                <input type="checkbox" name="masik_kartyaja[]" value="<?= $kartyak['id'] ?>">
                                <span class="checkmark"></span>
                            </label>
                            <img src="cards/<?= htmlspecialchars($kartyak['card_name']) ?>.png" alt="<?= htmlspecialchars($displayName) ?>">
                            <div class="card-name"><?= htmlspecialchars($displayName) ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <button type="submit" name="trade" class="trade-submit">Csere végrehajtása</button>
        </form>
    </div>
</body>
</html>