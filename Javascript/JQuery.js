$(document).ready(function(){
    $('.button').click(function(){
        var clickBtnValue = $(this).val();
        //lien depuis la page php
        var ajaxurl = './ajax/ajax.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            console.log("Sah jsuis content");
            // alert("C'est bon t'es pas trop abruti");
        });
    });
});