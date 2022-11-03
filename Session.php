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

<?php
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
            if(file_exists("//serveur\partage\Session_$i")){
                
            } else  {
                mkdir("//serveur\partage\Session_$i");
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
                    <a href="menu.php" style="width: 100px;"><img style="display:block;margin:auto;" src="images/maison.png" id="accueil" width="45px" height="45px"></a>
                </div>
                <div class="titre">
                    <h1>Session</h1>
                </div>
            </div>
                <div id="big_box">
                    <div id="medium_box">
                        <div id="title">
                            <label for="name">
                                <h2>Nombre de session à créer</h2>
                            </label>
                            <input type="number" min="1" value="1" name="session"
                                id="input_title" required>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>TITRE</td>
                                    <td>Date de Création du fichier</td>
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
                    </table>
                    <input id="submit" type="submit">
                    </div>                    
                </div>

                
                
            </form>
    </div>



</body>
</html>