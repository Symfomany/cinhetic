<?php
/*
Plugin Name: Light - Responsive LightBox
Plugin URI: http://captaintheme.com/plugins/light/
Description: Automatically makes all images that link to other images into a responsive lightbox, using FancyBox from FancyApps.
Author: Captain Theme
Author URI: http://captaintheme.com
Version: 1.1
*/

/* -Changes-
	1.1: Better Video Embedding with the 'video' class.

/*
|--------------------------------------------------------------------------
| SCRIPTS/STYLES
|--------------------------------------------------------------------------
*/

function light_load_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'fancybox', plugin_dir_url( __FILE__ ) . 'js/jquery.fancybox.pack.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'fancybox-load', plugin_dir_url( __FILE__ ) . 'js/light.js', array( 'fancybox' ), false, true );
	wp_enqueue_style( 'fancybox-style', plugin_dir_url( __FILE__ ) . 'css/jquery.fancybox.css' );
}
add_action('wp_enqueue_scripts', 'light_load_scripts');


/*
|--------------------------------------------------------------------------
| BLOCK WORDPRESS.ORG UPDATE CHECKS
|--------------------------------------------------------------------------
*/

function light_hide_plugin( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) )
		return $r; // Not a plugin update request. Bail immediately.
	$plugins = unserialize( $r['body']['plugins'] );
	unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
	unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
	$r['body']['plugins'] = serialize( $plugins );
	return $r;
}

add_filter( 'http_request_args', 'light_hide_plugin', 5, 2 );


/*
|--------------------------------------------------------------------------
| ADD OUR OWN AUTOMATIC UPDATE CHECKER
|--------------------------------------------------------------------------
*/

require( plugin_dir_path( __FILE__ ) . 'includes/updater.php' );