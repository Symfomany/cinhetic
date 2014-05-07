<?php class BlurbWidget extends WP_Widget
{
    function BlurbWidget(){
		$widget_ops = array('description' => 'Display your latest tweets');
		$control_ops = array('width' => 300, 'height' => 300);
		parent::WP_Widget(false,$name='UFO Blurb',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$blurbTitle = empty($instance['blurbTitle']) ? '' : $instance['blurbTitle'];
		$blurbContent = empty($instance['blurbContent']) ? '' : $instance['blurbContent'];
		$blurbLink = empty($instance['blurbLink']) ? '' : $instance['blurbLink'];
		$blurbButton = empty($instance['blurbButton']) ? '' : $instance['blurbButton'];
		
	echo $before_widget;
		
?>	
<div class="blurb">
	<?php echo $before_title; ?>          
	<?php echo $blurbTitle; ?>
	<?php echo $after_title; ?>
	<p><?php echo $blurbContent; ?></p> 

<?php if ( isset($blurbLink) && $blurbLink <> '' ) { ?>
	<a href="<?php echo $blurbLink; ?>" class="readmore"><?php echo $blurbButton; ?></a>
<?php } ?>
      
</div> <!-- .blurb  -->

<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['blurbTitle'] = stripslashes($new_instance['blurbTitle']);
		$instance['blurbContent'] = stripslashes($new_instance['blurbContent']);
		$instance['blurbLink'] = stripslashes($new_instance['blurbLink']);
		$instance['blurbButton'] = stripslashes($new_instance['blurbButton']);

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('blurbTitle'=>'Blurb Title', 'blurbContent'=>'Example Text', 'blurbLink' => '', 'blurbButton' => 'Learn More' ) );

		$blurbTitle = htmlspecialchars($instance['blurbTitle']);
		$blurbContent = htmlspecialchars($instance['blurbContent']);
		$blurbLink = htmlspecialchars($instance['blurbLink']);
		$blurbButton = htmlspecialchars($instance['blurbButton']);

		# Title
		echo '<p><label for="' . $this->get_field_id('blurbTitle') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('blurbTitle') . '" name="' . $this->get_field_name('blurbTitle') . '" type="text" value="' . $blurbTitle . '" /></p>';
		# Blurb Text
		echo '<p><label for="' . $this->get_field_id('blurbContent') . '">' . 'Blurb Content:' . '</label><textarea cols="10" rows="10" class="widefat" id="' . $this->get_field_id('blurbContent') . '" name="' . $this->get_field_name('blurbContent') . '" >'. $blurbContent .'</textarea></p>';
		# Blurb Link
		echo '<p><label for="' . $this->get_field_id('blurbLink') . '">' . 'Button Link:' . '</label><textarea cols="10" rows="2" class="widefat" id="' . $this->get_field_id('blurbLink') . '" name="' . $this->get_field_name('blurbLink') . '" >'. $blurbLink .'</textarea></p>';		
		# Blurb Button
		echo '<p><label for="' . $this->get_field_id('blurbButton') . '">' . 'Button Text:' . '</label><textarea cols="10" rows="2" class="widefat" id="' . $this->get_field_id('blurbButton') . '" name="' . $this->get_field_name('blurbButton') . '" >'. $blurbButton .'</textarea></p>';
	}

}// end BlurbWidget class

function BlurbWidgetInit() {
  register_widget('BlurbWidget');
}

add_action('widgets_init', 'BlurbWidgetInit');

?>