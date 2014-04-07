// Récupère le div qui contient la collection de tags
var collectionHolder2 = $('div.pjs');

// ajoute un lien « add a tag »
var $addTagLink2 = $('<a class="btn btn-primary addcaracteristiques"><i class="glyphicon glyphicon-plus"></i> Ajouter un fichier</a>');
var $newLinkLi2 = $('<p></p>').append($addTagLink2);
// ajoute un lien de suppression à tous les éléments li de
// formulaires de tag existants
collectionHolder2.find('li').each(function () {
    addTagForm2DeleteLink2($(this));
});

function addTagForm2DeleteLink2($tagFormLi) {
    var $removeFormA = $('<a class="btn btn-primary addcaracteristiques"><i class="glyphicon glyphicon-minus"></i> Supprimer cet fichier</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function (e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // supprime l'élément li pour le formulaire de tag
        $tagFormLi.remove();
    });
}


function addTagForm2(collectionHolder2, $newLinkLi2) {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder2.attr('data-prototype');

    // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
    // la longueur de la collection courante
    var newForm = prototype.replace(/__name__/g, collectionHolder2.children().length);

    // Affiche le formulaire dans la page dans un li, avant le lien "ajouter un tag"
    var $newFormLi2 = $('<li></li>').append(newForm);
    $newLinkLi2.before($newFormLi2);
    addTagForm2DeleteLink2($newFormLi2);
}


jQuery(document).ready(function () {

    /**
     * CAlcul tva
     */
    $('#prixHT').on('blur', function (e) {
        if ($('#prixHT').val().length > 0) {
            var ttc = parseFloat($('#prixHT').val()) * (1 + parseFloat($("#tva").val()) / 100).toFixed(2);
            if (ttc != "")
                $('#prixTTC').val(ttc);
        }
    });
    $('#tva').on('change', function (e) {
        if ($('#prixHT').val().length > 0) {
            var ttc = parseFloat($('#prixHT').val()) * (1 + parseFloat($("#tva").val()) / 100).toFixed(2);
            if (ttc != "")
                $('#prixTTC').val(ttc);
        }
    });

// ajoute l'ancre « ajouter un tag » et li à la balise ul
    collectionHolder2.append($newLinkLi2);

    $addTagLink2.on('click', function (e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire tag (voir le prochain bloc de code)
        addTagForm2(collectionHolder2, $newLinkLi2);
    });

});