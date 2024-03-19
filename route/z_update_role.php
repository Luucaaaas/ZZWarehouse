<?php
session_start();

require_once 'Database.php';
require_once 'z_int.php';

// si un utilisateur qui n'est pas admin tape l'url alors il est redirigé vers la page d'acceuil
if ($id_role != '1') {
    header("Location:p_accueil.php");
    exit;
}

$database = new Database();

// formulaire soumis ? si oui je les recupere 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUtilisateur = $_POST['id_utilisateur'];
    $idRole = $_POST['id_role'];

    // mise a jour du role ou l utilisateur est selectionner 
    $database->query("UPDATE utilisateurs SET id_role = :id_role WHERE id_utilisateur = :id_utilisateur");
    $database->bind(':id_role', $idRole);
    $database->bind(':id_utilisateur', $idUtilisateur);
    $database->execute();

    // recuperer les info du role qui a été selectioner 
    $database->query("SELECT nom_role FROM roles WHERE id_role = :id_role");
    $database->bind(':id_role', $idRole);
    $role = $database->single();

    // recuperer les infos de l'utilisateur qui a été selectionner 
    $database->query("SELECT nom, prenom FROM utilisateurs WHERE id_utilisateur = :id_utilisateur");
    $database->bind(':id_utilisateur', $idUtilisateur);
    $utilisateur = $database->single();

    $message = "Le rôle " . $role->nom_role . " a bien été attribué à " .$utilisateur->prenom . " " . $utilisateur->nom;
    $_SESSION['messageRole'] = $message;
}

header("Location: p_role.php");
exit;
?>