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

$sql = "SELECT * FROM stocks";
$result = $database->query($sql);
$stocks = $result->fetchAll(PDO::FETCH_ASSOC);

// Inclure le fichier d'en-tête HTML
include("header.html");

if (isset($_SESSION['email'])) {
  $session_duration = 1800; // en secondes
  $current_time = time();
  $login_time = $_SESSION['login_time'];

  $session_time_remaining = $session_duration - ($current_time - $login_time);

  if ($session_time_remaining <= 0) {
    // redirection quand le temps de session n'est plus valide vers le code pour "detruire la session" 
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
    <title>ZZWarehouse | Stock</title>
</head>

<body>  
<?php echo "Bonjour, $prenom $nom !"; ?><br>
<?php echo $time_remaining ?>     
<form action="z_reset_session.php" method="POST">
        <button type="submit" name="reset">Réinitialiser le temps de session</button>
    </form>
    <h1>Stock</h1>

<!-- Affichage des informations sur le stock -->
<table>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Quantité disponible</th>
        <th>Type</th>
    </tr>
    <?php foreach ($stocks as $stock): ?>
        <tr>
            <td><?php echo $stock['nom']; ?></td>
            <td><?php echo $stock['description']; ?></td>
            <td><?php echo $stock['quantite_disponible']; ?></td>
            <td><?php echo $stock['type']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Formulaire d'ajout -->
<h2>Ajouter au stock</h2>
<form action="ajouter_stock.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required>
    <br>
    <label for="description">Description :</label>
    <input type="text" name="description" id="description" required>
    <br>
    <label for="quantite">Quantité :</label>
    <input type="number" name="quantite" id="quantite" required>
    <br>
    <input type="submit" value="Ajouter au stock">
</form>

<!-- Formulaire de suppression -->
<h2>Supprimer du stock</h2>
<form action="supprimer_stock.php" method="POST">
    <label for="id_stock">ID du stock :</label>
    <input type="number" name="id_stock" id="id_stock" required>
    <br>
    <input type="submit" value="Supprimer du stock">
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