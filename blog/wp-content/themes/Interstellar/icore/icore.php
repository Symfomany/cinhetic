<?php

/**
 * iCore
 * @since iCore 2.0
 */

global $shortname, $version;
$version = "2.0.1";

class Icore_Theme_Options {

	// Array of sections for the theme options page
	public $sections;
	public $checkboxes;
	public $settings;

	// Initialize
	public function __construct() {
		global $shortname;
		
		// Get theme info
		if ( function_exists('wp_get_theme') ) {
			$theme = wp_get_theme();
			$this->theme['authorURI'] = $theme->{'Author URI'};
		} else {
			$theme = get_theme_data( get_stylesheet_directory() . '/style.css' );
			$this->theme['authorURI'] = $theme['AuthorURI'];
		}
		
		$this->theme['name'] = $theme['Name'];
		$this->theme['nicename'] = strtolower( str_replace( " ", "-", $this->theme['name'] ) );
		$this->theme['textdomain'] = strtolower( str_replace( " ", "_", $this->theme['name'] ) );
		$this->theme['version'] = $theme['Version'];
		$this->theme['author'] = $theme['Author'];
		$this->theme['uri'] = $this->theme['authorURI'] . "/themes/" . $this->theme['nicename'];
		$this->theme['support'] = $this->theme['authorURI'] . '/support/';
		$this->theme['readme'] = get_template_directory_uri() . '/readme.txt';
		
		// This will keep track of the checkbox options for the validate_settings function.
		$this->checkboxes = array();
		$this->settings = array();
	
		add_action( 'admin_menu', array( &$this, 'add_pages' ) );
		add_action( 'admin_init', array( &$this, 'register_settings' ) );	
		add_action( 'wp_ajax_readme', array( &$this, 'displayReadme' ) );
			
		//	Load Theme Options	
		require_once ( get_template_directory() . '/includes/icore/theme-options.php' );
		
		if ( ! get_option( $shortname . '_options' ) )
			$this->initialize_settings();
	}

	// Add pages to the admin menu
	public function add_pages() {
		
		$options_page = add_theme_page( __( 'Theme Options', $this->theme['textdomain'] ), __( 'Theme Options', $this->theme['textdomain'] ), 'manage_options', 'theme-options', array( &$this, 'options_page' ) );
		
		$instructions_page = add_theme_page( __( 'Theme Instructions', $this->theme['textdomain'] ), __( 'Theme Instructions', $this->theme['textdomain'] ), 'manage_options', 'theme-instructions', array( &$this, 'instructions_page' ) );
				
		add_action( 'admin_print_scripts-' . $options_page, array( &$this, 'scripts' ) );
		add_action( 'admin_print_styles-' . $options_page, array( &$this, 'styles' ) );
	}

	// jQuery Tabs for Theme Options page
	public function scripts() {
		
		wp_print_scripts( 'jquery-ui-tabs' );
		wp_print_scripts( 'jquery-ui-dialog' );
		
		//Media Uploader Scripts
		wp_register_script('upload-option', get_stylesheet_directory_uri() . '/icore/js/uploader.js', array('jquery','media-upload','thickbox'));
		wp_register_script('appendo', get_stylesheet_directory_uri() . '/icore/js/jquery.appendo.js', array('jquery'));
			
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('upload-option');
		wp_enqueue_script('appendo');
		wp_enqueue_script( 'jquery-ui-sortable' );
		
	}
	
	// HTML to display the Theme Options page
	public function options_page() {
		
		global $shortname, $version;		
		echo '<div id="icore-wrap" class="wrap">';
		screen_icon( 'themes' );
		echo '<h2>' . __( 'Theme Options', $this->theme['textdomain'] ) . '</h2>';
		echo '<ul class="icore-info">';
		echo '<li class="icore-version">' . __( 'iCore Version: ', $this->theme['textdomain'] ) . $version . '</li>';
		echo '<li><a href="' . $this->theme['uri'] . '" target="_blank">' . $this->theme['name'] . '</a></li>';
		echo '<li>' . __( 'Version: ', $this->theme['textdomain'] ) . $this->theme['version'] . '</li>';
		echo '<li><a href="' . $this->theme['support'] . '"" target="_blank">' . __( 'Support', $this->theme['textdomain'] ) . '</a></li>';
		echo '<li><a class="thickbox" href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=readme&height=800&width=640" title="' . __( 'Theme Instructions', $this->theme['textdomain'] ) . '">' . __( 'Instructions', $this->theme['textdomain'] ) . '</a></li>';
		echo '</ul>';

		echo '<form action="options.php" method="post" id="icore_form">';

			settings_fields( $shortname . '_options' );
			echo '<div class="ui-tabs">
				<ul class="ui-tabs-nav">';

			foreach ( $this->sections as $section )
				echo '<li><a href="#' . strtolower( str_replace( ' ', '_', $section ) ) . '" class="' . strtolower( str_replace( ' ', '_', $section ) ) . '">' . $section . '</a></li>';

			echo '</ul>';
			do_settings_sections( $_GET['page'] );

			echo '</div>
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Changes' ) . '" /></p>
			</form>';
		
		echo '
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				
				var wrapped = $(".wrap h3").wrap("<div class=\"ui-tabs-panel\">");
				wrapped.each(function() {
					$(this).parent().append($(this).parent().nextUntil("div.ui-tabs-panel"));
				});
				
				
				$(".ui-tabs-panel").each(function(index) {
					var str = $(this).children("h3").text().replace(/\s/g, "_");
					$(this).attr("id", str.toLowerCase());
					if (index > 0)
						$(this).addClass("ui-tabs-hide");
				});
				
				$(".ui-tabs").tabs({ fx: { opacity: "toggle", duration: "fast" } });
				
				$("input[type=text], textarea").each(function() {
					if ($(this).val() == $(this).attr("placeholder"))
						$(this).css("color", "#999");
				});

				$("input[type=text], textarea").focus(function() {
					if ($(this).val() == $(this).attr("placeholder")) {
						$(this).val("");
						$(this).css("color", "#000");
					}
				}).blur(function() {
					if ($(this).val() == "" || $(this).val() == $(this).attr("placeholder")) {
						$(this).val($(this).attr("placeholder"));
						$(this).css("color", "#888");
					}
				});
				
				$(".wrap h3, .wrap table").show();
				
				if ($.browser.mozilla)
				         $("form").attr("autocomplete", "off");
				
				
					// Slider
					// call Appendo
		            $("#slideshow_list").appendo({
		                allowDelete: false,
		                labelAdd: "Add Another Slide",
		                subSelect: "li.slide:last",
		                onAdd: clear_fields
		            });

		            // slide delete button
					$("#slideshow_list li.slide").ready(function() {
						if($("#slideshow_list li.slide").size() == 1) {
							$(".submitdelete").hide();
						}
						return false;
					});
		            $("#slideshow_list li.slide .remove_slide").live("click", function() {
		                
		                    $(this).parent().slideUp(300, function() {
		                        $(this).remove();
		                    })
		                
		                return false;
		            });

		            function clear_fields($row)
		            {

		                $row.find("input,textarea").val("");
		                $row.find(".upload-img-preview").html("");
						$row.find(".editslideimage, .doneslideimage").hide();
						$row.find(".image-details").removeClass("slidedetails")						
		                return true;
		            };

		            $("#slideshow_list").sortable();

					$("#slides-details-button").click(function(){
						$("#slideshow_list li").toggleClass("list-view");
						$("#slides-details-button").toggleClass("list");

					});
					
					// Edit Image Button
					$(".image-details").hide();
					$(".image-details-overlay").hide();
					
					$(".editslideimage").live("click",function(){
						imageDetails = $(this).parents(".slide").find(".image-details");
						$(imageDetails).slideToggle();
					});
					
					
					$(".doneslideimage").live("click",function(){
						imageDetails = $(this).parents(".slide").find(".image-details");
						$(imageDetails).slideToggle();
					});	
			});
		</script>
		</div>';
	}
	
	
	// HTML to display the Theme Options page
	public function instructions_page() {
		
		global $shortname, $version;		
		echo '<div id="icore-wrap" class="wrap">';
		screen_icon( 'themes' );
		echo '<h2>' . __( 'Theme Instructions', $this->theme['textdomain'] ) . '</h2>';
		$response = wp_remote_get( get_stylesheet_directory_uri().'/readme.txt' );
		if( is_wp_error( $response ) ) {
		   echo 'Unable to load the instructions.';
		} else {
		   $readme = $response['body'];
		}
		$readme = nl2br(esc_html($readme));
		// clickable links
		// code, strong, em tags
		$readme = preg_replace('/`(.*?)`/', '<code>\\1</code>', $readme);
		$readme = preg_replace('/[\040]\*\*(.*?)\*\*/', ' <strong>\\1</strong>', $readme);
		$readme = preg_replace('/[\040]\*(.*?)\*/', ' <em>\\1</em>', $readme);
		// heading
		$readme = preg_replace('/=== (.*?) ===/', '<h2>\\1</h2>', $readme);
		$readme = preg_replace('/== (.*?) ==/', '<h3>\\1</h3>', $readme);
		$readme = preg_replace('/= (.*?) =/', '<h4>\\1</h4>', $readme);
		
		// links
		$readme = preg_replace('#(^|[\[]{1}[\s]*)([^\n<>^\)]+)([\]]{1}[\(]{1}[\s]*)(http://|ftp://|mailto:|https://)([^\s<>]+)([\s]*[\)]|$)#', '<a href="$4$5">$2</a>', $readme);
		
		$readme = preg_replace('#(^|[^\"=]{1})(http://|ftp://|mailto:|https://)([^\s<>]+)([\s\n<>]|$)#', '$1<a href="$2$3">$2$3</a>$4', $readme);
		
		echo $readme;
		echo '</div>';
	}
	
	
	/**
	 * Format Pages for $choices array.
	 *
	 * @uses get_pages
	 * @param $value, the value to be used in the option value=""
	 * default is ID, any index can be used as a value.
	 * see codex: http://codex.wordpress.org/Function_Reference/get_pages
	 */
	public function getPages( $value = null, $firstblank = false ) {

		if ( is_null( $value ) )
			$value = 'ID';

		$args = array( 'post_type' => 'page' );
		$obj = get_pages( $args );

		$items = array();
		$items['none'] = '-- None --';
		if( $firstblank ) {
			$terms[''] = '-- Choose One --';
		}

		foreach ( $obj as $item ) {
			$items[$item->$value] = $item->post_title;
		}

		return $items;
	}
	
	
	/**
	 * Parse the readme.txt file
	 *
	 * @uses parseFile()
	 * @return html parsed from markdown in txt
	 */
	public function displayReadme() {
		print $this->parseFile( $this->theme['readme'] );
		exit();
	}
	
	
	public function parseFile( $url=null ) {

		// no/wrong url
		if ( empty($url) or basename($url) != 'readme.txt')
			return false;

		$response = wp_remote_get( $url );
		if( is_wp_error( $response ) ) {
		   echo 'Unable to load theme instructions.';
		} else {
		   $readme = $response['body'];
		}

		// make links clickable
		$readme = nl2br(esc_html($readme));
		// code, strong, em
		$readme = preg_replace('/`(.*?)`/', '<code>\\1</code>', $readme);
		$readme = preg_replace('/[\040]\*\*(.*?)\*\*/', ' <strong>\\1</strong>', $readme);
		$readme = preg_replace('/[\040]\*(.*?)\*/', ' <em>\\1</em>', $readme);
		// headings
		$readme = preg_replace('/=== (.*?) ===/', '<h2>\\1</h2>', $readme);
		$readme = preg_replace('/== (.*?) ==/', '<h3>\\1</h3>', $readme);
		$readme = preg_replace('/= (.*?) =/', '<h4>\\1</h4>', $readme);
		// links
		$readme = preg_replace('#(^|[\[]{1}[\s]*)([^\n<>^\)]+)([\]]{1}[\(]{1}[\s]*)(http://|ftp://|mailto:|https://)([^\s<>]+)([\s]*[\)]|$)#', '<a href="$4$5">$2</a>', $readme);
		$readme = preg_replace('#(^|[^\"=]{1})(http://|ftp://|mailto:|https://)([^\s<>]+)([\s\n<>]|$)#', '$1<a href="$2$3">$2$3</a>$4', $readme);

		return  $readme;
	}
	
	// Define all settings and their defaults
	
	/* Register settings via the WP Settings API */
	public function register_settings() {
		global $shortname;
		register_setting( $shortname . '_options', $shortname . '_options', array ( &$this, 'validate_settings' ) );

		foreach ( $this->sections as $slug => $title )
			add_settings_section( $slug, $title, array( &$this, 'display_section' ), 'theme-options' );

		foreach ( $this->settings as $id => $setting ) {
			$setting['id'] = $id;
			$this->create_setting( $setting );
		}

	}

	// Initialize settings to their default
	public function initialize_settings( $settings=null ) {
		
		global $shortname;
		
		if ( is_null( $settings ) )
			$settings = $this->settings;
			
		$default_settings = array();
		foreach ( $settings as $id => $setting ) {
			if ( $setting['type'] != 'heading' )
				$default_settings[$id] = $setting['std'];
		}

		update_option( $shortname . '_options', $default_settings );

	}

	
	// Create settings field
	public function create_setting( $args = array() ) {

		$defaults = array(
			'id'      => 'default_field',
			'title'   => 'Default Field',
			'desc'    => 'This is a default description.',
			'std'     => '',
			'type'    => 'text',
			'section' => 'general',
			'choices' => array(),
			'class'   => ''
		);

		extract( wp_parse_args( $args, $defaults ) );

		$field_args = array(
			'type'      => $type,
			'id'        => $id,
			'desc'      => $desc,
			'std'       => $std,
			'choices'   => $choices,
			'label_for' => $id,
			'class'     => $class
		);

		if ( $type == 'checkbox' )
			$this->checkboxes[] = $id;

		add_settings_field( $id, $title, array( $this, 'display_setting' ), 'theme-options', $section, $field_args );

	}
	
	// HTML output for individual settings
	public function display_setting( $args = array() ) {
		global $shortname;
		
		$shortname_options = $shortname . '_options';

		extract( $args );

		$options = get_option( $shortname . '_options' );
		
		if ( empty($options) )
			$options[$id] = $std;
		elseif ( ! isset( $options[$id] ) )
			$options[$id] = 0;

		$field_class = '';
		if ( $class != '' )
			$field_class = ' class="' . $class . '"';
	
		switch ( $type ) {
			
				case 'heading':
					echo '</td></tr><tr valign="top"><td colspan="2"><h4>' . $desc . '</h4>';
					break;

				case 'checkbox':
					echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="' . $shortname_options . '[' . $id . ']' . '" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';

					break;

				case 'select':
					echo '<select class="select' . $field_class . '" name="' . $shortname_options . '[' . $id . ']' . '">';

					foreach ( $choices as $value => $label )
						echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';

					echo '</select>';

					if ( $desc != '' )
						echo '<br /><span class="description">' . $desc . '</span>';

					break;

				case 'radio':
					$i = 0;
					foreach ( $choices as $value => $label ) {
						echo '<input class="radio' . $field_class . '" type="radio" name="' . $shortname_options . '[' . $id . ']' . '" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
						if ( $i < count( $options ) - 1 )
							echo '<br />';
						$i++;
					}

					if ( $desc != '' )
						echo '<br /><span class="description">' . $desc . '</span>';

					break;

				case 'textarea':
					echo '<textarea class="' . $field_class . '" id="' . $id . '" name="' . $shortname_options . '[' . $id . ']' . '" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';

					if ( $desc != '' )
						echo '<br /><span class="description">' . $desc . '</span>';

					break;

				case 'password':
					echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="' . $shortname_options . '[' . $id . ']' . '" value="' . esc_attr( $options[$id] ) . '" />';

					if ( $desc != '' )
						echo '<br /><span class="description">' . $desc . '</span>';

					break;

				case 'text':
				default:
					echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="' . $shortname_options . '[' . $id . ']' . '" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';

			 		if ( $desc != '' )
			 			echo '<br /><span class="description">' . $desc . '</span>';

			 		break;
			
				case 'html':
				default:
					echo $std;

			 		if ( $desc != '' )
			 			echo '<br /><span class="description">' . $desc . '</span>';

			 		break;
			
				case 'upload':
				default:
				   echo '<input id="' . $id . '" class="upload-url' . $field_class . '" type="text" name="' . $shortname_options . '[' . $id . ']' . '" value="' . esc_attr( $options[$id] ) . '" /><input id="st_upload_button" class="st_upload_button" type="button" name="upload_button" value="Upload" />';

				if ( $desc != '' )
				   echo '
				   <span class="description">' . $desc . '</span>';
				echo '<div class="upload-img-preview">';
				if (esc_attr( $options[$id] <> '')) {
					echo '<img class="upload-img-preview" src='.esc_attr( $options[$id]).' />';
					echo '<a class="removeupload">'. __('Delete Image', 'icore') .'</a>';
				}
					echo '</div>';
					break;
					
					case 'slide':
						if ( $desc != '' )
		                    echo '<span class="description' . $field_class . '">' . $desc . '</span>';

		                echo '<br /><span id="slides-details-button"></span>';
		                echo '<ul id="slideshow_list">';

						if ( $options['slider'] <> '' ) {

							$slides = array();
							foreach ($options[$id]['title'] as $k => $v) {
								$slides[] = array(
				       				'title' => $v,
				       				'link' => $options[$id]['link'][$k],
									'caption' => $options[$id]['caption'][$k],
									'image' => $options[$id]['image'][$k]
				       			);
							}

							$i = 1;
							foreach ($slides as $slide) {
								echo '<li class="slide">';
								echo '<a class="editslideimage">edit</a>';
								echo '<div class="image-details slidedetails">';
								echo '<span class="description">' . __( 'Slide Title', 'icore' ) . '</span>';
								echo '<input class="regular-text' . $field_class . '" name="' . $shortname_options . '[' . $id . '][title][]" placeholder="' . $std . '" id="'. $id .'_title_'.$i.'"  value="'.$slide['title'].'" type="text" />';

								echo '<span class="description">' . __( 'Slide Link', 'icore' ) . '</span>';
								echo '<input class="regular-text' . $field_class . '" name="' . $shortname_options . '[' . $id . '][link][]" placeholder="' . $std . '" id="'. $id .'_title_'.$i.'"  value="'.$slide['link'].'" type="text" />';

								echo '<span class="description">' . __( 'Slide Caption', 'icore' ) . '</span>';
								echo '<textarea class="'.$field_class.'" name="' . $shortname_options . '[' . $id . '][caption][]" id="'. $id .'_caption_'.$i.'" cols="40" rows="4">'.$slide['caption'].'</textarea>';

								echo '<span class="description">' . __( 'Slide Image', 'icore' ) . '</span>';
								echo '<input class="upload-input-text src" name="' . $shortname_options . '[' . $id . '][image][]" id="'. $id .'_image_'.$i.'" type="text" value="'.$slide['image'].'" type="text" />
								<a href="'.get_option('siteurl').'/wp-admin/admin-ajax.php?action=choice&width=150&height=100" id="'.$id.'_button" class="button upbutton">' . __( 'Upload' ) . '</a>';
								echo '<a class="doneslideimage">Done</a>';
								echo '</div>';
				                echo '<div class="clear"></div><div class="upload-img-preview">';
				                if ( $slide['image'] != "" )
								{
									echo '<img class="upload-img-preview" id="image_'. $id .'_image_'.$i.'" src="'.$slide['image'].'" />';
								}
				                echo '</div>';
								echo '<a class="remove_slide submitdelete">' . __( 'Delete Slide', 'icore' ) . '</a>';
								echo '</li>';
								$i++;
							}

						} else {
							$i = 1;
							echo '<li class="slide">';
							echo '<span class="description">' . __( 'Slide Title', 'icore' ) . '</span>';
							echo '<input class="regular-text' . $field_class . '" name="' . $shortname_options . '[' . $id . '][title][]" placeholder="' . $std . '" id="'. $id .'_title_'.$i.'"  value="" type="text" />';

							echo '<span class="description">' . __( 'Slide Link', 'icore' ) . '</span>';
							echo '<input class="regular-text' . $field_class . '" name="' . $shortname_options . '[' . $id . '][link][]" placeholder="' . $std . '" id="'. $id .'_title_'.$i.'"  value="" type="text" />';

							echo '<span class="description">' . __( 'Slide Caption', 'icore' ) . '</span>';
							echo '<textarea class="'.$field_class.'" name="' . $shortname_options . '[' . $id . '][caption][]" id="'. $id .'_caption_'.$i.'" cols="40" rows="4"></textarea>';

							echo '<span class="description">' . __( 'Slide Image', 'icore' ) . '</span>';
							echo '<input class="upload-input-text src" name="' . $shortname_options . '[' . $id . '][image][]" id="'. $id .'_image_'.$i.'" type="text" value="" type="text" />
							<a href="'.get_option('siteurl').'/wp-admin/admin-ajax.php?action=choice&width=150&height=100" id="'.$id.'_button" class="button upbutton">' . __( 'Upload', 'icore' ) . '</a>';

			                echo '<div class="clear"></div><div class="upload-img-preview">';
			                echo '</div>';
							echo '<a class="remove_slide submitdelete">' . __( 'Delete Slide' ) . '</a>';
							echo '</li>';
						}

						echo '</ul>';
						break;

			}
		}

	
	// Description for section
	public function display_section() {
		// code
	}
	
	/* Insert custom CSS */
	public function styles() {

		wp_register_style( 'theme-admin', get_template_directory_uri() . '/icore/css/style.css' );
		wp_enqueue_style( 'theme-admin' );
		
		//Media Uploader Style
		wp_enqueue_style('thickbox');
	}
	
	// Validate Settings
	public function validate_settings( $input ) {
		global $shortname;
		
		if ( ! empty( $_POST['reset'] ) ) {
			$defaults = array();
			foreach ( $this->settings as $id => $setting ) {
				if ( $setting['type'] != 'heading' ) {
					$defaults[$id] = $setting['std'];
				}
			}
			return $defaults;
		}
		
		if ( ! isset( $input['reset_theme'] ) ) {
			$options = get_option( $shortname . '_options' );
			
			foreach ( $this->checkboxes as $id ) {
				if ( isset( $options[$id] ) && ! isset( $input[$id] ) )
					unset( $options[$id] );
			}
			
			return $input;
		}
		return false;
		
	}

	
} // end Icore_Theme_Options class


// New Icore_Theme_Options class
$theme_options = new Icore_Theme_Options;
?>