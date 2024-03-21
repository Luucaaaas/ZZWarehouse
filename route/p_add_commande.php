<?php
session_start();
require_once 'Database.php';
require_once 'z_int.php';

$database = new Database();

// // si un utilisateur qui n'est pas admin tape l'url alors il est rediriger vers la page de stock
// if ($id_role != '1') {
//     header("Location:p_stock.php");
//     exit;
// }

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Passer une commande</title>
</head>
<body>
    <header class="header">
        <?php include("zz_header.html"); ?>
    </header>
    <h1>Passer une commande</h1>

    <footer class="site-footer">
        <?php include("zz_footer.html"); ?>
    </footer>
</body>
</html>