var idBadge = document.getElementById('idBadge');
var matriculeEtudiant = document.getElementById('matriculeEtudiant');
var nomEtudiant = document.getElementById('nomEtudiant');
var prenomEtudiant = document.getElementById('prenomEtudiant');
var dateNaissEtudiant = document.getElementById('dateNaissEtudiant');
var lieuNaissEtudiant = document.getElementById('lieuNaissEtudiant');
var ecoleEtudiant = document.getElementById('ecoleEtudiant');
var filiereEtudiant = document.getElementById('filiereEtudiant');

var btnValider = document.getElementById('btn_valider');
var scanButton = document.getElementById('scan');
scanButton.addEventListener('click', function(){
    window.location.href = "addStudent.php?idBadge=scanner";
})

var idBadgeFilled = false;
var isFieldsEmpty = true;

// Désactivation de tous les champs
idBadge.disabled = true;

//Gestion d'événement de type input
idBadge.addEventListener('input', function(){
    console.log("changement détecté !")
    idBadgeFilled = true;

    matriculeEtudiant.disabled = false;
    nomEtudiant.disabled = false;
    prenomEtudiant.disabled = false;
    dateNaissEtudiant.disabled = false;
    lieuNaissEtudiant.disabled = false;
    ecoleEtudiant.disabled = false;
    filiereEtudiant.disabled = false;
    btnValider.disabled = false;
});

// Activation des champs

btnValider.addEventListener('click', function(event){
    var champInvalide = isEmpty(matriculeEtudiant) || isEmpty(nomEtudiant) || isEmpty(prenomEtudiant) || isEmpty(dateNaissEtudiant) || isEmpty(lieuNaissEtudiant) || isEmpty(ecoleEtudiant) || isEmpty(filiereEtudiant);
    if(champInvalide){
        alert("Vous n'avez pas rempli tous les champs");
        event.preventDefault();
    }else{
        var reponse = confirm("Toutes les informations saisies sont-elles correctes ?\nSi oui, cliquez sur OK pour envoyer le formulaire");
        
        if(!reponse){
            event.preventDefault();
        }
    }
});

// Déclaration de fonctions
function isEmpty(champ){
    var text = champ.value;

    if(text.trim() == ""){
        console.log("Ce champ est vide")
        return true;
    }

    return false;
}