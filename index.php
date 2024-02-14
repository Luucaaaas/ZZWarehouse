<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ZZWarehouse";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilisateurs WHERE email = '$email' AND mot_de_passe = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        header("Location: accueil.php");
        exit();
    } else {
        $loginError = "Identifiants invalides";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES ('$nom', '$prenom', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {

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
                <div class="main">  	

		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<label for="chk" aria-hidden="true">Sign up</label>

                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Mot de passe" required><br>
                    <input type="submit" name="login" value="Se connecter">
                </form>
                <?php if (isset($loginError)) { echo '<p class="error">' . $loginError . '</p>'; } ?>
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
            <?php if (isset($signupError)) { echo '<p class="error">' . $signupError . '</p>'; } ?>
			</div>
	</div>
</body>
</html>

