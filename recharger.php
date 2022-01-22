<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


// Insertion sécurisé des données
function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$idBadge = $nomEtudiant = $prenomEtudiant = $matriculeEtudiant = $montantBadge = "";

session_start();

$serverName = "localhost:3306";
$dbName = "restaurant_kone";
$userName = "pi";
$password = "";
$badge = "";
$input = [];
$error;

try{
  $db = new PDO('mysql:host='.$serverName.';dbname='.$dbName.';charset=utf8', $userName, $password);
}catch(Exception $e){
  die('Erreur :'.$e->getMessage());
}

// Récupération de l'id du badge

if(isset($_GET['idBadge']) == "scanner" && !isset($_POST['btnValider'])){
    exec("sudo python3 /usr/local/bin/read_rfid.py", $output, $error);
    $badge = $output[0];
    $badge = substr(strval($badge), 0, -2);
    
    $firstQuery = "SELECT Badge.MatriculeEt, NomEt, PrenomEt FROM Badge INNER JOIN Etudiant ON Badge.MatriculeEt = Etudiant.MatriculeEt WHERE IdBadge=".$badge.";";
    $statement = $db->prepare($firstQuery);
    $statement->execute();
    $donnees = $statement->fetch($mode=PDO::FETCH_ASSOC);
    if($donnees){
      $_SESSION["idBadge"] = $badge;
      $_SESSION["badgeExiste"] = true;
    }else{
      $_SESSION["badgeExiste"] = false; 
    }
}

if(isset($_POST['btnValider'])){
  $idBadge = test_input($_SESSION["idBadge"]);
  $montantBadge = test_input($_POST['montantBadge']);
  $ancienMontantQuery = "SELECT MontantBadge FROM Badge WHERE IdBadge=".intval($idBadge).";";
  $ancienMontantStatement = $db->prepare($ancienMontantQuery);
  $ancienMontantStatement->execute();
  $ancienMontant = $ancienMontantStatement->fetch($mode=PDO::FETCH_ASSOC);  

  $nouveauMontant = intval($ancienMontant['MontantBadge']) + intval($montantBadge);

  $query = "UPDATE Badge SET MontantBadge=".$nouveauMontant." WHERE IdBadge=".intval($idBadge).";";
  
  $statement2 = $db->prepare($query);
  $statement2->execute();
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
                        <h2 class="section-heading mb-5"><span class="section-heading-upper">DE BON PLAT CHEZ MME KONE</span><span class="section-heading-lower">RECHARGER</span></h2>
			<?php if(!isset($_POST['btnValider']) && $_SESSION['badgeExiste']==true){ ?>
                        <form method="POST" action="#" style="display: flex;margin-bottom: 4em;flex-direction: column;align-items: flex-start;">
                          <small class="form-text">Numéro de Badge</small>
                          <input class="form-control" type="number" name="idBadge" id="idBadge" value="<?php echo $badge; ?>">
                          <small class="form-text">Nom</small>
                          <input class="form-control" type="text" name="nomEtudiant" value="<?php echo $donnees['NomEt']; ?>" id="nomEtudiant">
                          <small class="form-text">Prenom</small>
                          <input class="form-control" type="text" name="prenomEtudiant" value="<?php echo $donnees['PrenomEt']; ?>" id="prenomEtudiant">
                          <small class="form-text">Matricule</small>
                          <input class="form-control" type="text" name="matriculeEtudiant" value="<?php echo $donnees['MatriculeEt']; ?>" id="matriculeEtudiant">
                          <small class="form-text">Montant</small>
                          <input class="form-control" type="number" name="montantBadge" id="montant">
                          <input id="btn_valider" name="btnValider" class="btn btn-primary" type="submit" value="Valider">
                        </form>
			<?php }else if($_SESSION['badgeExiste']==false){ ?>
			<div class="alert alert-danger" role="alert">Badge non existant: <a href="addStudent.php?idBadge=scanner">Cliquez ici pour l'enregistrer</a></div>
			<?php }else{ ?>
			<div class="alert alert-success" role="alert">Rechargement réussi</div>
			<?php } ?>
                        <p class="address mb-5"><em><strong>INP-HB</strong><span><br>Yamoussoukro, Côte d'Ivoire</span></em></p>
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
    <script src="js/recharger.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/current-day.js"></script>
</body>

</html>
