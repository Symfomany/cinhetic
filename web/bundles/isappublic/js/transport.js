
jQuery(document).ready(function () {

    $('#nature').on('change', function(){
        $val = $(this).val();
        if($val == 1){
            $('#from').attr('placeholder', 'Min. en kg');
            $('#to').attr('placeholder', 'Max. en kg');
        }
        if($val == 2){
            $('#from').attr('placeholder', 'Min. en nombre');
            $('#to').attr('placeholder', 'Max. en nombre');
        }
        if($val == 3){
            $('#from').attr('placeholder', 'Min. en €');
            $('#to').attr('placeholder', 'Max. en €');
        }
    });
    $val = $('#nature').val();
    if($val == 1){
        $('#from').attr('placeholder', 'Min. en kg');
        $('#to').attr('placeholder', 'Max. en kg');
    }
    if($val == 2){
        $('#from').attr('placeholder', 'Min. en nombre');
        $('#to').attr('placeholder', 'Max. en nombre');
    }
    if($val == 3){
        $('#from').attr('placeholder', 'Min. en €');
        $('#to').attr('placeholder', 'Max. en €');
    }
});



