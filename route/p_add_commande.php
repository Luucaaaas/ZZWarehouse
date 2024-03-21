<?php
session_start();
require_once 'Database.php';
require_once 'z_int.php';

$database = new Database();


// Récupérer les informations de l'utilisateur connecté
$sql = "SELECT id_utilisateur, nom, prenom, id_role FROM utilisateurs WHERE email = :email";
$database->query($sql);
$database->bind(':email', $email);
$database->execute();

$user = $database->single();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $id_utilisateur = $_POST['id_utilisateur'];
    $id_stock = $_POST['id_stock'];
    $quantite = $_POST['quantite'];
    $type_mouvement = $_POST['type_mouvement'];

    // Vérifier si les valeurs sont valides (vous pouvez ajouter des validations supplémentaires si nécessaire)

    // Insérer la commande dans la base de données
    $sql = "INSERT INTO commande (id_utilisateur, id_stock, quantite, type_mouvement) VALUES (:id_utilisateur, :id_stock, :quantite, :type_mouvement)";
    $database->query($sql);
    $database->bind(':id_utilisateur', $id_utilisateur);
    $database->bind(':id_stock', $id_stock);
    $database->bind(':quantite', $quantite);
    $database->bind(':type_mouvement', $type_mouvement);
    $database->execute();

    // Vérifier si l'insertion a réussi
    if ($database->rowCount() > 0) {
        echo "La commande a été insérée avec succès.";
    } else {
        echo "Erreur lors de l'insertion de la commande.";
    }
}

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
    <?php echo $user->id_utilisateur; ?>
    <form action="insertion_commande.php" method="post">
        <input type="hidden" name="id_utilisateur" value="<?php echo $user->id_utilisateur; ?>">

        <label for="id_stock">ID Stock:</label>
        <input type="text" name="id_stock" id="id_stock"><br>

        <label for="quantite">Quantité:</label>
        <input type="text" name="quantite" id="quantite"><br>

        <label for="type_mouvement">Type de mouvement:</label>
        <select name="type_mouvement" id="type_mouvement">
            <option value="Entree">Entrée</option>
            <option value="Sortie">Sortie</option>
        </select><br>

        <input type="submit" value="Soumettre">
    </form>

    <footer class="site-footer">
        <?php include("zz_footer.html"); ?>
    </footer>
</body>
</html>