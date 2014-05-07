<?php

/*-----------------------------------------------------------------------------------*/
/* Register Theme Sidebars */
/*-----------------------------------------------------------------------------------*/  

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar',
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget' => '</div> <!-- .widget-content --></div> <!-- end .widget -->',
		'before_title' => '<div class="sidebar-header"><h3>',
		'after_title' => '</h3></div><div class="widget-content">',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
	'name' => 'Homepage 1/4',
	'id' => 'homepage',
    'before_widget' => '<div class="home-widget %2$s"><div class="widget-content">',
    'after_widget' => '</div> <!-- .widget-content --></div> <!-- .home-widget -->',
    ));  

if ( function_exists('register_sidebar') )
    register_sidebar(array(
	'name' => 'Homepage 1/2',
	'id' => 'homepage-2',
    'before_widget' => '<div class="home-widget %2$s"><div class="widget-content">',
    'after_widget' => '</div> <!-- .widget-content --></div> <!-- .home-widget -->',
    ));


if ( function_exists('register_sidebar') )
    register_sidebar(array(
	'name' => 'Footer',
	'id' => 'footer-sidebar',
    'before_widget' => '<div class="footer-widget %2$s">',
    'after_widget' => '</div> <!-- end .widget-content --></div> <!-- end .footer-widget -->',
    'before_title' => '<h4 class="widget-title">',
    'after_title' => '</h4><div class="widget-content">',
    ));   
?>