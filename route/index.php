<?php
// Connexion bdd
require_once 'bdd.php';

$session_lifetime = 10; // tps en seconde

session_set_cookie_params($session_lifetime);


//déjà connecté ?
session_start();
if (isset($_SESSION['email'])) {
    header("Location: accueil.php");
    exit();
}

// login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // requêtes préparées (injections SQL attention)
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verification du mdp
        if (password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['email'] = $email;
            session_regenerate_id();
            header("Location: accueil.php");
            exit();
        } else {
            $loginError = "Email ou mot de passe invalides";
        }
    } else {
        $loginError = "Email ou mot de passe invalides";
    }

    $stmt->close();
}
// singup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // mail existant deja ?
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    if ($count > 0) {
        $signupError = "Cette adresse e-mail <br> est déjà renseignée";
    } else {
        // Hashage mdp
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ajout utilisateur garce a la requette prepare 
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $prenom, $email, $hashedPassword);
        if ($stmt->execute()) {
            $message = "L'utilisateur <br> $nom, $prenom <br> a été créé avec succès.";
        }
    }

    $stmt->close();
}

$conn->close();
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