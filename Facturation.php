<?php
ob_start();
session_start();
require_once('DATA_connect.php');

if ($_SESSION['logged_in'] != true) {
  header('Location:login.php');
  exit;
}

include("connection.php");

$requete = $bdd->query("SELECT Client.IDcli, Voiture.IDvoit, Voiture.Design, Voiture.Prix, Achat.Qte, (Voiture.Prix * Achat.Qte) as montant 
                        FROM Client 
                        INNER JOIN Achat ON Client.IDcli = Achat.IDCli 
                        INNER JOIN Voiture ON Achat.IDvoit = Voiture.IDvoit");

$donnees = $requete->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
  <link rel="stylesheet" href="BOOTSTRAP/bootstrap-offline-docs-5.1/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="style.css">
   <script src="BOOTSTRAP/js/bootstrap.min.js" ></script>
    <script src="BOOTSTRAP/bootstrap-offline-docs-5.1/dist/js/bootstrap.bundle.min.js" ></script>
    <script src="jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="Gestion bg-dark text-white ">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <ul class="Gest nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <span class="fs-4 mt-1"><p class="Titre h1 " >GESTION DE VENTE DE VOITURE</p></span>
        </ul>

        
        <form class=" col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 "  method="GET">
          <!-- <label class="col-sm-4 form-label"  for="RECHERCHE"><h6>RECHERCHE :</h6></label> -->
          <div class="recherche" >
          <input class="form-control" type="search" placeholder="          Tapez Ici !" name="Tapez_Ici" >
          
          <div class="actualiser" >
          <button class="Supp btn btn-primary icon-search " type = "submit" name = "recherche" ></button>
          <button id="actualiser" class="actualiser  btn btn-dark icon-refresh " type = "submit" name = "actualiser" ></button>
          </div>
          </div>  
        </form>
        </div>


      </div>
</div>

<main>
  <div class="NAV d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
    <ul class="nav nav-pills flex-column mb-auto">
      <li><img src="Images/logo.png" class="GestionLogo rounded rounded-circle img-fluid " alt="Client" width="200" height="200"></li>
      <li >
        <a href="Dashboard.php" class="nav-link text-white " aria-current="page">
          <svg class="bi me-2 " width="16" height="16"><use xlink:href="#home"></use></svg>
          <span class="icon-bar-chart" ></span><span class="Titre" >    STATISTIQUE</span> 
        </a>
      </li>
      <li class="nav-item " >
        <a href="Affiche_Client.php" class="nav-link text-white ">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
          <span class="icon-group"></span><span class="Titre" >    CLIENTS</span> 
        </a>
      </li>
      <li>
        <a href="Affiche_Voiture.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
          <span class="icon-truck"></span><span class="Titre" >    VOITURES</span> 
        </a>
      </li>
      <li>
        <a href="Affiche_Achat.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
          <span class="icon-shopping-cart"></span><span class="Titre" >    ACHATS</span> 
        </a>
      </li>
      <li>
        <a href="#" class="nav-link active">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
          <span class="icon icon-list-alt"></span><span class="Titre" >    FACTURES</span> 
        </a>
      </li>
    </ul>
    <hr>
    <div class="btn">
      <a href="logout.php" class="d-flex align-items-center text-white text-decoration-none " id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <strong><span class="icon icon-signout" ></span class="Titre" >        Deconnexion</strong>
      </a>
      </div>
  </div>
  <div class="ListeClient">
    <div class="container-fluid">
    <h2 class="mb-4">Liste des Factures</h2>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID Client</th>
          <th>ID Voiture</th>
          <th>Design</th>
          <th>Prix (Ar)</th>
          <th>Quantité</th>
          <th>Montant (Ar)</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($donnees as $ligne): ?>
          <tr>
            <td><?php echo $ligne['IDcli']; ?></td>
            <td><?php echo $ligne['IDvoit']; ?></td>
            <td><?php echo $ligne['Design']; ?></td>
            <td><?php echo $ligne['Prix']; ?></td>
            <td><?php echo $ligne['Qte']; ?></td>
            <td><?php echo $ligne['montant']; ?></td>
            <td>
              <a type="button" class="btn btn-primary icon-print" href="Versionpdf.php?id=<?php echo $ligne['IDcli']; ?>" target="_blank"></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
    </div>

<!---------------------------------------------------------------------------------------------------------->
</main>
<script>
function submitForm() {
  document.querySelector('form').submit();
}

// Code pour afficher le modal une fois que la page est chargée
window.addEventListener('load', function() {
  var myModal = new bootstrap.Modal(document.getElementById('facture'));
  myModal.show();
});
</script>

</body>
</html>