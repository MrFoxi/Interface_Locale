<!DOCTYPE html>
<html>
    
    <head>
        <title>Interface locale pour transfert de fichiers</title>
        <meta charset="UTF-8">
        <meta name="description" content="Plateforme de Diffusion streaming/replay">
        <meta name="keywords" content="HTML, CSS, JavaScript, PHP, Bootstrap">
        <meta name="auteurs" content="Xavier Crenn , Clément Perdrix">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/xavier_css.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
        <script src="./Javascript/coches_vertes.js" defer></script>
</head>
<body>
    <?php
    require './database.php';
    require 'Controller/PHP/requetesSQL.php';

    //si le formulaire est envoyé et que les données sont récupérées
    if(!empty($_POST)){
        /**
         C'est de la magie noire de recupérer les données titre et description
         Y'a pas de champ title ni de champ text_area dans le formulaire 
         Et pourtant ça fonctionne quand même par la magie du saint esprit
         */
        //variables qui vont etre envoyées à la BDD
        $titre = $_POST['title'];
        $description = $_POST['description'];
        $fichier = $_FILES['fileupload']['name'];
        $intervenant = $_POST['intervenant'];
        $session = $_POST['session'];
        $tmpName = $_FILES['fileupload']['tmp_name'];

        //selection du jour et de la salle pour trouver le chemin où ranger le fichier
        $id_salle_selectionnee = idSalleSession_Id($session);
        $id_jour_selectionne = idJourSalle_Id($id_salle_selectionnee[0]);

        //Maintenant on peut choper les noms des jours, des salles et des sessions
        $nom_salle = titreSalle_Id($id_salle_selectionnee[0]);
        $nom_jour = titreJour_Id($id_jour_selectionne);
        $nom_jour = $nom_jour[0];
        $nom_session = titreSession_Id($session);

        //récupération du token dans l'url pour savoir quel document modifier
        $token = explode('=', $_SERVER['REQUEST_URI']);
        $extension = explode('.', $fichier);
        $extension = $extension[1];
        $juste_token = explode('.', $token[1]);
        $juste_token = $juste_token[0];

        /**
         CHEMIN DE RANGEMENT DU FICHIER
         */
        //variable pour les chemins de rangement des nouvelles données
        $chemin_rangement = "C:/wamp64/www/InterfaceLocale/Jour/$nom_jour/$nom_salle/$nom_session/$juste_token.$extension";

        // on va tout chercher sur un document sauf l'ancien nom
        $recuperation = idTitreDescnuminumsDocument_Td($token[1]);

        //variables de récuperation (anciennes données qui vont etre mises à jour)
        $num_intervenant = $recuperation['num_intervenant'];
        $num_session = $recuperation['num_session'];
        $ancien_nom_session = titreSession_Id($num_session);
        $nom_prenom_intervenant = nomPrenomTpIntervenant_Id($num_intervenant);

         /**
         CHEMIN DE PRELEVEMENT DU FICHIER
         */
        //chemin d'accès au fichier à supprimer avec le unlink plus bas
        $chemin_prelevement = "C:/wamp64/www/InterfaceLocale/Jour/$nom_jour/$nom_salle/$ancien_nom_session/$token[1]";

        // attributs de la table document récupérés
        $id = $recuperation['id'];
        $title = $recuperation['titre'];
        $descrip = $recuperation['description'];
        $nom_Intervenant = $nom_prenom_intervenant['nom'];
        $prenom_Intervenant = $nom_prenom_intervenant['prenom'];

        //on met à jour la base de données dans la table document
        unlink($chemin_prelevement);
        move_uploaded_file($tmpName, $chemin_rangement);
        updateDocumentTitreDescAncienNomTdNumIntNumS_Id($titre, $description, $fichier, $juste_token.'.'.$extension, $intervenant, $session, $id);
        // echo "La base de données a été mise à jour";
        header("location: ./Presentations.php");
        
        //on va chercher la liste des intervenants et des sessions
        $intervenant_stmt = nomPrenomIdIntervenant();
        $session_stmt = idTitreSession();

    }else{
        //si la page est appelée sans POST, on va chercher les données du document à modifier
        //on vient chercher le token dans l'url pour savoir quelles informations recupérer dans la BDD
        $token = explode('=', $_SERVER['REQUEST_URI']);
        $recuperation = idTitreDescnuminumsDocument_Td($token[1]);
        $num_session = $recuperation['num_session'];
        $num_intervenant = $recuperation['num_intervenant'];
        $nom_prenom_intervenant = nomPrenomTpIntervenant_Id($num_intervenant);

        // attributs de la table document récupérés
        $title = $recuperation['titre'];
        $descrip = $recuperation['description'];
        $nom_Intervenant = $nom_prenom_intervenant['nom'];
        $prenom_Intervenant = $nom_prenom_intervenant['prenom'];

        //on va chercher la liste des intervenants et des sessions
        $intervenant_stmt = nomPrenomIdIntervenant();
        $session_stmt = idTitreSession();
    }
   
    ?>
    <div id="forms">
        <form id="formulaire" action="" method="post" enctype="multipart/form-data" class="form-example">
            <div class="head_box">
                <div class="accueil">
                    <!--Lien peut etre à changer pour rediriger vers le menu-->
                    <a href="menu.php" style="width: 100px;"><img style="display:block;margin:auto;"
                            src="images/burger.png" id="accueil" width="45px" height="45px"></a>
                </div>
                <div class="titre">
                    <h1>EDITEUR DE PRESENTATION</h1>
                </div>
            </div>
            <div id="big_box">

                <div id="medium_box">

                    <div id="title">

                        <label for="name">
                            <h2>Titre de la présentation</h2>
                        </label>
                        <!-- INPUT POUR LE TITRE AVEC LA COCHE VERTE -->
                        <input type="text" placeholder="Exemple : Caféine et corps humain." name="title"
                            value="<?=$title?>" id="input_title" required>
                            <img id="check_title" class="check" src="images/Green_check.svg.png" width="20px">
                        </div>

                        <div id="description">
                            <label for="name">
                                <h2>Description</h2>
                            </label>
                            <!-- INPUT POUR LA DESCRIPTION AVEC LA COCHE VERTE-->
                            <textarea form="formulaire" cols="30" id="text_area" name="description" class="text"
                            placeholder="Description..."><?=$descrip?></textarea>
                            <img id="check_descrip" class="check" src="images/Green_check.svg.png" width="20px">
                        </div>
                    </div>

                    <div id="small_box">

                    <label>
                        <h2>Mes Documents</h2>
                    </label>
                    <div>
                        <!-- INPUT DU FICHIER A UPLOAD AVEC COCHE -->
                        <input type="file" id="fileupload" name="fileupload" value="importer un document" required>
                        <img id="check_doc" class="check" hidden src="images/Green_check.svg.png" width="20px">
                    </div>

                    <label>
                        <h2>Intervenant</h2>
                    </label>
                    <div>
                        <!-- LISTE DES INTERVENANTS -->
                        <select class="select" name="intervenant" required id="liste_intervenants">
                        <?php 
                        // itération sur les intervenants de la BDD
                            foreach($intervenant_stmt as $row){
                                // on choisit l'intervenant qui s'occupe de la présentation à modifier
                                if($row['id'] == $num_intervenant) {
                                    $selected_intervenant = 'selected';
                                } else {
                                    $selected_intervenant = '';
                                }
                                //on vient chercher les données de l'intervenant
                                $id = $row['id'];
                                $nom = $row['nom'];
                                $prenom = $row['prenom'];
                                // on affiche les données de l'intervenant dans la liste
                                echo "<option name='intervenant' value=' $id' $selected_intervenant>";
                                echo htmlspecialchars(($nom));echo " "; echo htmlspecialchars(($prenom));
                                echo "</option>";
                            }
                            ?>

                        </select>
                        <img id="check_ppl" class="check" src="images/Green_check.svg.png" width="20px">
                    </div>
                    <label>
                        <h2>Session</h2>
                    </label>
                    <div>
                        <!-- LISTE DES SESSIONS -->
                        <select class="select" name="session" required id="liste_sessions">
                            <?php foreach($session_stmt as $row){

                                if($row['id'] == $num_session) {
                                     $selected_session = 'selected';
                                 } else {
                                     $selected_session = '';
                                 }
                                 $id = $row['id'];
                                 $titre = $row['titre'];
                                 echo "<option name='session' value='$id' $selected_session>";
                                 echo htmlspecialchars(($titre));
                                 echo "</option>";
                            }
                                ?>
                        </select>
                        <img id="check_session" class="check" src="images/Green_check.svg.png" width="20px">
                        <input id="submit" type="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>