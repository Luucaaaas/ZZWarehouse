<?php
require_once 'Database.php';
require_once 'z_int.php';


// requete pour avoir le stock
$query = "SELECT * FROM stocks";
$database->query($query);
$stocks = $database->resultSet();

if (isset($_SESSION['confirmation_message'])) {
    $confirmationMessage = $_SESSION['confirmation_message'];
    $confirmationMessage = '<div class="confirmation-message">La colonne a été supprimé avec succès.</div>';
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

    <h1>Stock</h1>
    <?php if (isset($confirmationMessage)) { echo '<p class="message">' . htmlspecialchars_decode($confirmationMessage) . '</p>'; } ?>

    
    <table>
    <tr>
        <!-- <th>ID</th> -->
        <th>Produit</th>
        <th>Quantité disponible</th>
        <th>Supprimer</th>
    </tr>
    <?php foreach ($stocks as $item) { ?>
        <tr>
            <!-- <td><?php echo $item->id_stock; ?></td> -->
            <td><?php echo $item->nom; ?></td>
            <td><?php echo $item->quantite_disponible; ?></td>
            <td>
                <form id="delete-form-<?php echo $item->id_stock; ?>" action="z_delete.php" method="post">
                    <input type="hidden" name="id_stock" value="<?php echo $item->id_stock; ?>">
                    <button type="button" onclick="showConfirmation(<?php echo $item->id_stock; ?>)">🗑️</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
<script>
    // popup de confirmation
    function showConfirmation(idStock) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette colonne ?")) {
            // si ok est selectionner alors supprimer 
            document.getElementById('delete-form-' + idStock).submit();
        }
    }
</script>
</body>
    <footer class="site-footer">
        <?php include("zz_footer.html"); ?>
    </footer>
</html>