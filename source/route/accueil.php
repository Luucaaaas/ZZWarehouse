<?php
session_start();

//utilisateur deja connecte ?
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

require_once 'bdd.php';

$email = $_SESSION['email'];

$sql = "SELECT nom, prenom FROM utilisateurs WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $prenom = $row['prenom'];
} else {
    $nom = "?";
    $prenom = "???";
}

echo "Bonjour, $prenom $nom !";
?>


<!DOCTYPE html>
<head>
    <link rel="icon" href="../img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="accueil.css">
    <title>ZZWarehouse | Accueil de <?php echo $prenom?></title>
</head>
<body>
    <a href="logout.php"><img src="../img/logout.png" width="25" height="25"></a>
</body>
</html>