<?php
session_start();
require_once 'Database.php';
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
DASHBOARD HERE !
</body>
<footer class="site-footer">
<?php include("zz_footer.html"); ?>
</footer>
</html