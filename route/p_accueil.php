<?php
session_start();
require_once 'Database.php';
require_once 'z_int.php';

if (isset($_SESSION['messageCommande'])) {
    $messageCommande = $_SESSION['messageCommande'];
    unset($_SESSION['messageCommande']);
}
?>

<!DOCTYPE html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Accueil de <?php echo $prenom?></title>
</head>
<header class="header">
<?php include("zz_header.html"); ?>
</header>
<body>  
<?php if ($id_role == '3' || $id_role == '4') : ?><?php if (isset($messageCommande)) { echo '<p class="confirmation-message">' . htmlspecialchars_decode($messageCommande) . '</p>'; } ?><?php endif; ?>
DASHBOARD HERE !
</body>
<footer class="site-footer">
<?php include("zz_footer.html"); ?>
</footer>
</html