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

    let data = [];

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

        // Traitement si requète ajax à fonctionner
        $.ajax(settings).done(function (response) {
            response = response.trim();
            if (response.content !== 'erreur') {
                // Creation d'une instance de appart: les infos d'un appartement
                let unAppart = new Appart();

                // Récuperation du bloc html qui contient les infos sur les appartements
                let html = $(response).find('.contenu').contents();
                let annonces = html.find('div .bloc_annonce');

                // Recuperation des infos sur chaque appartement du bloc
                $(annonces).each(function (index, element) {

                    // Reférence de l'appart
                    unAppart.ref = $(element).find('.ref')[0].textContent;

                    // Ville et quartier
                    let title =  $(element).find('.title_part2')[0].textContent.split('–');
                    unAppart.ville = title[0] !== '' ? title[0].trim(): null;
                    unAppart.quartier = title.length === 2 && title[1] !== '' ? title[1].trim(): null;

                    // nobre de pièce - metre carré - prix fai
                    let chiffres = $(element).find('.chiffres_cles strong');
                    unAppart.nb_piece =  $(chiffres)[0] instanceof Object ? $(chiffres)[0].textContent: null;
                    unAppart.m_carre =  $(chiffres)[1] instanceof Object ? $(chiffres)[1].textContent: null;
                    unAppart.prix_fai = $(chiffres)[2] instanceof Object ? $(chiffres)[2].textContent: null;

                    // Ajout de l'appartement au tableau d'appart
                    data.push(unAppart);
                });
            }

        });
        console.log(data)

    });

    // Objet représentant un appartement
    function  Appart() {
        this.ref = null;
        this.ville = null;
        this.quartier = null;
        this.nb_piece = null;
        this.m_carre = null;
        this.prix_fai = null;
        //this.date_apire = (new Date()).getMonth();
    }

</script>
</body>
</html>
