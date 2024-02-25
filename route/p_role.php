<?php

require_once 'Database.php';

$database = new Database();

session_start();

// utilisateur login ? 
if (!isset($_SESSION['email'])) {
  //redirection sur la page de login si l utilisateur n'est pas connecte 
  header("Location: index.php");
  exit();
}

// role l'utilisateur ?
$role = $_SESSION['role'];

// Vérifier si l'utilisateur n'a pas le rôle d'administrateur
if ($role != 'admin') {
    // Redirection vers la page d'accueil si l'utilisateur n'a pas le rôle d'administrateur
    header("Location: accueil.php");
    exit();
}



if (isset($_SESSION['email'])) {
  $session_duration = 1800 ; // Durée de la session en secondes
  $current_time = time();
  $login_time = $_SESSION['login_time'];

  $session_time_remaining = $session_duration - ($current_time - $login_time);

  if ($session_time_remaining <= 0) {
    // redirection quand le temps de session vers le code pour "detruire la session"
    header("Location: z_logout.php");
      exit();
  }

  // temps de seesion sera supprime je pense lors de la version final du projet 
  $hours_remaining = floor($session_time_remaining / 3600);
  $minutes_remaining = floor(($session_time_remaining % 3600) / 60);
  $seconds_remaining = $session_time_remaining % 60;

  $time_remaining = "Temps de session restant : 
                    " . $hours_remaining . 
                    " heures, " . 
                    $minutes_remaining . 
                    " minutes, " . 
                    $seconds_remaining . 
                    " secondes";
}



$email = $_SESSION['email'];
// qui est login avec quelle role ?
$sql = "SELECT nom, prenom, id_role FROM utilisateurs WHERE email = :email";
$database->query($sql);
$database->bind(':email', $email);
$database->execute();

if ($database->rowCount() == 1) {
    $row = $database->single();
    $nom = $row->nom;
    $prenom = $row->prenom;
    $id_role = $row->id_role;
} else {
    $nom = "?";
    $prenom = "???";
    $id_role = "";
}
?>

<!DOCTYPE html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Rôle</title>
</head>
<header class="header">
  <a href="../route/accueil.php" class="logo"><img src="../source/img/logogsbpetit.ico."width="50" height="50"><span>Accueil</span><a href="../route/index.php"></a></a>
  <input class="menu-btn" type="checkbox" id="menu-btn" />
  <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
  <ul class="menu">
    <li><a href="role.php"><img src="../source/img/Role.png" width="25" height="25"><br>Rôle</a></li>
    <li><a href="commande.php"><img src="../source/img/commande.png" width="25" height="25"><br>Commande</a></li>
    <li><a href="stock.php"><img src="../source/img/Stock.png" width="25" height="25"><br>Stock</a></li>
    <li><a href="z_logout.php"><img src="../source/img/logout.png" width="25" height="25"><br>Se déconnecter</a></li>
  </ul>
</header>
<body>  
<?php echo "Bonjour, $prenom $nom !"; ?><br>
<?php echo $time_remaining ?><br>
<form action="z_reset_session.php" method="POST">
        <button type="submit" name="reset">Réinitialiser le temps de session</button>
    </form>
</body>
<footer class="site-footer">
  <hr class="custom"/>
  <p class="copyright-text">Copyright © 2024</p>
  <div class="social-icons">
    <a class="github" href="https://github.com/Luucaaaas/ZZWarehouse" target="_blank"><img src="../source/img/github.png"width="50" height="50"></a>
  </div>
</footer>
</html