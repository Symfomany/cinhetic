//<![CDATA[  
jQuery(document).ready(function() { 
       

var $CaptionItem = jQuery('#featured');
jQuery('.slide-caption').css('opacity','0');
$CaptionItem.hover(function(){

	jQuery(this).find('.slide-caption').stop(true, true).animate({opacity: 1},200);
}, function(){
	jQuery(this).find('.slide-caption').stop(true, true).animate({opacity: 0},200);

});
        	
/*  Initialize SuperFish  */
jQuery('ul.nav').superfish({ 
	delay:       400,                            // one second delay on mouseout 
	animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
	speed:       100,                          // faster animation speed 
	autoArrows:  true,                           // disable generation of arrow mark-up 
	dropShadows: false                            // disable drop shadows 
});


/*  Initialize Shadowbox  */
Shadowbox.init({
    
	overlayColor: "#FFFFFF",
    overlayOpacity: 0.9,
    autoplayMovies:     false,
    viewportPadding: 30
});


var $home_widget = jQuery("#home-widgets .home-widgets-fourth .home-widget");  

if (!($home_widget.length == 0)) {
	$home_widget.each(function (index, domEle) {
	// domEle == this
	if ((index+1)%4 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div><div class='line-div'></div>");
	});
} 

var $home_widget = jQuery("#home-portfolio ul li");  

if (!($home_widget.length == 0)) {
	$home_widget.each(function (index, domEle) {
	// domEle == this
	if ((index+1)%4 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
	});
}

var $home_widget = jQuery("#home-widgets .home-widgets-half .home-widget");  

if (!($home_widget.length == 0)) {
	$home_widget.each(function (index, domEle) {
	// domEle == this
	if ((index+1)%2 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div><div class='line-div'></div>");
	});
}    
   

var $footer_widget = jQuery("#footer-widgets div.footer-widget");  

if (!($footer_widget.length == 0)) {
	$footer_widget.each(function (index, domEle) {
		// domEle == this
		if ((index+1)%4 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
	});
}
		
// Highlight on Hover
 jQuery('.ufo-recent .recent-thumb, .index-thumb img, ul.portfolio-widget-items li, #home-portfolio li img').hover(function(){

    	jQuery(this).stop(true, true).animate({opacity: 0.8},100);
    }, function(){
    	jQuery(this).stop(true, true).animate({opacity: 1},100);

    });

// Social Highlight on Hover
 jQuery('#social a').hover(function(){

    	jQuery(this).stop(true, true).animate({opacity: 1},100);
    }, function(){
    	jQuery(this).stop(true, true).animate({opacity: 0.3},100);

    });
	    
    
/*  Gallery  */

var $SingleItem = jQuery('.thumb');
jQuery('.zoom-icon').css('opacity','0');
$SingleItem.hover(function(){
	
	jQuery(this).find('.zoom-icon').stop(true, true).animate({opacity: 1},200);
}, function(){
	jQuery(this).find('.zoom-icon').stop(true, true).animate({opacity: 0},200);
	
});


var $SingleGalItem = jQuery('.gallery-image-wrap');
jQuery('.zoom-icon, .link-icon').css('opacity','0');
$SingleGalItem.hover(function(){
	
	jQuery(this).find('.zoom-icon, .link-icon').stop(true, true).animate({opacity: 1},100);
}, function(){
	jQuery(this).find('.zoom-icon, .link-icon').stop(true, true).animate({opacity: 0},100);
	
}); 

jQuery(function(){

if (!((jQuery(".galleries .two-column .portfolio").length) == 0)) {
		jQuery(".galleries .two-column .portfolio").each(function (index, domEle) {
			// domEle == this
			if ((index+1)%2 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
		});
	};
});

jQuery(function(){

	if (!((jQuery(".galleries .three-column .portfolio").length) == 0)) {
			jQuery(".galleries .three-column .portfolio").each(function (index, domEle) {
				// domEle == this
				if ((index+1)%3 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
			});
		};
	});
      
	
});

//]]>