


// Récupère le div qui contient la collection de tags
var collectionHolder3 = $('div.liens');

// ajoute un lien « add a tag »
var $addTagLink3 = $('<a class="btn btn-primary addcaracteristiques"><i class="glyphicon glyphicon-plus"></i> Ajouter un lien</a>');
var $newLinkLi3 = $('<p></p>').append($addTagLink3);
// ajoute un lien de suppression à tous les éléments li de
// formulaires de tag existants
collectionHolder3.find('li').each(function () {
    addTagForm3DeleteLink3($(this));
});

function addTagForm3DeleteLink3($tagFormLi) {
    var $removeFormA = $('<a class="btn btn-primary addcaracteristiques"><i class="glyphicon glyphicon-minus"></i> Supprimer ce lien</a><div class="clear"></div> ');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function (e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // supprime l'élément li pour le formulaire de tag
        $tagFormLi.remove();
    });
}


function addTagForm3(collectionHolder3, $newLinkLi3) {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder3.attr('data-prototype');

    // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
    // la longueur de la collection courante
    var newForm = prototype.replace(/__name__/g, collectionHolder3.children().length);

    // Affiche le formulaire dans la page dans un li, avant le lien "ajouter un tag"
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi3.before($newFormLi);
    addTagForm3DeleteLink3($newFormLi);
}


jQuery(document).ready(function () {

// ajoute l'ancre « ajouter un tag » et li à la balise ul
    collectionHolder3.append($newLinkLi3);

    $addTagLink3.on('click', function (e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire tag (voir le prochain bloc de code)
        addTagForm3(collectionHolder3, $newLinkLi3);
    });

});