<?php 

/*-----------------------------------------------------------------------------------*/
/* Register Theme Meta Boxes */
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_menu', 'icontrol_create_meta_box' );
add_action( 'save_post', 'icontrol_save_meta_data' );

function icontrol_create_meta_box() {
	global $shortname;

	add_meta_box( 'post-meta-boxes', __('<img src="'. get_template_directory_uri().'/icore/images/icon-icore.png" style="width:14px;height:14px;top:2px;position:relative;" />'.' iCore Post Options'), 'post_meta_boxes', 'post', 'normal', 'high' );
	
	add_meta_box( 'page-meta-boxes', __('<img src="'.  get_template_directory_uri().'/icore/images/icon-icore.png" style="width:14px;height:14px;top:2px;position:relative;" />'.' iCore Page Options'), 'page_meta_boxes', 'page', 'normal', 'high' );

}

function icontrol_page_meta_boxes() {

/* Array of the meta box page options. */
	$meta_boxes = array(           
            'subheading' => array( 
                'name' => 'Subheader', 
                'title' => __('Subheading', 'icontrol'), 
                'type' => 'text',
                'info' => 'Enter Subheading for this page')
            );
	
	return apply_filters( 'icontrol_post_meta_boxes', $meta_boxes );
}

function icontrol_post_meta_boxes() {

/* Array of the meta box post options. */
	$meta_boxes = array(
                'subheading' => array( 
                    'name' => 'Subheader', 
                    'title' => __('Subheading', 'icontrol'), 
                    'type' => 'text',
                    'info' => 'Enter Subheading for this post')
                );
	
	return apply_filters( 'icontrol_post_meta_boxes', $meta_boxes );
}



/**
 * Displays post meta boxes.
 * Gets array from icontrol_post_meta_boxes()
 */
function post_meta_boxes() {
	global $post;
	$meta_boxes = icontrol_post_meta_boxes(); ?>

 
	<?php foreach ( $meta_boxes as $meta ) :
    $value = get_post_meta( $post->ID, $meta['name'], true );
    if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );
        endforeach; ?>
<?php
}

/**
 * Displays page meta boxes.
 * Gets array from icontrol_page_meta_boxes()
 */
function page_meta_boxes() {
	global $post;
	$meta_boxes = icontrol_page_meta_boxes(); ?>
	  
	<?php foreach ( $meta_boxes as $meta ) :
    $value = stripslashes( get_post_meta( $post->ID, $meta['name'], true ) );
    if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );
        endforeach; ?>	
<?php
}

/**
 * Outputs a text input box with arguments from the
 * parameters.  Used for both the post/page meta boxes.
 */
function get_meta_text_input( $args = array(), $value = false ) {

	extract( $args ); ?>

	 <div class="metabox-wrap" style="background: #f9f9f9; border: 1px solid #ccc; padding: 10px; margin-bottom: 5px;">
			<label for="<?php echo $name; ?> " style="font-size:12px; color:#444444; font-weight:bold;padding-left:4px;"><?php echo $title; ?></label>
		
			<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_html( $value, 1 ); ?>" size="30" tabindex="30" style="width: 97%;" />
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
			<p><?php echo $info; ?></p>
		</div>
	<?php
}

/**
 * Outputs a select box with arguments from the
 * parameters.  Used for both the post/page meta boxes.
 */
function get_meta_select( $args = array(), $value = false ) {

	extract( $args ); ?>

	<div class="metabox-wrap" style="background: #f9f9f9; border: 1px solid #ccc; padding: 10px; margin-bottom: 5px;">
			<label for="<?php echo $name; ?>" style="font-size:12px; color:#444444; font-weight:bold;padding-left:4px;"><?php echo $title; ?></label>
	
			<select name="<?php echo $name; ?>" id="<?php echo $name; ?>">
			<?php foreach ( $options as $option ) : ?>
				<option <?php if ( htmlentities( $value, ENT_QUOTES ) == $option ) echo ' selected="selected"'; ?>>
					<?php echo $option; ?>
				</option>
			<?php endforeach; ?>
			</select>
			<p><?php echo $info; ?></p>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
	</div>

	<?php
}

/**
 * Outputs a textarea with arguments from the
 * parameters.  Used for both the post/page meta boxes.
 */
function get_meta_textarea( $args = array(), $value = false ) {

	extract( $args ); ?>

<div class="metabox-wrap" style="background: #f9f9f9; border: 1px solid #ccc; padding: 10px; margin-bottom: 5px;">
			<label for="<?php echo $name; ?>" style="font-size:12px; color:#444444; font-weight:bold;padding-left:4px;"><?php echo $title; ?></label>
		
			<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="60" rows="4" tabindex="30" style="width: 97%;"><?php echo esc_html( $value, 1 ); ?></textarea>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
			<p><?php echo $info; ?></p>
	</div>
	<?php
}


/**
 * Loops through each meta box's set of variables.
 * Saves them to the database as custom fields.
 */
function icontrol_save_meta_data( $post_id ) {
	global $post;
	global $shortname;
    
if(get_option($shortname.'_seo') == 'on') {	if ( 'page' == $_POST['post_type'] ) {
	
	    $seo_panel = array_merge( icontrol_seo_page_meta_boxes() );
        $basic_panel = array_merge( icontrol_page_meta_boxes() );
		$meta_boxes = array_merge( $seo_panel, $basic_panel ); } 
		
	else {
	    
	    $seo_panel = array_merge( icontrol_seo_post_meta_boxes() );
        $basic_panel = array_merge( icontrol_post_meta_boxes() );
		$meta_boxes = array_merge( $seo_panel, $basic_panel ); }
}

else {
    if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] )
        $meta_boxes = array_merge( icontrol_page_meta_boxes() );
    if ( isset($_POST['post_type']) && 'post' == $_POST['post_type'] ) 
	    $meta_boxes = array_merge( icontrol_post_meta_boxes() );
}	
	if (isset($meta_boxes)) {
		foreach ( $meta_boxes as $meta_box ) :

			if ( !wp_verify_nonce( $_POST[$meta_box['name'] . '_noncename'], plugin_basename( __FILE__ ) ) )
				return $post_id;

			if ( 'page' == $_POST['post_type'] && !current_user_can( 'edit_page', $post_id ) )
				return $post_id;

			elseif ( 'post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
				return $post_id;

			$data = stripslashes( $_POST[$meta_box['name']] );

			if ( get_post_meta( $post_id, $meta_box['name'] ) == '' )
				add_post_meta( $post_id, $meta_box['name'], $data, true );

			elseif ( $data != get_post_meta( $post_id, $meta_box['name'], true ) )
				update_post_meta( $post_id, $meta_box['name'], $data );

			elseif ( $data == '' )
				delete_post_meta( $post_id, $meta_box['name'], get_post_meta( $post_id, $meta_box['name'], true ) );

		endforeach;
		}
	}
?>