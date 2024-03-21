<?php

session_start();

require_once 'Database.php';
require_once 'z_int.php';

$database = new Database();

if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    $errorMessage = '<div class="error-message">Le stock n\'existe pas.</div>';
    unset($_SESSION['error_message']);
}

// mettre a nul la variable message si un message de validation est present dans la session (ici le message lorsqu'on modifie du stock)
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

// requete pour avoir le stock
$sql = "SELECT * FROM stocks";
$database->query($sql);
$stocks = $database->resultSet();

if (isset($_SESSION['confirmation_message'])) {
    $confirmationMessage = $_SESSION['confirmation_message'];
    $confirmationMessage = '<div class="confirmation-message">La ligne a été supprimée avec succès.</div>';
    unset($_SESSION['confirmation_message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Stock</title>
</head>
<body>
    <header class="header">
        <?php include("zz_header.html"); ?>
    </header>

    <div class=container-titre>
        <div class=trois></div>
        <div class=trois><h1>Stock</h1></div>
        <div class=trois><?php if ($id_role == '1') : ?><a href="p_add_stock.php" class="btn-add">➕Ajouter un stock</a><?php endif; ?></div>
        </div>

        <?php if (!empty($message)) : ?><p class="message"><?php echo $message; ?></p><?php endif; ?>
        <?php if (isset($confirmationMessage)) { echo '<p class="message">' . htmlspecialchars_decode($confirmationMessage) . '</p>'; } ?>
        <?php if (isset($errorMessage)) { echo '<p class="message">' . htmlspecialchars_decode($errorMessage) . '</p>'; } ?>
        <?php if (isset($messageAdd)) { echo '<p class="confirmation-message">' . htmlspecialchars_decode($messageAdd) . '</p>'; } ?>


        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantité disponible</th>
                    <th scope="col">Type</th>
                    <?php if ($id_role == '1') : ?><th scope="col">Modifier</th><?php endif; ?>
                    <?php if ($id_role == '1') : ?><th scope="col">Supprimer</th><?php endif; ?>
                </tr>
                <thead>
                    <tbody>
                        <?php foreach ($stocks as $item) { ?>
                            <tr>
                                <td data-label="ID"><?php echo $item->id_stock; ?></td>
                                <td data-label="Nom"><?php echo $item->nom; ?></td>
                                <td data-label="Description"><?php echo $item->description; ?></td>
                                <td data-label="Quantité disponible"><?php echo $item->quantite_disponible; ?></td>
                                <td data-label="Type"><?php echo $item->type; ?></td>
                                <?php if ($id_role == '1') : ?><td data-label="Modifier">
                                    <form action="p_edit_stock.php" method="get">
                                        <input type="hidden" name="id_stock" value="<?php echo $item->id_stock; ?>">
                                        <button type="submit">🖊️</button>
                                    </form>
                                </td><?php endif; ?>
                                <?php if ($id_role == '1') : ?><td data-label="Supprimer">
                                    <form id="delete-form-<?php echo $item->id_stock; ?>" action="z_delete_stock.php" method="post">
                                    <input type="hidden" name="id_stock" value="<?php echo $item->id_stock; ?>">
                                    <button type="button" onclick="showConfirmation(<?php echo $item->id_stock; ?>, '<?php echo addslashes($item->nom); ?>')">🗑️</button>
                                </form>
                            </td><?php endif; ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <script>
                // Popup de confirmation
                function showConfirmation(idStock, productName) {
                    if (confirm("Êtes-vous sûr de vouloir supprimer le produit \"" + productName + "\" ?")) {
                        // Si "OK" est sélectionné, alors supprimer
                        document.getElementById('delete-form-' + idStock).submit();
                    }
                }
                </script>
                <footer class="site-footer">
                    <?php include("zz_footer.html"); ?>
                </footer>
</body>
</html>