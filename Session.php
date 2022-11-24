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
</head>

<!-- <?php
require "database.php";
// On recherche si il y a une valeur puis on ajoute pour tant, le nombre de fichier session à créer
if(!empty($_POST)) {
    $session = $_POST['session'];
    for($i = 1; $i <= $session ; $i++){
        $req = $pdo->prepare('SELECT id FROM session WHERE id = ?;');
        $req->execute([$i]);
        $exists = $req->fetchColumn();
        
        if($exists == false){
            $req = $pdo->prepare('INSERT INTO session (created_at) VALUES (?);');
            $req->execute([date("Y-m-d H:i:s")]);
            if(file_exists("Session/Session_$i")){
    
            } else {
                mkdir("Session/Session_$i");
            }
        }
        
    }
    // header("location: ./Presentations.php");
}


?> -->
<?php
    //on va chercher le PDO
    //parametres de connexion de la BDD
    require "database.php";

    //test si les champs sont vides
    if(!empty($_POST)){

        //on va chercher les champs pour voir combien faut en créer
        $jour = $_POST['jour'];
        $salle = $_POST['salle'];
        //$session = $_POST['session'];
        
        /////////////////////////////////////JOUR///////////////////////////////////////
        //on va chercher les titres POTENTIELS de la table jour
        $requete = $pdo->prepare('SELECT titre FROM jour;');
        $requete->execute(['']);
        //on va chercher tous les noms des jours
        $exists = $requete->fetchColumn();
        
        //on verifie si la BDD est vide ou non
        if($exists == false){

            for($i = 1; $i <= $jour; $i++){
                //on déclare le nom pour plus de simpliciter avec la requete
                $jour_choisit = "Jour_$i";
                //on insere les valeurs, une à la fois
                $requete = $pdo->prepare("INSERT INTO jour (titre) VALUES (?);");
                $requete->execute([$jour_choisit]);
                
                if(!file_exists("Jour/Jour_$i")){
                    //on crée le dossier pour y ranger les données
                    // mkdir("Jour/Jour_$i");
                }
            }
        }else{
            //On prend le nombre dans le titre qui existe
            //puis on l'explose pour MAJ notre $i
            $variable = explode("_", $exists);
            $i = 1 + intval($variable[1]);//on recupere le chiffre dans le nom

            //on boucle pour créer une ligne par une ligne dans la BDD
            for($j = 0; $j < $jour; $j++){

                //on va chercher les 
                $requete_titres_salles = $pdo->prepare('SELECT DISTINCT titre FROM salle;');
                $requete_titres_salles->execute(['']);
                $liste_titres_salles = $requete_titres_salles->fetchAll(PDO::FETCH_COLUMN);
                // var_export($liste_titres_salles);
                //on va chercher le plus gros id des jours pour l'inserer dans salle
                //il existe pas donc faut le prédire
                $requete_id_max = $pdo->prepare('SELECT max(id) FROM jour;');
                $requete_id_max->execute(['']);
                $id_max = $requete_id_max->fetchColumn();
                $id_max = $id_max + 1;

                //on va inserer les nouvelles salles du nouveau jour
                foreach($liste_titres_salles as $titre_salle){
                    // var_dump($titre_salle);
                    $requete_inserer_salles = $pdo->prepare('INSERT INTO salle (titre, id_jour) VALUES (?, ?)');
                    $requete_inserer_salles->execute([$titre_salle, $id_max]);
                }

                //on déclare le nom pour plus de simpliciter avec la requete
                $addition = $i + $j;
                $jour_choisit = "Jour_$addition";

                //on insere les valeurs, une à la fois
                $requete = $pdo->prepare("INSERT INTO jour (titre) VALUES (?);");
                $requete->execute([$jour_choisit]);
                
                if(!file_exists("Jour/Jour_$i")){
                    //on crée le dossier pour y ranger les données
                    // mkdir("Jour/Jour_$i");
                }
            }
        }
        /////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////SALLE///////////////////////////////////////
        //on va chercher les titres POTENTIELS de la table jour
        $requete = $pdo->prepare('SELECT titre FROM salle;');
        $requete->execute(['']);
        $exists = $requete->fetchColumn();

        //on va chercher la liste des id de tous les jours présents dans la BDD
        $requete_id_jours = $pdo->prepare('SELECT id FROM jour;');
        $requete_id_jours->execute(['']);
        $liste_id_jours = $requete_id_jours->fetchAll(PDO::FETCH_COLUMN);
        
        //on verifie si la BDD est vide ou non
        if($exists == false){

            foreach($liste_id_jours as $id_jour){
                //conversion de l'id en int
                intval($id_jour);

                for($i = 1; $i <= $salle; $i++){
                    $requete_creation_salle = $pdo->prepare('INSERT INTO salle (titre, id_jour) VALUES (?, ?);');
                    $requete_creation_salle->execute(["Salle_$i", "$id_jour"]);
                }
            }
            //petite condition sinon il rajoute une salle quand on rajoute un jour :=)
        }else if($salle !=0){

            //on va chercher tous les titres des salle pour avoir le plus grand chiffre et faire +1
            $requete_titres_salles = $pdo->prepare('SELECT titre FROM salle;');
            $requete_titres_salles->execute(['']);
            $liste_titres_salles = $requete_titres_salles->fetchAll(PDO::FETCH_COLUMN);
            $liste_chiffres_salles = array();

            //var_dump($liste_titres_salles);

            //on itere pour mettre a dans un array parce que explode prend que 1 argument string
            foreach($liste_titres_salles as $titre_salle){

                $variable = explode("_", $titre_salle);
                //on prend juste le chiffre dans le titre
                array_push($liste_chiffres_salles, $variable[1]);
            }
            $max = max($liste_chiffres_salles);
            $max = $max + 1;//c'est de la merde
            $salle = $salle + $max;
            // var_dump($max, $salle);
            $k = 1;
            foreach($liste_id_jours as $id_jour){
                //conversion de l'id en int
                // echo "je passe $k";
                $k++;
                intval($id_jour);

                $requete_creation_salle = $pdo->prepare('INSERT INTO salle (titre, id_jour) VALUES (?, ?);');
                // echo "coucou$i";
                $requete_creation_salle->execute(["Salle_$max", "$id_jour"]);
                // for($i = 1; $i <= $salle; $i++){
                // }
            }
        }
    }
    /////////////////////////////////////////////////////////////////////////////////
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
                                <input type="number" min="0" value="0" name="jour" id="input_title" required>
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
                                <input type="number" min="0" value="0" name="salle" id="input_title" required>
                                <span>salle(s)</span>
                                <button class="ajouter_element" type="submit">+</button>
                            </div>
                        </div>

                        <!-- <div class="title">
                            <label class="name">
                                <h2>Session(s)</h2>
                            </label>
                            <div class="ajouter_session">
                                <span>Ajouter</span>
                                <input type="number" min="0" value="0" name="session" id="input_title" required>
                                <span>session(s)</span>
                                <button class="ajouter_element" type="submit">+</button>
                            </div>
                        </div> -->
                    </div>
                    <div id="gestion_elements">
                        <div class="element">
                            <label class="name">
                                <h2>Nombre de jour(s)</h2>
                            </label>
                            <!-- Remplir les tables ici bas -->
                            <table>

                            </table>
                        </div>

                        <div class="element">
                            <label class="name">
                                <h2>Salle(s)</h2>
                            </label>
                            <table>
                                
                            </table>
                        </div>

                        <div class="element">
                            <label class="name">
                                <h2>Session(s) de la salle INPUT PHP</h2>
                            </label>
                            <table>
                                
                            </table>
                        </div>

                    </div>
                    <!-- Faire des changements drastiques -->
                    <!-- <table>
                            <thead>
                                <tr>
                                    <td>N°</td>
                                    <td>TITRE</td>
                                    <td>Date de création de la session</td>
                                </tr>
                            </thead>
                        <?php 
                $req = $pdo->prepare('SELECT count(id) FROM session');
                $req->execute();
                $count = $req->fetchColumn();
                
                for($i = 1; $i <= $count ; $i++){
                    if(!empty($_POST["Titre$i"])){
                        $req = $pdo->prepare("UPDATE session SET titre = ? WHERE id = ?");
                        $req->execute([$_POST["Titre$i"], $i]);
                    }

                    $req = $pdo->prepare('SELECT * FROM session WHERE id = ?');
                    $req->execute([$i]);
                    $infos = $req->fetch(PDO::FETCH_ASSOC);
                
                    $id = $infos['id'];
                    $Titre_Session = $infos['titre'];
                    $Created_at = $infos['created_at'];

                    DisplayList($id,$Titre_Session,$Created_at);
                    
                }
                
                function displayList($id, $Titre_Session, $Created_at){
                // Certainement un soucis avec les lignes en dessous
                echo"
                        <tbody>
                            <tr>
                                <td>$id</td>
                                <td><input type='text' name='Titre$id' value='$Titre_Session' id='input_title' ></td>
                                <td>$Created_at</td>
                            </tr>
                        </tbody>";
                }
                ?>
                    </table> -->
                    <!-- <input id="submit" type="submit"> -->
                </div>
            </div>
        </form>
    </div>



</body>

</html>