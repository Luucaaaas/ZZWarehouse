<?php
session_start();

// deja connecte ?
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

require_once 'Database.php';

$database = new Database();

$email = $_SESSION['email'];
// qui est login ?
$sql = "SELECT nom, prenom FROM utilisateurs WHERE email = :email";
$database->query($sql);
$database->bind(':email', $email);
$database->execute();

if ($database->rowCount() == 1) {
    $row = $database->single();
    $nom = $row->nom;
    $prenom = $row->prenom;
} else {
    $nom = "?";
    $prenom = "???";
}
?>


<!DOCTYPE html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/accueil.css">
    <title>ZZWarehouse | Accueil de <?php echo $prenom?></title>
</head>
<header class="header">
  <a href="../route/accueil.php" class="logo"><img src="../source/img/logogsbpetit.ico."width="50" height="50"><span>Accueil</span><a href="../route/index.php"></a></a>
  <input class="menu-btn" type="checkbox" id="menu-btn" />
  <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
  <ul class="menu">
    <li><a href="#"><img src="../source/img/commande.png" width="25" height="25"><br>Commande</a></li>
    <li><a href="#"><img src="../source/img/Role.png" width="25" height="25"><br>Rôle</a></li>
    <li><a href="#"><img src="../source/img/Stock.png" width="25" height="25"><br>Stock</a></li>
    <li><a href="z_logout.php"><img src="../source/img/logout.png" width="25" height="25"><br><?php echo $prenom?></a></li>
  </ul>
</header>
<body>  
<?php echo "Bonjour, $prenom $nom !"; ?>
</body>
</html