$(function () {

    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })


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
});
