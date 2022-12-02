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
    <script>
        var bouton = document.getElementById('menu_lien');
        var fond_a_changer = document.body

        bouton.onmouseover = function(){
            fond_a_changer.className = 'hovered';
        }
        bouton.onmouseout = function(){
            fond_a_changer.className = '';
        }
    </script>

</head>

<body class="">
    <div id="forms">
        <form id="" action="" enctype="multipart/form-data" method="post" class="form-example">
            
            <div id="big_box_unlock">
                
                <ul id="presta_box">
                    <div id="medium_box">
                            <div class="boite_à_liens">
                                <button>
                                    <a href="presentations.php" id="menu_lien">PRESENTATIONS</a>
                                </button>
                                <button>
                                    <a href="AjouteurDePresentations.php" id="menu_lien">AJOUTER UNE PRESENTATION</a>
                                </button>
                                <button>
                                    <a href="Ajout_Intervenant.php" id="menu_lien">AJOUTER UN INTERVENANT</a>
                                </button>
                                <button>
                                    <a href="Session.php?jour=Jour_1&salle=Salle_1-Jour_1" id="menu_lien">AJOUTER UNE SESSION</a>
                                </button>
                            </div>
                            
                    </div>
                </ul>
            </div>
        </form>
        
    </div>
</body>

</html>