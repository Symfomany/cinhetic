$(function () {
    $('#flashdatas .alert').delay(5000).slideUp('fast');

    $(".fancybox").fancybox();

    $('select[multiple="multiple"]').selectpicker({});


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


    if ($("#search_input_api").length > 0) {
        $("#search_input_api").autocomplete({
            minLength: 2,
            scrollHeight: 220,
            source: function(req, add) {
                return $.ajax({
                    url: $("#search_input_api").attr('data-url'),
                    type: "get",
                    dataType: "json",
                    data: "search=" + req.term,
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
                $('#search_input_api').val(ui.item.nom);
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li></li>").data("ui-autocomplete-item", item).append("" + item.nom + "").appendTo(ul.addClass("list-row"));
        };
    }



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
    $("#listmovies *").highlight(search, "highlight");


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

    if($(window).width() >= 200 && $(window).width() <= 748){
        alert('ok');
    }


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
