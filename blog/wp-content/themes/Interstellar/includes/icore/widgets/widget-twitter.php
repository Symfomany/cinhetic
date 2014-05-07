<?php class TwitterWidget extends WP_Widget
{
    function TwitterWidget(){
		$widget_ops = array('description' => 'Display your latest tweets');
		$control_ops = array('width' => 300, 'height' => 300);
		parent::WP_Widget(false,$name='UFO Twitter Feed',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Latest Tweets' : $instance['title']);
		$userName = empty($instance['userName']) ? '' : $instance['userName'];
		$postNumber = empty($instance['postNumber']) ? '' : $instance['postNumber'];
		
		$feed = "http://search.twitter.com/search.json?q=from:" . $userName . "&amp;rpp=" . $postNumber;
		
	echo $before_widget;
	if ( $title )
	    echo $before_title . $title . $after_title;
		
?>	
<div class="ufo-twitter">

<script type="text/javascript" charset="utf-8">
//<![CDATA[
     var userName = '<?php echo $userName; ?>';
     var count = '<?php echo $postNumber; ?>';
     
    jQuery(document).ready(function()
    {
       
        getTweets(userName, count);

   
    function getTweets(userName, count)
    {    

        jQuery.getJSON(
            'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=' + userName + '&count=' + count + '&callback=?',
            {},
            showTweets,
            'jsonp'
        );
    }
    
    

    function showTweets(tweets)
    {  
        
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var str = '<ul>';
        var i = 0;
        jQuery.each(tweets, function(index,value)
        {
            if(i == count)  return;
            var dt = new Date(value.created_at);
            str+= '<li><p>';
            var tweet = value.text;
            tweet = tweet.replace(/(http\:\/\/[A-Za-z0-9\/\.\?\=\-]*)/g,'<a href="$1">$1</a>');
            tweet = tweet.replace(/@([A-Za-z0-9\/_]*)/g,'<a href="http://twitter.com/$1">@$1</a>');
            tweet = tweet.replace(/#([A-Za-z0-9\/\.]*)/g,'<a href="http://twitter.com/search?q=$1">#$1</a>');  
            str+= tweet;
            str+= '</p>';
            str+='<span class="ufo-twitter-date">';
            str+= dt.getDate() + '-' + months[dt.getMonth()] + '-' + dt.getFullYear();
            str+= ' at ' + dt.getHours() + ':' +dt.getMinutes();
            str+= '</span></li>';
            i++;
        });
        str+= '</ul>'; 
        str+= '<a href="http://www.twitter.com/<?php echo $userName; ?>" class="readmore" target="_blank"><span><?php _e('Follow','InterStellar'); ?></span></a>';
        jQuery('.ufo-twitter').html(str);
        jQuery('.ufo-twitter > ul > li:odd').addClass('odd');
        jQuery('.ufo-twitter > ul > li:even').addClass('even');
    }
    
 });
 //]]>	       
</script>
</div>
<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['userName'] = stripslashes($new_instance['userName']);
		$instance['postNumber'] = stripslashes($new_instance['postNumber']);

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Latest Tweets', 'userName'=>'', 'postNumber'=>'5') );

		$title = htmlspecialchars($instance['title']);
		$userName = htmlspecialchars($instance['userName']);
		$postNumber = htmlspecialchars($instance['postNumber']);

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# Image
		echo '<p><label for="' . $this->get_field_id('userName') . '">' . 'Twitter User Name:' . '</label><textarea cols="10" rows="1" class="widefat" id="' . $this->get_field_id('userName') . '" name="' . $this->get_field_name('userName') . '" >'. $userName .'</textarea></p>';	
		# About Text
		echo '<p><label for="' . $this->get_field_id('postNumber') . '">' . 'Number of Tweets to display:' . '</label><textarea cols="10" rows="1" class="widefat" id="' . $this->get_field_id('postNumber') . '" name="' . $this->get_field_name('postNumber') . '" >'. $postNumber .'</textarea></p>';
	}

}// end Twitteridget class

function TwitterWidgetInit() {
  register_widget('TwitterWidget');
}

add_action('widgets_init', 'TwitterWidgetInit');

?>