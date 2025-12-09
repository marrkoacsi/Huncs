<?php 

	require "config.php";

	

if (isset($_POST['reg-btn'])) {

    $email = $_POST['email'];
    $username = $_POST['username'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    $lekerdezes = "SELECT * FROM user WHERE email='$email'";
    $talalt_felhasznalo = $conn->query($lekerdezes);

    if (mysqli_num_rows($talalt_felhasznalo) == 0) {

        if ($pass1 === $pass2) {

            $titkositott_jelszo = password_hash($pass1, PASSWORD_DEFAULT);
            $mappa = getcwd();
            $eleresi_ut = $mappa . "\\user\\" . $username;

            if (!file_exists($eleresi_ut)) {
                if (mkdir($eleresi_ut, 0777)) {

                    $insert = "INSERT INTO user VALUES (id, '$email', '$username', '$titkositott_jelszo','', '500')";
                    if ($conn->query($insert)) {
                        echo "<script>alert('Sikeres regisztráció!')</script>";
                    } else {
                        echo "<script>alert('Adatbázis hiba: nem sikerült menteni.')</script>";
                    }

                } else {
                    echo "<script>alert('Nem sikerült mappát létrehozni!')</script>";
                }
            } else {
                echo "<script>alert('A felhasználónévhez tartozó mappa már létezik!')</script>";
            }

        } else {
            echo "<script>alert('A két jelszó nem egyezik!')</script>";
        }

    } else {
        echo "<script>alert('Ez az e-mail cím már foglalt!')</script>";
    }
}

if (isset($_POST['login-btn'])) {
    $password = $_POST['password'];
    $email = $_POST['email'];

    $lekerdezes = "SELECT * FROM user WHERE email = '$email'";
    $talalt_felhasznalo = $conn->query($lekerdezes);

    if (mysqli_num_rows($talalt_felhasznalo) == 1) {
        $felhasznalo = $talalt_felhasznalo->fetch_assoc();

        if (password_verify($password, $felhasznalo['password'])) {
            setcookie("id", $felhasznalo["id"], time()+3600, "/");
            $date = date("Y-m-d H:i:s");
            $lekerdezes = "SELECT * FROM daily_login WHERE user_id=$felhasznalo[id] ORDER BY last_login DESC LIMIT 1";
            $lekerdezett_login = $conn->query($lekerdezes);
            $login = $lekerdezett_login->fetch_assoc();

            if (empty($login) or (strtotime($date) - strtotime($login['last_login'])) >= 86400) {
                $conn->query("INSERT INTO daily_login (user_id, last_login) VALUES ('$felhasznalo[id]', '$date')");
                $conn->query("UPDATE user SET coin = coin + 100 WHERE id=$felhasznalo[id]");
                echo "<script>alert('Kaptál napi bonuszt. Az új egyenleged: " . ($felhasznalo['coin'] + 100) . "'); window.location.href='index.php';</script>";
            } else {
                header("Location: index.php");
            }
        } else {
            echo "<script>alert('Hibás jelszó!')</script>";
        }
    } else {
        echo "<script>alert('Nincs ilyen felhasználó!')</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bejelentkezés / Regisztráció</title>
  <link rel="stylesheet" href="css/reglog.css">
  <link rel="icon" href="img/fav.png" type="image/png">
</head>
<body class="login-page">

  <nav>
    <ul>
      <li><a class="menu-left" href="index.php">Főoldal</a></li>
    </ul>
  </nav>

  <div class="form-container">
    <!-- Bejelentkezés -->
    <form class="login-box" id="login" method="post">
      <h2>Bejelentkezés</h2>
      <input type="email" name="email" placeholder="Példa@példa.com" class="form-control" required>
      <input type="password" name="password" placeholder="Jelszó" class="form-control" required>
      <input type="submit" name="login-btn" value="Bejelentkezés" class="btn-primary">
      <p class="form-link">Még nincs fiókod? <a href="#" onclick="showForm('reg')">Regisztrálj!</a></p>
      <p class="form-link">Elfelejtetted a jelszavad? <a href="forgotpass.php">Lépj be!</a></p>
    </form>

    <!-- Regisztráció -->
    <form class="login-box" id="reg" style="display: none;" method="post">
      <h2>Regisztráció</h2>
      <input type="email" name="email" placeholder="Példa@példa.com" class="form-control" required>
      <input type="text" name="username" placeholder="Felhasználónév" class="form-control" required>
      <input type="password" id="myInput" name="pass1" placeholder="Jelszó" class="form-control" required>
      <input type="password" id="myInput1" name="pass2" placeholder="Jelszó újra" class="form-control" required>
      
      <div class="checkbox-group">
        <input type="checkbox" onclick="togglePasswords()" id="showPassword">
        <label for="showPassword">Jelszó mutatása</label>
      </div>

      <input type="submit" name="reg-btn" value="Regisztrálok!" class="btn-primary">
      <p class="form-link">Már van fiókod? <a href="#" onclick="showForm('login')">Lépj be!</a></p>
    </form>
  </div>

  <script>
    function showForm(form) {
      document.getElementById("login").style.display = form === "login" ? "block" : "none";
      document.getElementById("reg").style.display = form === "reg" ? "block" : "none";
    }

    function togglePasswords() {
      const pass1 = document.getElementById("myInput");
      const pass2 = document.getElementById("myInput1");
      const type = pass1.type === "password" ? "text" : "password";
      pass1.type = type;
      pass2.type = type;
    }
  </script>
</body>
</html>
