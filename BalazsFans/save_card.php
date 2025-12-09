<?php

    require "config.php";

    session_start();

    $selectedCard = ($_POST['selectedCard']);
    $userId = $_COOKIE['id'];

    $conn->query("INSERT INTO card_results (user_id, card_name) VALUES ($userId, '$selectedCard')");

    $conn->query("UPDATE user SET coin = coin - 10 WHERE id = $userId");

?>
