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
    <!-- message de confirmation apres avoir validé le double clique de validation -->
    <?php if (isset($_SESSION['messageRole'])) { ?><div class="confirmation-message"><?php echo $_SESSION['messageRole']; ?></div><?php unset($_SESSION['messageRole']); ?><?php } ?>
    <table class="page-role">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Prenom</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $utilisateur) { ?>
                <tr>
                    <td data-label="ID"><?php echo $utilisateur->id_utilisateur; ?></td>
                    <td data-label="Nom"><?php echo $utilisateur->nom; ?></td>
                    <td data-label="Prenom"><?php echo $utilisateur->prenom; ?></td>
                    <td data-label="Email"><?php echo $utilisateur->email; ?></td>
                    <td data-label="Role">
                        <form onsubmit="return confirmUpdateRole('<?php echo $utilisateur->nom; ?>')" action="z_update_role.php" method="post">
                        <input type="hidden" name="id_utilisateur" value="<?php echo $utilisateur->id_utilisateur; ?>">
                        <select name="id_role">
                            <?php foreach ($roles as $role) { ?>
                                <option value="<?php echo $role->id_role; ?>" <?php if ($role->id_role == $utilisateur->id_role) echo 'selected'; ?>>
                                <?php echo $role->nom_role; ?>
                            </option>
                            <?php } ?>
                        </select>
                        <button type="submit">Appliquer</button>
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