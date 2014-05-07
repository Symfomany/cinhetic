<?php class UFORecentWidget extends WP_Widget
{
    function UFORecentWidget(){
		$widget_ops = array('description' => 'Display recent posts');
		$control_ops = array('width' => 200, 'height' => 200);
		parent::WP_Widget(false,$name='UFO Recent Posts',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Recent' : $instance['title']);
		
	    extract($args);
		$recentPostsNumber = empty($instance['recentPostsNumber']) ? '' : $instance['recentPostsNumber'];
		$categoryNumber = empty($instance['categoryNumber']) ? '' : $instance['categoryNumber'];

         echo $before_widget;

    		if ( $title )
    		echo $before_title . $title . $after_title;	   
   
?>  

<?php 
query_posts("showposts=$recentPostsNumber&cat=$categoryNumber");
if (have_posts()) : while (have_posts()) : the_post(); 
?>

<div class="ufo-recent">
                   
    <div class="widget-content">
            <?php if( has_post_thumbnail() ) { ?>
				<div class="thumb-wrap">
					<a href="<?php the_permalink() ?>">
	             		<span class="recent-thumb"><?php the_post_thumbnail('thumbnail'); ?></span>
					</a>
				</div>
                    <?php } ?> 

            <div class="meta">
                <h4><a href="<?php the_permalink() ?>" class="title" title="Read <?php the_title_attribute(); ?>" >
                <?php icore_title(56);  ?>
                    </a></h4>
        <?php the_time('M j, Y | ') ?><?php comments_popup_link(__('0 comments','InterStellar'), __('1 comment','InterStellar'), '% '.__('comments','InterStellar')); ?>
            </div>  <!--  end .meta  -->
    </div> <!--  end .post-content  --> 
</div> <!--  end .ufo-recent  -->  
<?php endwhile; endif; wp_reset_query(); 

 echo $after_widget; 

}
  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;  		
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['recentPostsNumber'] = stripslashes($new_instance['recentPostsNumber']);
		$instance['categoryNumber'] = stripslashes($new_instance['categoryNumber']);
	   

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Recent', 'recentPostsNumber'=>'3', 'categoryNumber'=>'') ); 
        $title = htmlspecialchars($instance['title']);
		$recentPostsNumber = htmlspecialchars($instance['recentPostsNumber']);
		$categoryNumber = htmlspecialchars($instance['categoryNumber']); 
		
		 # Title
    		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		
		# Number of Recent Posts
		echo '<p><label for="' . $this->get_field_id('recentPostsNumber') . '">' . 'Number of Recent Posts:' . '</label><input class="widefat" id="' . $this->get_field_id('recentPostsNumber') . '" name="' . $this->get_field_name('recentPostsNumber') . '" type="text" value="' . $recentPostsNumber . '" /></p>';
		
	    # Blog Category 
		 $categories = get_categories();   ?>
		 <p><label for="<?php echo $this->get_field_id('categoryNumber') ?>"> Select Category : </label>
		     <select id="<?php echo $this->get_field_id('categoryNumber'); ?>" name="<?php echo $this->get_field_name('categoryNumber'); ?>" value="<?php echo $categoryNumber; ?>"> 
    		 
    		 <option value="" <?php if($categoryNumber == '') echo 'selected="selected"'; ?>>All Categories</option>
    	     <?php foreach ($categories as $category) {  ?>
                 <option value="<?php echo $category->cat_ID; ?>" <?php if($categoryNumber == $category->cat_ID) echo 'selected="selected"'; ?>><?php echo $category->name; ?></option>  
             <?php } ?>                	  
    	  </select>
        </p>
        
        <?php
		
		
	}

}

function UFORecentWidgetInit() {
	register_widget('UFORecentWidget');
}

add_action('widgets_init', 'UFORecentWidgetInit');

?>