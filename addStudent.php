<?php
// Insertion sécurisé des données


session_start();

function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$matriculeEtudiant = $idBadge = $nomEtudiant = $prenomEtudiant = $dateNaissEtudiant = $lieuNaissEtudiant = $ecoleEtudiant = $filiereEtudiant = "";

$serverName = "localhost:3306";
$dbName = "restaurant_kone";
$userName = "pi";
$password = "";
$badge = "";
$input = [];
$error;

$db = new mysqli($serverName, $userName, $password, $dbName);
if($db->connect_error){
  die('Erreur :'.$e->getMessage()); 
}

// Récupération de l'id du badge
if(isset($_GET['idBadge']) == "scanner" && !isset($_POST['btnValider'])){
    exec("sudo python3 /usr/local/bin/read_rfid.py", $output, $error);
    $badge = $output[0];
    $badge = substr(strval($badge), 0,-2);
    $syntaxe = "SELECT IdBadge FROM Badge WHERE IdBadge=".intval($badge).";";
    $newQuery = mysqli_query($db, $syntaxe);
    $rowCount = mysqli_num_rows($newQuery);
    if($rowCount>0){
      $_SESSION['iBadgeExiste'] = true;
    }else{ 
      $_SESSION['iBadgeExiste'] = false; 
    }
}


if(isset($_POST['matriculeEtudiant']) && isset($_POST['idBadge']) && isset($_POST['nomEtudiant']) && isset($_POST['prenomEtudiant']) && isset($_POST['dateNaissEtudiant']) && isset($_POST['lieuNaissEtudiant']) && isset($_POST['ecoleEtudiant']) && isset($_POST['filiereEtudiant']) ){
    $matriculeEtudiant = test_input($_POST['matriculeEtudiant']);
    $idBadge = test_input($_POST['idBadge']);
    $nameEtudiant = test_input($_POST['nomEtudiant']);
    $prenomEtudiant = test_input($_POST['prenomEtudiant']);
    $dateNaissEtudiant = test_input($_POST['dateNaissEtudiant']);
    $lieuNaissEtudiant = test_input($_POST['lieuNaissEtudiant']);
    $ecoleEtudiant = test_input($_POST['ecoleEtudiant']);           
    $filiereEtudiant = test_input($_POST['filiereEtudiant']);
    
    // Requêtes d'ajout dans la base de données
    $query = "INSERT INTO Etudiant(MatriculeEt, NomEt, PrenomEt, DateNaissEt, LieuNaissEt, EcoleEt, FiliereEt) VALUE"." ("."'".$matriculeEtudiant."'".','."'".$nameEtudiant."'".','."'".$prenomEtudiant."'".','."'".$dateNaissEtudiant."'".','."'".$lieuNaissEtudiant."'".','."'".$ecoleEtudiant."'".','."'".$filiereEtudiant."'".");";
    $badgeQuery = "INSERT INTO Badge(IdBadge, MontantBadge, MatriculeEt) VALUE (".$idBadge.","."0".","."'".$matriculeEtudiant."'".");";

    $etudQ = mysqli_query($db, $query);
	if($etudQ){
	    $badgeQ = mysqli_query($db, $badgeQuery);
	}else{
	      $_SESSION['iBadgeExiste'] = "etudExiste"; 
	}
    
 
    
    
    $db->close();

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
    <h1 class="text-center text-white d-none d-lg-block site-heading"><span class="text-primary site-heading-upper mb-3">FOTAMANA</span><span class="site-heading-lower">KONESTO</span></h1>
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
                    <div class="text-center cta-inner rounded">
                        <h2 class="section-heading mb-5"><span class="section-heading-upper">de bon plat chez mme kone</span><span class="section-heading-lower">inscription</span></h2>
			<?php if(!isset($_POST['btnValider']) && $_SESSION['iBadgeExiste']==false){ ?>
                        <form action="#" method="post" style="display: flex;margin-bottom: 4em;flex-direction: column;align-items: flex-start;">
                          <small class="form-text">numero de badge</small>
                          <input class="form-control" type="number" name="idBadge" id="idBadge" value="<?php echo $badge; ?>">
                          <small class="form-text">Matricule</small>
                          <input class="form-control" type="text" name="matriculeEtudiant" id="matriculeEtudiant">
                          <small class="form-text">nom</small>
                          <input class="form-control" type="text" name="nomEtudiant" id="nomEtudiant">
                          <small class="form-text">prenom</small>
                          <input class="form-control" type="text" name="prenomEtudiant" id="prenomEtudiant">
                          <small class="form-text">date de naissance</small>
                          <input class="form-control" id="dateNaissEtudiant" name="dateNaissEtudiant" type="date">
                          <small class="form-text">lieu de naissance</small>
                          <input class="form-control" type="text" name="lieuNaissEtudiant" id="lieuNaissEtudiant">
                          <small class="form-text">ecole</small>
                          <input class="form-control" type="text" name="ecoleEtudiant" id="ecoleEtudiant">
                          <small class="form-text">filière</small>
                          <input class="form-control" type="text" name="filiereEtudiant" id="filiereEtudiant">
                          <input id="btn_valider" name="btnValider" class="btn btn-primary" type="submit" value="valider">
                        </form>
			<?php }else if($_SESSION['iBadgeExiste']==true){ ?>
			<div class="alert alert-warning" role="alert"><strong>Attention</strong>: Cet Matricule existe déjà</div>
			<?php }else if(strcmp($_SESSION['iBadgeExiste'], "etudExiste") !== 0){ ?>
			<div class="alert alert-warning" role="alert"><strong>Attention</strong>: Ce etudiant est déjà enregistré</div>
			<?php }else{ ?>
			<div class="alert alert-success" role="alert">Enregistrement <strong>Réussi</strong></div>
			<?php } ?>
                        <p class="address mb-5"><em><strong>inp-hb</strong><span><br>yamoussoukro, côte d'ivoire</span></em></p>
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
                            <h2 class="section-heading mb-4"><span class="section-heading-upper">De BON PLAT POUR LES ETUDIANTS</span><span class="section-heading-lower">&nbsp;A PROPOS</span></h2>
                            <p>Nous vous fournissons de merveilleux plats traditionnels africains, mais aussi des plats européens afin que vous pouviez découvrir de nouveaux horizons. Ne vous préoccupé plus d'avoir la monnaie, en tant qu'étudiant de l'INP-HB, vous pouvez régler la facture grâçe à votre badge INP.</p>
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
    <script src="js/inscription.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/current-day.js"></script>
</body>

</html>
