<?php
global $options;
?>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function($){	
	//	Initialize Homepage Slider
	$("#featured .flexslider").flexslider({
		controlNav: false,
		directionNav: true,
		animation: "<?php echo $options['slider_animation']; ?>",
		slideshowSpeed: <?php echo $options['slider_speed']; ?>,
		slideshow: <?php if ( isset($options['slider_auto']) && $options['slider_auto']  == '1' ) { echo 'true'; } else { echo 'false'; } ?>,
		start: function(){
	      $('.loader').hide();
	  }
	});	
});
//]]>
</script>