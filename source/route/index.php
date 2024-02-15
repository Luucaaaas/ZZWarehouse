<?php
//connexion bdd
require_once 'bdd.php';

//utilisateur deja connecte ?
session_start();
if (isset($_SESSION['email'])) {
    header("Location: accueil.php");
    exit();
}



// Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilisateurs WHERE email = '$email' AND mot_de_passe = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['email'] = $email;
        header("Location: accueil.php");
        exit();
    } else {
        $loginError = "Email ou mot de passe invalides";
    }
}

//inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification de l'adresse e-mail existante
    $existingEmailQuery = "SELECT COUNT(*) AS count FROM utilisateurs WHERE email = '$email'";
    $existingEmailResult = $conn->query($existingEmailQuery);

    if ($existingEmailResult) {
        $row = $existingEmailResult->fetch_assoc();
        $count = $row['count'];

        if ($count > 0) {
            $signupError = "Cette adresse e-mail est déjà renseignée";
        } else {
            $insertQuery = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES ('$nom', '$prenom', '$email', '$password')";
            if ($conn->query($insertQuery) === TRUE) {
                $message = "L'utilisateur $nom, $prenom a été créé avec succès.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/index.css">
    <title>ZZWarehouse | Login</title>
    <link rel="icon" href="../img/logogsbpetit.ico" type="image/x-icon">
</head>
<body>
<div class="container">
    <div class="image-container"></div>
    <div class="info-container">
        <div class="gsblogo"><a href="/BTS/index.php"><img src="../img/logogsb.png"></a></div>
        <?php if (isset($message)) : ?><div class="message"><p><?php echo $message; ?></p></div><?php endif; ?>
        <?php if (isset($loginError)) { echo '<p class="error">' . $loginError . '</p>'; } ?>
        <?php if (isset($signupError)) { echo '<p class="error">' . $signupError . '</p>'; } ?>
        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="signup">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Mot de passe" required><br>
                    <input type="submit" name="login" value="Se connecter">
                </form>
            </div>

            <div class="login">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="text" name="nom" placeholder="Nom" required><br>
                    <input type="text" name="prenom" placeholder="Prénom" required><br>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Mot de passe" required><br>
                    <input type="submit" name="signup" value="S'inscrire">
                </form>
            </div>
        </div>
    </div>
</body>
</html>