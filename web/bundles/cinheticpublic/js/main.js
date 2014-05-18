$(function () {
    $('#flashdatas .alert').delay(5000).slideUp('fast');

    if ($("#search_page_ajax").length > 0) {
        $("#search_page_ajax").autocomplete({
            minLength: 2,
            scrollHeight: 220,
            source: function(req, add) {
                return $.ajax({
                    url: $("#search_page_ajax").attr('data-url'),
                    type: "get",
                    dataType: "json",
                    data: "word=" + req.term,
                    async: true,
                    cache: true,
                    success: function(data) {
                        return add($.map(data, function(item) {
                            return {
                                nom: item.nom,
                                url: item.url
                            };
                        }));
                    }
                });
            },
            focus: function(event, ui) {
                $(this).val(ui.item.nom);
                return false;
            },
            select: function(event, ui) {
                window.location.href = ui.item.url;
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li></li>").data("ui-autocomplete-item", item).append("<a href=\"" + item.url + "\">" + item.nom + "</span></a>").appendTo(ul.addClass("list-row"));
        };
    }


    if ($("#search_input").length > 0) {
        $("#search_input").autocomplete({
            minLength: 2,
            scrollHeight: 220,
            source: function(req, add) {
                return $.ajax({
                    url: $("#search_input").attr('data-url'),
                    type: "get",
                    dataType: "json",
                    data: "word=" + req.term,
                    async: true,
                    cache: true,
                    success: function(data) {
                        return add($.map(data, function(item) {
                            return {
                                nom: item.nom,
                                url: item.url
                            };
                        }));
                    }
                });
            },
            focus: function(event, ui) {
                $(this).val(ui.item.nom);
                return false;
            },
            select: function(event, ui) {
                window.location.href = ui.item.url;
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li></li>").data("ui-autocomplete-item", item).append("<a href=\"" + item.url + "\">" + item.nom + "</span></a>").appendTo(ul.addClass("list-row"));
        };
    }

    /*
    $('#Cinhetic_publicbundle_actors_city').autocomplete({
        source : function(requete, reponse){ // les deux arguments représentent les données nécessaires au plugin
        $.ajax({
                url : 'http://ws.geonames.org/searchJSON', // on appelle le script JSON
                dataType : 'json', // on spécifie bien que le type de données est en JSON
                data : {
                    name_startsWith : $('#Cinhetic_publicbundle_actors_city').val(), // on donne la chaîne de caractère tapée dans le champ de recherche
                    maxRows : 15
                },
                
                success : function(donnee){
                    reponse($.map(donnee.geonames, function(objet){
                        return objet.name + ', ' + objet.countryName; // on retourne cette forme de suggestion
                    }));
                }
            });
        }
    });
*/


    $(window).scroll(function () {
        if ($(document).scrollTop() >= 100) {
            return $('body .navbar-default').stop(true, true).animate({
                opacity: 0.8
            });
        } else {
            return $('body .navbar-default').stop(true, true).animate({
                opacity: 1
            });
        }
    });
    $("body .navbar-default").hover((function () {
        return $(this).stop(true, true).animate({
            opacity: 1
        });
    }), function () {
        if ($(document).scrollTop() >= 100) {
            return $('body .navbar-default').stop(true, true).animate({
                opacity: 0.8
            });
        }
    });



    jQuery.fn.highlight = function (str, className) {
        var regex = new RegExp(str, "gi");
        return this.each(function () {
            $(this).contents().filter(function() {
                return this.nodeType == 3 && regex.test(this.nodeValue);
            }).replaceWith(function() {
                return (this.nodeValue || "").replace(regex, function(match) {
                    return "<span class=\"" + className + "\">" + match + "</span>";
                });
            });
        });
    };

    var search = $('#search_input').val();
    $('#search_input').parents("#listmovies *").highlight(search, "highlight");


    $('.ishome').click(function (evt) {
        $obj = $(this);
        $.ajax({
            url: $(this).attr('data-url'),
            type: "get",
            dataType: "json",
            success: function (data) {
                if($obj.hasClass('athome')){
                    $obj.find('i').attr('class','pull-left glyphicon glyphicon-heart-empty');
                }else{
                    $obj.find('i').attr('class','pull-left glyphicon glyphicon-heart');
                }
            }
        });
    });

    $('#moresearch').click(function () {
        return $('#advancedsearch').toggleClass('hide', '');
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('form').on("submit", function (event) {
        $(this).find('button[type=submit]').attr('disabled', 'disabled');
        $(this).find('button[type=submit]').text('Envoi en cours...');
        return $('#overlay').removeClass('hide');
    });



    $("input[required]").on("blur", function (event) {
        if ($(this).val().length == 0 && $(this).val() == "") {
            return $(this).addClass('parsley-error');
        }
    });
    $("input[required]").on("keydown", function (event) {
        return $(this).removeClass('parsley-error');
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            return $(".scrollup").fadeIn();
        } else {
            return $(".scrollup").fadeOut();
        }
    });
    return $(".scrollup").click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
    

    $('.alert-success').delay(5000).slideUp('fast');

});
