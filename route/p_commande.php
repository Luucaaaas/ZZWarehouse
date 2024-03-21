<?php
session_start();
require_once 'Database.php';
require_once 'z_int.php';

$database = new Database();

// Récupérer les commandes
$database->query("SELECT * FROM commandes");
$commandes = $database->resultSet();

// Récupérer les utilisateurs
$database->query("SELECT * FROM utilisateurs");
$utilisateurs = $database->resultSet();

// Récupérer les mouvements
$database->query("SELECT * FROM mouvements");
$mouvements = $database->resultSet();

// Récupérer les stocks
$database->query("SELECT * FROM stocks");
$stocks = $database->resultSet();
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
        <div class="trois">
            <h1>Commande</h1>
        </div>
        <div class="trois">
            <?php if ($id_role == '1') : ?>
                <a href="p_add_commande.php" class="btn-add">➕Ajouter une Commande</a>
            <?php endif; ?>
        </div>
    </div>

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
            <?php foreach ($commandes as $commande) :
                $utilisateur = "";
                foreach ($utilisateurs as $u) {
                    if ($u->id_utilisateur === $commande->id_utilisateur) {
                        $utilisateur = $u;
                        break;
                    }
                }

                $mouvement = "";
                foreach ($mouvements as $m) {
                    if ($m->id_commande === $commande->id_commande) {
                        $mouvement = $m;
                        break;
                    }
                }

                $stock = "";
                foreach ($stocks as $s) {
                    if ($s->id_stock === $mouvement->id_stock) {
                        $stock = $s;
                        break;
                    }
                }
                ?>
                <tr>
                <td data-label="ID"><?php echo $commande->id_commande; ?></td>
                <td data-label="Utilisateur"><?php echo $utilisateur->prenom . ' ' . $utilisateur->nom; ?></td>
                <td data-label="Produit"><?php echo $stock->nom; ?></td>
                <td data-label="Quantité Mouvement"><?php echo $mouvement->quantite; ?></td>
                <td>
                    <?php
                        if ($mouvement->type_mouvement === 'Entree') {
                            echo '<img src="../source/img/entree.png" width="30" height="30" alt="Mouvement d\'entrée">';
                        } elseif ($mouvement->type_mouvement === 'Sortie') {
                            echo '<img src="../source/img/sortie.png" width="30" height="30"  alt="Mouvement de sortie">';
                        }
                    ?>
                    <br><?php echo $mouvement->type_mouvement; ?>
                </td>                <td data-label="Date"><?php echo $commande->date_commande; ?></td>
                <td data-label="Statut"><?php echo $commande->statut; ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <footer class="site-footer">
        <?php include("zz_footer.html"); ?>
    </footer>
</body>
</html>