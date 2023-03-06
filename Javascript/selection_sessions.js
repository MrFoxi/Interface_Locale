window.onload = () => {

    //On va aller chercher la valeur de l'option selectionnée
    //pour afficher le resultat en fonction de ce qu'on a choisit
    //page Session.php
    console.log("Page chargée");

    var ligne_selectionnee_jour = document.getElementById("liste_jours");
    var ligne_selectionnee_salle = document.getElementById("liste_salles");
    console.log(ligne_selectionnee_salle);
    ligne_selectionnee_jour.addEventListener('click', mise_a_jour);
    ligne_selectionnee_salle.addEventListener('input', mise_a_jour_salle);

    //met juste le jour dans l'url
    function mise_a_jour(valeur_selectionnee){

        let select = valeur_selectionnee.target;
        console.log(select.value); 
        var url = `Session.php?jour=${select.value}&salle=Salle_1-${select.value}`;
        window.location.href = url;
    }
    
    //On va chercher l'url et le split pour retirer le jour
    function separation () {

        url = window.location.href;
        const listeUrl = url.split("?");

        jour = listeUrl[1];
        console.log("jour => " + jour);

        jour = jour.split("&");
        console.log(jour);
        
        jour = jour[0].split("=");

        return jour[1];
    }

    //met la salle a jour dans l'url en gardant le jour
    function mise_a_jour_salle(valeur_selectionnee, jour){

        jour = separation();
        let select = valeur_selectionnee.target;
        console.log(select.value); 
        var url = `Session.php?jour=${jour}&salle=${select.value}`;
        window.location.href = url;
        console.log(select, url);
    }

    
}