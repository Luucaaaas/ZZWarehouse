<?php

require_once 'Database.php';

$database = new Database();

session_start();

require_once 'z_int.php'
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
<?php echo "Bonjour, $prenom $nom !"; ?><br>
<?php echo $time_remaining ?>     
<form action="z_reset_session.php" method="POST">
        <button type="submit" name="reset">Réinitialiser le temps de session</button>
    </form>
</body>
<footer class="site-footer">
<?php include("zz_footer.html"); ?>
</footer>
</html