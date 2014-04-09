$(function () {
    $('#flashdatas .alert').delay(5000).slideUp('fast');

    $(".fancybox").fancybox();

    $('.star').raty({
        numberMax : 5,
        readOnly: true,
        halfShow : true,
        score: function() {
            return $(this).attr('data-number')
        }
    });

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

    $(".message_form").submit(function(){
        $obj = $(this);
        $.ajax({
            url: $(".message_form").attr('action'),
            type: "POST",
            dataType    : "json",
            data: $obj.serialize(),
            success: function(data) {
                $("#overlay").fadeOut('fast');
                $obj.find("button").text('Merci de votre réponse');
                $obj.parents(".media-list").find(".alert-warning").fadeOut('fast');
                $obj.find("button").removeClass("btn-danger");
                $obj.find("button").addClass("btn-success");
                $commentaire = $("<p>" + $obj.find('textarea').val() + "</p>");
                $obj.prev('.media-body').append($commentaire);
            }

        });
        return false;
    });


    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });


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
