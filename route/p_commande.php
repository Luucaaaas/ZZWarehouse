<?php
session_start();
require_once 'Database.php';
require_once 'z_int.php';

$database = new Database();

$database->query("SELECT c.id_commande, u.nom AS nom_utilisateur, s.nom AS nom_produit, c.quantite, c.type_mouvement, c.date_commande, c.statut FROM commandes c
                  JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
                  JOIN stocks s ON c.id_stock = s.id_stock");
$commandes = $database->resultSet();


if (isset($_POST['valider_commande'])) {
    $commande_id = $_POST['commande_id'];

    $database->query("UPDATE commandes SET statut = 'validee' WHERE id_commande = :commande_id");
    $database->bind(':commande_id', $commande_id);
    $database->execute();

    $_SESSION['messageCommande'] = 'Le statut de la commande a été mis à jour.';
} elseif (isset($_POST['invalider_commande'])) {
    $commande_id = $_POST['commande_id'];

    $database->query("UPDATE commandes SET statut = 'invalidée' WHERE id_commande = :commande_id");
    $database->bind(':commande_id', $commande_id);
    $database->execute();

    $_SESSION['messageCommande'] = 'Le statut de la commande a été mis à jour.';
}

if (isset($_SESSION['messageCommande'])) {
    $messageCommande = $_SESSION['messageCommande'];
    unset($_SESSION['messageCommande']);
}


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Commande</title>
</head>
<body>
    <header class="header">
        <?php include("zz_header.html"); ?>
    </header>

    <div class="container-titre">
        <div class="trois"></div>
        <div class="trois"><h1>Commande</h1></div>
        <div class="trois">
            <?php if ($id_role == '1') : ?>
                <a href="p_add_commande.php" class="btn-add">➕Ajouter une Commande</a>
            <?php endif; ?>
        </div>
    </div>
    <?php if (isset($messageCommande)) { echo '<p class="confirmation-message">' . htmlspecialchars_decode($messageCommande) . '</p>'; } ?>
    

        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Utilisateur</th>
                    <th scope="col">Produit</th>
                    <th scope="col">Quantite</th>
                    <th scope="col">Mouvement</th>
                    <th scope="col">Date</th>
                    <th scope="col">Statut</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($commandes as $commande) : ?>
            <tr>
                <td data-label="ID"><?php echo $commande->id_commande; ?></td>
                <td data-label="Utilisateur"><?php echo $commande->nom_utilisateur; ?></td>
                <td data-label="Produit"><?php echo $commande->nom_produit; ?></td>
                <td data-label="Quantite"><?php echo $commande->quantite; ?></td>
                <td data-label="Mouvement">                    
                    <div><?php
                        if ($commande->type_mouvement === 'Entree') {
                            echo '<img src="../source/img/entree.png" width="30" height="30" alt="Mouvement d\'entrée">';
                        } elseif ($commande->type_mouvement === 'Sortie') {
                            echo '<img src="../source/img/sortie.png" width="30" height="30"  alt="Mouvement de sortie">';
                        }
                    ?><br><?php echo $commande->type_mouvement; ?></div></td>
                <td data-label="Date"><?php echo $commande->date_commande; ?></td>
                <td data-label="Statut">
                    <?php if ($commande->statut === 'validee') {
                        echo '<img src="../source/img/validee.png" width="50" height="50" alt="Statut validé">';
                    } elseif ($commande->statut === 'invalidée') {
                        echo '<img src="../source/img/invalidee.png" width="50" height="50" alt="Statut invalidé">';
                    }elseif ($commande->statut === 'en attente') {
                        echo '<img src="../source/img/en attente.png" width="50" height="50" alt="Statut en attente">';
                        }?><br>
                        <h3><?php echo $commande->statut; ?></h3     >
                        <form method="POST" class="inline-form">
                            <div class="flex-container-2"><br>
                                <input type="hidden" name="commande_id" value="<?php echo $commande->id_commande; ?>">
                                <button type="submit" name="valider_commande" class="cancel-button" onclick="return confirm('Êtes-vous sûr de vouloir valider la commande ?')">Valider</button>
                                <button type="submit" name="invalider_commande" class="stock-button" onclick="return confirm('Êtes-vous sûr de vouloir invalider la commande ?')">Invalider</button>
                            </form>             
                        </td>
                    </tr>
                <?php endforeach; ?>
            <div>
        </tbody>
    </table>
    <footer class="site-footer">
        <?php include("zz_footer.html"); ?>
    </footer>
</body>
</html>