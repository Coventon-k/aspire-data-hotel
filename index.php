<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="jQuery.js"></script>
</head>
<body>
<div id="res"></div>
<input type="text" placeholder="lien" class="lien">
<input type="button" value="Extraire" id="extraire">
<script type="application/javascript">

    let data = {};

    $("#extraire").click(function() {
        let lien = $('.lien')[0].value;
        var settings = {
            url: "aspire.php",
            method: "POST",
            dataType: "html",
            data: {
                'lien': lien
            }
        };

        $.ajax(settings).done(function (response) {
            response = response.trim();
            if (response.content !== 'erreur') {
                let html = $(response).find('.contenu').contents();
                let annonces = html.find('div .bloc_annonce');
                $(annonces).each(function (index, element) {

                    console.log($(element).find('.ref')[0].textContent);
                    console.log($(element).find('.title_part2')[0].textContent);
                    let chiffres = $(element).find('.chiffres_cles strong');
                    //console.log(chiffres)
                    $(chiffres).each(function (index, element) {
                        console.log(element.textContent)

                    })
                    //console.log(element.find('.ref'));
                    //console.log(element.find('.ref'));
                });
            }

        });
    })

    function  Appart() {
        this.ref = 0;
        this.title_part2 = '';
        this.chiffres_cles = '';
    }

</script>
</body>
</html>
