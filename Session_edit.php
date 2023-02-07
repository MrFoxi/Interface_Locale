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
    require "Controller/config/config.php";
    require "Controller/PHP/requetesSQL.php";

    exec('START C:/"Program Files"/"Microsoft Office"/root/Office16/POWERPNT.EXE <erreur.txt', $var);


    
    //      
    $req = $pdo->prepare("SELECT COUNT(id) FROM session");
    $req->execute();
    $count = $req->fetchColumn();
    // var_dump($count);
    

    $req = $pdo->prepare("SELECT id FROM session");
    $req->execute();
    $id = $req->fetchAll(PDO::FETCH_COLUMN);
    var_dump($id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        for ($i = 0; $i <= $count-1 ; $i++) {
            $idi = intval($id[$i]);
            // var_dump($idi);
            if(isset($_POST["$idi"])){
                if($_POST["$idi"] == '🗑️') {
                    $req = $pdo->prepare("DELETE FROM session WHERE id = $idi;");
                    $req->execute();
                    // header("Refresh:0");
                }
            }
        }
    }

    $id_session = $id[0];
    // var_dump($id_session);

    // var_dump($id[0]);
    $id_test = intval($id[0]);
    // $var_dump();


    // for ($i = 0; $i <= $count ; $i++) {
    // //     ar_dump($id[$i]);
    //     $req = $pdo->prepare("SELECT setitre, satitre, jotitre FROM session INNER JOIN salle ON session.id_salle = salle.id INNER JOIN jour ON salle.id_jour = jour.id WHERE session.id = ?");
    //     $req->execute(["$id[$i]"]);
    //     $resultat = $req->fetch(PDO::FETCH_ASSOC);

    //     $titre_session = $resultat['setitre'];
    //     $titre_salle = $resultat['satitre'];
    //     $titre_jour = $resultat['jotitre'];

    //     var_dump($titre_session, $titre_salle, $titre_jour);
    // //     // var_dump($resultat);
    // }

    // foreach ($resultat as $res) {
    //     var_dump($res);
    // }
    

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
                <div class="Editer">
                    <!--Lien peut etre à changer pour rediriger vers le menu-->
                    <a href="Session.php?jour=Jour_1&salle=Salle_1-Jour_1" style="width:100px;"><img style="display:block;margin:auto;"
                        src="images/1827933.png" id="accueil" width="45px" height="45px"></a>
                </div>
            </div>
            <div id="big_box">
                <div id="medium_box_session">
                    <div class="wrap-table100">
                        <div class="table100 ver1 m-b-110">
                            <div class="table100-head">
                                <table>
                                    <thead>
                                        <tr class="row100 head">
                                            <th class="cell100 column1">Jour</th>
                                            <th class="cell100 column2">Salle</th>
                                            <th class="cell100 column3">Session</th>
                                            <th class="cell100 column4">Delete</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="table100-body js-pscroll">
                                <table>
                                    <tbody>
<?php
                                            

                                            for ($i = 0; $i <= $count-1 ; $i++) {

                                                $idi = intval($id[$i]);
                                                echo "<tr class='row100 body'>";
                                                // var_dump($id[$i]);
                                                $req = $pdo->prepare("SELECT session.id as seid, session.titre as setitre,salle.titre as satitre,jour.titre as jotitre FROM session INNER JOIN salle ON session.id_salle = salle.id INNER JOIN jour ON salle.id_jour = jour.id WHERE session.id = ?");
                                                $req->execute([$idi]);
                                                // var_dump($idi);
                                                $resultat = $req->fetch(PDO::FETCH_ASSOC);

                                                if(isset($resultat['seid'])){
                                                    $idsession = intval($resultat['seid']);
                                                
                                                    $titre_session = $resultat['setitre'];
                                                    $titre_salle = $resultat['satitre'];
                                                    $titre_jour = $resultat['jotitre'];
                                                    echo "<td class='cell100 column1'>$titre_jour</td>";
                                                    echo "<td class='cell100 column2'>$titre_salle</td>";
                                                    echo "<td class='cell100 column3'>$titre_session</td>";
                                                    echo "<td class='cell100 column4'><input type='submit' name='$idsession' value='🗑️'/></td>";
                                                // var_dump($idsession);
                                                
                                                //     // var_dump($resultat);

                                                    echo "</tr>";
                                                }
                                                
                                        
                                                

                                            }
                                            

                                            
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </form>
    </div>



</body>

</html>