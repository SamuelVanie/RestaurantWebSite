<?php

// Liste des parametres de connection
$serverName = "localhost:3306";
$dbName = "restaurant_kone";
$userName = "pi";
$password = "";

// Connection à la base de données
try{
  $db = new PDO('mysql:host='.$serverName.';dbname='.$dbName.';charset=utf8', $userName, $password);
}catch(Exception $e){
 die('Erreur :'.$e->getMessage()); 
}

// Initialisation des requêtes
$query = "SELECT * FROM Plat;"; // Récupération de la liste des plats
$statement = $db->prepare($query);
$statement->execute();
$plats = $statement->fetchAll(); // Résultat de la requête

if(isset($_POST['nomPlat']) && isset($_POST['montantPlat'])){
  $queryPlat = "INSERT INTO Plat(NomPlat, MontantPlat) VALUE ('".strval($_POST['nomPlat'])."'".",".intval($_POST['montantPlat']).");";
  $statementPlat = $db->prepare($queryPlat);
  $statementPlat->execute();
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
                        <h2 class="section-heading mb-5"><span class="section-heading-upper">BON APPETIT</span><span class="section-heading-lower">PLATS</span></h2>
                        <ul class="list-unstyled text-start mx-auto list-hours mb-5" id="listeRepas">
                            <?php
                              foreach($plats as $plat){
                            ?>
                                <li id="plat<?php echo $plat['IdPlat']; ?>" class="d-flex list-unstyled-item list-hours-item">
                                    <?php echo $plat['NomPlat']; ?>
                                    <span id="prixPlat" class="ms-auto"><?php echo $plat['MontantPlat']; ?></span>
                                </li>
                            <?php 
                              }
                            ?>
                        </ul>
                        <form action="#" method="post">
                            <div class="row">
                                <div class="col-7">
                                    <input type="text" class="form-control form-control" placeholder="Nom du nouveau plat" name="nomPlat" id="nameInput">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control form-control" placeholder="Montant" name="montantPlat" id="costInput">
                                </div>
                                <div class="col-2">
                                    <input type="submit" class="btn btn-primary" name="btnAjouter" value="Ajouter" id="btnAjouter">
                                </div>
                            </div>
                        </form>                        <p class="address mb-5"><em><strong>INP-HB</strong><span><br>Yamoussoukro</span></em></p>
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
    <script src="js/affichage_plats"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/current-day.js"></script>
</body>

</html>
