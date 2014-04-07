$ ->
  alert 'ok'
  if $("#search_input").length > 0
    $("#search_input").autocomplete(
      minLength: 2
      scrollHeight: 220
      source: (req, add) ->
        $.ajax
          url: $("#search_input").attr('data-url')
          type: "get"
          dataType: "json"
          data: "query="+req.term
          async: true
          cache: true
          success: (data) ->
            add $.map(data, (item) ->
              nom: item.nom
              url: item.url
            )

      focus: (event, ui) ->
        $(this).val ui.item.nom
        false

      select: (event, ui) ->
        window.location.href = ui.item.url
        false
    ).data("ui-autocomplete")._renderItem = (ul, item) ->
      $("<li></li>").data("ui-autocomplete-item", item).  append("<a href=\"" + item.url + "\">" + item.nom + "</span></a>").appendTo ul.addClass("list-row")


  $(".fancybox").fancybox()

  $poped = $('#notifications')
  $poped.popover(
    content: $("#notifications-content").html()
    html: true).click (evt) ->
      evt.stopPropagation()
      $(this).popover "show"

  $('.popov').popover
    "original-title": "<i class=glyphicon glyphicon-question-sign></i> Aide"
    placement: "bottom"
    trigger: 'focus'
    content: $(this).attr('data-content')
    html: true

  $("#btn-tchat").click (evt) ->
    $('#messagerie').show()

  $("#messagerie").draggable()

  $(".closemessagerie").click ->
    $('#messagerie').hide()

  $("html").click ->
    $poped.popover "hide"

  # Trigger for the hiding
#  $("html:not(#notifications)").on "click.popover.data-api", ->
#    $poped.popover "hide"

#  $(".star").jRating
#    isDisabled : true
#    bigStarsPath: '/images/stars.png'
#    length : 5
#    rateMax : 5

  $(window).scroll ->
    if $(document).scrollTop() >= 100
      $('body .navbar-default').stop(true,true).animate
        opacity: 0.8
    else
      $('body .navbar-default').stop(true,true).animate
        opacity: 1

  $("body .navbar-default").hover (->
    $(this).stop(true,true).animate
      opacity: 1
  ), ->
    if $(document).scrollTop() >= 100
      $('body .navbar-default').stop(true,true).animate
        opacity: 0.8

  $('.multiselect').multiselect
    buttonText: (options, select) ->
      if options.length is 0
        "Aucune"
      else
        selected = ""
        options.each ->
          selected += $(this).text() + ", "
        selected.substr(0, selected.length - 2) + " <b class=\"caret\"></b>"
    maxHeight: 200
    maxWidth: 200
    buttonWidth: 200
    enableFiltering: true
    enableCaseInsensitiveFiltering : true

  $( ".date" ).datepicker()

  $('.alert-success').delay(5000).slideUp('fast')

  $('#moresearch').click ->
    $('#advancedsearch').toggleClass('hide','')

#  $('.check, .rad').iCheck
#    checkboxClass: 'icheckbox_flat-green'
#    radioClass: 'iradio_flat-green'
#    increaseArea: '20%'

  $('form').on "submit", (event) ->
    $(this).find('button[type=submit]').attr 'disabled','disabled'
    $(this).find('button[type=submit]').text('Envoi en cours...')
    $('#overlay').removeClass('hide')


  $("input[required]").on "blur", (event) ->
    if $(this).val().length == 0
      $(this).addClass('parsley-error')

  $("input[required]").on "keydown", (event) ->
    $(this).removeClass('parsley-error')


  $(window).scroll ->
    if $(this).scrollTop() > 100
      $(".scrollup").fadeIn()
    else
      $(".scrollup").fadeOut()

  $(".scrollup").click ->
    $("html, body").animate
      scrollTop: 0
    , 600
    false