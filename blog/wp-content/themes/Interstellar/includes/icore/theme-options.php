<?php

/*-----------------------------------------------------------------------------------*/
/* Register Theme Options */
/*-----------------------------------------------------------------------------------*/
global $options;

$this->sections['general']      = __( 'General', 'icore' );
$this->sections['appearance']   = __( 'Appearance', 'icore' );
$this->sections['thumbnails']   = __( 'Thumbnails', 'icore' );
$this->sections['social']   = __( 'Social', 'icore' );
$this->sections['homepage']   = __( 'Homepage', 'icore' );
$this->sections['slider']   = __( 'Homepage Slider', 'icore' );
$this->sections['themes']   = __( 'Get More Themes', 'icore' );

/* Define Theme Options */

/* General Settings
===========================================*/


$this->settings['colorscheme'] = array(
	'section' => 'general',
	'title'   => __( 'Color Scheme', 'icore' ),
	'desc'    => __( 'Select color scheme', 'icore' ),
	'type'    => 'select',
	'std'     => 'default',
	'choices' => array(
		'default' => 'blue',
		'green' => 'green',
		'red' => 'red',
		'pink' => 'pink',
		'orange' => 'orange'
	)
);

$this->settings['favicon'] = array(
    'title'   => __( 'Custom Favicon ' ),
    'desc'    => __( 'Upload favicon image here.' ),
    'std'     => '',
    'type'    => 'upload',
    'section' => 'general'
);

$this->settings['logo'] = array(
    'title'   => __( 'Logo Image' ),
    'desc'    => __( 'Upload logo image' ),
    'std'     => '',
    'type'    => 'upload',
    'section' => 'general'
);

$this->settings['google_analytics'] = array(
    'title'   => __( 'Google Analytics' ),
    'desc'    => __( 'Paste your <a href="http://www.google.com/analytics/" rel="nofollow" target="_blank" >Google Analytics</a> code above.' ),
    'std'     => '',
    'type'    => 'textarea',
    'section' => 'general'
);


/* Social
===========================================*/
$this->settings['facebook'] = array(
	'title'   => __( 'Facebook Icon' ),
	'desc'    => __( 'enter your Facebook page url' ),
	'std'     => '',
	'type'    => 'text',
	'section' => 'social'
);
$this->settings['twitter'] = array(
	'title'   => __( 'Twitter Icon' ),
	'desc'    => __( 'enter your Twitter page url' ),
	'std'     => '',
	'type'    => 'text',
	'section' => 'social'
);
$this->settings['rss'] = array(
	'title'   => __( 'RSS Icon' ),
	'desc'    => __( 'enter your RSS feed url' ),
	'std'     => '',
	'type'    => 'text',
	'section' => 'social'
);
$this->settings['youtube'] = array(
	'title'   => __( 'YouTube Icon' ),
	'desc'    => __( 'enter your YouTube page url' ),
	'std'     => '',
	'type'    => 'text',
	'section' => 'social'
);
	

/* Appearance
===========================================*/

$this->settings['search'] = array(
	'section' => 'appearance',
	'title'   => __( 'Search Bar' ),
	'desc'    => __( 'display header search bar' ),
	'type'    => 'checkbox',
	'std'     => '1'
);

$this->settings['portfolio_layout'] = array(
	'section' => 'appearance',
	'title'   => __( 'Portfolio Layout', 'icore' ),
	'desc'    => __( 'Select layout for portfolio archive pages', 'icore' ),
	'type'    => 'select',
	'std'     => 'two',
	'choices' => array(
		'one' => 'one column',
		'two' => 'two column',
		'three' => 'three column'
	)
);

$this->settings['blog_style'] = array(
	'section' => 'appearance',
	'title'   => __( 'Full Post Content' ),
	'desc'    => __( 'show full post content instead of excerpt' ),
	'type'    => 'checkbox',
	'std'     => ''
);

$this->settings['custom_css'] = array(
	'title'   => __( 'Custom CSS' ),
	'desc'    => __( 'Enter your custom CSS code here.' ),
	'std'     => '',
	'type'    => 'textarea',
	'section' => 'appearance',
	'class'   => 'code'
);


/* Homepage
===========================================*/

$this->settings['call_to_action_enabled'] = array(
			'section' => 'homepage',
			'title'   => __( 'Call to Action' ),
			'desc'    => __( 'Display Call to Action Button'),
			'std'     => '1',
			'type'    => 'checkbox'
		);
		
$this->settings['call_to_action_one'] = array(
			'section' => 'homepage',
			'title'   => __( 'Call to Action Line One Text' ),
			'desc'    => __( 'Enter text for line one'),
			'std'     => 'Do not delay. Sign up today and get a one month FREE trial !',
			'type'    => 'text'
		);
		
$this->settings['call_to_action_two'] = array(
			'section' => 'homepage',
			'title'   => __( 'Call to Action Line Two Text' ),
			'desc'    => __( 'Enter text for line two'),
			'std'     => 'You can change this text by going to Appearance -> Theme Options -> Homepage',
			'type'    => 'text'
		);

$this->settings['call_to_action_button'] = array(
			'section' => 'homepage',
			'title'   => __( 'Call to Action Button Text' ),
			'desc'    => __( 'Enter button text'),
			'std'     => 'Sign Up',
			'type'    => 'text'
		);
			
$this->settings['call_to_action_link'] = array(
			'section' => 'homepage',
			'title'   => __( 'Call to Action Button Link' ),
			'desc'    => __( 'Enter button link'),
			'std'     => '',
			'type'    => 'text'
		);				

$this->settings['portfolio_posts'] = array(
	'section' => 'homepage',
	'title'   => __( 'Homepage Portfolio Items', 'icore' ),
	'desc'    => __( 'Select number of portfolio items to show on homepage', 'icore' ),
	'type'    => 'select',
	'std'     => '4',
	'choices' => array(
		'0' => 'none',
		'4' => '4',
		'8' => '8',
		'12' => '12',
		'16' => '16'
	)
);
/* Thumbnails
===========================================*/

$this->settings['front-page_thumb'] = array(
	'section' => 'thumbnails',
	'title'   => __( 'Front page thumbnails' ),
	'desc'    => __( 'show thumbnails on Front page' ),
	'type'    => 'checkbox',
	'std'     => '1'
);

$this->settings['category_thumb'] = array(
	'section' => 'thumbnails',
	'title'   => __( 'Category page thumbnails' ),
	'desc'    => __( 'show thumbnails on Category pages' ),
	'type'    => 'checkbox',
	'std'     => '1'
);

$this->settings['author_thumb'] = array(
	'section' => 'thumbnails',
	'title'   => __( 'Author page thumbnails' ),
	'desc'    => __( 'show thumbnails on Author pages' ),
	'type'    => 'checkbox',
	'std'     => '1'
);

$this->settings['tag_thumb'] = array(
	'section' => 'thumbnails',
	'title'   => __( 'Tag page thumbnails' ),
	'desc'    => __( 'show thumbnails on Tag pages' ),
	'type'    => 'checkbox',
	'std'     => '1'
);

$this->settings['single_thumb'] = array(
	'section' => 'thumbnails',
	'title'   => __( 'Single post thumbnail' ),
	'desc'    => __( 'show thumbnails on Single posts' ),
	'type'    => 'checkbox',
	'std'     => '1'
);

$this->settings['page_thumb'] = array(
	'section' => 'thumbnails',
	'title'   => __( 'Single page thumbnail' ),
	'desc'    => __( 'show thumbnails on Single page' ),
	'type'    => 'checkbox',
	'std'     => '1'
);

$this->settings['search_thumb'] = array(
	'section' => 'thumbnails',
	'title'   => __( 'Search page thumbnail' ),
	'desc'    => __( 'show thumbnails on search page' ),
	'type'    => 'checkbox',
	'std'     => ''
);


/* Slider
===========================================*/

$this->settings['slider_enabled'] = array(
    'section' => 'slider',
    'title'   => __( 'Homepage Slider', 'icore' ),
    'desc'    => __( 'Enable Homepage Slider', 'icore' ),
    'type'    => 'checkbox',
    'std'     => ''
);

$this->settings['slider_auto'] = array(
    'section' => 'slider',
    'title'   => __( 'Automatic Animation', 'icore' ),
    'desc'    => __( 'Animate slider automatically', 'icore' ),
    'type'    => 'checkbox',
    'std'     => '1'
);

$this->settings['slider_animation'] = array(
	'section' => 'slider',
	'title'   => __( 'Slider Effect', 'icore' ),
	'desc'    => __( 'Select slider animation effect', 'icore' ),
	'type'    => 'select',
	'std'     => 'fade',
	'choices' => array(
		'fade' => 'fade',
		'slide' => 'slide'
	)
);

$this->settings['slider_speed'] = array(
	'section' => 'slider',
	'title'   => __( 'Slideshow Speed' ),
	'desc'    => __( 'Set the speed of the slideshow cycling, in milliseconds. 1 second = 1000 milliseconds.' ),
	'type'    => 'text',
	'std'     => '7000'
);


$this->settings['slider'] = array(
    'section' => 'slider',
    'title'   => __( 'Slideshow Images', 'InterStellar' ),
    'desc'    => __( 'Upload slider Images. Drag and drop to reorganize.', 'InterStellar' ),
    'type'    => 'slide',
    'std'     => ''
);

$this->settings['themes_link'] = array(
	'section' => 'themes',
	'title'   => __( 'Find More Awesome Themes', 'icore' ),
	'desc'    => __( 'Click the link above to see more themes by UFO Themes', 'icore' ),
	'type'    => 'html',
	'std'     => '<a href="http://www.ufothemes.com/themes/" target="_blank">Browse Our WordPress Themes</a>'
);

?>