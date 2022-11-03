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
    <link rel="stylesheet" href="css/Xavier_css_3.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">

</head>
<?php

/*
    Appel de la Base de Données
*/

require "database.php";

    /*
        On vient chercher si le cadenas est ouvert ou fermer enregistré dans la base de données
        Puis on associe si il est ouvert ou fermé à $cadenas_properties
    */
    $req = $pdo->prepare('SELECT cadenas FROM lock_unlock');
    $req->execute();
    $cadenas = $req->fetchColumn();
    if($cadenas == true) {
        $cadenas_properties = 'ouvrir';
    } else {
        $cadenas_properties = 'fermer';
    }


    /*
        Création d'une liste allant chercher tous les valeurs dans la table session de la base de données
    */

    $host = 'localhost';
    $dbname = 'document';
    $username = 'root';
    $password = '';
    $dsn = "mysql:host=$host;dbname=$dbname"; 
    $session_sql = "SELECT id, titre FROM session";

    try{
        $pdo = new PDO($dsn, $username, $password);
        $session_stmt = $pdo->query($session_sql);
        
        if($session_stmt === false){
        die("Erreur");
        }
        
    }catch (PDOException $e){
        echo $e->getMessage();
    }

        

    /*
        Ici on cherche quelle était la dernière session lancé avant de changer de page pour la réafficher ensuite
    */
        $req = $pdo->prepare('SELECT session FROM lock_unlock');
        $req->execute();
        $cadenas_session = $req->fetchColumn();
        $titre_session = "Veuillez choisir une session";
        if(isset($_POST['session'])){
            $req = $pdo->prepare('SELECT titre FROM session WHERE id = ?');
            $req->execute([$_POST['session']]);
            $titre_session = $req->fetchColumn();
            
        } else {
            $req = $pdo->prepare('SELECT titre FROM session WHERE id = ?');
            $req->execute([$cadenas_session]);
            $titre_session = $req->fetchColumn();
        }



        
?>
<body>
    <div id="forms">
        <form id="" action="" enctype="multipart/form-data" method="post" class="form-example">
        <div class="head_box">
            <?php if($cadenas_properties == 'ouvrir'): ?>
                <div class="accueil">
                    <!--Lien peut etre à changer pour rediriger vers le menu-->
                    <a href="menu.php" style="width: 100px;"><img style="display:block;margin:auto;" src="images/maison.png" id="accueil" width="45px" height="45px"></a>
                </div>
            <?php endif;?>
                <div class="titre">
                    <h1><?=$titre_session;?></h1>
                </div>
            </div>
            
            
            <div id="big_box">
                
                <ul id="presta_box">
                    <?php
                        
                        /*
                            Ici on vient compter le nombre de document au total
                        */

                        $req = $pdo->prepare('SELECT count(id) FROM document');
                        $req->execute();
                        $count = $req->fetchColumn();

                        /*
                            Puisqu'on à le nombre de document au total on va venir un par un regarder les informations avec un "FOR" et en limite le nombre de document au total
                        */

                        for($i = 1; $i <= $count ; $i++){

                            /*
                                Récupération du titre, de la description, de l'ancien nom et du token_document en fonction de l'id
                            */

                            $req = $pdo->prepare("SELECT titre, description, AncienNom, token_document, num_intervenant FROM document WHERE id = $i");
                            $req->execute();
                            $infos = $req->fetch(PDO::FETCH_ASSOC);

                            /*
                                Récupération de l'id de l'intervenant stocké dans document pour faire à nouveau une requête pour afficher les noms, prénoms, photos des intervenant
                            */

                            $num_intervenant = $infos['num_intervenant'];

                            $req = $pdo->prepare("SELECT nom, prenom, token_photo FROM intervenant WHERE id = ?");
                            $req->execute([$num_intervenant]);
                            $nom_prenom_intervenant = $req->fetch(PDO::FETCH_ASSOC);

                            /*
                                Toutes les variables qu'on voudra utiliser à afficher
                            */

                            $title = $infos['titre'];
                            $descrip = $infos['description'];
                            $AncienNom = $infos['AncienNom'];
                            $token = $infos['token_document'];
                            $nom_intervenant = $nom_prenom_intervenant['nom'];
                            $prenom_intervenant = $nom_prenom_intervenant['prenom'];
                            $token_photo = $nom_prenom_intervenant['token_photo'];

                            /*
                                Si il y a une session d'affiché via la liste manuelle
                                On va aller chercher les documents de la session saisie à afficher
                                
                                Sinon on va chercher dans la base de données la valeur de la session précédente et l'afficher avec tout les documents qui vont avec
                            */

                            if(isset($_POST['session'])){
                                $req = $pdo->prepare('SELECT num_session FROM document WHERE id = ?');
                                $req->execute([$i]);
                                $num_session = $req->fetchColumn();
                                

                                if($_POST['session'] == $num_session){
                                    displayList($title, $descrip, $AncienNom, $token, $nom_intervenant, $prenom_intervenant, $token_photo, $num_session, $cadenas_properties);
                                }
                            } else {
                                
                                $req = $pdo->prepare('SELECT num_session FROM document WHERE id = ?');
                                $req->execute([$i]);
                                $num_session = $req->fetchColumn();

                                if($cadenas_session == $num_session){
                                    displayList($title, $descrip, $AncienNom, $token, $nom_intervenant, $prenom_intervenant, $token_photo, $num_session, $cadenas_properties);
                                }
                            }
                                                                 
                        }

                        /*
                            On a ici la fonction qui sert à afficher un document avec toutes les informations situées dans les paramètres
                        */

                        function displayList($title, $descrip, $AncienNom, $token, $nom_intervenant, $prenom_intervenant, $token_photo, $num_session, $cadenas_properties){

                            $token = explode('.', $token);
                            
                            echo "<li id='presta_list'>";
                            echo "<div id='pp_box'><img src ='intervenant/$token_photo' id='pp'></div>";
                            echo "<div id='list'>";
                            echo "<h1>";
                            echo "$title";
                                    echo "</h1>";
                                    
                                    echo "<p>";
                                    echo "$nom_intervenant $prenom_intervenant";
                                    echo "</p>";

                                    echo "<p>";
                                    echo "$descrip";
                                    echo "</p>";

                                    echo "<h4>";
                                    echo "$AncienNom";
                                    echo "</h4>";
                                echo '</div>';
                                echo "<div class='lien'><a href='../InterfaceLocale/Session/Session_$num_session/".$token[0].".bat'><button data-modal-target='#\modal' class='btn-primary' type='button'><img id='fleche-photo' src='images/green_rounded_triangle.png'></button></a></div>";
                                if($cadenas_properties == 'ouvrir'){
                                    echo "<div><a href='Editer?=".$token[0].".".$token[1]."'><img style='width:100px;height:100px;' src='images/trois-points.png'/></a></div>";
                                }
                            echo "</li>";
                                                   
                        }                        
                    ?>
                <!-- -->
                </ul>
            </div>
            <!-- Afficher ou pas si le cadenas est fermé ou ouvert -->
            <?php if($cadenas_properties == 'ouvrir'): ?>
                <center><h2><a href="AjouteurDePresentations.php">Cliquez ici pour ajouter une présentation</a></h2></center>
                <p>                        </p>
                
                <form method="post">
                    <select name="session">
                        <?php while($row = $session_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option name="session" value="<?= $row['id']?>">
                                <?php echo htmlspecialchars(($row['titre'])); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <input type="submit">
                </form>
            <?php endif;?>
        </form>
        
    </div>
    <?php

        $session_cad = $cadenas_session;
        if(isset($_POST['session'])) {
            $session_cad = $_POST['session'];
        }
    ?>
    <a href="lock.php?<?=$session_cad;?>" style="padding: 2px;background-color:#fff;border-radius:25%; position:fixed; top:10px; right:10px; width: 20px;height: 20px; z-index: 9;">
        <img style="position:fixed; top:12px; right:12px; width: 20px;height: 20px; z-index: 10;" src="images/<?=$cadenas_properties;?>"/>
    </a>
</body>

</html>