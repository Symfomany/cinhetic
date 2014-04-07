$ ->
  # Get the ul that holds the collection of tags
  collectionHolder = $("div.metas")

  collectionHolder.find("div").each ->
    addTagFormDeleteLink $(this)

  # setup an "add a tag" link
  $addTagLink = $("<a href=\"#\" class=\"add_tag_link\">Add a metas</a>")
  $newLinkLi = $("<div></div>").append($addTagLink)

  # ajoute l'ancre « ajouter un tag » et li à la balise ul
  collectionHolder.append $newLinkLi

  $addTagLink.on "click", (e) ->

    # empêche le lien de créer un « # » dans l'URL
    e.preventDefault()

    # ajoute un nouveau formulaire tag (voir le prochain bloc de code)
    addTagForm collectionHolder, $newLinkLi


  addTagFormDeleteLink = ($tagFormLi) ->
    $removeFormA = $("<a href=\"#\">Supprimer ce tag</a>")
    $tagFormLi.append $removeFormA
    $removeFormA.on "click", (e) ->

      # empêche le lien de créer un « # » dans l'URL
      e.preventDefault()

      # supprime l'élément li pour le formulaire de tag
      $tagFormLi.remove()

  addTagForm = ($collectionHolder, $newLinkLi) ->

    addTagFormDeleteLink $newFormLi

    # Get the data-prototype explained earlier
    prototype = $collectionHolder.data("prototype")

    # get the new index
    index = $collectionHolder.data("index")

    # Replace '__name__' in the prototype's HTML to
    # instead be a number based on how many items we have
    newForm = prototype.replace(/__name__/g, index)

    # increase the index with one for the next item
    $collectionHolder.data "index", index + 1

    # Display the form in the page in an li, before the "Add a tag" link li
    $newFormLi = $("<div></div>").append(newForm)
    $newLinkLi.before $newFormLi

