<?php

    require "config.php";

    session_start();




    if(isset($_POST['forgot'])){
        
        $email = $_GET['email'];
        $password = $_POST['password'];
        $password1 = $_POST['password2'];

        if($password === $password1){
            
            $lekerdezes = "SELECT * FROM user WHERE email = '$email'";
            $talalt_felhasznalo = $conn->query($lekerdezes);

            if ($felhasznalo = $talalt_felhasznalo->fetch_assoc()) {
                $titkositott_jelszo = password_hash($password, PASSWORD_DEFAULT);
                $update = "UPDATE user SET password = '$titkositott_jelszo' WHERE email = '$email'";

                if ($conn->query($update)) {
                    echo "<script>alert('Jelszó sikeresen megváltoztatva!')</script>";
                    header("Location:reglog.php");
                } else {
                    echo "<script>alert('Adatbázis hiba: nem sikerült frissíteni.')</script>";
                }
            } else {
                echo "<script>alert('Nem található ilyen email!')</script>";
            }
        } else {
            echo "<script>alert('A két jelszó nem egyezik!')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forgotpass.css">
     <link rel="icon" href="img/fav.png" type="image/png">
    <title>Jelszó Visszaállítás</title>
</head>
<body>
    <form method="post">
        <input type="password" value="" id="myInput" name="password" placeholder="Jelszó">
        <br><br>
        <input type="password" value="" id="myInput1" name="password2" placeholder="Jelszó újra">
        <br><br>
        <input type="checkbox" onclick="togglePasswords()">Jelszó mutatása
        <br><br>
        <input type="submit" name="forgot" value="Új jelszó létrehozása">
    </form>

    <script>
        function togglePasswords() {
            var pass1 = document.getElementById("myInput");
            var pass2 = document.getElementById("myInput1");
            pass1.type = pass1.type === "password" ? "text" : "password";
            pass2.type = pass2.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
