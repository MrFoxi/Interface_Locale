window.onload = () => {

    //accusé de reception
    console.log("la page est complètement chargée");

    var check_titre = document.getElementById("check_title");
    var check_descrip = document.getElementById("check_descrip");
    var check_docs = document.getElementById("check_doc");
    var check_intervenant = document.getElementById("check_ppl");
    var check_session = document.getElementById("check_session");

    var titre = document.getElementById("input_title");
    var descrip = document.getElementById("text_area");
    var docs = document.getElementById("fileupload");
    var intervenant = document.getElementById("liste_intervenants");
    var session = document.getElementById("liste_sessions");
    var count = 0;

    titre.addEventListener('change', function () {
        var titreValide = titre.checkValidity();

        if (titreValide) {
            check_titre.hidden = false;
            if (check_titre.hidden == false && check_session.hidden == false && check_intervenant.hidden ==
                false && check_docs.hidden == false) {
                bouton = document.getElementById("submit_button");
                bouton.disabled = false;
            }
        } else {
            check_titre.hidden = true;
        }
    });

    descrip.addEventListener('change', function () {
        var descripValide = descrip.checkValidity();

        if (descripValide) {
            check_descrip.hidden = false;
        } else {
            check_descrip.hidden = true;
        }
    });
    docs.addEventListener('input', function () {
        var docsValide = docs.checkValidity();

        if (docsValide) {
            check_docs.hidden = false;
        } else {
            check_docs.hidden = true;
        }
    });
    intervenant.addEventListener('click', function () {
        var listValues = intervenant.value;

        if (intervenant.value[0] != 0) {
            check_intervenant.hidden = false;
            console.log(intervenant.value[0])
            if (check_titre.hidden == false && check_session.hidden == false && check_intervenant.hidden ==
                false && check_docs.hidden == false) {
                bouton = document.getElementById("submit_button");
                bouton.disabled = false
            }
        } else {
            check_intervenant.hidden = true;
        }
    });
    session.addEventListener('click', function () {
        var listValues = session.value;

        if (session.value[0] != 0) {
            check_session.hidden = false;
            if (check_titre.hidden == false && check_session.hidden == false && check_intervenant.hidden ==
                false && check_docs.hidden == false) {
                bouton = document.getElementById("submit_button");
                bouton.disabled = false;
            }
        } else {
            check_session.hidden = true;
        }
    });

    console.log(count)
    console.log(check_descrip.style.visibility);

    if (check_titre.hidden == false && check_session.hidden == false && check_intervenant.hidden == false &&
        check_docs.hidden == false) {
        bouton = document.getElementById("submit_button");
        bouton.disabled = false
    }
}