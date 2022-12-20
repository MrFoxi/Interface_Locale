<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'supprimer':
                insert();
                break;
            case 'select':
                select();
                break;
        }
    }

    function select() {
        echo "Bullshit";
        exit;
    }

    function insert() {
        $sah = 3;
        var_dump($sah);
        echo "<option>Session_1</option>";
        exit;
    }
?>