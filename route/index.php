<?php
// connexion a la bdd
require_once 'Database.php';

$database = new Database();

$session_lifetime = 1800; // en secondes

session_set_cookie_params($session_lifetime);

// deja connecte ?
session_start();
if (isset($_SESSION['email'])) {
    header("Location: accueil.php");
    exit();
}

// login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // requete preparée (injections SQL attention)
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $database->query($sql);
    $database->bind(':email', $email);
    $user = $database->single();

    if ($database->rowCount() == 1 && password_verify($password, $user->mot_de_passe)) {
        $_SESSION['email'] = $email;
        session_regenerate_id();
        header("Location: accueil.php");
        exit();
    } else {
        $loginError = "Email ou mot de passe invalides";
    }
}

// signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // mail deja existant ?
    $sql = "SELECT COUNT(*) AS count FROM utilisateurs WHERE email = :email";
    $database->query($sql);
    $database->bind(':email', $email);
    $count = $database->single()->count;

    if ($count > 0) {
        $signupError = "Cette adresse e-mail <br> est déjà renseignée";
    } else {
        // hashage mdp
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Ajout de l'utilisateur avec une requête préparée
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :password)";
        $database->query($sql);
        $database->bind(':nom', $nom);
        $database->bind(':prenom', $prenom);
        $database->bind(':email', $email);
        $database->bind(':password', $hashedPassword);
        if ($database->execute()) {
            $message = "L'utilisateur <br> $nom, $prenom <br> a été créé avec succès.";
        }
    }
}

$database = null;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../source/css/index.css">
    <title>ZZWarehouse | Login</title>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
</head>
<body>
<div class="container">
    <div class="image-container"></div>
    <div class="info-container">
        <div class="gsblogo"><a href="../route/index.php"><img src="../source/img/logogsb.png"></a></div>
        <?php if (isset($message)) { echo '<p class="message">' . htmlspecialchars_decode($message) . '</p>'; } ?>
        <?php if (isset($loginError)) { echo '<p class="error">' . htmlspecialchars($loginError) . '</p>'; } ?>
        <?php if (isset($signupError)) { echo '<p class="error">' . htmlspecialchars_decode($signupError) . '</p>'; } ?>
        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="login">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                <label for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Mot de passe" required><br>
                  
                    <input type="submit" name="login" value="Se connecter">
                </form>
            </div>

            <div class="signup">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="chk" aria-hidden="true">Sign up</label>
                    <input type="text" name="nom" placeholder="Nom" required><br>
                    <input type="text" name="prenom" placeholder="Prénom" required><br>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Mot de passe" required><br>
                    <input type="submit" name="signup" value="S'inscrire">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>