<?php   

/***************************************************************************
    Built by UFO Themes. http://www.ufothemes.com
    Copyright (C) 2012 UFO Themes    
***************************************************************************/ 

global $shortname;
$shortname = 'interstellar';

$template_dir = get_template_directory();

// Load iCore Framework and Theme Options
require_once ( $template_dir . '/icore/icore-init.php' );


/*** Load Theme Related Files ***/

// Load Theme Setup files
require_once ( $template_dir . '/includes/icore/theme-functions.php' );
// Load Theme Sidebars
require_once ( $template_dir . '/includes/icore/theme-sidebars.php' );
// Load Theme MetaBoxes
require_once ( $template_dir . '/includes/icore/theme-metaboxes.php' );
// Load Theme Filters
require_once ( $template_dir . '/includes/icore/theme-filters.php' );
// Load Theme Javascript
require_once ( $template_dir . '/includes/icore/theme-scripts.php' );
// Load Theme Setup files
require_once ( $template_dir . '/includes/icore/theme-taxonomies.php' );
// Load Theme Widgets
require_once ( $template_dir . '/includes/icore/theme-widgets.php' );
// Load Theme Setup files
require_once ( $template_dir . '/includes/icore/theme-customizer.php' );
// Load Theme Shortcodes
require_once ( $template_dir . '/ufo-shortcodes/shortcodes.php' );
?>