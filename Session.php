<!DOCTYPE html>
<html>

<head>
    <title>Interface locale pour transfert de fichiers</title>
    <meta charset="UTF-8">
    <meta name="description" content="Plateforme de Diffusion streaming/replay">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, Bootstrap">
    <meta name="auteurs" content="Xavier Crenn , Clément Perdrix">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/Xavier_css.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <script src="./Javascript/selection_sessions.js" defer></script>
    <!-- Import de JQuery  -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="./Javascript/JQuery.js" defer></script>
</head>

<?php
    //on charge les différentes fonctions pour les requetes SQL
    require "Controller/PHP/requetesSQL.php";
    //test si les champs sont vides
    if(!empty($_POST)){

        //on va chercher les champs pour voir combien faut en créer
        $jour = $_POST['jour'];
        $salle = $_POST['salle'];
        $session = $_POST['session'];
        /////////////////////////////////////JOUR///////////////////////////////////////
        $exists = titreJour();
        $liste_jours = array();
        foreach($exists as $valeur){
            $numero = explode("_", $valeur);
            array_push($liste_jours, $numero[1]); 
        }
        //on verifie si la BDD est vide ou non
        if($exists == false){
            for($i = 1; $i <= $jour; $i++){

                $jour_choisit = "Jour_$i";
                insererJour($jour_choisit);
                if(!file_exists("Jour/Jour_$i")){
                    //on crée le dossier pour y ranger les données
                    mkdir("Jour/Jour_$i");
                }
            }
        }else{
            //On prend le nombre dans le titre qui existe
            //on prend le jour max et on l'additionne plus bas
            $numero_jour = max($liste_jours);
            //on boucle pour créer une ligne par une ligne dans la BDD
            for($j = 1; $j <= $jour; $j++){

                $liste_titres_salles = titreSalleDernierJour();
                //on va chercher le plus gros id des jours pour l'inserer dans salle
                //il existe pas donc faut le prédire
                $id_max = maxID();
                $id_max = $id_max + 1;
                //on déclare le nom pour plus de simpliciter avec la requete
                $addition = $numero_jour + $j;
                $soustraction = $addition - 1;
                $jour_choisit = "Jour_$addition";
                //on insere les valeurs, une à la fois
                insererJour($jour_choisit);
                //on va inserer les nouvelles salles du nouveau jour
                foreach($liste_titres_salles as $titre_salle){
                    //On prend le jour dans le titre de la salle et on le change par le bon chiffre
                    $titre_final = explosionTitre($titre_salle, $jour_choisit);
                    insererSalle($titre_final, $id_max);
                }
                if(!file_exists("Jour/Jour_$addition")){
                    //on crée le dossier pour y ranger les données
                    mkdir("Jour/Jour_$addition");
                    //on va chercher le jour juste avant dans la BDD pour recuperer les salles créées
                    $id_jour_moins_un = idJour_Titre("$soustraction");
                    echo "Jour $soustraction";
                    if(!empty($id_jour_moins_un)){
                        //On va chercher les salles déjà créées pour le nouveau Jour_i qui lui est vide
                        $liste_salles_a_creer = titreSalle_IdJour($id_jour_moins_un[0]);
                        foreach($liste_salles_a_creer as $salle){

                            mkdir("Jour/Jour_$addition/$salle");
                        }
                    }
                }
            }
        }
        /////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////SALLE///////////////////////////////////////
        //on va chercher les titres POTENTIELS de la table jour
        $exists = titreSalle();
        //on va chercher la liste des id de tous les jours présents dans la BDD
        $liste_id_jours = idJour();
        //on verifie si la BDD est vide ou non
        if($exists == false){

            foreach($liste_id_jours as $id_jour){

                intval($id_jour);
                //on va chercher le nom du jour en fonction de son ID pour mettre les salles dans les dossiers jours
                $jour = titreJour_Id($id_jour);
                for($i = 1; $i <= $salle; $i++){

                    $titre = "Salle_$i-$jour[0]";
                    insererSalle($titre, "$id_jour");
                    if(!file_exists("Jour/$jour[0]/$titre")){
                        //on crée le dossier pour y ranger les données
                        mkdir("Jour/$jour[0]/$titre");
                    }
                }
            }
        }else if($salle !=0){
            //on va chercher tous les titres des salle pour avoir le plus grand chiffre et faire +1
            $liste_titres_salles = titreSalle();
            $liste_chiffres_salles = array();
            foreach($liste_titres_salles as $titre_salle){

                $variable = explode("_", $titre_salle);
                $chiffre = explode("-", $variable[1]);
                //on prend juste le chiffre dans le titre de la salle
                array_push($liste_chiffres_salles, $chiffre[0]);
            }
            $max = max($liste_chiffres_salles);
            
            for($i = 1; $i <= $salle; $i++){
                $max = $max + 1;
                
                foreach($liste_id_jours as $id_jour){
                    //conversion de l'id en int
                    intval($id_jour);
                    $jour = titreJour_Id($id_jour);
                    $titre = "Salle_$max-$jour[0]";
                    insererSalle($titre, $id_jour);

                    if(!file_exists("Jour/$jour[0]/$titre")){
                        //on crée le dossier pour y ranger les données
                        mkdir("Jour/$jour[0]/$titre");
                    }
                }
            }    
        }
    }
?>

<body>
    <div id="forms">
        <form action="" method="post" enctype="multipart/form-data" class="form-example">
            <div class="head_box">
                <div class="accueil">
                    <!--Lien peut etre à changer pour rediriger vers le menu-->
                    <a href="menu.php" style="width:100px;"><img style="display:block;margin:auto;"
                            src="images/burger.png" id="accueil" width="45px" height="45px"></a>
                </div>
                <div class="titre">
                    <h1>Gestionnaire de sessions</h1>
                </div>
            </div>
            <div id="big_box">
                <div id="medium_box_session">
                    <div id="gestion_session">

                        <div class="title">
                            <label class="name">
                                <h2>Jour(s)</h2>
                            </label>
                            <div class="ajouter_session">
                                <span>Ajouter</span>
                                <input type="number" min="0" value="0" name="jour" id="input_title">
                                <span>jour(s)</span>
                                <button class="ajouter_element" type="submit">+</button>
                            </div>
                        </div>

                        <div class="title">
                            <label class="name">
                                <h2>Salle(s)</h2>
                            </label>
                            <div class="ajouter_session">
                                <span>Ajouter</span>
                                <input type="number" min="0" value="0" name="salle" id="input_title">
                                <span>salle(s)</span>
                                <button class="ajouter_element" type="submit">+</button>
                            </div>
                        </div>

                        <div class="title">
                            <label class="name">
                                <h2>Session(s)</h2>
                            </label>
                            <div class="ajouter_session">
                                <span>Nom de session : </span>
                                <input type="text" value="" name="session" id="input_text">
                                <button class="ajouter_element" type="submit">+</button>
                            </div>
                        </div>

                    </div>
                    <?php   
                        //on va chercher la variable dans l'url pour la passer de JS a PHP
                        if(empty($_GET)){
                            $jour_selectionne = 0;
                            $salle_selectionnee = 0;
                        }
                        $jour_selectionne = $_GET["jour"];
                        $salle_selectionnee = $_GET["salle"];
                    ?>
                    <div id="gestion_elements">
                        <div class="element">
                            <label class="name">
                                <h2>Liste des jours</h2>
                            </label>
                            <table>
                                <select class="liste_jours_salles_session" id="liste_jours" multiple>

                                    <?php
                                        //on rempli la liste avec les jours de la BDD
                                        $requete_titres_jours = titreJour();
                                        foreach($requete_titres_jours as $titre_jour){
                                            echo"
                                                    <option id='ligne_jour' class='ligne_selectionnable' value='$titre_jour'>$titre_jour</option>";
                                                }
                                    ?>
                                </select>
                            </table>
                        </div>

                        <div class="element">
                            <label class="name">
                                <h2>Salle(s) du <span id="jour_selectionne"><?= $jour_selectionne; ?></span></strong>
                                </h2>
                            </label>
                            <table>
                                <select class="liste_jours_salles_session" id="liste_salles" multiple>

                                    <?php
                                        $jour_explose = explode("_", $jour_selectionne);
                                        $jour_chiffre = $jour_explose[1];
                                        //on passe le chiffre en argument
                                        $id_jour = idJour_Titre($jour_chiffre);
                                        $requete_titres_salles = titreSalle_IdJour($id_jour[0]);
                                        foreach($requete_titres_salles as $titre_salle){
                                            echo"
                                                    <option id='ligne_salle' class='ligne_selectionnable' value='$titre_salle'>$titre_salle</option>";
                                                }
                                    ?>
                                </select>
                            </table>
                        </div>

                        <div class="element">
                            <label class="name">
                                <?php   
                                    //On va chercher l'id de la salle
                                    $id_salle_selectionnee= idSalle_Titre($salle_selectionnee);
                                if(!empty($session)){
                                    //On va inserer l'id de la salle et le nom de la session pour créer une session
                                    $id_salle = intval($id_salle_selectionnee[0]);
                                    $titre_final = str_replace(" ", "_", $session);
                                    insererSession($id_salle, $titre_final, date("Y-m-d H:i:s"));
                                }
                                ?>
                                <h2>Session(s) de la <span id="jour_selectionne"><?= $salle_selectionnee; ?></span></h2>
                            </label>
                            <!-- Creation d'une session  -->
                            <table>
                                <select class="liste_jours_salles_session" multiple>
                                    <?php
                                        //on va chercher les sessions potentielles dans la liste des sessions
                                        $id_salle = intval($id_salle_selectionnee[0]);
                                        $liste_titres_sessions = titreSession_IdSalle($id_salle);
                                    if(!empty($liste_titres_sessions)){
                                        
                                        foreach($liste_titres_sessions as $titre){
                                            echo"
                                                <option>$titre<button type='submit'><i class='glyphicon glyphicon-remove' style='color: red;cursor: pointer;'></i></button></option>
                                            ";
                                            //Faire plus de verifs pour eviter de créer 2 fois la meme session
                                            if(!file_exists("Jour/$jour_selectionne/$salle_selectionnee/$titre") && !empty($session)){

                                                mkdir("Jour/$jour_selectionne/$salle_selectionnee/$titre");
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </table>
                        </div>

                    </div>
                    </table>
                    <!-- <input id="submit" type="submit"> -->
                </div>
            </div>
        </form>
    </div>



</body>

</html>