<?php class Ad125Widget extends WP_Widget
{
    function Ad125Widget(){
		$widget_ops = array('description' => 'Display 125x125px ads');
		$control_ops = array('width' => 300, 'height' => 300);
		parent::WP_Widget(false,$name='UFO 125x125 Ads',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Advertisement' : $instance['title']);
		
	
		$adImg1 = empty($instance['adImg1']) ? '' : $instance['adImg1'];
		$adLink1 = empty($instance['adLink1']) ? '' : $instance['adLink1'];
		
		$adImg2 = empty($instance['adImg2']) ? '' : $instance['adImg2'];
		$adLink2 = empty($instance['adLink2']) ? '' : $instance['adLink2'];
		
		$adImg3 = empty($instance['adImg3']) ? '' : $instance['adImg3'];
		$adLink3 = empty($instance['adLink3']) ? '' : $instance['adLink3'];
		
		$adImg4 = empty($instance['adImg4']) ? '' : $instance['adImg4'];
		$adLink4 = empty($instance['adLink4']) ? '' : $instance['adLink4'];
		

		echo $before_widget;

		if ( $title )
		echo $before_title . $title . $after_title;
?>	
<div class="ads125-wrap">
<?php if($adImg1 !='') { ?><a href="<?php echo $adLink1; ?>" class="ad125"><img src="<?php echo $adImg1; ?>" alt="ad125" /></a><?php } ?>
	
<?php if($adImg2 !='') { ?><a href="<?php echo $adLink2; ?>" class="ad125"><img src="<?php echo $adImg2; ?>" alt="ad125" /></a><?php } ?>

<?php if($adImg3 !='') { ?><a href="<?php echo $adLink3; ?>" class="ad125"><img src="<?php echo $adImg3; ?>" alt="ad125" /></a><?php } ?>

<?php if($adImg4 !='') { ?><a href="<?php echo $adLink4; ?>" class="ad125"><img src="<?php echo $adImg4; ?>" alt="ad125" /></a><?php } ?>
</div>
<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['adImg1'] = stripslashes($new_instance['adImg1']);
		$instance['adLink1'] = stripslashes($new_instance['adLink1']);
		
		$instance['adImg2'] = stripslashes($new_instance['adImg2']);
		$instance['adLink2'] = stripslashes($new_instance['adLink2']);
		
		$instance['adImg3'] = stripslashes($new_instance['adImg3']);
		$instance['adLink3'] = stripslashes($new_instance['adLink3']);
		
		$instance['adImg4'] = stripslashes($new_instance['adImg4']);
		$instance['adLink4'] = stripslashes($new_instance['adLink4']);
		

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Advertisment', 'adImg1'=>'', 'adLink1'=>'',  'adImg2'=>'', 'adLink2'=>'') );

		$title = htmlspecialchars($instance['title']);
		$adImg1 = htmlspecialchars($instance['adImg1']);
		$adLink1 = htmlspecialchars($instance['adLink1']);
		
		$adImg2 = htmlspecialchars($instance['adImg2']);
		$adLink2 = htmlspecialchars($instance['adLink2']);
		
		$adImg3 = htmlspecialchars($instance['adImg3']);
		$adLink3 = htmlspecialchars($instance['adLink3']);
		
		$adImg4 = htmlspecialchars($instance['adImg4']);
		$adLink4 = htmlspecialchars($instance['adLink4']);
		

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# Image
		echo '<p><label for="' . $this->get_field_id('adImg1') . '">' . 'Ad 1 Image URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('adImg1') . '" name="' . $this->get_field_name('adImg1') . '" >'. $adImg1 .'</textarea></p>';	
		# About Text
		echo '<p><label for="' . $this->get_field_id('adLink1') . '">' . 'Ad 1 Target URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('adLink1') . '" name="' . $this->get_field_name('adLink1') . '" >'. $adLink1 .'</textarea></p>';
		
		echo '<p><label for="' . $this->get_field_id('adImg2') . '">' . 'Ad 2 Image URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('adImg2') . '" name="' . $this->get_field_name('adImg2') . '" >'. $adImg2 .'</textarea></p>';	
		# About Text
		echo '<p><label for="' . $this->get_field_id('adLink2') . '">' . 'Ad 2 Target URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('adLink2') . '" name="' . $this->get_field_name('adLink2') . '" >'. $adLink2 .'</textarea></p>';
		
		echo '<p><label for="' . $this->get_field_id('adImg3') . '">' . 'Ad 3 Image URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('adImg3') . '" name="' . $this->get_field_name('adImg3') . '" >'. $adImg3 .'</textarea></p>';	
		# About Text
		echo '<p><label for="' . $this->get_field_id('adLink3') . '">' . 'Ad 3 Target URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('adLink3') . '" name="' . $this->get_field_name('adLink3') . '" >'. $adLink3 .'</textarea></p>';
		
		echo '<p><label for="' . $this->get_field_id('adImg4') . '">' . 'Ad 4 Image URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('adImg4') . '" name="' . $this->get_field_name('adImg4') . '" >'. $adImg4 .'</textarea></p>';	
		# About Text
		echo '<p><label for="' . $this->get_field_id('adLink4') . '">' . 'Ad 4 Target URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('adLink4') . '" name="' . $this->get_field_name('adLink4') . '" >'. $adLink4 .'</textarea></p>';
	}

}// end AboutMeWidget class

function Ad125WidgetInit() {
  register_widget('Ad125Widget');
}

add_action('widgets_init', 'Ad125WidgetInit');

?>