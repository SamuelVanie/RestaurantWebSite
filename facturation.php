<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Liste des parametres de connection
$serverName = "localhost:3306";
$dbName = "restaurant_kone";
$userName = "pi";
$password = "";
$idBadge = "";
$montantTotal = 0;
$output = [];
$error;

session_start();

try{
  $db = new PDO('mysql:host='.$serverName.';dbname='.$dbName.';charset=utf8', $userName, $password);
}catch(Exception $e){
 die('Erreur :'.$e->getMessage()); 
}

// Récupération du Montant total
if(!isset($_GET['montantTotal']) && isset($_GET['idBadge']) ){
    exec("sudo python3 /usr/local/bin/read_rfid.py", $output, $error);
    $idBadge = $output[0];
    $idBadge = substr(strval($idBadge), 0, -2);
    $badgeQuery = "SELECT * FROM Badge WHERE IdBadge=".$idBadge.";";
    $badgeStatement = $db->prepare($badgeQuery);
    $badgeStatement->execute();
    $donnees = $badgeStatement->fetch($mode = PDO::FETCH_ASSOC);
    $_SESSION['donnees'] = $donnees;
    
    if($donnees){
      $_SESSION['fBadgeExiste'] = true;
    }else{
      $_SESSION['fBadgeExiste'] = false;
    }
}

// Connection à la base de données


// Initialisation des requêtes
if($_SESSION['fBadgeExiste'] == true){
	$query = "SELECT * FROM Plat;"; // Récupération de la liste des plats
	$statement = $db->prepare($query);
	$statement->execute();

	$plats = $statement->fetchAll();

	var_dump($_SESSION['donnees']);
	$getEtudiantQuery = "SELECT NomEt, PrenomEt FROM Etudiant WHERE MatriculeEt="."'".$_SESSION['donnees']['MatriculeEt']."'".";";
	$getEtudiantStatement = $db->prepare($getEtudiantQuery);
	$getEtudiantStatement->execute();

	$infoEtudiant = $getEtudiantStatement->fetch($mode = PDO::FETCH_ASSOC);
        $montantActuel = $_SESSION['donnees']['MontantBadge'];
        $nouveauMontant = intval($montantActuel) - intval($_GET['montantTotal']);
	if($nouveauMontant>0){
		$updateQuery = "UPDATE Badge SET MontantBadge=".$nouveauMontant." WHERE IdBadge=".$_SESSION['donnees']['IdBadge'].";"; 
		$updateStatement = $db->prepare($updateQuery);
		$_SESSION['successUpdate'] = $updateStatement->execute();
	}else{
		$_SESSION['successUpdate'] = false;
	}
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Store - KONESTO</title>
    <meta name="description" content="Chaîne de restauration de MME KONE">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body style="background:linear-gradient(rgba(47, 23, 15, 0.65), rgba(47, 23, 15, 0.65)), url('assets/img/bg.jpg');">
    <h1 class="text-center text-white d-none d-lg-block site-heading"><span class="text-primary site-heading-upper mb-3">FOTAMANA&nbsp;</span><span class="site-heading-lower">KONESTO</span></h1>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark py-lg-4" id="mainNav">
        <div class="container"><a class="navbar-brand text-uppercase d-lg-none text-expanded" href="#">KONESTO</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navbarResponsive"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">ACCUEIL</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">A PROPOS</a></li>
                    <li class="nav-item"><a class="nav-link" href="addStudent.php?idBadge=scanner&amp;">AJOUTER ETUDIANT</a></li>
                    <li class="nav-item"><a class="nav-link" href="recharger.php?idBadge=scanner&amp;">RECHARGER</a></li>
                    <li class="nav-item"><a class="nav-link" href="facturation.php?idBadge=scanner&amp;">Facturation</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.html">SERVICES</a></li>
                    <li class="nav-item"><a class="nav-link" href="gestionPlats.php">PLATS</a></li>
                    <li class="nav-item"><a class="nav-link" href="store.html">HORAIRES</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="page-section cta">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="text-center cta-inner rounded" style="display: flex;flex-direction: column;">
              <h2 class="section-heading mb-5"><span class="section-heading-upper">BON APPETIT</span><span class="section-heading-lower">FACTURATION</span></h2>

			<?php if($_SESSION['fBadgeExiste']==true && !isset($_GET['montantTotal'])){ ?>
                        <span style="align-self: center;">
                          <?php echo $infoEtudiant['NomEt'].' '.$infoEtudiant['PrenomEt']; ?>
                        </span>
                        <span id="montantActuel" style="font-weight: bold;padding-top: 0.5em;padding-bottom: 3em;">
                          <?php echo $_SESSION['donnees']['MontantBadge']." FCFA"; ?>
                        </span>

                      
                        <ul id="listPlat" class="list-unstyled text-start mx-auto list-hours mb-5">
                          <?php 
                            foreach($plats as $plat){ 
                          ?>
                              <li id="plat<?php echo $plat['IdPlat']; ?>" class="d-flex list-unstyled-item list-hours-item">
                                <?php echo $plat['NomPlat']; ?>
                                <span class="ms-auto" id="prixPlat"><?php echo $plat['MontantPlat'].'FCFA'; ?></span>
                                <button id="btnAjouter<?php echo $plat['IdPlat']; ?>" class="btn"><i class="fa fa-plus-square"></i></button>
                                <button id="btnRetirer<?php echo $plat['IdPlat']; ?>" class="btn"><i class="fa fa-minus-square"></i></button>
                                <span id="compteur<?php echo $plat['IdPlat']; ?>"></span>
                              </li>
                          <?php 
                            } 
                          ?>
                        </ul>
                        <div class="row">
                            <div class="col-8">
                                <span id="montantTotal" style="font-weight: bold;align-self: end;">0</span> FCFA
                            </div>
                            <div class="col-4">
                                <button id="btnValider" name="btnValider" class="btn btn-primary align-self: end;">Valider</button>
                            </div>
                        </div>
			<?php }else if($_SESSION['fBadgeExiste']==false){ ?>
			<div class="alert alert-warning" role="alert"><strong>Attention: </strong>Vous ne pouvez pas acheter car ce badge n'est pas enregistré<br><a href="inscription.php?idBadge=scanner&amp;">Cliquez ici</a> pour l'enregistrer</div>
			<?php }else if(isset($_GET['montantTotal']) && $_SESSION['successUpdate']==true){ ?>
			<div class="alert alert-success" role="alert"><strong>Réussite: </strong>Vos achats ont été enregistré</div>
			<?php }else if(isset($_GET['montantTotal']) && $_SESSION['successUpdate']==false){ ?>
			<div class="alert alert-danger" role="alert"><strong>Erreur: </strong>Votre solde est insuffisant, pensez à recharger votre badge<br><a href="recharger.php?idBadge=scanner&amp;">Cliquer ici</a> pour le rechargement</div>
			<?php } ?>
                        <p class="address mb-5"><em><strong>INP-HB</strong><span><br>Yamoussoukro</span></em></p>
                        <p class="address mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="page-section about-heading">
        <div class="container"><img class="img-fluid rounded about-heading-img mb-3 mb-lg-0" src="assets/img/about.jpg">
            <div class="about-heading-content">
                <div class="row">
                    <div class="col-lg-10 col-xl-9 mx-auto">
                        <div class="bg-faded rounded p-5">
                            <h2 class="section-heading mb-4"><span class="section-heading-upper">KONESTO VOUS PROPOSE</span><span class="section-heading-lower">DE BON PLATS</span></h2>
                            <p>Nous vous fournissons de merveilleux plats traditionnels africains, mais aussi des plats européens afin que vous pouviez découvrir de nouveaux horizons. Ne vous préoccupez plus d'avoir la monnaie, en tant qu'étudiant de l'INP-HB, vous pouvez régler la facture grâçe à votre badge INP.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="text-center footer text-faded py-5">
        <div class="container">
            <p class="m-0 small">Copyright&nbsp;©&nbsp;KONESTO 2022</p>
        </div>
    </footer>
    <script src="js/facturation.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/current-day.js"></script>
</body>

</html>
