<?php
session_start();

require_once 'Database.php';
require_once 'z_int.php';

// pour acceder au role l'utilisateur doit etre admin
if ($id_role != '1') {
  header("Location: p_accueil.php");
  exit();
}
?>

<!DOCTYPE html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Rôle</title>
</head>
<header class="header">
<?php include("zz_header.html"); ?>
</header>
<body>  
<?php echo "Bonjour, $prenom $nom !"; ?><br>
<?php echo $time_remaining ?><br>
<form action="z_reset_session.php" method="POST">
        <button type="submit" name="reset">Réinitialiser le temps de session</button>
    </form>
</body>
<footer class="site-footer">
<?php include("zz_footer.html"); ?>
</footer>
</html