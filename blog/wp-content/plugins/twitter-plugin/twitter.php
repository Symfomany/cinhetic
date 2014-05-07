<?php
/*
Plugin Name: Twitter
Plugin URI:  http://bestwebsoft.com/plugin/
Description: Plugin to add a link to the page author to twitter.
Author: BestWebSoft
Version: 2.35
Author URI: http://bestwebsoft.com/
License: GPLv2 or later
*/

/*
	@ Copyright 2014  BestWebSoft  ( http://support.bestwebsoft.com )

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Add BWS menu */
if ( ! function_exists ( 'twttr_add_pages' ) ) {
	function twttr_add_pages() {
		global $bstwbsftwppdtplgns_options, $wpmu, $bstwbsftwppdtplgns_added_menu;
		$bws_menu_version = '1.2.6';
		$base = plugin_basename(__FILE__);

		if ( ! isset( $bstwbsftwppdtplgns_options ) ) {
			if ( 1 == $wpmu ) {
				if ( ! get_site_option( 'bstwbsftwppdtplgns_options' ) )
					add_site_option( 'bstwbsftwppdtplgns_options', array(), '', 'yes' );
				$bstwbsftwppdtplgns_options = get_site_option( 'bstwbsftwppdtplgns_options' );
			} else {
				if ( ! get_option( 'bstwbsftwppdtplgns_options' ) )
					add_option( 'bstwbsftwppdtplgns_options', array(), '', 'yes' );
				$bstwbsftwppdtplgns_options = get_option( 'bstwbsftwppdtplgns_options' );
			}
		}

		if ( isset( $bstwbsftwppdtplgns_options['bws_menu_version'] ) ) {
			$bstwbsftwppdtplgns_options['bws_menu']['version'][ $base ] = $bws_menu_version;
			unset( $bstwbsftwppdtplgns_options['bws_menu_version'] );
			update_option( 'bstwbsftwppdtplgns_options', $bstwbsftwppdtplgns_options, '', 'yes' );
			require_once( dirname( __FILE__ ) . '/bws_menu/bws_menu.php' );
		} else if ( ! isset( $bstwbsftwppdtplgns_options['bws_menu']['version'][ $base ] ) || $bstwbsftwppdtplgns_options['bws_menu']['version'][ $base ] < $bws_menu_version ) {
			$bstwbsftwppdtplgns_options['bws_menu']['version'][ $base ] = $bws_menu_version;
			update_option( 'bstwbsftwppdtplgns_options', $bstwbsftwppdtplgns_options, '', 'yes' );
			require_once( dirname( __FILE__ ) . '/bws_menu/bws_menu.php' );
		} else if ( ! isset( $bstwbsftwppdtplgns_added_menu ) ) {
			$plugin_with_newer_menu = $base;
			foreach ( $bstwbsftwppdtplgns_options['bws_menu']['version'] as $key => $value ) {
				if ( $bws_menu_version < $value && is_plugin_active( $base ) ) {
					$plugin_with_newer_menu = $key;
				}
			}
			$plugin_with_newer_menu = explode( '/', $plugin_with_newer_menu );
			$wp_content_dir = defined( 'WP_CONTENT_DIR' ) ? basename( WP_CONTENT_DIR ) : 'wp-content';
			if ( file_exists( ABSPATH . $wp_content_dir . '/plugins/' . $plugin_with_newer_menu[0] . '/bws_menu/bws_menu.php' ) )
				require_once( ABSPATH . $wp_content_dir . '/plugins/' . $plugin_with_newer_menu[0] . '/bws_menu/bws_menu.php' );
			else
				require_once( dirname( __FILE__ ) . '/bws_menu/bws_menu.php' );
			$bstwbsftwppdtplgns_added_menu = true;			
		}

		add_menu_page( 'BWS Plugins', 'BWS Plugins', 'manage_options', 'bws_plugins', 'bws_add_menu_render', plugins_url( 'images/px.png', __FILE__ ), 1001 );
		add_submenu_page( 'bws_plugins', __( 'Twitter Settings', 'twitter' ), __( 'Twitter', 'twitter' ), 'manage_options', 'twitter.php', 'twttr_settings_page' );
	}
}

/* Function for init */
if ( ! function_exists( 'twttr_init' ) ) {
	function twttr_init() {
		/* Internationalization, first(!) */
		load_plugin_textdomain( 'twitter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		/* Get/Register and check settings for plugin */
		if ( ! is_admin() || ( isset( $_GET['page'] ) && "twitter.php" == $_GET['page'] ) )
			twttr_settings();
	}
}

if ( ! function_exists( 'twttr_admin_init' ) ) {
	function twttr_admin_init() {
		/* Add variable for bws_menu */
		global $bws_plugin_info, $twttr_plugin_info;

		if ( ! $twttr_plugin_info )
			$twttr_plugin_info = get_plugin_data( __FILE__ );

		if ( ! isset( $bws_plugin_info ) || empty( $bws_plugin_info ) )					
			$bws_plugin_info = array( 'id' => '76', 'version' => $twttr_plugin_info["Version"] );
		/* Function check if plugin is compatible with current WP version  */
		twttr_version_check();
	}
}

/* Register settings for plugin */
if ( ! function_exists( 'twttr_settings' ) ) {
	function twttr_settings() {
		global $wpmu, $twttr_options, $twttr_plugin_info;	

		if ( ! $twttr_plugin_info ) {
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$twttr_plugin_info = get_plugin_data( __FILE__ );
		}	

		$twttr_options_default = array(
			'plugin_option_version' => $twttr_plugin_info["Version"],
			'url_twitter' 			=>	'admin',
			'display_option'		=>	'custom',
			'count_icon' 			=>	1,
			'img_link' 				=>	plugins_url( "images/twitter-follow.gif", __FILE__ ),
			'position' 				=>	'',
			'disable' 				=>	'0'
		);
		/* Install the option defaults */
		/* Get options from the database */
		if ( 1 == $wpmu ) {
			if ( ! get_site_option( 'twttr_options' ) ) {
				if ( false !== get_site_option( 'twttr_options_array' ) ) {
					$old_options = get_site_option( 'twttr_options_array' );
					foreach ( $twttr_options_default as $key => $value ) {
						if ( isset( $old_options['twttr_' . $key] ) )
							$twttr_options_default[$key] = $old_options['twttr_' . $key];
					}
					delete_site_option( 'twttr_options_array' );
				}
				add_site_option( 'twttr_options', $twttr_options_default, '', 'yes' );
			}
			$twttr_options = get_site_option( 'twttr_options' );
		} else {
			if ( ! get_option( 'twttr_options' ) ) {
				if ( false !== get_option( 'twttr_options_array' ) ) {
					$old_options = get_option( 'twttr_options_array' );
					foreach ( $twttr_options_default as $key => $value ) {
						if ( isset( $old_options['twttr_' . $key] ) )
							$twttr_options_default[$key] = $old_options['twttr_' . $key];
					}
					delete_option( 'twttr_options_array' );
				}
				add_option( 'twttr_options', $twttr_options_default, '', 'yes' );
			}
			$twttr_options = get_option( 'twttr_options' );
		}
		
		if ( ! isset( $twttr_options['plugin_option_version'] ) || $twttr_options['plugin_option_version'] != $twttr_plugin_info["Version"] ) {
			$twttr_options = array_merge( $twttr_options_default, $twttr_options );
			$twttr_options['plugin_option_version'] = $twttr_plugin_info["Version"];
			update_option( 'twttr_options', $twttr_options );
		}
	}
}

/* Function check if plugin is compatible with current WP version  */
if ( ! function_exists ( 'twttr_version_check' ) ) {
	function twttr_version_check() {
		global $wp_version, $twttr_plugin_info;
		$require_wp		=	"3.0"; /* Wordpress at least requires version */
		$plugin			=	plugin_basename( __FILE__ );
	 	if ( version_compare( $wp_version, $require_wp, "<" ) ) {
			if ( is_plugin_active( $plugin ) ) {
				deactivate_plugins( $plugin );
				wp_die( "<strong>" . $twttr_plugin_info['Name'] . " </strong> " . __( 'requires', 'twitter' ) . " <strong>WordPress " . $require_wp . "</strong> " . __( 'or higher, that is why it has been deactivated! Please upgrade WordPress and try again.', 'twitter') . "<br /><br />" . __( 'Back to the WordPress', 'twitter') . " <a href='" . get_admin_url( null, 'plugins.php' ) . "'>" . __( 'Plugins page', 'twitter') . "</a>." );
			}
		}
	}
}

/* Add Setting page */
if ( ! function_exists( 'twttr_settings_page' ) ) {
	function twttr_settings_page() {
		global $twttr_options, $wp_version, $twttr_plugin_info;
		$copy = false;
		$message = $error = "";

		if ( false !== @copy( plugin_dir_path( __FILE__ ) . "images/twitter-follow.jpg", plugin_dir_path( __FILE__ ) . "images/twitter-follow1.jpg" ) )
			$copy = true;

		if ( isset( $_REQUEST['twttr_form_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'twttr_nonce_name' ) ) {
			$twttr_options['url_twitter']		=	$_REQUEST['twttr_url_twitter'];
			$twttr_options['display_option' ]	=	$_REQUEST['twttr_display_option'];
			$twttr_options['position']			=	$_REQUEST['twttr_position'];
			$twttr_options['disable']			=	isset( $_REQUEST["twttr_disable"] ) ? 1 : 0;
			if ( isset( $_FILES['upload_file']['tmp_name'] ) &&  $_FILES['upload_file']['tmp_name'] != "" )
				$twttr_options['count_icon']	=	$twttr_options['count_icon'] + 1;
			if ( 2 < $twttr_options['count_icon'] )
				$twttr_options['count_icon']	=	1;

			update_option( 'twttr_options', $twttr_options );
			$message = __( "Settings saved", 'twitter' );

			/* Form options */
			if ( isset( $_FILES['upload_file']['tmp_name'] ) && "" != $_FILES['upload_file']['tmp_name'] ) {
				$max_image_width	=	100;
				$max_image_height	=	100;
				$max_image_size		=	32 * 1024;
				$valid_types 		=	array( 'jpg', 'jpeg' );
				/* Construction to rename downloading file */
				$new_name			=	'twitter-follow' . $twttr_options['count_icon'];
				$new_ext			=	'.jpg';
				$namefile			=	$new_name . $new_ext;
				$uploaddir			=	$_REQUEST['home'] . 'wp-content/plugins/twitter-plugin/images/'; /* The directory in which we will take the file: */
				$uploadfile			=	$uploaddir . $namefile;

				/* Checks is file download initiated by user */
				if ( isset( $_FILES['upload_file'] ) && 'custom' == $_REQUEST['twttr_display_option'] )	{
					/* Checking is allowed download file given parameters */
					if ( is_uploaded_file( $_FILES['upload_file']['tmp_name'] ) ) {
						$filename	=	$_FILES['upload_file']['tmp_name'];
						$ext		=	substr( $_FILES['upload_file']['name'], 1 + strrpos( $_FILES['upload_file']['name'], '.' ) );
						if ( filesize ( $filename ) > $max_image_size ) {
							$error = __( "Error: File size > 32K", 'twitter' );
						} elseif ( ! in_array( $ext, $valid_types ) ) {
							$error = __( "Error: Invalid file type", 'twitter' );
						} else {
							$size = GetImageSize( $filename );
							if ( ( $size ) && ( $size[0] <= $max_image_width ) && ( $size[1] <= $max_image_height ) ) {
								/* If file satisfies requirements, we will move them from temp to your plugin folder and rename to 'twitter_ico.jpg' */
								if ( move_uploaded_file ( $_FILES['upload_file']['tmp_name'], $uploadfile ) ) {
									$message .= '. ' . __( "Upload successful.", 'twitter' );
								} else {
									$error = __( "Error: moving file failed", 'twitter' );
								}
							} else {
								$error = __( "Error: check image width or height", 'twitter' );
							}
						}
					} else {
						$error = __( "Uploading Error: check image properties", 'twitter' );
					}
				}
			}
		}
		twttr_update_option();

		/* GO PRO */
		if ( isset( $_GET['action'] ) && 'go_pro' == $_GET['action'] ) {
			global $bstwbsftwppdtplgns_options;

			$bws_license_key = ( isset( $_POST['bws_license_key'] ) ) ? trim( $_POST['bws_license_key'] ) : "";

			if ( isset( $_POST['bws_license_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'bws_license_nonce_name' ) ) {
				if ( '' != $bws_license_key ) { 
					if ( strlen( $bws_license_key ) != 18 ) {
						$error = __( "Wrong license key", 'twitter' );
					} else {
						$bws_license_plugin = trim( $_POST['bws_license_plugin'] );	
						if ( isset( $bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['count'] ) && $bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['time'] < ( time() + (24 * 60 * 60) ) ) {
							$bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['count'] = $bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['count'] + 1;
						} else {
							$bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['count'] = 1;
							$bstwbsftwppdtplgns_options['go_pro'][ $bws_license_plugin ]['time'] = time();
						}	

						/* download Pro */
						if ( !function_exists( 'get_plugins' ) )
							require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
						if ( ! function_exists( 'is_plugin_active_for_network' ) )
							require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
						$all_plugins = get_plugins();
						$active_plugins = get_option( 'active_plugins' );
						
						if ( ! array_key_exists( $bws_license_plugin, $all_plugins ) ) {
							$current = get_site_transient( 'update_plugins' );
							if ( is_array( $all_plugins ) && !empty( $all_plugins ) && isset( $current ) && is_array( $current->response ) ) {
								$to_send = array();
								$to_send["plugins"][ $bws_license_plugin ] = array();
								$to_send["plugins"][ $bws_license_plugin ]["bws_license_key"] = $bws_license_key;
								$to_send["plugins"][ $bws_license_plugin ]["bws_illegal_client"] = true;
								$options = array(
									'timeout' => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3 ),
									'body' => array( 'plugins' => serialize( $to_send ) ),
									'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ) );
								$raw_response = wp_remote_post( 'http://bestwebsoft.com/wp-content/plugins/paid-products/plugins/update-check/1.0/', $options );

								if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ) {
									$error = __( "Something went wrong. Try again later. If the error will appear again, please, contact us <a href=http://support.bestwebsoft.com>BestWebSoft</a>. We are sorry for inconvenience.", 'twitter' );
								} else {
									$response = maybe_unserialize( wp_remote_retrieve_body( $raw_response ) );
									
									if ( is_array( $response ) && !empty( $response ) ) {
										foreach ( $response as $key => $value ) {
											if ( "wrong_license_key" == $value->package ) {
												$error = __( "Wrong license key", 'twitter' ); 
											} elseif ( "wrong_domain" == $value->package ) {
												$error = __( "This license key is bind to another site", 'twitter' );
											} elseif ( "you_are_banned" == $value->package ) {
												$error = __( "Unfortunately, you have exceeded the number of available tries. Please, upload the plugin manually.", 'twitter' );
											}
										}
										if ( '' == $error ) {
											$bstwbsftwppdtplgns_options[ $bws_license_plugin ] = $bws_license_key;

											$url = 'http://bestwebsoft.com/wp-content/plugins/paid-products/plugins/downloads/?bws_first_download=' . $bws_license_plugin . '&bws_license_key=' . $bws_license_key . '&download_from=5';
											$uploadDir = wp_upload_dir();
											$zip_name = explode( '/', $bws_license_plugin );
										    if ( file_put_contents( $uploadDir["path"] . "/" . $zip_name[0] . ".zip", file_get_contents( $url ) ) ) {
										    	@chmod( $uploadDir["path"] . "/" . $zip_name[0] . ".zip", octdec( 755 ) );
										    	if ( class_exists( 'ZipArchive' ) ) {
													$zip = new ZipArchive();
													if ( $zip->open( $uploadDir["path"] . "/" . $zip_name[0] . ".zip" ) === TRUE ) {
														$zip->extractTo( WP_PLUGIN_DIR );
														$zip->close();
													} else {
														$error = __( "Failed to open the zip archive. Please, upload the plugin manually", 'twitter' );
													}								
												} elseif ( class_exists( 'Phar' ) ) {
													$phar = new PharData( $uploadDir["path"] . "/" . $zip_name[0] . ".zip" );
													$phar->extractTo( WP_PLUGIN_DIR );
												} else {
													$error = __( "Your server does not support either ZipArchive or Phar. Please, upload the plugin manually", 'twitter' );
												}
												@unlink( $uploadDir["path"] . "/" . $zip_name[0] . ".zip" );										    
											} else {
												$error = __( "Failed to download the zip archive. Please, upload the plugin manually", 'twitter' );
											}

											/* activate Pro */
											if ( file_exists( WP_PLUGIN_DIR . '/' . $zip_name[0] ) ) {			
												array_push( $active_plugins, $bws_license_plugin );
												update_option( 'active_plugins', $active_plugins );
												$pro_plugin_is_activated = true;
											} elseif ( '' == $error ) {
												$error = __( "Failed to download the zip archive. Please, upload the plugin manually", 'twitter' );
											}																				
										}
									} else {
										$error = __( "Something went wrong. Try again later or upload the plugin manually. We are sorry for inconvienience.", 'twitter' ); 
					 				}
					 			}
				 			}
						} else {
							/* activate Pro */
							if ( ! ( in_array( $bws_license_plugin, $active_plugins ) || is_plugin_active_for_network( $bws_license_plugin ) ) ) {			
								array_push( $active_plugins, $bws_license_plugin );
								update_option( 'active_plugins', $active_plugins );
								$pro_plugin_is_activated = true;
							}						
						}
						update_option( 'bstwbsftwppdtplgns_options', $bstwbsftwppdtplgns_options, '', 'yes' );
			 		}
			 	} else {
		 			$error = __( "Please, enter Your license key", 'twitter' );
		 		}
		 	}
		} ?>
		<div class="wrap">
			<div class="icon32 icon32-bws" id="icon-options-general"></div>
			<h2><?php _e( "Twitter Settings", 'twitter' ); ?></h2>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab<?php if ( ! isset( $_GET['action'] ) ) echo ' nav-tab-active'; ?>" href="admin.php?page=twitter.php"><?php _e( 'Settings', 'twitter' ); ?></a>
				<a class="nav-tab<?php if ( isset( $_GET['action'] ) && 'extra' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=twitter.php&amp;action=extra"><?php _e( 'Extra settings', 'twitter' ); ?></a>
				<a class="nav-tab bws_go_pro_tab<?php if ( isset( $_GET['action'] ) && 'go_pro' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=twitter.php&amp;action=go_pro"><?php _e( 'Go PRO', 'twitter' ); ?></a>
			</h2>
			<div class="updated fade" <?php if ( empty( $message ) || "" != $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div id="twttr_settings_notice" class="updated fade" style="display:none"><p><strong><?php _e( "Notice:", 'twitter' ); ?></strong> <?php _e( "The plugin's settings have been changed. In order to save them please don't forget to click the 'Save Changes' button.", 'twitter' ); ?></p></div>
			<div class="error" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
			<?php if ( ! isset( $_GET['action'] ) ) { ?>
				<form method='post' action="admin.php?page=twitter.php" enctype="multipart/form-data" id="twttr_settings_form">
					<table class="form-table">
						<tr valign="top">
							<th scope="row" colspan="2"><?php echo __( 'Settings for the button "Follow Me":', 'twitter' ); ?></th>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php echo __( "Enter your username:", 'twitter' ); ?>
							</th>
							<td>
								<input name='twttr_url_twitter' type='text' value='<?php echo $twttr_options['url_twitter'] ?>'/><br />
								<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php echo __( 'If you do not have Twitter account yet, you should create it using this link', 'twitter' ); ?> <a target="_blank" href="https://twitter.com/signup">https://twitter.com/signup</a> .</span><br />
								<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php echo __( 'Paste the shortcode &lsqb;follow_me&rsqb; into the necessary page or post to use the "Follow Me" button.', 'twitter' ); ?></span><br />
								<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php echo __( 'If you would like to use this button in some other place, please paste this line into the template source code', 'twitter' ); ?>	&#60;?php if ( function_exists( 'twttr_follow_me' ) ) echo twttr_follow_me(); ?&#62;</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php echo __( "Choose display settings:", 'twitter' ); ?>
							</th>
							<td>
								<select name="twttr_display_option" onchange="if ( this . value == 'custom' ) { getElementById ( 'twttr_display_option_custom' ) . style.display = 'block'; } else { getElementById ( 'twttr_display_option_custom' ) . style.display = 'none'; }">
									<option <?php if ( 'standart' == $twttr_options['display_option'] ) echo 'selected="selected"'; ?> value="standart"><?php echo __( "Standard button", 'twitter' ); ?></option>
									<?php if ( $copy || 'custom' == $twttr_options['display_option'] ) { ?>
										<option <?php if ( 'custom' == $twttr_options['display_option'] ) echo 'selected="selected"'; ?> value="custom"><?php echo __( "Custom button", 'twitter' ); ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div id="twttr_display_option_custom" <?php if ( 'custom' == $twttr_options['display_option'] ) { echo ( 'style="display:block"' ); } else { echo ( 'style="display:none"' ); } ?>>
									<table>
										<th style="padding-left:0px;font-size:13px;">
											<?php echo __( "Current image:", 'twitter' ); ?>
										</th>
										<td>
											<img src="<?php echo $twttr_options['img_link']; ?>" />
										</td>
									</table>
									<table>
										<th style="padding-left:0px;font-size:13px;">
											<?php echo __( '"Follow Me" image:', 'twitter' ); ?>
										</th>
										<td>
											<input type="hidden" name="MAX_FILE_SIZE" value="64000"/>
											<input type="hidden" name="home" value="<?php echo ABSPATH ; ?>"/>
											<input type="file" name="upload_file" style="width:196px;" /><br />
											<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php echo __( 'Image properties: max image width:100px; max image height:100px; max image size:32Kb; image types:"jpg", "jpeg".', 'twitter' ); ?></span>
										</td>
									</table>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row" colspan="2"><?php echo __( 'Settings for the "Twitter" button:', 'twitter' ); ?></th>
						</tr>
						<tr>
							<th><?php _e( 'Disable the "Twitter" button:', 'twitter' ); ?></th>
							<td>
								<input type="checkbox" name="twttr_disable" value="1" <?php if ( 1 == $twttr_options["disable"] ) echo "checked=\"checked\""; ?> />
								<span style="color: rgb(136, 136, 136); font-size: 10px;"> <?php echo __( 'The button "T" will not be displayed. Just the shortcode &lsqb;follow_me&rsqb; will work.', 'twitter' ); ?></span><br />
							</td>
						</tr>
						<tr>
							<th>
								<?php _e( 'Choose the "Twitter" icon position:', 'twitter' ); ?>
							</th>
							<td>
								<label><input type="radio" name="twttr_position" value="1" <?php if ( 1 == $twttr_options['position'] ) echo 'checked="checked"'?> /> <?php echo __( 'Top position', 'twitter' ); ?></label><br />
								<label><input type="radio" name="twttr_position" value="0" <?php if ( 0 == $twttr_options['position'] ) echo 'checked="checked"'?> /> <?php echo __( 'Bottom position', 'twitter' ); ?></label><br />
								<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php echo __( 'By clicking this icon a user can add the article he/she likes to his/her Twitter page.', 'twitter' ); ?></span><br />
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="hidden" name="twttr_form_submit" value="submit" />
								<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'twitter' ) ?>" />
							</td>
						</tr>
					</table>
					<?php wp_nonce_field( plugin_basename( __FILE__ ), 'twttr_nonce_name' ); ?>
				</form>
				<div class="bws-plugin-reviews">
					<div class="bws-plugin-reviews-rate">
						<?php _e( 'If you enjoy our plugin, please give it 5 stars on WordPress', 'twitter' ); ?>: 
						<a href="http://wordpress.org/support/view/plugin-reviews/twitter-plugin" target="_blank" title="Twitter reviews"><?php _e( 'Rate the plugin', 'twitter' ); ?></a>
					</div>
					<div class="bws-plugin-reviews-support">
						<?php _e( 'If there is something wrong about it, please contact us', 'twitter' ); ?>: 
						<a href="http://support.bestwebsoft.com">http://support.bestwebsoft.com</a>
					</div>
				</div>
			<?php } elseif ( 'extra' == $_GET['action'] ) { ?>
				<div class="bws_pro_version_bloc">
					<div class="bws_pro_version_table_bloc">	
						<div class="bws_table_bg"></div>											
						<table class="form-table bws_pro_version">
							<tr valign="top">
								<td colspan="2">
									<?php _e( 'Please choose the necessary post types (or single pages) where Twitter button will be displayed:', 'twitter' ); ?>
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">
									<label>
										<input disabled="disabled" checked="checked" id="twttrpr_jstree_url" type="checkbox" name="twttrpr_jstree_url" value="1" />
										<?php _e( "Show URL for pages", 'twitter' );?>
									</label>
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">
									<img src="<?php echo plugins_url( 'images/pro_screen_1.png', __FILE__ ); ?>" alt="<?php _e( "Example of site pages' tree", 'twitter' ); ?>" title="<?php _e( "Example of site pages' tree", 'twitter' ); ?>" />
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">
									<input disabled="disabled" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'twitter' ); ?>" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" colspan="2">
									* <?php _e( 'If you upgrade to Pro version all your settings will be saved.', 'twitter' ); ?>
								</th>
							</tr>				
						</table>	
					</div>
					<div class="bws_pro_version_tooltip">
						<div class="bws_info">
							<?php _e( 'Unlock premium options by upgrading to a PRO version.', 'twitter' ); ?> 
							<a href="http://bestwebsoft.com/plugin/twitter-pro/?k=a8417eabe3c9fb0c2c5bed79e76de43c&pn=76&v=<?php echo $twttr_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Twitter Pro"><?php _e( 'Learn More', 'twitter' ); ?></a>				
						</div>
						<a class="bws_button" href="http://bestwebsoft.com/plugin/twitter-pro/?k=a8417eabe3c9fb0c2c5bed79e76de43c&pn=76&v=<?php echo $twttr_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>#purchase" target="_blank" title="Twitter Pro">
							<?php _e( 'Go', 'twitter' ); ?> <strong>PRO</strong>
						</a>	
						<div class="clear"></div>					
					</div>
				</div>
			<?php } elseif ( 'go_pro' == $_GET['action'] ) { ?>
				<?php if ( isset( $pro_plugin_is_activated ) && true === $pro_plugin_is_activated ) { ?>
					<script type="text/javascript">
						window.setTimeout( function() {
						    window.location.href = 'admin.php?page=twitter-pro.php';
						}, 5000 );
					</script>				
					<p><?php _e( "Congratulations! The PRO version of the plugin is successfully download and activated.", 'twitter' ); ?></p>
					<p>
						<?php _e( "Please, go to", 'twitter' ); ?> <a href="admin.php?page=twitter-pro.php"><?php _e( 'the setting page', 'twitter' ); ?></a> 
						(<?php _e( "You will be redirected automatically in 5 seconds.", 'twitter' ); ?>)
					</p>
				<?php } else { ?>
					<form method="post" action="admin.php?page=twitter.php&amp;action=go_pro">
						<p>
							<?php _e( 'You can download and activate', 'twitter' ); ?> 
							<a href="http://bestwebsoft.com/plugin/twitter-pro/?k=a8417eabe3c9fb0c2c5bed79e76de43c&pn=76&v=<?php echo $twttr_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Twitter Pro">PRO</a> 
							<?php _e( 'version of this plugin by entering Your license key.', 'twitter' ); ?><br />
							<span style="color: #888888;font-size: 10px;">
								<?php _e( 'You can find your license key on your personal page Client area, by clicking on the link', 'twitter' ); ?> 
								<a href="http://bestwebsoft.com/wp-login.php">http://bestwebsoft.com/wp-login.php</a> 
								<?php _e( '(your username is the email you specify when purchasing the product).', 'twitter' ); ?>
							</span>
						</p>
						<?php if ( isset( $bstwbsftwppdtplgns_options['go_pro']['twitter-pro/twitter-pro.php']['count'] ) &&
							'5' < $bstwbsftwppdtplgns_options['go_pro']['twitter-pro/twitter-pro.php']['count'] &&
							$bstwbsftwppdtplgns_options['go_pro']['twitter-pro/twitter-pro.php']['time'] < ( time() + ( 24 * 60 * 60 ) ) ) { ?>
							<p>
								<input disabled="disabled" type="text" name="bws_license_key" value="<?php echo $bws_license_key; ?>" />
								<input disabled="disabled" type="submit" class="button-primary" value="<?php _e( 'Go!', 'twitter' ); ?>" />
							</p>
							<p>
								<?php _e( "Unfortunately, you have exceeded the number of available tries per day. Please, upload the plugin manually.", 'twitter' ); ?>
							</p>
						<?php } else { ?>
							<p>
								<input type="text" name="bws_license_key" value="<?php echo $bws_license_key; ?>" />
								<input type="hidden" name="bws_license_plugin" value="twitter-pro/twitter-pro.php" />
								<input type="hidden" name="bws_license_submit" value="submit" />
								<input type="submit" class="button-primary" value="<?php _e( 'Go!', 'twitter' ); ?>" />
								<?php wp_nonce_field( plugin_basename(__FILE__), 'bws_license_nonce_name' ); ?>
							</p>
						<?php } ?>
					</form>
				<?php }
			} ?>
		</div>
	<?php
	}
}

/* Function 'twttr_update_option' reacts to changes type of picture (Standard or Custom) and generates link to image, link transferred to array 'twttr_options' */
if ( ! function_exists( 'twttr_update_option' ) ) {
	function twttr_update_option () {
		global $twttr_options;
		if ( 'standart' == $twttr_options[ 'display_option' ] ) {
			$twttr_img_link	=	plugins_url( 'images/twitter-follow.jpg', __FILE__ );
		} else if ( 'custom' == $twttr_options['display_option'] ) {
			$twttr_img_link	= plugins_url( 'images/twitter-follow' . $twttr_options['count_icon'] . '.jpg', __FILE__ );
		}
		$twttr_options['img_link'] = $twttr_img_link;
		update_option( "twttr_options", $twttr_options );
	}
}

/* Function to creates shortcode [follow_me] */
if ( ! function_exists( 'twttr_follow_me' ) ) {
	function twttr_follow_me() {
		global $twttr_options;
		if ( 'standart' == $twttr_options[ 'display_option' ] ) {
			return '<div class="twttr_follow">
						<a href="https://twitter.com/' . $twttr_options["url_twitter"] . '" class="twitter-follow-button" data-show-count="true">Follow me</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>';
		} else {
			return '<div class="twttr_follow"><a href="http://twitter.com/' . $twttr_options["url_twitter"] . '" target="_blank" title="Follow me">
						<img src="' . $twttr_options['img_link'] . '" alt="Follow me" />
					</a></div>';
		}
	}
}

/* Positioning in the page	*/
if ( ! function_exists( 'twttr_twit' ) ) {
	function twttr_twit( $content ) {
		global $post, $twttr_options;
		$permalink_post	=	get_permalink($post->ID);
		$title_post		=	htmlspecialchars($post->post_title);
		if ( $title_post == 'your-post-page-title' )
			return $content;
		if ( 0 == $twttr_options['disable'] ) {
			$position = $twttr_options['position'];
			$str = '<div class="twttr_button">
						<a href="http://twitter.com/share?url=' . $permalink_post . '&text=' . $title_post . '" target="_blank" title="' . __( 'Click here if you like this article.', 'twitter' ) . '">
							<img src="' . plugins_url( 'images/twitt.gif', __FILE__ ) . '" alt="Twitt" />
						</a>
					</div>';
			if ( $position ) {
				return $str . $content;
			} else {
				return $content . $str;
			}
		} else {
			return $content;
		}
	}
}

if ( ! function_exists( 'twttr_action_links' ) ) {
	function twttr_action_links( $links, $file ) {
		/* Static so we don't call plugin_basename on every plugin row */
		static $this_plugin;
		if ( ! $this_plugin ) $this_plugin = plugin_basename( __FILE__ );
		if ( $file == $this_plugin ) {
			 $settings_link = '<a href="admin.php?page=twitter.php">' . __( 'Settings', 'twitter' ) . '</a>';
			 array_unshift( $links, $settings_link );
		}
		return $links;
	}
}

/* Function creates other links on admin page. */
if ( ! function_exists( 'twttr_links' ) ) {
	function twttr_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			$links[]	=	'<a href="admin.php?page=twitter.php">' . __( 'Settings','twitter' ) . '</a>';
			$links[]	=	'<a href="http://wordpress.org/plugins/twitter-plugin/faq/" target="_blank">' . __( 'FAQ','twitter' ) . '</a>';
			$links[]	=	'<a href="http://support.bestwebsoft.com">' . __( 'Support','twitter' ) . '</a>';
		}
		return $links;
	}
}

/* Registering and apllying styles and scripts */
if ( ! function_exists( 'twttr_admin_head' ) ) {
	function twttr_admin_head() {
		if ( isset( $_GET['page'] ) && "twitter.php" == $_GET['page'] )
			wp_enqueue_script( 'twttr_script', plugins_url( 'js/script.js', __FILE__ ) );
	}
}

/* Registering and apllying styles and scripts */
if ( ! function_exists( 'twttr_wp_head' ) ) {
	function twttr_wp_head() {
		wp_enqueue_style( 'twttr_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
	}
}

if ( ! function_exists ( 'twttr_plugin_banner' ) ) {
	function twttr_plugin_banner() {
		global $hook_suffix;	
		if ( 'plugins.php' == $hook_suffix ) {  
			global $twttr_plugin_info, $bstwbsftwppdtplgns_cookie_add;
			$banner_array = array(
				array( 'pdtr_hide_banner_on_plugin_page', 'updater/updater.php', '1.12' ),
				array( 'cntctfrmtdb_hide_banner_on_plugin_page', 'contact-form-to-db/contact_form_to_db.php', '1.2' ),		
				array( 'gglmps_hide_banner_on_plugin_page', 'bws-google-maps/bws-google-maps.php', '1.2' ),		
				array( 'fcbkbttn_hide_banner_on_plugin_page', 'facebook-button-plugin/facebook-button-plugin.php', '2.29' ),
				array( 'twttr_hide_banner_on_plugin_page', 'twitter-plugin/twitter.php', '2.34' ),
				array( 'pdfprnt_hide_banner_on_plugin_page', 'pdf-print/pdf-print.php', '1.7.1' ),
				array( 'gglplsn_hide_banner_on_plugin_page', 'google-one/google-plus-one.php', '1.1.4' ),
				array( 'gglstmp_hide_banner_on_plugin_page', 'google-sitemap-plugin/google-sitemap-plugin.php', '2.8.4' ),
				array( 'cntctfrmpr_for_ctfrmtdb_hide_banner_on_plugin_page', 'contact-form-pro/contact_form_pro.php', '1.14' ),
				array( 'cntctfrm_for_ctfrmtdb_hide_banner_on_plugin_page', 'contact-form-plugin/contact_form.php', '3.62' ),
				array( 'cntctfrm_hide_banner_on_plugin_page', 'contact-form-plugin/contact_form.php', '3.47' ),	
				array( 'cptch_hide_banner_on_plugin_page', 'captcha/captcha.php', '3.8.4' ),
				array( 'gllr_hide_banner_on_plugin_page', 'gallery-plugin/gallery-plugin.php', '3.9.1' )				
			);
			if ( ! $twttr_plugin_info )
				$twttr_plugin_info = get_plugin_data( __FILE__ );
			
			if ( ! function_exists( 'is_plugin_active_for_network' ) )
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

			$active_plugins = get_option( 'active_plugins' );			
			$all_plugins = get_plugins();
			$this_banner = 'twttr_hide_banner_on_plugin_page';
			foreach ( $banner_array as $key => $value ) {
				if ( $this_banner == $value[0] ) {
					global $wp_version;
		       		if ( ! isset( $bstwbsftwppdtplgns_cookie_add ) ) {
						echo '<script type="text/javascript" src="' . plugins_url( 'js/c_o_o_k_i_e.js', __FILE__ ) . '"></script>';
						$bstwbsftwppdtplgns_cookie_add = true;
					} ?>
					<script type="text/javascript">		
						(function($) {
							$(document).ready( function() {		
								var hide_message = $.cookie( "twttr_hide_banner_on_plugin_page" );
								if ( hide_message == "true") {
									$( ".twttr_message" ).css( "display", "none" );
								} else {
									$( ".twttr_message" ).css( "display", "block" );
								}
								$( ".twttr_close_icon" ).click( function() {
									$( ".twttr_message" ).css( "display", "none" );
									$.cookie( "twttr_hide_banner_on_plugin_page", "true", { expires: 32 } );
								});	
							});
						})(jQuery);				
					</script>
					<div class="updated" style="padding: 0; margin: 0; border: none; background: none;">					                      
						<div class="twttr_message bws_banner_on_plugin_page" style="display: none;">
							<img class="twttr_close_icon close_icon" title="" src="<?php echo plugins_url( 'images/close_banner.png', __FILE__ ); ?>" alt=""/>
							<div class="button_div">
								<a class="button" target="_blank" href="http://bestwebsoft.com/plugin/twitter-pro/?k=137342f0aa4b561cf7f93c190d95c890&pn=76&v=<?php echo $twttr_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>"><?php _e( "Learn More", 'twitter' ); ?></a>				
							</div>
							<div class="text"><?php
								_e( "It's time to upgrade your <strong>Twitter</strong> to <strong>PRO</strong> version", 'twitter' ); ?>!<br />
								<span><?php _e( 'Extend standard plugin functionality with new great options', 'twitter' ); ?>.</span>
							</div> 	
							<div class="icon">				
								<img title="" src="<?php echo plugins_url( 'images/banner.png', __FILE__ ); ?>" alt=""/>
							</div>	
						</div>  
					</div>
					<?php break;
				}
				if ( isset( $all_plugins[ $value[1] ] ) && $all_plugins[ $value[1] ]["Version"] >= $value[2] && ( 0 < count( preg_grep( '/' . str_replace( '/', '\/', $value[1] ) . '/', $active_plugins ) ) || is_plugin_active_for_network( $value[1] ) ) && ! isset( $_COOKIE[ $value[0] ] ) ) {
					break;
				}
			}    
		}
	}
}

/* Function for delete options */
if ( ! function_exists( 'twttr_delete_options' ) ) {
	function twttr_delete_options() {
		delete_option( 'twttr_options' );
		delete_site_option( 'twttr_options' );
	}
}
/* Adding 'BWS Plugins' admin menu */
add_action( 'admin_menu', 'twttr_add_pages' );
/* Initialization */
add_action( 'init', 'twttr_init' );
add_action( 'admin_init', 'twttr_admin_init' );
/* Adding stylesheets */
add_action( 'admin_enqueue_scripts', 'twttr_admin_head' );
add_action( 'wp_enqueue_scripts', 'twttr_wp_head' );
/* Adding plugin buttons */
add_shortcode( 'follow_me', 'twttr_follow_me' );
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'the_content', "twttr_twit" );
/* Additional links on the plugin page */
add_filter( 'plugin_action_links', 'twttr_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'twttr_links', 10, 2 );
/* Adding banner */
add_action( 'admin_notices', 'twttr_plugin_banner' );
/* Plugin uninstall function */
register_uninstall_hook( __FILE__, 'twttr_delete_options' );
?>