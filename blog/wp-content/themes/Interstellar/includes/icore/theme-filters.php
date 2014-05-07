<?php 

/*-----------------------------------------------------------------------------------*/
/* Theme Filters */
/*-----------------------------------------------------------------------------------*/

// Filter excerpt length
function icore_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'icore_excerpt_length', 999 );

// Change Excerpt [...] Symbol
function _theme_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', '_theme_excerpt_more'); 

/**
 * Filters the body_class and adds the css class
 */
function icore_browser_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
		// Browser detection
		if($is_lynx) $classes[] = 'browser-lynx';
		elseif($is_gecko) $classes[] = 'browser-gecko';
		elseif($is_opera) $classes[] = 'browser-opera';
		elseif($is_NS4) $classes[] = 'browser-ns4';
		elseif($is_safari) $classes[] = 'browser-safari';
		elseif($is_chrome) $classes[] = 'browser-chrome';
		elseif($is_IE) $classes[] = 'browser-ie';
		elseif($is_iphone) $classes[] = 'browser-iphone';
		else $classes[] = 'unknown';
		
		// Check for non-multisite installs
		if ( ! is_multi_author() ) $classes[] = 'single-author';
		// Do we have a header image?
		$header_image = get_header_image();
	    if ( $header_image ) $classes[] = 'has-header-image';
	
	    // Is the sidebar enabled?
	    if ( is_home() && is_active_sidebar('homepage-sidebar') )
	    	$classes[] = 'active-homepage-sidebar';
	
		if ( !is_home() && is_active_sidebar('sidebar') )
	    	$classes[] = 'active-sidebar';

	return $classes;
}
// Filter body_class with the function above
add_filter('body_class','icore_browser_class');
    
?>