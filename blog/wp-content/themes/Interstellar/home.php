<?php get_header(); ?>
<?php global $shortname;  
$postNumber = $options['portfolio_posts']; ?>
<?php if ( isset($options['call_to_action_enabled']) && $options['call_to_action_enabled'] == 1 )
		get_template_part( '/includes/quote'); ?>
    
<div id="main">
	<section id="home-widgets" class="widget-area" role="complementary">
		<div class="home-widgets-fourth">
			<?php if ( is_active_sidebar( 'homepage' ) ) : ?>	
				<?php dynamic_sidebar( 'homepage' ); ?>
			<?php endif; ?>
		</div>
		<?php if($postNumber != '0') { ?>
			<div id="home-portfolio">
				<h3 class="title"><?php _e('From Portfolio', 'InterStellar'); ?></h3>
				        <ul class="home-portfolio-items">
				        	<?php $wpq = array( 'post_type' => 'portfolio', 'taxonomy' => 'pcategory', 'field'=>'slug', 'orderby' => '', 'posts_per_page' => $postNumber );
								  $type_posts = new WP_Query ($wpq);
								
								  if ( ! $type_posts->have_posts() ) {
									_e("You don't have any portfolio items. To add portfolio items go to WP Dashboard -> Portfolios. To configure or hide this section go to WP Dashboard -> Appearance -> Theme Options.");
								  } else {
		                          	while ( $type_posts->have_posts() ) : $type_posts->the_post(); ?> 
			                          	<li>
			                          		<?php if ( has_post_thumbnail() ) { ?>
		                                   		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'gallery-thumb', 'title=' ); ?></a>                                       
		                                   		<?php } ?>
			                          	</li>
			                        <?php endwhile; wp_reset_postdata(); ?>
								<?php } ?>
						</ul><!-- .home-portfolio-items -->
			  </div> <!-- #home-portfolio -->
		<?php } ?>

		<div class="home-widgets-half">
		<?php if ( is_active_sidebar( 'homepage-2' ) ) : ?>	
			<?php dynamic_sidebar( 'homepage-2' ); ?>
		<?php endif; ?>
		</div>  
	</section><!-- #home-widgets .widget-area -->
</div>   <!--  #main  -->
<?php get_footer(); ?>