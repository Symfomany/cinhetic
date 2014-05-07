<?php

/*-----------------------------------------------------------------------------------*/
/* Load Theme JavaScript */
/*-----------------------------------------------------------------------------------*/  

if (!is_admin())
	add_action( 'wp_enqueue_scripts', 'theme_js' );
	
/* Load frontend javascripts */
function theme_js( ) {
    
	// Load javascript
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('shadowbox', get_template_directory_uri() . '/js/shadowbox/shadowbox.js', array('jquery'));
    wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery')); 
	wp_enqueue_script('theme-js', get_template_directory_uri() . '/js/theme.js', array('jquery'));
	wp_enqueue_script('mobile-menu', get_template_directory_uri() . '/js/mobile.menu.js', array('jquery'));

	wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/flexslider/jquery.flexslider-min.js', array('jquery'));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
			
	// Load javascript related styles
	wp_enqueue_style( 'shadowbox', get_template_directory_uri() . '/js/shadowbox/shadowbox.css' );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/js/flexslider/flexslider.css' );
	
	//Load fonts
	wp_enqueue_style( 'Lobster-font', 'http://fonts.googleapis.com/css?family=Lobster&v1' );
	wp_enqueue_style( 'DroidSans-font', 'http://fonts.googleapis.com/css?family=Droid+Sans:700' );
}

if (!is_admin())
	add_action( 'wp_head', 'init_slider' );
	
function init_slider() {
	if ( is_home() || is_front_page() ) include( get_template_directory() . '/js/flexslider/flexslider_init.php' );
	if ( is_single() && 'portfolio' == get_post_type() )
		wp_enqueue_script('portfolio-slider-js', get_template_directory_uri() . '/js/flexslider/portfolio-slider.js', array('jquery'));
}

//  Load product slider widget js 
function portfolio_widget_js() {
       wp_enqueue_script('portfolio-widget-js', get_template_directory_uri() . '/js/portfolio-widget.js'); 
}

?>