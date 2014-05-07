<?php 
/* 
Template Name: Two Column Portfolio
*/
?>
<?php get_header();?>
<?php
$meta = icore_get_multimeta(array('Subheader')); 
?>
<div id="entry-full">
    <div id="page-top">	 
    	<h1 class="title"><?php  the_title();  ?></h1>
    	<?php if( isset($meta['Subheader'] ) && $meta['Subheader'] <> '') { ?>
        	<span class="subheader"><?php echo $meta['Subheader']; ?></span>
    	<?php } ?>
    </div> <!-- #page-top  -->

	<div id="left" class="full-width">
        
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>            
			<?php the_content(); ?>
		<?php endwhile; endif; ?>
		    
		<?php
	    $args = array(
			'post_type'=>'portfolio',
			'paged' => $paged
	    );

	    $temp = $wp_query;
	    $wp_query = null;
	    $wp_query = new WP_Query();
	    $wp_query->query( $args );
	    ?>

		<?php if ( $wp_query->have_posts() ) : ?>
                
	    	<div class="galleries">
				<div class="two-column">
                    
		        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
		    		<?php $do_not_duplicate = $post->ID; ?>

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
		
				<?php endwhile; ?>
				
				</div>											
			</div> <!-- .galleries -->
		
			<?php get_template_part( 'navigation', 'index' ); ?>
		
		<?php else : ?>
		
			<?php get_template_part( 'no-results', 'index' ); ?>

	<?php endif; ?>
            
	</div> <!--  end #left  -->
</div> <!-- #entry-full  -->
<?php get_footer(); ?>