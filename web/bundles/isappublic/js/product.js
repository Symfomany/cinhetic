
jQuery(document).ready(function () {

    $("#my-awesome-dropzone").dropzone(
        {
            dictDefaultMessage: '<h3><i class="glyphicon glyphicon-picture"></i> Déposer votre image ici</h3>',
            paramName: "file",
            clickable : true,
            maxFilesize: 7, // MB
        }
    );



});


