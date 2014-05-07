<?php class UFOPortfolioWidget extends WP_Widget
{
    function UFOPortfolioWidget(){
		$widget_ops = array('description' => 'Display Portfolio items');
		$control_ops = array('width' => 200, 'height' => 200);
		parent::WP_Widget(false,$name='UFO Portfolio',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'From Portfolio' : $instance['title']);
		
	    extract($args);
		$recentPostsNumber = empty($instance['recentPostsNumber']) ? '' : $instance['recentPostsNumber'];
		$categoryNumber = empty($instance['categoryNumber']) ? '' : $instance['categoryNumber'];

         echo $before_widget;

    		if ( $title )
    		echo $before_title . $title . $after_title;	   
   
?>  

<div class="ufo-portfolio">
                   
    <div class="widget-content">
    

	        <ul class="portfolio-widget-items">
	                        <?php $wpq = array( 'post_type' => 'portfolio', 'taxonomy' => 'pcategory', 'field'=>'slug', 'term' => $categoryNumber, 'orderby' => '', 'posts_per_page' => $recentPostsNumber );

	                        $type_posts = new WP_Query ($wpq); 
	                        while ( $type_posts->have_posts() ) : $type_posts->the_post(); ?> 
	                          <li>


	                                  <?php if ( has_post_thumbnail() ) { ?>
	                                     <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'gallery-thumb', 'title=' ); ?></a>                                       
	                                  <?php } ?> 
	 
	                           </li>
	                          <?php endwhile; wp_reset_postdata(); ?>

						</ul><!-- .slides -->
        
    </div> <!-- .widget-content  --> 
</div> <!-- .ufo-recent  -->  
<?php

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
		$instance = wp_parse_args( (array) $instance, array('title'=>'From Portfolio', 'recentPostsNumber'=>'3', 'categoryNumber'=>'') ); 
        $title = htmlspecialchars($instance['title']);
		$recentPostsNumber = htmlspecialchars($instance['recentPostsNumber']);
		$categoryNumber = htmlspecialchars($instance['categoryNumber']); 
		
		 # Title
    		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		
		# Number of Recent Posts
		echo '<p><label for="' . $this->get_field_id('recentPostsNumber') . '">' . 'Number of slides:' . '</label><input class="widefat" id="' . $this->get_field_id('recentPostsNumber') . '" name="' . $this->get_field_name('recentPostsNumber') . '" type="text" value="' . $recentPostsNumber . '" /></p>';
		
	    # Blog Category 
		 $categories = get_terms( 'pcategory');  ?>
		 <p><label for="<?php echo $this->get_field_id('categoryNumber') ?>"> Select Category : </label>
		     <select id="<?php echo $this->get_field_id('categoryNumber'); ?>" name="<?php echo $this->get_field_name('categoryNumber'); ?>" value="<?php echo $categoryNumber; ?>"> 
    		 
    		 <option value="" <?php if($categoryNumber == '') echo 'selected="selected"'; ?>>All Categories</option>
    	     <?php foreach ($categories as $category) {  ?>
                 <option value="<?php echo $category->slug; ?>" <?php if($categoryNumber == $category->slug) echo 'selected="selected"'; ?>><?php echo $category->name; ?></option>  
             <?php } ?>                	  
    	  </select>
        </p>
        
        <?php
		
		
	}

}

function UFOPortfolioWidgetInit() {
	register_widget('UFOPortfolioWidget');
}

add_action('widgets_init', 'UFOPortfolioWidgetInit');

?>