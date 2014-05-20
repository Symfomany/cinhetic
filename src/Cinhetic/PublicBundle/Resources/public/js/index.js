jQuery(document).ready(function () {
    var re = /(https?:\/\/(([-\w\.]+)+(:\d+)?(\/([\w/_\.]*(\?\S+)?)?)?))/ig;
    var re2 = /\B#\w*[a-zA-Z]+\w*/ig;
    var re3 =  /\B#\w*[a-zA-Z]+\w*/ig;
    $('#tweets_bloc table tr td').each(function(){
        $(this).html($(this).html().replace(re, '<a href="$1" title="">$1</a>'));
    });

});


