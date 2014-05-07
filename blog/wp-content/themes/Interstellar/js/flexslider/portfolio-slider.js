//<![CDATA[
jQuery(document).ready(function($){	
	
	//	Initialize Homepage Slider
	$(".flexslider").flexslider({
		controlNav: false,
		directionNav: true,
		start: function(){
	      $('.loader').hide();
	  	}
	});	
});
//]]>