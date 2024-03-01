<?php
require_once 'Database.php';
session_start();

$database = new Database();

//verif requete si la requête est une requete POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'ID du stock a été transmis
    if (isset($_POST['id_stock'])) {
        $idStock = $_POST['id_stock'];
        // requete pour suppr dans la base
        $sql = "DELETE FROM stocks WHERE id_stock = :id_stock";
        $database->query($sql);
        $database->bind(':id_stock', $idStock);
        $database->execute();

        // stocker le message pour lafficher apres
        $_SESSION['confirmation_message'] = "La colonne a été supprimé avec succès.";

        // remetttre l utlisateur sur la page stock
        header("Location: p_stock.php");
        exit();
    }
}
?>