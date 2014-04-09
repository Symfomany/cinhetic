$(document).ready(function () {

    var socket = io.connect('http://www.cinhetic.ju:1665');
    var me = null;


    /*****************Handle All actions******************/

    // on the client connected
    socket.on('logged', function (user) {
        $html ='<h3><i class="glyphicon glyphicon-info-sign"></i> '+ user.firstname +' '+ user.lastname +' vient de se connecter</h3>';
        $('#mini-notification').html($html);
        $('#mini-notification').miniNotification({closeButton: false});
    });

    // on the client connected
    socket.on('messagerie', function (user) {
        $('.alert-danger').hide()
        $('#messagerie').fadeIn('slow')
        $elt = $('<p class="clear" id="' + user.id + '"><span class="text-info">' + user.firstname + ' ' +  user.lastname + ' a dit:</span> ' + user.message + '</p>').hide();
        $('#messagerie #messages').append($elt);
        $elt.show('slow');
        $('#messagerie #messages').animate({scrollTop:$('#messagerie #messages').prop('scrollHeight')}, 500);
        $('h3#btn-tchat').css('backgroundColor','chocolate');
    });




    // on alerting
    socket.on('alerting', function (user) {
        $html ='<h4><i class="glyphicon glyphicon-info-sign"></i> '+ user.message +' par '+ user.firstname +' '+ user.lastname +'</h4>';
        $('#mini-notification').html($html);
        $('#mini-notification').miniNotification({closeButton: false});

        var response = '';
        $.ajax({ type: "GET",
            url: "/app_dev.php/backend/dernieres-actions",
            success : function(text)
            {
                response = text;
                $('#lastactions-panel').html(response);
                $('#lastactions-panel .panel-heading h4').hide().fadeIn('slow');
            }
        });
        $.ajax({ type: "GET",
            url: "/app_dev.php/backend/dernieres-notify",
            success : function(text)
            {
                response = text;
                $('.navbar-right .popover.bottom .popover-content').html(response);
                $('#notifications').popover('show');
            }
        });
    });


    // on alerting
    socket.on('notify', function (user) {
        var response = '';
        $.ajax({ type: "GET",
            url: "/app_dev.php/backend/dernieres-notify",
            success : function(text)
            {
                response = text;
                $('.navbar-right .popover.bottom .popover-content').html(response);
                $('#notifications').popover('show');
            }
        });
    });


});