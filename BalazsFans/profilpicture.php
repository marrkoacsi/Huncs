<?php
require "config.php";

$id = $_GET['profil'];

$lekerdezes = "SELECT * FROM user WHERE id='$_COOKIE[id]'";
$talalt_felhasznalo = $conn->query($lekerdezes);
$felhasznalo = $talalt_felhasznalo->fetch_assoc();

if(isset($_POST['upload'])) {
    $file_name = $_FILES['ppicture']['name'];
    $tmp_name = $_FILES['ppicture']['tmp_name'];
    
    $mappa = "user/".$felhasznalo['user']."/";
    $eleresi_ut = $mappa.$file_name;

    if(!file_exists($mappa)) {
        mkdir($mappa);
    }

    $regi_kep = $mappa.$felhasznalo['ppicture'];
    if(file_exists($regi_kep) && $felhasznalo['ppicture'] != "") {
        unlink($regi_kep);
    }

    if(move_uploaded_file($tmp_name, $eleresi_ut)) {
        $conn->query("UPDATE user SET ppicture= '$file_name' WHERE id='$id'");
        echo "<script>
            alert('Új profilkép sikeresen feltöltve!')
            window.location.href = 'profil.php';
            </script>";
    }
    else {
        echo "<script>alert('A profilkép feltöltése sikertelen')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profilepicture.css">
    <link rel="icon" href="img/fav.png" type="image/png">
    <title>Balázs Rúgások</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="ppicture" accept="image/*" placeholder="Tolts fel kepet">
        <br><br>
        <input type="submit" name="upload" value="Feltoltes">
    </form>
    
</body>
</html>