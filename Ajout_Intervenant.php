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

<body>
    <?php
    require_once './database.php';
    function str_random($length) {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

    $token_photo = str_random(60);
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
            $token_photo_link = "$token_photo.".$test[1]."";
            move_uploaded_file($tmpName, "intervenant/$token_photo_link");
            


            var_dump($_FILES['fileupload']);
            // var_dump($_POST['intervenant']);

            if(isset($_POST['nom'])){

                $prenom = $_POST['prenom'];
                $nom = $_POST['nom'];
                //rajouter le nom de la connexion utilisateur pour le "author"
                $req = $pdo ->prepare("INSERT INTO intervenant SET nom = ?, prenom =  ?, token_photo = ?, created_at = ?");
                //faut mettre un tableau en params (1 argument seulement accepté)
                $req->execute([$nom, $prenom,  $token_photo_link, date("Y-m-d H:i:s")]);
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
                    <h1>Ajouter un Intervenant</h1>
                </div>
            </div>
            <div id="big_box">
                <div id="medium_box">
                    <div id="title">
                        <label for="name">
                            <h2>Nom</h2>
                        </label>
                        <input type="text" placeholder="Exemple : Caféine et corps humain." name="nom"
                            id="input_title" required>
                    </div>
                    <div id="title">
                        <label for="name">
                            <h2>Prenom</h2>
                        </label>
                        <input type="text" placeholder="Exemple : Caféine et corps humain." name="prenom"
                            id="input_title" required>
                    </div>
                </div>
                <div id="small_box">
                    <h2>Ma photos</h2>
                    <input type="file" id="fileupload" name="fileupload" accept=".png,.jpg,.jpeg"
                        value="importer votre photo">
                    <input id="submit" type="submit">
                </div>
                
            </div>

        </form>
    </div>

</body>

</html>