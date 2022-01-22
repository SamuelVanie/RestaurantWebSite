var btnAjouter = document.getElementById('btnAjouter');
var nameInput = document.getElementById('nameInput');
var costInput = document.getElementById('costInput');

btnAjouter.addEventListener('click', function(event){
    var champInvalide = isEmpty(nameInput) || isEmpty(costInput);
    if(champInvalide){
        alert("Vous n'avez pas rempli au moins un des champs");
        event.preventDefault();
    }else{
        var reponse = confirm("Le plat et le montant saisis sont-ils corrects ?\nSi oui, cliquez sur OK pour effecture le rechargement");
        
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