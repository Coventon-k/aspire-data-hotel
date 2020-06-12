
let trier = function (piece, surface, quartier, data) {
    return  data.filter( appart =>
        appart.quartier === quartier
        /*appart.nb_piece == piece &&
        appart.m_carre == surface)*/
    )
}

let prixmax = function (data) {
    return Math.max.apply(Math, data)
}

let prixmin = function (data) {
    return Math.min.apply(Math, data)
}

let prixmoy = function (data) {
    return eval(data.join("+")) / data.length
}


let getPrixFai = function (data) {
    let prix = [];
    $(data).each(function (index, element) {
        console.log(element.prix_fai)
        let e = element.prix_fai;
        if (!isNaN(e) && e !== null) {
            prix.push(e)
        }

    })
    return prix;
}