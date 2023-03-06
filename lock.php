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
    <div id="forms">
        <form id="" action="" method="post" class="form-example">
            <?php
                require 'database.php';

                // On récupère la session dans l'url pour rediriger après le submit
                $session = $_GET['session'];
                
                $checked = '';
                $unchecked = '';
                // on récupère l'information sur le status du cadenas dans l'url 
                $status_checked = $_GET['lock'];

                // on garde en mémoire l'info pour selectionner par avance le status
                // meilleur feedback utilisateur
                if($status_checked == 1) {
                    $unchecked = 'checked';
                } else {
                    $checked = 'checked';
                }
                // le bouton selectionné envoi sa valeur dans le POST pour changer l'état juste après
                if(array_key_exists('cadenas', $_POST)){
                    $etatCadenas = $_POST['cadenas'];
                }
                // si le bouton submit est appuyé on retourne sur la page présentation avec le status du cadenas changé
                if(isset($_POST['cadenas'])){ 
                    // echo "presentations.php?lock='$etatCadenas'";
                    header("Location: presentations.php?lock=$etatCadenas&session=$session");
                }
            ?>
        <div id="big_box_unlock">
            <div>
                <input style="cursor: pointer;top: 35.8%;left: 34.8%" value="1" class="btn-modif" type="radio" name="cadenas" <?= $unchecked?>>
                <img style="width: 200px;height:200px;position: fixed;top: 36%;left: 35%;" src="images/ouvrir.png"/>
            </div>
            <div>
                <input style="cursor: pointer;top: 35.8%;right: 34.8%" value="0" class="btn-modif" type="radio" name="cadenas" <?= $checked?>>
                <img style="width: 200px;height:200px;position: fixed;top: 36%;right: 35%;" src="images/fermer.png"/>
            </div>
            <input value="Valider" id="btn-validez" type="submit">
        </div>
        </form>
    </div>
</body>

</html>