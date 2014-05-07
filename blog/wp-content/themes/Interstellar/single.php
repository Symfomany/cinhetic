<?php get_header();?>

<?php 
global $options;
$location = icore_get_location();   
$meta = icore_get_multimeta(array('Subheader')); ?>

<div id="entry-full">
	<div id="page-top"> 
    	<h1 class="title"><?php  the_title();  ?></h1>
    	<?php if( isset($meta['Subheader'] ) && $meta['Subheader'] <> '') { ?>
        	<span class="subheader"><?php echo $meta['Subheader']; ?></span>
    	<?php } ?>
    </div> <!-- #page-top  -->
    <div id="left">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        	<div class="post-full single">
            
	                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 
	                     
							<!-- Print Thumbnail Image -->
							<?php if ( has_post_thumbnail() && isset($options[$location . '_thumb']) && $options[$location . '_thumb'] == '1' ) :
								  	$thumbid = get_post_thumbnail_id($post->ID);
									$img = wp_get_attachment_image_src($thumbid,'full');
									$img['title'] = get_the_title($thumbid); ?>

		                            <div class="thumb loading raised"> 
		                            	<?php the_post_thumbnail("large"); ?>
		                            	<a href="<?php echo $img[0]; ?>" class="zoom-icon" rel="shadowbox" ></a>                                    		
									</div> <!-- .thumbnail  -->                        
							<?php endif; ?>
							
	                        <?php the_content(); ?> 
	                    </article> 
						
						<div class="tags">
	                    	<?php the_tags(); ?>
						</div>
	
	                    <div class="meta">
	                        <?php the_time('M j, Y | ');  _e('Posted by ','InterStellar');  the_author_posts_link(); ?> <?php _e('in ','InterStellar');  the_category(', ') ?> | <?php comments_popup_link(__('0 comments','InterStellar'), __('1 comment','InterStellar'), '% '.__('comments','InterStellar')); ?>
	                    </div>  <!-- .meta  -->
		<?php comments_template(); ?>

		<?php endwhile; else: ?>

			<p><?php _e('Sorry, no posts matched your criteria.','InterStellar'); ?></p>

	<?php endif; ?>
            
	         </div> <!-- .post  -->
		</article> 
    </div> <!-- #left  -->
<?php get_sidebar(); ?>
</div> <!-- #entry-full  -->
<?php get_footer(); ?>