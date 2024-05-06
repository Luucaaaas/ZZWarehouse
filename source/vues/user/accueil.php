<?php
session_start();

require_once '../source/base/database.php';
require_once '../source/controleur/int.php';

if (isset($_SESSION['messageCommande'])) {
    $messageCommande = $_SESSION['messageCommande'];
    unset($_SESSION['messageCommande']);
}
?>

<!DOCTYPE html>
<head>
    <link rel="icon" href="./img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style/app.css">
    <title>ZZWarehouse | Accueil de <?php echo $prenom?></title>
</head>
<header class="header">
    <?php include("../source/vues/html/header.php"); ?>
</header>
    <body>  
<?php if ($id_role == '3' || $id_role == '4') : ?><?php if (isset($messageCommande)) { echo '<p class="confirmation-message">' . htmlspecialchars_decode($messageCommande) . '</p>'; } ?><?php endif; ?>
</body>
<h1>DASHBOARD HERE !</h1>
<footer class="site-footer">
    <?php include("../source/vues/html/footer.php"); ?>
</footer>
</html