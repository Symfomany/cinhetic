<?php

add_action( 'wp_enqueue_scripts', 'UFOshortcodesInit');

function UFOshortcodesInit() {
	wp_enqueue_style('ufo_shortcodes_css', get_template_directory_uri() . '/ufo-shortcodes/shortcodes.css');
	//Register Google Maps Scripts
	wp_register_script('google-map-script', 'http://maps.google.com/maps/api/js?sensor=false');
	wp_register_script('google-map-shortcode',  get_template_directory_uri() . '/ufo-shortcodes/js/google.map.js' );
}

/*  Shortcodes  */
add_shortcode('half', 'half');

function half($atts, $content = null) {
    $output = do_shortcode($content);
    return '<div class="ufo-shortcode half">' . $output . '</div>';
}


add_shortcode('half_last', 'half_last');

function half_last($atts, $content = null) {
    $output = do_shortcode($content);
    return '<div class="ufo-shortcode half-last">' . $output . '</div><div class="clearboth"></div>';
}


add_shortcode('third', 'third');

function third($atts, $content = null) {
    $output = do_shortcode($content);
    return '<div class="ufo-shortcode third">' . $output . '</div>';
}


add_shortcode('third_last', 'third_last');

function third_last($atts, $content = null) {
    $output = do_shortcode($content);
    return '<div class="ufo-shortcode third-last">' . $output . '</div><div class="clearboth"></div>';
}


add_shortcode('fourth', 'fourth');

function fourth($atts, $content = null) {
    $output = do_shortcode($content);
    return '<div class="ufo-shortcode fourth">' . $output . '</div>';
}


add_shortcode('fourth_last', 'fourth_last');

function fourth_last($atts, $content = null) {
    $output = do_shortcode($content);
    return '<div class="ufo-shortcode fourth-last">' . $output . '</div><div class="clearboth"></div>';
}



add_shortcode('box', 'box');

function box($atts, $content = null) {
    return '<div class="ufo-shortcode box">' . $content . '</div>';
}


add_shortcode('hr', 'hr');

function hr($atts, $content = null) {
    return '<hr class="ufo-shortcode"/>';
}


add_shortcode('code', 'code');
  
function code($atts, $content = null) {
 
        return '<a href="javascript:void(0)" class="ufo-code-toggle">+ See The Code</a><div class="ufo-shortcode code">' . $content . '</div>';
}



add_shortcode('small_button', 'small_button');

function small_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "url" => ''
    ), $atts));
    return '<a class="ufo-shortcode more-icon" href="'.$url.'">'.$content.'</a>';
}


add_shortcode('big_button', 'big_button');

function big_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "url" => ''
    ), $atts));
    return '<a class="ufo-shortcode  more-icon-big" href="'.$url.'">'.$content.'</a>';
}



add_shortcode('youtube', 'youtube');

function youtube($atts, $content = null) {
    return '
<div class="ufo-shortcode" rel="showdowbox"><object width="610" height="420"><param name="movie" value="http://www.youtube.com/v/'.$content.'fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$content.'?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="610" height="420"></embed></object></div>
<div class="clearboth"></div>';
}


add_shortcode('hilite', 'hilite');

function hilite($atts, $content = null) {
    return '<span class="ufo-shortcode hilite">' . $content . '</span>';
}



add_shortcode("googlemap", "googleMap");

function googleMap($atts, $content = null) {
   extract(shortcode_atts(array(
      "width"       =>  '480',
      "height"      =>  '480',
      "address"   =>   ''
   ), $atts));
   $src = "http://maps.google.com/maps?f=q&source=s_q&hl=en&q=".$address;
   return '<div class="ufo-shortcode google-map"><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&amp;output=embed" class="googlemap" style="width:'.$width.'px; height:'.$height.'px;"></iframe></div>';
}

add_shortcode("map", "googleMaps");

function googleMaps($atts, $content = null) {
	wp_enqueue_script('google-map-script');
	wp_enqueue_script('google-map-shortcode');
	extract( shortcode_atts( array( 
		'address' => 'eiffel tower, paris, france', 
		'width' => "500", 
		'height' => "500", 
		'zoom' => 15), $atts));
		
		$num = rand(0,10000);
		return '<script type="text/javascript">	
					jQuery(document).ready(function() {
				  		googlemap_init("'.$address.'",'.$num.','.$zoom.');
					});
				</script>
				<div class="ufo-shortcode map">
					<div id="ufo_map_wrapper_'.$num.'" style="display: block;width:'.$width.'px;height:'.$height.'px;" class="map-container"></div>
				</div>';
}

add_shortcode('button', 'button');

function button($atts, $content = null) {
    extract(shortcode_atts(array(
      "link"       =>  '#',
      "text"      =>  'Button',
	  "size"   => '',
	  "color"  => ''
   ), $atts));
    return '<a href="'.$link.'" class="ufo-shortcode button '. $color .' ' . $size . ' ">' . $text . '</a>';
}


add_action( 'wp_footer', 'UFOshortcodesJS');

function UFOshortcodesJS() { ?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			
			jQuery('.ufo-shortcode.code').toggle();
			 
			jQuery('a.ufo-code-toggle').click(function() {
				jQuery(this).next('.code').toggle('fast', function() {
			  	});
			});
		});
	</script>
<?php }
?>