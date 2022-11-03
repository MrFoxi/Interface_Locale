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

                $num_session = explode('?', $_SERVER['REQUEST_URI']);
                $req = $pdo->prepare('UPDATE lock_unlock SET session = ?');
                $req->execute([$num_session[1]]);


                if(isset($_POST['cadenas'])){
                    $cadenas = $_POST['cadenas'];
                    $req = $pdo->prepare('UPDATE lock_unlock SET cadenas = ?');
                    $req->execute([$cadenas]);
                    header("Location: ./Presentations.php");
                }
                
                $req = $pdo->prepare('SELECT cadenas FROM lock_unlock');
                $req->execute();
                $status_checked = $req->fetchColumn();

                $checked = '';
                $unchecked = '';

                if($status_checked == 1) {
                    $unchecked = 'checked';
                } else {
                    $checked = 'checked';
                }
            ?>
        
        <div id="big_box_unlock">
            <div>
                <input style="top: 35.8%;left: 34.8%" value="1" class="btn-modif" type="radio" name="cadenas" <?= $unchecked?>>
                <img style="width: 200px;height:200px;position: fixed;top: 36%;left: 35%;" src="images/ouvrir.png"/>
            </div>
            <div>
                <input style="top: 35.8%;right: 34.8%" value="0" class="btn-modif" type="radio" name="cadenas" <?= $checked?>>
                <img style="width: 200px;height:200px;position: fixed;top: 36%;right: 35%;" src="images/fermer.png"/>
            </div>
            <input value="Validez" id="btn-validez" type="submit">
        </div>
        </form>
    </div>
</body>

</html>