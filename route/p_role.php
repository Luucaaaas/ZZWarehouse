<?php
session_start();

require_once 'Database.php';
require_once 'z_int.php';

// si un utilisateur qui n'est pas admin tape l'url alors il est rediriger vers la page d'acceuil
if ($id_role != '1') {
    header("Location:p_accueil.php");
    exit;
}

$database = new Database();

// pour avoir les utlisateur
$database->query("SELECT * FROM utilisateurs");
$utilisateurs = $database->resultSet();

// pour avoir les roless
$database->query("SELECT * FROM roles");
$roles = $database->resultSet();


// info de tri pour 
$column = $_GET['column'] ?? 'id_utilisateur';
$order = $_GET['order'] ?? 'asc';

// inverser l'ofre
$newOrder = ($order === 'asc') ? 'desc' : 'asc';

// pour mettre a jour le tableau
$database->query("SELECT * FROM utilisateurs ORDER BY $column $order");
$utilisateurs = $database->resultSet();

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Utilisateurs</title>
</head>
<header class="header">
    <?php include("zz_header.html"); ?>
</header>
<body>
    <h1>Rôle</h1>
    <?php if (isset($_SESSION['messageRole'])) { ?><div class="confirmation-message"><?php echo $_SESSION['messageRole']; ?></div><?php unset($_SESSION['messageRole']); ?><?php } ?>
    <table> 
    <thead class="role-column">
    <tr>
        <th scope="col">
            <form method="get">
                <button type="submit" name="column" value="id_utilisateur">
                    ID
                    <?php if ($column === 'id_utilisateur') { ?>
                        <?php if ($order === 'asc') { ?>
                            <img src="../source/img/fleche-haut.png" width="10" height="10" alt="haut">
                        <?php } else { ?>
                            <img src="../source/img/fleche-bas.png" width="10" height="10" alt="bas">           
                        <?php } ?>
                    <?php } ?>
                </button>
                <input type="hidden" name="order" value="<?php echo ($column === 'id_utilisateur' && $order === 'asc') ? 'desc' : 'asc'; ?>">
            </form>
        </th>
        <th scope="col">
            <form method="get">
                <button type="submit" name="column" value="nom">
                    Utilisateur
                    <?php if ($column === 'nom') { ?>
                        <?php if ($order === 'asc') { ?>
                            <img src="../source/img/fleche-haut.png" width="10" height="10" alt="haut">
                        <?php } else { ?>
                            <img src="../source/img/fleche-bas.png" width="10" height="10" alt="bas">           
                        <?php } ?>
                    <?php } ?>
                </button>
                <input type="hidden" name="order" value="<?php echo ($column === 'nom' && $order === 'asc') ? 'desc' : 'asc'; ?>">
            </form>
        </th>
        <th scope="col">
            <form method="get">
                <button type="submit" name="column" value="email">
                    Email
                    <?php if ($column === 'email') { ?>
                        <?php if ($order === 'asc') { ?>
                            <img src="../source/img/fleche-haut.png" width="10" height="10" alt="haut">
                        <?php } else { ?>
                            <img src="../source/img/fleche-bas.png" width="10" height="10" alt="bas">           
                        <?php } ?>
                    <?php } ?>
                </button>
                <input type="hidden" name="order" value="<?php echo ($column === 'email' && $order === 'asc') ? 'desc' : 'asc'; ?>">
            </form>
        </th>
        <th scope="col">
            <form method="get">
                <button type="submit" name="column" value="id_role">
                    Role
                    <?php if ($column === 'id_role') { ?>
                        <?php if ($order === 'asc') { ?>
                            <img src="../source/img/fleche-haut.png" width="10" height="10" alt="haut">
                        <?php } else { ?>
                            <img src="../source/img/fleche-bas.png" width="10" height="10" alt="bas">           
                        <?php } ?>
                    <?php } ?>
                </button>
                <input type="hidden" name="order" value="<?php echo ($column === 'id_role' && $order === 'asc') ? 'desc' : 'asc'; ?>">
            </form>
        </th>
    </tr>
</thead>
        <tbody class="page-role">
    <?php foreach ($utilisateurs as $utilisateur) { ?>
        <tr>
            <td data-label="ID"><?php echo $utilisateur->id_utilisateur; ?></td>
            <td data-label="Utilisateur"><?php echo $utilisateur->nom  . ' ' .  $utilisateur->prenom; ?></td>
            <td data-label="Email"><?php echo $utilisateur->email; ?></td>
            <td data-label="Role">
                <form onsubmit="return confirmUpdateRole('<?php echo $utilisateur->nom; ?>')" action="z_update_role.php" method="post">
                    <input type="hidden" name="id_utilisateur" value="<?php echo $utilisateur->id_utilisateur; ?>">
                    <?php if ($utilisateur->id_role == 1) { ?>
                        <img src="../source/img/admin.png" width="50" height="50" alt="admin">
                    <?php } elseif ($utilisateur->id_role == 2) { ?>
                        <img src="../source/img/utilisateur.png" width="50" height="50" alt="user">
                    <?php } elseif ($utilisateur->id_role == 3) { ?>
                        <img src="../source/img/client.png" width="50" height="50" alt="client">
                    <?php } ?>
                    <div class="flex-container">
                        <br>
                        <select name="id_role">
                            <?php foreach ($roles as $role) { ?>
                                <option value="<?php echo $role->id_role; ?>" <?php if ($role->id_role == $utilisateur->id_role) echo 'selected'; ?>>
                                    <?php echo $role->nom_role; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br>
                        <button type="submit">Appliquer</button>
                    </div>
                </form>
            </td>
        </tr>
    <?php } ?>
</tbody>
    </table>
    <script>
    function confirmUpdateRole(nomUtilisateur) {
        return confirm("Voulez-vous vraiment mettre à jour le rôle de l'utilisateur " + nomUtilisateur + " ?");
    }
    </script>
</body>
<footer class="site-footer">
    <?php include("zz_footer.html"); ?>
</footer>
</html>