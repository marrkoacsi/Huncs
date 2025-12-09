<?php

    require "config.php";

    if(isset($_POST['forgot'])){

        $email = $_POST['email'];

        $lekerdezes = "SELECT * FROM user WHERE email = '$email'";
        $talalt_felhasznalo = $conn->query($lekerdezes);

        if (mysqli_num_rows($talalt_felhasznalo) == 1) {

            header("Location:forgotpass2.php?email=$email");
        }
        else {
        echo "<script>alert('Nincs ilyen Email!')</script>";
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
    <title>Document</title>
</head>
<body>
    <form method="post">

        <input type="email" name="email" placeholder="Email">

        <br><br>

        <input type="submit" name="forgot" value="Új jelszó">
</body>
</html>