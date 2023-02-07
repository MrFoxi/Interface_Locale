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

    if(!empty($_POST)){

        $session = $_POST['session'];

        // var_dump($session);

        //On va chercher les id de salle et de jour pour choper les noms
        $id_salle_selectionnee = idSalleSession_Id($session);
        $id_jour_selectionne = idJourSalle_Id($id_salle_selectionnee[0]);
        

        // var_dump($id_jour_selectionne, intval($id_salle_selectionnee));

        //Maintenant on peut choper les noms
        $nom_salle = titreSalle_Id($id_salle_selectionnee[0]);
        
        $nom_jour = titreJour_Id($id_jour_selectionne);
        
        $nom_session = titreSession_Id($session);
        
        
    }

    $host = 'localhost';
        $dbname = 'document';
        $username = 'root';
        $password = '';
        $dsn = "mysql:host=$host;dbname=$dbname"; 
        $intervenant_sql = "SELECT id, nom, prenom FROM intervenant";
        $session_sql = "SELECT id, titre FROM session";
        try{
            $pdo = new PDO($dsn, $username, $password);
            $intervenant_stmt = $pdo->query($intervenant_sql);
            
            if($intervenant_stmt === false){
            die("Erreur");
            }
            
        }catch (PDOException $e){
            echo $e->getMessage();
        }

        try{
            $pdo = new PDO($dsn, $username, $password);
            $session_stmt = $pdo->query($session_sql);
            
            if($session_stmt === false){
            die("Erreur");
            }
            
        }catch (PDOException $e){
            echo $e->getMessage();
        }

    $token = explode('=', $_SERVER['REQUEST_URI']);
    $recuperation = idTitreDescTdnuminumsDocument_Td($token[1]);

    $num_intervenant = $recuperation['num_intervenant'];
    $num_session = $recuperation['num_session'];
    $nom_prenom_intervenant = nomPrenomTpIntervenant_Id($num_intervenant);

    $titre_session = titreSession_Id($num_session);

    // attributs de la table document
    $id = $recuperation['id'];
    $title = $recuperation['titre'];
    $descrip = $recuperation['description'];
    $token_document = $recuperation['token_document'];
    $nom_Intervenant = $nom_prenom_intervenant['nom'];
    $prenom_Intervenant = $nom_prenom_intervenant['prenom'];
    var_dump($token_document);
    
    //test si la variable est nulle
    if(isset($_FILES['fileupload'])){
        
        unlink("Jour/$nom_jour[0]/$nom_salle/$nom_session/$token_document");
        $tmpName = $_FILES['fileupload']['tmp_name'];
        $name = $_FILES['fileupload']['name'];
        $size = $_FILES['fileupload']['size'];
        $error = $_FILES['fileupload']['error'];
        var_dump($tmpName, $name);
        $_SESSION['flash']['success'] = 'Transfert vers le dossier local complété.';
        //transfert de fichier
    
        $token_document = explode('.', $token_document);
        $extension = explode('.' ,$name);
        // var_dump($token_document, $test);
        // var_dump($test);
        // move_uploaded_file($tmpName, "Session/Session_".$_POST['session']."/".$token_document[0].".".$test[1]."");
        move_uploaded_file($tmpName, "Jour/$nom_jour[0]/$nom_salle/$nom_session/$token_document[0].".$extension[1]."");
        // var_dump("Jour/$nom_jour[0]/$nom_salle[0]/$nom_session/$token_document[0].".$test[1]."");
        
        $lien = $token_document[0].".".$extension[1];
        var_dump($lien);

        //Creation du fichier .bat
        unlink("Jour/$nom_jour[0]/$nom_salle/$nom_session/".$token_document[0].".bat");
        $bathfilebat = fopen("Jour/$nom_jour[0]/$nom_salle/$nom_session/$token_document[0].bat","w");
        $txtbat = "start C:/wamp64/www/InterfaceLocale/Attente_AVEF.mp4
                    start C:/wamp64/www/InterfaceLocale/Jour/$nom_jour[0]/$nom_salle/$nom_session/$token_document[0].vbs
                    timeout 7
                    TASKKILL /f /im Video.UI.exe ";
        fwrite($bathfilebat, $txtbat);
        fclose($bathfilebat);

        //Creation du fichier .vbs
        unlink("Jour/$nom_jour[0]/$nom_salle/$nom_session/".$token_document[0].".vbs");
        $bathfilevbs = fopen("Jour/$nom_jour[0]/$nom_salle/$nom_session/$token_document[0].vbs","w");
        $txtvbs = "set shell = CreateObject('WScript.Shell')
                    shell.SendKeys '^{PGUP}'
                    WScript.Sleep 1000
                    shell.SendKeys '{ESC}'
                    shell.Run('C:/wamp64/www/InterfaceLocale/Jour/$nom_jour[0]/$nom_salle/$nom_session'.'/'.$lien.'')
                    WScript.Sleep 7000
                    shell.SendKeys '{F5}'";
        fwrite($bathfilevbs, $txtvbs);
        fclose($bathfilevbs);
        var_dump($token_document);
        // var_dump($_FILES['fileupload']);
        // var_dump($_POST['intervenant']);

        if(isset($_POST['text_area'])){

            $new_description = $_POST['text_area'];
            $new_titre = $_POST['title'];
            //rajouter le nom de la connexion utilisateur pour le "author"
            updateDocumentTitreDescAncienNomTdNumIntNumS_Id($new_titre, $new_description, $name, $lien, $_POST['intervenant'], $_POST['session'], $id);
            //redirection vers la page de présentation
            header("location: ./Presentations.php");
        }
    }
    ?>
    <div id="forms">
        <form action="" method="post" enctype="multipart/form-data" class="form-example">
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
                        <input type="text" placeholder="Exemple : Caféine et corps humain." name="title"
                            value="<?=$title?>" id="input_title" required>
                            <img id="check_title" class="check" src="images/Green_check.svg.png" width="20px">
                        </div>

                        <div id="description">
                            <label for="name">
                                <h2>Description</h2>
                            </label>
                            <textarea cols="30" id="text_area" name="text_area" class="text"
                            placeholder="Description..."><?=$descrip?></textarea>
                            <img id="check_descrip" class="check" src="images/Green_check.svg.png" width="20px">
                        </div>
                    </div>

                    <div id="small_box">

                    <label>
                        <h2>Mes Documents</h2>
                    </label>
                    <div>
                        <input type="file" id="fileupload" name="fileupload" value="importer un document" required>
                        <img id="check_doc" class="check" hidden src="images/Green_check.svg.png" width="20px">
                    </div>

                    <label>
                        <h2>Intervenant</h2>
                    </label>
                    <div>
                        <select class="select" name="intervenant" required id="liste_intervenants">
                        <?php while($row = $intervenant_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                                <?php
                                    if($row['id'] == $num_intervenant) {
                                        $selected_intervenant = 'selected';
                                    } else {
                                        $selected_intervenant = '';
                                    }
                                ?>
                            <option name="intervenant" value="<?= $row['id']?>" <?=$selected_intervenant;?>>
                                <?php echo htmlspecialchars(($row['nom']));echo " "; echo htmlspecialchars(($row['prenom'])); ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                        <img id="check_ppl" class="check" src="images/Green_check.svg.png" width="20px">
                    </div>
                    <label>
                        <h2>Session</h2>
                    </label>
                    <div>
                        <select class="select" name="session" required id="liste_sessions">
                            <?php while($row = $session_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                                <?php
                                    if($row['id'] == $num_session) {
                                        $selected_session = 'selected';
                                    } else {
                                        $selected_session = '';
                                    }
                                ?>
                            <option name="session" value="<?= $row['id']?>" <?=$selected_session;?>>
                                <?php echo htmlspecialchars(($row['titre'])); ?>
                            </option>
                            <?php endwhile; ?>
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