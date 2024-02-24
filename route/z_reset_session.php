<?php
session_start();

if (isset($_POST['reset'])) {
    $_SESSION['login_time'] = time();
    header("Location: accueil.php");
    exit();
}
?>