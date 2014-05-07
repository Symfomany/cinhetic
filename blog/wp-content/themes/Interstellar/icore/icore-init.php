<?php

/*-----------------------------------------------------------------------------------*/
/* Load the required iCore Framework Files */
/*-----------------------------------------------------------------------------------*/

add_action( 'after_setup_theme', 'icore_framework_setup' );

if ( ! function_exists( 'icore_framework_setup' ) ):
	function icore_framework_setup() {
		
		// Load WP Settings API Theme Options
		require ( get_template_directory() . '/icore/icore.php' );

		// Load iCore Helper Functions
		require ( get_template_directory() . '/icore/functions.php' );

}
endif; // icore_framework_setup
?>