<?php get_header();?>

<?php 
global $options;
$location = icore_get_location();   
$meta = icore_get_multimeta(array('Subheader')); ?>

<div id="entry-full">
	<div id="page-top"> 
    	<h1 class="title"><?php the_title(); ?></h1>
    </div> <!-- #page-top  -->
    <div id="left" class="full-width">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-content">	
						<?php $args = array(
							'post_type' 	=> 'attachment',
							'numberposts' 	=> -1,
							'post_status' 	=> null,
							'post_parent' 	=> $post->ID,
							//'post__not_in'	=> array($thumb_id),
							'post_mime_type'=> 'image',
							'orderby'		=> 'menu_order',
							'order'			=> 'ASC'
						);
						$attachments = get_posts($args); 
						$count = count($attachments); ?>
						
						<?php if ( $count > 1 ) { ?>

						<div class="post-format-content">
						    <div class="flexslider">
						        <ul class="slides">

									<?php foreach ( $attachments as $attachment ) :
										$_post = & get_post( $attachment->ID );
										$url = wp_get_attachment_url($_post->ID);
										$post_title = esc_attr($_post->post_title);
										$large_image = wp_get_attachment_image($attachment->ID, 'large');
						                $caption = get_post_field('post_excerpt', $attachment->ID);
						            ?>

						            <li>
						            	<?php echo '<a href="'.$url.'" title="'.$post_title.'"></a>'; ?>
						            	<?php echo $large_image; ?>
						                <?php if ($caption) {
						                    echo '<p class="flex-caption">'.$caption.'</p>';
						                } ?>
						            </li>

						        <?php endforeach;   ?>

						        </ul><!-- .slides -->
						  	</div><!-- .flexslider -->
						</div><!-- .post-format-content -->
					<?php } else { ?>
						
		            <?php if ( has_post_thumbnail() ) : ?>

						<?php	$thumbid = get_post_thumbnail_id($post->ID);
							$img = wp_get_attachment_image_src($thumbid,'full');
							$img['title'] = get_the_title($thumbid); ?>

							<div class="thumb loading raised"> 
                            	<?php the_post_thumbnail("large"); ?>
                            	<a href="<?php echo $img[0]; ?>" class="zoom-icon" ></a>                                    		
							</div> <!-- .thumbnail  -->
					
	        		<?php endif; ?>
	
					<?php } ?>
					<?php the_content(); ?>
			
				</div>  <!-- .post-content -->
			
			<footer class="meta">
				<?php echo get_the_term_list( $post->ID, 'pcategory', 'Category: ', ', ', '' )."</br>";
					  echo get_the_term_list( $post->ID, 'ptag', 'Tags: ', ', ', '' )."</br>"; ?>
			</footer><!-- #entry-meta -->
			
			<div class="portfolio-nav">
				<?php previous_post_link( '<div class="alignleft pagination-prev">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'InterStellar' ) . '</span> %title' ); ?>
				<?php next_post_link( '<div class="alignright pagination-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'InterStellar' ) . '</span>' ); ?>
			</div>

	<?php endwhile; else: ?>

	<p><?php _e('Sorry, no posts matched your criteria.','InterStellar'); ?></p>

<?php endif; ?>

		</article><!-- #post-<?php the_ID(); ?> -->
    </div> <!-- #left  -->
</div> <!-- #entry-full  -->
<?php get_footer(); ?>