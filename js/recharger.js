var idBadge = document.getElementById('idBadge');
var nomEtudiant = document.getElementById('nomEtudiant');
var prenomEtudiant = document.getElementById('prenomEtudiant');
var matriculeEtudiant = document.getElementById('matriculeEtudiant');
var montant = document.getElementById('montant');

var btnValider = document.getElementById('btn_valider');


// Désactivation de tous les champs
idBadge.disabled = true;
nomEtudiant.disabled = true;
prenomEtudiant.disabled=true;
matriculeEtudiant.disabled = true;

// Activation des champs

btnValider.addEventListener('click', function(event){
    if(isEmpty(montant)){
        alert("Vous n'avez saisie aucun montant");
        event.preventDefault();
    }else{
        var reponse = confirm("Le montant saisi est-il correct ?\nSi oui, cliquez sur OK pour effecture le rechargement");
        
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