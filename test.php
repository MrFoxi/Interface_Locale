<?php 
    if(isset($_POST['test'])){
        mkdir('C:/Powerpoint/Salle1/test');
    }
?>

<form method="post">
    <input type="radio" name="test" value="3"/>
    <input type="submit"/>
</form>