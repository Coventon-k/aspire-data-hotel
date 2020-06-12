<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/test.css">
    <script src="jQuery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</head>
<body>

<div id="un" class="un container-fluid">
    <div class="blocun">
        <h1 class="info-color white-text text-center py-4">
            <img src="img/text828.png" alt="">
        </h1>
        <form class="offset-3 col-md-6 form-inline">
            <div class="input-group mb-3 col-12">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">Lien</span>
                </div>
                <input type="text" value="https://www.blot-immobilier.fr/habitat/achat/appartement-neuf/ille-et-vilaine/rennes/" class="form-control" id="lien" aria-describedby="basic-addon3">
                <div class="input-group-append">
                    <a href="#deux" id="extraire" class="btn btn-secondary">Aspirer</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="deux" class="deux container-fluid">
    <div class="blocdeux">
        <h1 class="info-color text-center py-4">
            <strong class="text-light">Filtrer</strong>
        </h1>
        <form class="offset-3 col-md-6 form-inline">
            <div class="input-group mb-3 col-12">
                <div class="input-group-prepend col-2 input-group-text">
                    <span>Surface</span>
                </div>
                <input type="number" id="surface" min="0" class="form-control" aria-describedby="basic-addon3">
                <div class="input-group-append col-2 input-group-text">
                    <span>m²</span>
                </div>
            </div>
            <div class="input-group mb-3 col-12">
                <div class="input-group-prepend col-2 input-group-text">
                    <span>Pièces</span>
                </div>
                <input type="number" id="piece" min="1" value="1" class="form-control" aria-describedby="basic-addon3">
            </div>
            <div class="input-group mb-3 col-12">
                <div class="input-group-prepend col-2 input-group-text">
                    <span>Quartier</span>
                </div>
                <select id="quartier" class="form-control custom-select" aria-describedby="basic-addon3">
                    <option selected>Choisir...</option>
                </select>
            </div>
            <div class="input-group mb-3 col-12">
                <div class="input-group-append col-12 p-0">
                    <a href="#trois" id="filtrer" class="btn btn-secondary col-6">Filtrer</a>
                    <a href="#un" class="btn btn-secondary col-6">Un</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="trois" class="trois container-fluid">
    <div class="bloctrois">
        <div class=" offset-3 col-md-6 card">
            <div class="card-header">
                <div class="text-capitalize font-weight-normal">
                    Résultat de filtre ...
                </div>

            </div>
            <div class="no-gutters row align-items-center p-5">
                <div class="col-sm-6 col-md-4 col-xl-4">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <img src="img/mini.PNG" alt="" class="card-img">
                        </div>
                        <div class="col-8 minmaxmoy" id="min">
                            179000
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-4">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <img src="img/mini.PNG" alt="" class="card-img">
                        </div>
                        <div class="col-8 minmaxmoy" id="max">
                            240000
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <img src="img/maxi.PNG" alt="" class="card-img">
                        </div>
                        <span class="col-8 minmaxmoy" id="moy">
                            180000
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-center d-block p-3 card-footer">
                <div class="input-group mb-3 col-12">
                    <div class="input-group-append col-12 p-0">
                        <a href="#trois" id="filtrer" class="btn btn-secondary offset-3 col-6">Filtrer à nouveau</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="bootstrap/js/calcul.js"></script>
<script type="application/javascript">
    $('#deux').hide();
    $('#trois').hide();

    let data = [];
    let list_quartier = [];

    $("#extraire").click(function() {

        $('#deux').show();

        let lien = $('#lien')[0].value;
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

                // Récuperation du bloc html qui contient les infos sur les appartements
                let html = $(response).find('.contenu').contents();
                let annonces = html.find('div .bloc_annonce');

                // Recuperation des infos sur chaque appartement du bloc
                $(annonces).each(function (index, element) {

                    // Creation d'une instance de appart: les infos d'un appartement
                    let unAppart = new Appart();
                    // Reférence de l'appart
                    unAppart.ref = $(element).find('.ref')[0].textContent;

                    // Ville et quartier
                    let title =  $(element).find('.title_part2')[0].textContent.split('–');
                    unAppart.ville = title[0] !== '' ? title[0].trim(): null;

                    if (title.length === 2 && title[1] !== '') {
                        let quartier = title[1].trim();

                        unAppart.quartier = quartier;

                        // Remplissage list_quartier
                        if (!list_quartier.includes(quartier)) {
                            list_quartier.push(quartier);
                        }
                    }


                    // nobre de pièce - metre carré - prix fai
                    let chiffres = $(element).find('.chiffres_cles strong');
                    unAppart.nb_piece =  $(chiffres)[0] instanceof Object ? parseFloat($(chiffres)[0].textContent): null;
                    unAppart.m_carre =  $(chiffres)[1] instanceof Object ? parseFloat($(chiffres)[1].textContent): null;
                    let prix_fai = $(chiffres)[2] instanceof Object ? $(chiffres)[2].textContent.split('€')[0].trim(): null;
                    if (prix_fai !== null) {
                        unAppart.prix_fai = parseFloat(prix_fai.replace(/ /g,""), 10);
                    }

                    // Ajout de l'appartement au tableau d'appart
                    data.push(unAppart);
                });
            }
            console.log(data)

            // Remplir la liste déroulante de quartier
            list_quartier.forEach(function (value, index ) {
                $('#quartier').append(`<option value="${value}">
                                       ${value}
                                  </option>`);
            });

            // Action pour click sur btn filtrer
            $('#filtrer').on("click", function () {

                $('#trois').show();

                // Récupération des données de trie
                let piece = parseFloat($('#piece')[0].value);
                let surface = parseFloat($('#surface')[0].value);
                let quartier = $('#quartier')[0].value;

                let val_trier = trier(piece, surface, quartier, data)
                let prix = getPrixFai(val_trier);
                //console.log(prix)
                $('#min')[0].innerText = prixmin(prix);
                $('#max')[0].innerText = prixmax(prix);
                $('#moy')[0].innerText = prixmoy(prix).toFixed(2);
                console.log(prixmax(prix)+' '+prixmin(prix)+' '+prixmoy(prix))

            });
        });
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

    // Gerer annimation du changement de formulaire
    // référence: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_smooth_scroll_jquery
    $(document).ready(function(){
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            }
        });
    });

</script>
</body>
</html>
