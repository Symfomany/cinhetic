<?php get_header(); ?>

<?php
if( 'portfolio' == get_post_type() )  {
	$cat_title = __('Portfolio' ,'InterStellar');
	$cat_desc = '';
} ?>

<?php
if( is_category() )  {
	$cat_title = single_cat_title('',false);
	$cat_desc = category_description();
} ?>

<div id="index-page">
	<?php if ( isset($cat_title) && $cat_title <> '') { ?>	
		<h1 class="title"><?php echo $cat_title; ?></h1>
	<?php } ?>
		<?php if ( isset($cat_desc) && $cat_desc <> '') { ?>
	        <span class="subheader"><?php echo $cat_desc; ?></span>
	    <?php } ?>        

    <div id="left" <?php if ( 'portfolio' == get_post_type() ) echo 'class="full-width"'; ?>>
		<?php if (have_posts()) : ?>
			
			<?php if ( 'portfolio' == get_post_type() ) { ?>
				  	<div class="galleries">
						<div class="<?php echo $options['portfolio_layout'] . '-column'; ?>">
			<?php } ?>
			
			<!-- The Loop -->
    		<?php while (have_posts()) : the_post(); ?>
					
				<?php if ( 'portfolio' == get_post_type() ) { ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
						<div class="gallery-image-wrap">
					            <?php if ( has_post_thumbnail() ) { ?>

									<?php $thumbid = get_post_thumbnail_id($post->ID);
										$img = wp_get_attachment_image_src($thumbid,'full');
										$img['title'] = get_the_title($thumbid); ?>

											<?php the_post_thumbnail("gallery-thumb"); ?>

										<a href="<?php echo $img[0]; ?>" class="zoom-icon" rel="shadowbox" ></a>

										<a href="<?php the_permalink(); ?>" class="link-icon"></a>
				        		<?php } else { ?>
										<a href="<?php the_permalink(); ?>">
										<?php echo '<img src="'.get_stylesheet_directory_uri().'/images/no-portfolio-archive.png" class="wp-post-image"/>'; ?>			</a>
								<?php } ?>
						<?php $args = array(
							'post_type' 	=> 'attachment',
							'numberposts' 	=> -1,
							'post_status' 	=> null,
							'post_parent' 	=> $post->ID,
							'post_mime_type'=> 'image',
							'orderby'		=> 'menu_order',
							'order'			=> 'ASC'
						);
						$attachments = get_posts($args); 
						$count = count($attachments); ?>
										
						<?php if ( $count > 1 ) { ?>
							<span class="image-count"><?php echo $count . __(' Images', 'InterStellar'); ?></span>
						<?php } ?>
						</div>
						<h2 class="gallery-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
					</article><!-- #post-<?php the_ID(); ?> -->

				<?php } else { ?>
 
    	 		<?php get_template_part( 'content', get_post_format() ); ?>
				
				<?php } ?>		

  			<?php endwhile; ?>

			<?php if ( 'portfolio' == get_post_type() ) { ?>
						</div>
					</div> <!-- .galleries -->
			<?php } ?>
			
			<?php if(function_exists('wp_pagenavi')) { ?>
				 
					<?php wp_pagenavi(); ?>
				
				<?php } else { ?> 
						
					<?php get_template_part( 'navigation', 'index' ); ?>
						 
				<?php } else : ?>
			
					<?php get_template_part( 'no-results', 'index' ); ?>
			
				<?php endif; ?>
       
    </div> <!--  #left  -->   
	<?php if ( 'portfolio' != get_post_type() ) get_sidebar(); ?>
</div>   <!--  #index-page  -->
<?php get_footer();?>