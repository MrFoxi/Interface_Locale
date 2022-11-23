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
        $session = $_POST['session'];
        
        //on va chercher les titres POTENTIELS de la table jour
        $requete = $pdo->prepare('SELECT titre FROM jour;');
        $requete->execute(['']);
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

                        <div class="title">
                            <label class="name">
                                <h2>Session(s)</h2>
                            </label>
                            <div class="ajouter_session">
                                <span>Ajouter</span>
                                <input type="number" min="0" value="0" name="session" id="input_title" required>
                                <span>session(s)</span>
                                <button class="ajouter_element" type="submit">+</button>
                            </div>
                        </div>
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