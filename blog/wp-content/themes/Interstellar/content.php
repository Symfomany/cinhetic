<?php 
global $options;
$location = icore_get_location();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content">
		
		<?php if( isset($options['blog_style']) && $options['blog_style'] == '1' ) { ?>
			
			<h2 class="blog-style"><a href="<?php the_permalink() ?>" class="title" title="Read <?php the_title_attribute(); ?>"><?php the_title();  ?></a></h2> 

            <?php the_content(); ?>

			 	<div class="meta-blog-style">
                 <?php the_time('M j, Y | ');  _e('Posted by ','InterStellar');  the_author_posts_link(); ?> <?php _e('in ','InterStellar');  the_category(', ') ?> | <?php comments_popup_link(__('0 comments','InterStellar'), __('1 comment','InterStellar'), '% '.__('comments','InterStellar')); ?>
             </div>  <!-- .meta-blog-style  -->

		<?php } else { ?>
        		<div class="entry-left">
				<!-- Print Thumbnail -->
            	<?php if ( has_post_thumbnail() && isset($options[$location . '_thumb']) && $options[$location . '_thumb'] == '1' ) : ?>
                		<div class="index-thumb loading"> 
            				<a href="<?php the_permalink() ?>" title="Read <?php the_title_attribute(); ?>">
								<?php the_post_thumbnail("entry-thumb"); ?>
							</a>
            			</div> 
            	<?php endif; ?>
				</div> <!-- .entry-left  -->
				<div class="entry-right<?php if ( has_post_thumbnail() && isset($options[$location . '_thumb']) && $options[$location . '_thumb'] == '1' )  echo ' has-thumb'; ?>">		
				<h2><a href="<?php the_permalink() ?>" class="title" title="Read <?php the_title_attribute(); ?>"><?php the_title();  ?></a></h2>		
				<div class="meta">
		                <?php the_time('M j, Y');?> <?php  _e('by ','InterStellar');  the_author_posts_link(); ?> <?php _e('in ','InterStellar');  the_category(', ') ?> <?php comments_popup_link(__('0 comments','InterStellar'), __('1 comment','InterStellar'), '% '.__('comments','InterStellar')); ?>
		        </div>  <!-- .meta  -->
	
	            <div class="post-desc">
	            	<?php  the_excerpt(); ?>
 				</div>

	            <a href="<?php the_permalink(); ?>" class="readmore"><?php _e('read more','InterStellar'); ?></a>  
	
	    		</div>   <!--  .entry-right  --> 
		<?php } ?>  
      
    	
	</div><!-- .post-content  -->         
</article>