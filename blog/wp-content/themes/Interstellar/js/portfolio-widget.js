jQuery(document).ready(function($){ 
        $('.ufo-portfolio .flexslider').flexslider({
            controlNav: false,
	        directionNav: true,
	        animation: 'fade',
	        start: function(){
	            $('.loader').hide();
	        }
        });

		var $SingleItem = jQuery('.ufo-portfolio .flexslider');
		jQuery('.ufo-portfolio .flex-direction-nav').css('opacity','0');
		$SingleItem.hover(function(){

			jQuery(this).find('.flex-direction-nav').stop(true, true).animate({opacity: 1},0);
		}, function(){
			jQuery(this).find('.flex-direction-nav').stop(true, true).animate({opacity: 0},0);

		});
});