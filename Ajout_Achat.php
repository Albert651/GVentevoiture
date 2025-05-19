<?php
ob_start();


        include 'DATA_connect.php';

        if (isset($_POST['Ajouter'])) {
            $IDcli = mysqli_real_escape_string($connex, str_replace("Cl","",$_POST['idcli']));
            $IDvoit = mysqli_real_escape_string($connex, str_replace("V","",$_POST['idvoit']));
            $Date = mysqli_real_escape_string($connex, $_POST['Date']);
            $Qte = mysqli_real_escape_string($connex, $_POST['Qte']);


                
            if (!empty($IDcli) || !empty($IDvoit) || !empty($Date) && !empty($Qte) ) {

            // Récupère la quantité disponible de la voiture sélectionnée
            $sql = "SELECT Nombre FROM Voiture WHERE idvoit = $IDvoit";
            $result = mysqli_query($connex, $sql);
            $row = mysqli_fetch_assoc($result);
            $quantite_disponible = $row['Nombre'];

            // Vérifie si la quantité entrée est supérieure à la quantité disponible
            if ($_POST['Qte'] > $quantite_disponible) {
                echo "<script>document.getElementById('error-message').innerHTML = 'La quantité entrée est supérieure à la quantité disponible.';</script>";
                exit();
            }else {
                    $sql = "INSERT INTO Achat VALUES('','$IDcli','$IDvoit','$Date', '$Qte')";
                    $resultat = mysqli_query($connex,$sql);
                    $sql1 = "UPDATE Voiture SET Nombre=Nombre-'$Qte' WHERE IDvoit='$IDvoit'";
                    $resultat1 = mysqli_query($connex,$sql1);
                    if ($resultat) {
                        //echo "Ajouter avec success !";
                        header('location:Affiche_Achat.php');
                        }else {
                            die(mysqli_error($resultat));
                        } 
                }
        
                }else {
                    echo "Veillez remplir tout le formulaire !";
                }
            

            
        }

        ob_end_clean();       

?>





