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
    <script defer src="./Javascript/gestion_cadenas.js"></script>
</head>
<?php
    // Lien avec les autres pages pour les fonctions
    require "database.php";
    require "./Controller/PHP/requetesSQL.php";
    require "./Controller/config/config.php";
    // On récupère l'id de la session envoyé dans le form et on la met dans l'url
    if(array_key_exists('bouton_letsgo', $_POST)){
        header("location: presentations.php?lock=1&session=".$_POST['session']."");
    }
    // On vient chercher si le cadenas est ouvert ou fermé à partir de l'url
    // Puis on associe son status à $cadenas_properties

    $cadenas_status = $_GET['lock'];
    // On prend la session de base à partir de l'url
    // C'est un ID
    $session_de_base = $_GET['session'];

    if($cadenas_status == 1) {
        $cadenas_properties = 'ouvrir';
    } else {
        $cadenas_properties = 'fermer';
    }
    try{
        // Variables présentent dans le fichier de config
        $session_stmt = sessionValide($dsn, $username, $password, $session_sql);
        if($session_stmt === false){
            die("Erreur, session invalide");
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
    $cadenas_session = sessionStatus();
    $titre_session = "Veuillez choisir une session";
    // Si le formualire de session est vide ou pas
    if(isset($_POST['session'])){
        $titre_session = titreSession_Id($_POST['session']);
        $id_salle = idSalleSession_Titre($titre_session);
        
    } else if(!isset($_POST['session'])) {
        $id_salle = $session_de_base;
        $titre_session = titreSession_Id($id_salle);
    } else {
        $titre_session = "Veuillez choisir une session";
    }
    /**
            REQUETES POUR CHOPER LES JOURS ET SALLES 
        JUSTE POUR CHANGER LE LIEN DANS LE BOUTON TELECHARGER
                            😳
    */
    $id_salle = $session_de_base;
    $titre_salle = titreSalle_Id($id_salle);
    $id_jour = idJourSalle_Id($id_salle);
    $titre_jour = titreJour_Id($id_jour);
    $titre_session = titreSession_Id($id_salle);
?>

<body>
    <div id="forms">
        <form id="" action="" enctype="multipart/form-data" method="post" class="form-example">
            <div class="head_box">
                <?php if($cadenas_properties == 'ouvrir'): ?>
                <div class="accueil">
                    <!--Lien peut etre à changer pour rediriger vers le menu-->
                    <a href="menu.php" style="width: 100px;"><img style="display:block;margin:auto;"
                            src="images/burger.png" id="accueil" width="45px" height="45px"></a>
                </div>
                <?php endif;?>
                <div class="titre">
                    <h1><?=$titre_session;?></h1>
                </div>
            </div>
            <div id="big_box">
                <ul id="presta_box">
                    <?php
                        // On va déjà chercher la session dans l'url
                        // On a besoin de savoir combien de presentations il y a dans une session d'ou countId()
                        $count = countId();
                        /**
                          TROUVER UNE SOLUTION POUR N4IMPORTE QUEL ID DE DOCUMENT
                          AFFICHE LES BONNES PRESTA AU BON ENDROIT
                          ET TOUT CA EN FONCTION DE L4URL
                         */

                        for($i = 1; $i <= $count ; $i++){

                            // On met à jour lesinformations pour itérer sur les différentes présentations
                            $infos = tdatokenDocument_Id($i); // titre, description, ancien_nom, token_document
                            $num_intervenant = numintervenantDocument_Id($i); // num_intervenant
                            $nom_prenom_intervenant = nomPrenomTpIntervenant_Id($num_intervenant); // nom prenom token
                            $session_du_document = numsessionDocument_Id($i);
    
                            $title = $infos['titre'];
                            $descrip = $infos['description'];
                            $AncienNom = $infos['AncienNom'];
                            $token = $infos['token_document'];
                            $nom_intervenant = $nom_prenom_intervenant['nom'];
                            //on met le numero de session juste pour afficher la page de base, grâce à session de base
                            // $num_session = $session_de_base;
                            $prenom_intervenant = $nom_prenom_intervenant['prenom'];
                            $token_photo = $nom_prenom_intervenant['token_photo'];

                            // Verification de l'appartenence du document à la bonne session (actuelle)
                            if($session_de_base == $session_du_document){

                                displayList($title, $descrip, $AncienNom, $token, $nom_intervenant, $prenom_intervenant, $token_photo, $cadenas_properties, $session_de_base);                            
                            }
                        }
                        //Affichage de la liste des présentations
                        //AJOUTER LA PHOTO DE PROFIL EN FONCTION DE LA PERSONNE
                        function displayList($title, $descrip, $AncienNom, $token, $nom_intervenant, $prenom_intervenant, $token_photo, $cadenas_properties){

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
                                echo '</div>'; //Télécharger</button>
                                echo "<div data-modal-target='#modal' class='lien'><a href=''><input name='button1' class='btn-primary' type='submit' value='Lancer'/></a></div>";
                                if($cadenas_properties == 'ouvrir'){
                                    echo "<div id='bouton_editer' ><a href='Editer?=".$token[0].".".$token[1]."'><img style='width:50px;height:50px;' src='images/edit.png'/></a></div>";
                                }
                            echo "</li>";                     
                        }
                        /**
                         LA FONCTION ouvrirPpt() DOIT AVOIR UN TUPLE (IPV4, LIEN DE FICHIER PPT) EN PARAMETRE
                         */
                        if(array_key_exists('button1', $_POST)) {
                            open_ppt("192.168.56.1", "C:\\Users\\conta\\Desktop\\site\\presentation.pptx");
                        }
                        else if(array_key_exists('button2', $_POST)) {
                            open_ppt("192.168.0.157", "C:\\dev\\test.pptx");
                        }
                      
                        function open_ppt($host, $ppt_file) {
                            $host    = $host;
                            $port    = 5000;
                            $message = "open_ppt@".$ppt_file; //C:\\dev\\test.pptx";  // "open_ppt@C:\\wamp64\\www\\test.pptx";
                            // echo "open sent :".$message ."\n";
                            // create socket
                            $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
                            // connect to server
                            $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
                            // send string to server
                            socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
                            // get server response
                            $result = socket_read ($socket, 1024) or die("Could not read server response\n");
                            // echo "  --->   :".$result."\n";
                            // close socket
                            socket_close($socket);
                        }
                    ?>
                </ul>
            </div>
            <!-- <form method="post">
                <input type="submit" name="button1" class="button" value="BTN1" />

                <input type="submit" name="button2" class="button" value="BTN2" />
            </form> -->
            <?php if($cadenas_properties == 'ouvrir'): ?>
            <div class="footer_box">
                <h2><a href="AjouteurDePresentations.php" id="ajouter_presentation">Cliquez ici pour ajouter une
                        présentation</a></h2>
                <div class="choix_session">
                    <form method="post">
                        <select class="select" name="session">
                            <option value="0">--Changer de session--</option>
                            <?php while($row = $session_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option name="session" value="<?= $row['id']?>">
                                <?php echo htmlspecialchars(($row['titre'])); ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                        
                        <input type="submit" id="submit_session" value="Let's Go !" name="bouton_letsgo">
                    </form>
                    <?php endif;?>
                </div>
            </div>
        </form>
    </div>
    <!-- Cadenas de la page pour lock -->
    <a href="lock.php?lock=<?=$cadenas_status;?>&session=<?=$session_de_base;?>" style="padding: 2px;background-color:#fff;border-radius:25%; position:fixed; top:10px; right:10px; width: 20px;height: 20px; z-index: 9;">
        <img style="position:fixed; top:12px; right:12px; width: 20px;height: 20px; z-index: 10;" src="images/<?=$cadenas_properties;?>" />
    </a>
</body>

</html>