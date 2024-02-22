<?php
session_start();

// utilisateur login ? 
if (!isset($_SESSION['email'])) {
  //redirection sur la page de login si l utilisateur n'est pas connecte 
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

?>

<!DOCTYPE html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/accueil.css">
    <title>ZZWarehouse | Rôle</title>
</head>
<header class="header">
  <a href="../route/accueil.php" class="logo"><img src="../source/img/logogsbpetit.ico."width="50" height="50"><span>Accueil</span><a href="../route/index.php"></a></a>
  <input class="menu-btn" type="checkbox" id="menu-btn" />
  <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
  <ul class="menu">
    <li><a href="#"><img src="../source/img/commande.png" width="25" height="25"><br>Commande</a></li>
    <li><a href="role.php"><img src="../source/img/Role.png" width="25" height="25"><br>Rôle</a></li>
    <li><a href="#"><img src="../source/img/Stock.png" width="25" height="25"><br>Stock</a></li>
    <li><a href="z_logout.php"><img src="../source/img/logout.png" width="25" height="25"><br>Se déconnecter</a></li>
  </ul>
</header>
<body>  
<?php echo "Bonjour, !"; ?><br>
</body>
</html