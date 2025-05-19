<?php
ob_start();
include 'DATA_connect.php';

if (isset($_POST['Modifier'])) {
    // Récupérer et nettoyer les données du formulaire
    $NumAchat = str_replace("A", "", $_POST['NumAchat']);
    $IDCli = str_replace("Cl", "", $_POST['idcli']);
    $IDvoit = str_replace("V", "", $_POST['idvoit']);
    $Date = $_POST['Date'];
    $Qte = $_POST['Qte'];

    // Convertir en entiers pour éviter les injections SQL
    $NumAchat = (int)$NumAchat;
    $IDCli = (int)$IDCli;
    $IDvoit = (int)$IDvoit;
    $Qte = (int)$Qte;

    if (!empty($IDCli) && !empty($IDvoit) && !empty($Date) && $Qte > 0) {
        // Récupérer les informations originales de l'achat
        $sql_original = "SELECT idcli, idvoit, qte FROM Achat WHERE NumAchat = $NumAchat";
        $result_original = mysqli_query($connex, $sql_original);
        
        if (!$result_original) {
            die("Erreur lors de la récupération des informations originales: " . mysqli_error($connex));
        }
        
        $original_data = mysqli_fetch_assoc($result_original);
        $original_idcli = $original_data['idcli'];
        $original_idvoit = $original_data['idvoit'];
        $original_qte = $original_data['qte'];
        
        // Vérifier le stock pour la nouvelle voiture si elle a changé
        if ($original_idvoit != $IDvoit) {
            $sql_check_stock = "SELECT Nombre FROM Voiture WHERE idvoit = $IDvoit";
            $result_check_stock = mysqli_query($connex, $sql_check_stock);
            
            if (!$result_check_stock) {
                die("Erreur lors de la vérification du stock: " . mysqli_error($connex));
            }
            
            $stock_info = mysqli_fetch_assoc($result_check_stock);
            
            if ($stock_info['Nombre'] < $Qte) {
                die("Quantité trop élevée, il reste " . $stock_info['Nombre'] . " voiture(s) dans le stock !");
            }
            
            // Restituer le stock à l'ancienne voiture
            $sql_restore = "UPDATE Voiture SET Nombre = Nombre + $original_qte WHERE idvoit = $original_idvoit";
            $result_restore = mysqli_query($connex, $sql_restore);
            
            if (!$result_restore) {
                die("Erreur lors de la restitution du stock: " . mysqli_error($connex));
            }
            
            // Réduire le stock de la nouvelle voiture
            $sql_reduce = "UPDATE Voiture SET Nombre = Nombre - $Qte WHERE idvoit = $IDvoit";
            $result_reduce = mysqli_query($connex, $sql_reduce);
            
            if (!$result_reduce) {
                die("Erreur lors de la réduction du stock: " . mysqli_error($connex));
            }
        } 
        // Si même voiture mais quantité différente
        else if ($original_qte != $Qte) {
            $diff = $original_qte - $Qte;
            
            // Vérifier s'il y a assez de stock si on augmente la quantité
            if ($diff < 0) {
                $needed = abs($diff);
                $sql_check = "SELECT Nombre FROM Voiture WHERE idvoit = $IDvoit";
                $result_check = mysqli_query($connex, $sql_check);
                $stock = mysqli_fetch_assoc($result_check)['Nombre'];
                
                if ($stock < $needed) {
                    die("Quantité trop élevée, il reste " . $stock . " voiture(s) dans le stock !");
                }
            }
            
            // Ajuster le stock
            $sql_adjust = "UPDATE Voiture SET Nombre = Nombre + $diff WHERE idvoit = $IDvoit";
            $result_adjust = mysqli_query($connex, $sql_adjust);
            
            if (!$result_adjust) {
                die("Erreur lors de l'ajustement du stock: " . mysqli_error($connex));
            }
        }
        
        // Mettre à jour l'achat avec une requête simple
        $sql_update = "UPDATE Achat SET 
                      idcli = $IDCli,
                      idvoit = $IDvoit,
                      dateachat = '$Date',
                      qte = $Qte
                      WHERE NumAchat = $NumAchat";
        
        $result_update = mysqli_query($connex, $sql_update);
        
        if (!$result_update) {
            die("Erreur lors de la mise à jour de l'achat: " . mysqli_error($connex));
        }
        
        header('location:Affiche_Achat.php');
        exit;
    } else {
        die("Veuillez remplir tous les champs du formulaire correctement!");
    }
}
?>