var listPlats = document.querySelectorAll('li[id*="plat"]');
var montantTotal = document.getElementById('montantTotal');
var btnValider = document.getElementById('btnValider');

btnValider.addEventListener('click', function(){
    var montant = montantTotal.innerHTML;
    window.location.href = "facturation.php?montantTotal="+montant;
})

for(var i = 0; i < listPlats.length; i++){
    let button = listPlats[i].children[1];

    button.addEventListener('click', function(){
        let compteur = parseInt(button.nextElementSibling.nextElementSibling.innerHTML);

        if(compteur){
            compteur++;
        }else{
            compteur = 1;
        }

        button.nextElementSibling.nextElementSibling.innerHTML = compteur.toString();

        var mt = parseInt(montantTotal.innerHTML)+ parseInt(button.previousElementSibling.innerHTML);

        montantTotal.innerHTML = mt.toString();
    });
}

for(var i = 0; i < listPlats.length; i++){
    let button = listPlats[i].children[2];

    button.addEventListener('click', function(){
        let compteur = parseInt(button.nextElementSibling.innerHTML);
        if(compteur > 0){
            var mt = parseInt(montantTotal.innerHTML) - parseInt(button.previousElementSibling.previousElementSibling.innerHTML);
            montantTotal.innerHTML = mt.toString();
        }
        if(compteur){
            if(compteur > 0){
                compteur--;
            }else{
                compteur = 0;
            }
        }else{
            compteur = 0;
        }

        button.nextElementSibling.innerHTML = compteur.toString();

        
    });
}