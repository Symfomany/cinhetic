<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

// Do not delete these lines
	if (isset($_SERVER['SCRIPT_InterStellarFILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'InterStellar'); ?></p> 
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<div id="commentbox" class="clearfix"><h3 id="comments"><?php _e('Comments', 'InterStellar'); ?> (<?php comments_number(__('No Responses','InterStellar'), __('One Response','InterStellar'), __('% Responses','InterStellar'));?>)</h3>

<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments();?>
	</ol>


	<div class="navigation">
		<div class="alignleft">
		<?php previous_comments_link() ?>
		</div>
		<div class="alignright">
		<?php next_comments_link() ?>
		</div>
	</div> 
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
	<div id="trackbacks">
		<h3 id="pings"><?php _e('Trackbacks/Pingbacks','InterStellar') ?></h3>
		<ol class="pinglist">
			<?php wp_list_comments('type=pings&callback=list_pings'); ?>
		</ol>
	</div>
	<?php endif; ?>	
 <?php else : // this is displayed if there are no comments so far ?>
	<div id="commentbox" class="nocomments">
           <?php if ('open' == $post->comment_status) : ?>
        		<!-- If comments are open, but there are no comments. -->

    	 <?php else : // comments are closed ?>
    		<!-- If comments are closed. -->

    		<!-- <p class="nocomments"><?php _e('Comments are closed for this page.', 'InterStellar'); ?></p>  -->

    	<?php endif; ?>
    <?php endif; ?>


    <?php if ('open' == $post->comment_status) : ?> 

        <?php 

        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $commenter = wp_get_current_commenter();

        $commenter['comment_author'] = esc_attr__( 'Name (required)', 'InterStellar' ); 
        $commenter['comment_author_email'] = esc_attr__( 'Email (required)', 'InterStellar' ); 
        $commenter['comment_author_url'] = esc_attr__( 'Website', 'InterStellar' );
        

        $fields =  array( 

            'author' => '<p class="comment-form-author">' . '<label for="author">'. esc_attr( $commenter['comment_author']) .'</label> ' . ( $req ? '' : '' ) . '<input id="author" name="author" type="text" value="" size="30"' . $aria_req . ' /></p>',  

            'email'  => '<p class="comment-form-email"><label for="email">'. esc_attr( $commenter['comment_author_email']) .'</label> ' . ( $req ? '' : '' ) . '<input id="email" name="email" type="text" value="" size="30"' . $aria_req . ' /></p>',  

            'url'    => '<p class="comment-form-url"><label for="url">'. esc_attr( $commenter['comment_author_url']) .'</label>' . '<input id="url" name="url" type="text" value="" size="30" /></p>' 

        ); ?>

        <?php comment_form( array(
            'fields' => apply_filters( 'comment_form_default_fields', $fields ), 
            'label_submit' => esc_attr__( 'Submit Comment', 'InterStellar' ), 
            'title_reply' => '<span>' . esc_attr__( 'Add Your Comment', 'InterStellar' ) . '</span>', 
            'title_reply_to' => esc_attr__( 'Leave a Reply to %s', 'InterStellar' ), 
            'comment_notes_after' => '',
            'comment_notes_before' => '<p>' . esc_attr__( 'Your email address will not be published.', 'InterStellar' ) . '</p>'
            ) ); ?>

          <?php else: ?>

    <?php endif; // if you delete this the sky will fall on your head ?>
    </div>