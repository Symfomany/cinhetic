<?php
global $options;
?>
	<?php
	//	Homepage Slideshow
	if ( '' <> $options['slider'] && isset($options['slider_enabled']) ) {

		// Get Slides
		$slides = array();
		foreach ($options['slider']['title'] as $k => $v) {
			$slides[] = array(
				'title' => $v,
				'link' => $options['slider']['link'][$k],
				'caption' => $options['slider']['caption'][$k],
				'image' => $options['slider']['image'][$k]
			);
		} ?>
		<div id="featured">
		<div id="featured-inside">
			<div class="flexslider home-slider">
		        <ul class="slides">

		<?php		foreach ($slides as $slide) { ?>
						<li>
							<div class="slide <?php if ( ! $slide['title']) echo "slide-no-title" ?>">
											<img src="<?php echo $slide['image'] ?>" title="<?php echo $slide['title']; ?>" alt="slider image"/>
								<?php if ($slide['title'] || $slide['caption'] ) { ?>			
								<div class="slide-caption">
								<?php if ($slide['title']) { ?>
									<h2 class="slide-title">
										<?php if ( $slide['link'] <> '' ) { ?>
												<a href="<?php echo $slide['link']; ?>" title="<?php echo $slide['title'] ?>" class="slide-link">
													<?php echo $slide['title']; ?>
												</a>
										<?php } else {  ?>
												<?php echo $slide['title']; ?>
										<?php } ?>
									</h2>
								<?php } ?>
								
								<?php if ($slide['caption']) {
				                    echo '<div class="flex-caption">'.$slide['caption'].'</div>';
				                } ?>
				</div>
				<?php } ?>
							</div>
					
					
						</li>
		<?php		} ?>
				</ul> <!-- .slides -->	
			</div> <!-- .flexslider -->
		</div>
		<div class="stripe"></div>  
		<div class="bottom-symbol"></div>
		<div class="double-divider"></div>
		</div>
	<?php } 
	//	End Homepage Slider  
        


