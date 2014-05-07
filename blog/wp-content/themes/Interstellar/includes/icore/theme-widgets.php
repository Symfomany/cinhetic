<?php 

/*-----------------------------------------------------------------------------------*/
/* Register Theme Widgets */
/*-----------------------------------------------------------------------------------*/

$wp_ver = substr($GLOBALS['wp_version'],0,3);
if ($wp_ver >= 2.8) {
	$template_dir = get_template_directory();
	include($template_dir . '/includes/icore/widgets/widget-twitter.php'); 
	include($template_dir . '/includes/icore/widgets/widget-ads.php');
	include($template_dir . '/includes/icore/widgets/widget-recentposts.php');
	include($template_dir . '/includes/icore/widgets/widget-blurb.php');
	include($template_dir . '/includes/icore/widgets/widget-portfolio.php');
}      
?>