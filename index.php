<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ZZWarehouse";

$conn = new mysqli($servername, $username, $password, $dbname);


// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier les informations d'identification dans la base de données
    $sql = "SELECT * FROM utilisateurs WHERE email = '$email' AND mot_de_passe = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Utilisateur trouvé, rediriger vers la page d'accueil ou une autre page sécurisée
        header("Location: accueil.php");
        exit();
    } else {
        $loginError = "Identifiants invalides";
    }
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Insérer les informations de l'utilisateur dans la base de données
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES ('$nom', '$prenom', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        // Utilisateur inscrit avec succès, rediriger vers la page de connexion
        header("Location: login.php");
        exit();
    } else {
        $signupError = "Une erreur s'est produite lors de l'inscription : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="index.css">
    <title>ZZWarehouse | Login</title>
    <link rel="icon" href="source/logogsbpetit.ico" type="image/x-icon">    
</head>
<body>
    <div class="container">
        <div class="image-container"></div>
            <div class="info-container">
                    <h2>Connexion</h2>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Mot de passe" required><br>
                    <input type="submit" name="login" value="Se connecter">
                </form>
                <?php if (isset($loginError)) { echo '<p class="error">' . $loginError . '</p>'; } ?>

                <h2>Inscription</h2>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="nom" placeholder="Nom" required><br>
                <input type="text" name="prenom" placeholder="Prénom" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Mot de passe" required><br>
                <input type="submit" name="signup" value="S'inscrire">
            </form>
            <?php if (isset($signupError)) { echo '<p class="error">' . $signupError . '</p>'; } ?>
        </div>
    </div>
</div>
</div>
</body>
</html>     



