<?php

/*-----------------------------------------------------------------------------------*/
/* Setup Theme */
/*-----------------------------------------------------------------------------------*/  

if ( ! isset( $content_width ) ) $content_width = 960; 

add_action( 'after_setup_theme', 'icore_theme_setup' );

if ( ! function_exists( 'icore_theme_setup' ) ):

function icore_theme_setup() {
	
	// Load Theme Text Domain
	load_theme_textdomain( 'InterStellar', get_template_directory() . '/lang' );

	// Add WordPress theme support
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	$defaults = array(
		'default-color'          => 'F5F5F5',
		'default-image'          => get_template_directory_uri(). '/images/bg.png',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $defaults );
	add_editor_style();

	// Update Image Sizes
	update_option( 'thumbnail_size_w', 53, true );
	update_option( 'thumbnail_size_h', 53, true );
	update_option( 'medium_size_w', 620, true );
	update_option( 'medium_size_h', '', true );
	update_option( 'large_size_w', 940, true );
	update_option( 'large_size_h', '', true );
	
	// Add additional image sizes
	set_post_thumbnail_size( 53, 53, true ); // square thumbnail
	add_image_size( 'entry-thumb', 120, 120, true ); // square images
	add_image_size( 'gallery-thumb', 460, 320, true ); // square images

	// Register Custom Menus
	register_nav_menus( array(
		'primary-menu' => __( 'Primary Menu', 'InterStellar' )
	) );

}
endif; // icore_theme_setup 

// Load Theme CSS files
add_action( 'wp_enqueue_scripts', 'icore_load_theme_styles' );

if ( ! function_exists( 'icore_load_theme_styles' ) ):
	function icore_load_theme_styles() {
		global $options;
	
		// load style.css file
		wp_enqueue_style( 'style', get_stylesheet_uri() );
	
		if ( isset ( $options['colorscheme'] ) && 'default' != $options['colorscheme'] ) {
	        wp_enqueue_style( 'alt-style', get_template_directory_uri() . '/css/' . $options['colorscheme'] . '.css', array( 'style' ) );
		}	
}
endif; // icore_load_theme_styles

/*-----------------------------------------------------------------------------------*/
/* Additional Theme Functions */
/*-----------------------------------------------------------------------------------*/
  
?>