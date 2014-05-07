<?php

/**
 * WP 3.4 Theme Customizer
 */

add_action( 'customize_register', 'theme_customize_register' );

function theme_customize_register( $wp_customize ) {	

	// extending the field type to textarea
	class theme_custom_css extends WP_Customize_Control {
		public $type = 'customarea';

		public function render_content() {
			$options = get_option( 'interstellar_options' );
			$stored = "";
			if( isset( $options['custom_css'] ) ) { $stored = $options['custom_css']; }
			echo '<textarea style="width:100%;height:200px;">' . $stored . '</textarea>';
		}
		public function enqueue() {
			wp_enqueue_script( 'customarea', get_template_directory_uri() . '/icore/js/customizer.js', array( 'customize-controls' ), '20120607', true );
		}
	}

	// get our theme options so we can use defaults below
	$options = get_option( 'interstellar_options' );

	// enables live change support
	$wp_customize->get_setting('blogname')->transport='postMessage';
	$wp_customize->get_setting('blogdescription')->transport='postMessage';
	$wp_customize->get_setting('header_textcolor')->transport='postMessage';

	// add a setting to an existing theme option
	$wp_customize->add_setting( 'interstellar_options[logo]', array(
		'default'        => $options['logo'],
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		//'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label'      => __( 'Upload Logo', 'InterStellar' ),
		'section'    => 'title_tagline',
		'settings'   => 'interstellar_options[logo]'
	) ) );

	// add a setting to an existing theme option
	$wp_customize->add_setting( 'interstellar_options[colorscheme]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( 'interstellar_color_customizer', array(
		'settings'		=> 'interstellar_options[colorscheme]',
		'label'			=> __( 'Select color scheme', 'InterStellar' ),
		'section'		=> 'colors',
		'type'			=> 'select',
		'choices' => array(
				'default' => 'blue',
				'green' => 'green',
				'red' => 'red',
				'pink' => 'pink',
				'orange' => 'orange'
				),
		'priority'		=> 5
	) );


	// add customizer section
	$wp_customize->add_section( 'interstellar_appearance', array(
		'title'			=> __( 'Appearance', 'InterStellar' ),
		'priority'		=> 50
	) );
	
	// add a setting to an existing theme option
		$wp_customize->add_setting( 'interstellar_options[search]', array(
			'default'        => '',
			'type'           => 'option',
			'capability'     => 'edit_theme_options',
			//'transport'      => 'postMessage'
		) );

		// intercept the theme option and control it
		$wp_customize->add_control( 'interstellar_search_customizer', array(
			'settings'		=> 'interstellar_options[search]',
			'label'			=> __( 'Display Search Bar', 'InterStellar' ),
			'section'		=> 'interstellar_appearance',
			'type'			=> 'checkbox'
		) );
		
	// add a setting to an existing theme option
	$wp_customize->add_setting( 'interstellar_options[call_to_action_enabled]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		//'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( 'interstellar_call_to_action_enabled_customizer', array(
		'settings'		=> 'interstellar_options[call_to_action_enabled]',
		'label'			=> __( 'Display Homepage Call to Action', 'InterStellar' ),
		'section'		=> 'interstellar_appearance',
		'type'			=> 'checkbox'
	) );
	
	// add a setting to an existing theme option
	$wp_customize->add_setting( 'interstellar_options[slider_enabled]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		//'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( 'interstellar_slider_enabled_customizer', array(
		'settings'		=> 'interstellar_options[slider_enabled]',
		'label'			=> __( 'Display Homepage Slider', 'InterStellar' ),
		'section'		=> 'interstellar_appearance',
		'type'			=> 'checkbox'
	) );
	
	// add a setting to an existing theme option
	$wp_customize->add_setting( 'interstellar_options[portfolio_posts]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( 'interstellar_portfolio_posts', array(
		'settings'		=> 'interstellar_options[portfolio_posts]',
		'label'			=> __( 'Homepage Portfolio Items', 'InterStellar' ),
		'section'		=> 'interstellar_appearance',
		'type'			=> 'select',
		'choices' => array(
				'0' => 'none',
				'4' => '4',
				'8' => '8',
				'12' => '12',
				'16' => '16'
				)
	) );

	
	// add customizer section
	$wp_customize->add_section( 'interstellar_custom_css', array(
		'title'			=> __( 'Custom CSS', 'InterStellar' ),
		'priority'		=> 60
	) );

	// add a setting to an existing theme option
	$wp_customize->add_setting( 'interstellar_options[custom_css]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage'
	) );

	// intercept the theme option and control it
	$wp_customize->add_control( new theme_custom_css( $wp_customize, 'custom_css', array(
		'settings'		=> 'interstellar_options[custom_css]',
		'label'			=> __( 'Custom CSS', 'InterStellar' ),
		'section'		=> 'interstellar_custom_css'
	) ) );


	/**
	 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
	 * Used with fonts
	 *
	 * @since InterStellar 1.0
	 */
	function theme_customizer_preview_js() { ?>
		<?php
		$doc_ready_script = '
		<script type="text/javascript">
			(function($){
				$(document).ready(function() {

					wp.customize("blogname", function(value) {
						value.bind(function(to) {
							$(".logo a").html(to);
						});
					});

					wp.customize("blogdescription", function(value) {
						value.bind(function(to) {
							$("#tagline").html(to);
						});
					});

					wp.customize( "header_textcolor", function( value ) {
						value.bind( function( to ) {
							$(".site-title a, .site-description").css("color", to ? to : "" );
						});
					});


					wp.customize("interstellar_options[logo]", function(value) {
						value.bind(function(to) {
							$(".logo a").html("<img id=\"logo\" alt=\"' . get_bloginfo( 'name' ) . '\" src=\"" + to + "\">" );
						});
					});


					wp.customize("interstellar_options[colorscheme]",function(value) {
						value.bind(function(to) {
							$("#alt-style-css").attr("href", "'. get_template_directory_uri() .'/css/"+to+".css");
						});
					});

					wp.customize("interstellar_options[custom_css]",function(value) {
						value.bind(function(to) {
							$("#tempcss").remove();
							var googlefont = to.split(",");
							$("body").append("<div id=\"tempcss\"><style type=\"text/css\">"+to+"</style></div>");
						});
					});
					
					wp.customize("interstellar_options[search]",function(value) {
						value.bind(function(to) {
							if( to == "1" )  { 
								$("#searchbar").show(); 
							} else {
								$("#searchbar").hide();
							}
						});
					});
					
			});
		})(jQuery);
		</script>';

		echo $doc_ready_script;
	}
	if ( $wp_customize->is_preview() && ! is_admin() )
		add_action( 'wp_footer', 'theme_customizer_preview_js', 21 );
}

?>