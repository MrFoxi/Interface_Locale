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
</head>

<body>
    <?php
    require_once './database.php';
    function str_random($length) {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
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


    $token_document = str_random(60);
    //test si la variable est nulle
        if(isset($_FILES['fileupload'])){
            $tmpName = $_FILES['fileupload']['tmp_name'];
            $name = $_FILES['fileupload']['name'];
            $size = $_FILES['fileupload']['size'];
            $error = $_FILES['fileupload']['error'];
            $_SESSION['flash']['success'] = 'Transfert vers le dossier local complété.';
            //transfert de fichier
            $test = explode('.' ,$name);
            var_dump($test);
            move_uploaded_file($tmpName, "C:\wamp64\www\InterfaceLocale\Session/Session_".$_POST['session']."/$token_document.".$test[1]."");

            $bathfilebat = fopen("C:\wamp64\www\InterfaceLocale\Session/Session_".$_POST['session']."/$token_document.bat","w");
            $txtbat = "start C:/wamp64/www/InterfaceLocale/Attente_AVEF.mp4
start C:\wamp64\www\InterfaceLocale\Session/Session_".$_POST['session']."/$token_document.vbs
timeout 7
TASKKILL /f /im Video.UI.exe ";
            fwrite($bathfilebat, $txtbat);
            fclose($bathfilebat);

            $lien = "$token_document.".$test[1]."";

            $bathfilevbs = fopen("C:\wamp64\www\InterfaceLocale\Session/Session_".$_POST['session']."/$token_document.vbs","w");
            $txtvbs = 'set shell = CreateObject("WScript.Shell")
shell.SendKeys "^{PGUP}"
WScript.Sleep 1000
shell.SendKeys "{ESC}"
shell.Run("C:\wamp64\www\InterfaceLocale\Session/Session_'.$_POST['session'].'/'.$lien.'")
WScript.Sleep 7000
shell.SendKeys "{F5}"';
            fwrite($bathfilevbs, $txtvbs);
            fclose($bathfilevbs);
            


            var_dump($_FILES['fileupload']);
            var_dump($_POST['intervenant']);

            if(isset($_POST['text_area'])){

                $description = $_POST['text_area'];
                $title = $_POST['title'];
                //rajouter le nom de la connexion utilisateur pour le "author"
                $req = $pdo ->prepare("INSERT INTO document SET titre = ?, description =  ?,AncienNom = ?, token_document = ?, num_intervenant = ?, num_session = ?, created_at = ?");
                //faut mettre un tableau en params (1 argument seulement accepté)
                $req->execute([$_POST['title'], $_POST['text_area'], $name, $lien, $_POST['intervenant'], $_POST['session'], date("Y-m-d H:i:s")]);
                header("location: ./Presentations.php");
            }
        }
    ?>
    <div id="forms">
        <form action="" method="post" enctype="multipart/form-data" class="form-example">
            <div class="head_box">
                <div class="accueil">
                    <!--Lien peut etre à changer pour rediriger vers le menu-->
                    <a href="menu.php" style="width: 100px;"><img style="display:block;margin:auto;" src="images/maison.png" id="accueil" width="45px" height="45px"></a>
                </div>
                <div class="titre">
                    <h1>Ajouter une présentations</h1>
                </div>
            </div>
            <div id="big_box">


                <div id="medium_box">


                    <div id="title">
                        <label for="name">
                            <h2>Titre de la présentation</h2>
                        </label>
                        <div>
                            <input type="text" placeholder="Exemple : Caféine et corps humain." name="title"
                            id="input_title" required>
                            <img id="check_title" hidden class="check" src="images/Green_check.svg.png" width="20px">
                        </div>
                    </div>


                    <div id="description">
                        <label for="name">
                            <h2>Description</h2>
                        </label>
                        <div>
                            <textarea cols="30" id="text_area" name="text_area" class="text"
                                placeholder="Description..."></textarea>
                                <img id="check_descrip" class="check" hidden src="images/Green_check.svg.png" width="20px">
                        </div>
                    </div>


                </div>


                <div id="small_box">


                    <label>
                        <h2>Mes Documents</h2>
                    </label>
                    <div>
                        <input type="file" id="fileupload" name="fileupload" value="importer un document">
                        <img id="check_doc" class="check" hidden src="images/Green_check.svg.png" width="20px">
                    </div>


                    <label>
                        <h2>Intervenant</h2>
                    </label>
                    <div>
                        <select name="intervenant" required>
                            <option value="">--Veuillez choisir un Intervenant--</option>
                            <?php while($row = $intervenant_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                                <option name="intervenant" value="<?= $row['id']?>">
                                    <?php echo htmlspecialchars(($row['nom']));echo " "; echo htmlspecialchars(($row['prenom'])); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <img id="check_ppl" class="check" hidden src="images/Green_check.svg.png" width="20px">
                    </div>

                    <label>
                        <h2>Session</h2>
                    </label>
                    <div>
                        <select name="session" required>
                            <option value="">--Veuillez choisir une session--</option>
                            <?php while($row = $session_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                                <option name="session" value="<?= $row['id']?>">
                                    <?php echo htmlspecialchars(($row['titre'])); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <img id="check_ppl" class="check" hidden src="images/Green_check.svg.png" width="20px">
                    </div>


                    <a id="submit" type="submit"><button class="enregistrer">Enregistrer</button></a>


                </div>
                
            </div>

        </form>
    </div>
<script>
    var check_titre = document.getElementById("check_title");
    var check_descrip = document.getElementById("check_descrip");
    var check_docs = document.getElementById("check_doc");
    var check_intervenant = document.getElementById("check_ppl");
    var titre = document.getElementById("input_title");
    var descrip = document.getElementById("text_area");
    var docs = document.getElementById("fileupload");
    var intervenant = document.getElementById("liste_intervenants");

    titre.addEventListener('change', function (){
        var titreValide = titre.checkValidity();

        if(titreValide){
            check_titre.hidden = false;
        }else{
            check_titre.disabled = true;
        }
    });
    descrip.addEventListener('change', function (){
        var descripValide = descrip.checkValidity();

        if(descripValide){
            check_descrip.hidden = false;
        }else{
            check_descrip.disabled = true;
        }
    });
    docs.addEventListener('input', function (){
        var docsValide = docs.checkValidity();

        if(docsValide){
            check_docs.hidden = false;
        }else{
            check_docs.disabled = true;
        }
    });
    intervenant.addEventListener('click', function (){
        var listValues = intervenant.value;

        if(intervenant.value[0] != 0){
            check_intervenant.hidden = false;
            console.log(intervenant.value[0])
        }else{
            check_intervenant.disabled = true;
        }
    });

</script>
</body>

</html>