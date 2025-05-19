<?php
ob_start();
session_start();
require_once('DATA_connect.php');
if ($_SESSION['logged_in'] != true) {
    header('Location:login.php');
    exit;
}

if (isset($_POST['Supprimer'])) {
    // Dans votre Affiche_Client.php, vous affichez "Cl " au début de l'ID
    // str_replace("Cl ", "", $_POST['IDcli']) serait plus approprié
    $IDcli = str_replace("Cl ", "", $_POST['IDcli']);
    
    // Forcer le type entier pour plus de sécurité
    $IDcli = (int)$IDcli;
    
    // Vérifier que l'ID est valide
    if ($IDcli <= 0) {
        die("ID client invalide");
    }
    
    // Option 1: Supprimer d'abord les achats, puis le client (deux requêtes séparées)
    $sql1 = "DELETE FROM achat WHERE IDCli = ?";
    $stmt1 = mysqli_prepare($connex, $sql1);
    
    if (!$stmt1) {
        die("Erreur de préparation (achats): " . mysqli_error($connex));
    }
    
    mysqli_stmt_bind_param($stmt1, "i", $IDcli);
    $resultat1 = mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
    
    // Maintenant supprimer le client
    $sql2 = "DELETE FROM client WHERE idcli = ?";
    $stmt2 = mysqli_prepare($connex, $sql2);
    
    if (!$stmt2) {
        die("Erreur de préparation (client): " . mysqli_error($connex));
    }
    
    mysqli_stmt_bind_param($stmt2, "i", $IDcli);
    $resultat2 = mysqli_stmt_execute($stmt2);
    
    if ($resultat2) {
        mysqli_stmt_close($stmt2);
        header('location:Affiche_Client.php');
        exit;
    } else {
        die("Erreur lors de la suppression du client: " . mysqli_error($connex));
    }
}
?>