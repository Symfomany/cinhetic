
jQuery(document).ready(function () {

    $('#nature').on('change', function(){
        $val = $(this).val();
        if($val == 1){
            $('#remiseNet').val('').removeAttr('disabled');
            $('#remiseVar').val('').attr('disabled', 'disabled');
            $('#offert').removeAttr('checked');
        }
        if($val == 2){
            $('#remiseNet').val('').attr('disabled', 'disabled');
            $('#remiseVar').val('').removeAttr('disabled');
            $('#offert').removeAttr('checked');
        }
        if($val == 3){
            $('#remiseNet').val('').attr('disabled', 'disabled');
            $('#remiseVar').val('').attr('disabled', 'disabled');
            $('#offert').attr('checked','checked');
        }
    });
    $val = $('#nature').val();
    if($val == "1"){
        $('#remiseNet').removeAttr('disabled');
        $('#remiseVar').val('').attr('disabled', 'disabled');
        $('#offert').removeAttr('checked');
    }
    if($val == "2"){
        $('#remiseNet').val('').attr('disabled', 'disabled');
        $('#remiseVar').removeAttr('disabled');
        $('#offert').removeAttr('checked');
    }
    if($val == "3"){
        $('#remiseNet').val('').attr('disabled', 'disabled');
        $('#remiseVar').val('').attr('disabled', 'disabled');
        $('#offert').attr('checked','checked');
    }
});



