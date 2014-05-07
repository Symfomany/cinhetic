<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package adamos
 * @since adamos 1.0
 */
?>

	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer_container">
    <div class="section group">
    
	<div class="col span_1_of_3">
    <?php if ( is_active_sidebar( 'left_column' ) && dynamic_sidebar('left_column') ) : else : ?>
         <div class="widget">
			<?php echo '<h4>' . __('Widget Ready', 'adamos') . '</h4>'; ?>
            <?php echo '<p>' . __('This left column is widget ready! Add one in the admin panel.', 'adamos') . '</p>'; ?>
            </div>     
	<?php endif; ?>  
		</div>
        
	<div class="col span_1_of_3">
	<?php if ( is_active_sidebar( 'center_column' ) && dynamic_sidebar('center_column') ) : else : ?>
         <div class="widget">
			<?php echo '<h4>' . __('Widget Ready', 'adamos') . '</h4>'; ?>
            <?php echo '<p>' . __('This center column is widget ready! Add one in the admin panel.', 'adamos') . '</p>'; ?>
            </div>     
	<?php endif; ?> 

	</div>
    
	<div class="col span_1_of_3">
	<?php if ( is_active_sidebar( 'right_column' ) && dynamic_sidebar('right_column') ) : else : ?>
         <div class="widget">
			<?php echo '<h4>' . __('Widget Ready', 'adamos') . '</h4>'; ?>
            <?php echo '<p>' . __('This right column is widget ready! Add one in the admin panel.', 'adamos') . '</p>'; ?>
            </div>     
	<?php endif; ?> 
	</div>
	</div>
        </div><!-- footer container -->
        <div class="site-info">
			<?php printf( __( 'Powered by %1$s. %2$s theme by %3$s.', 'adamos' ),'<a href="http://wordpress.org/" target="_blank">WordPress</a>', '<a href="http://www.templateexpress.com/adamos-theme/" target="_blank">adamos</a>', 'Ossie' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->
</div><!-- end of wrapper -->
<?php wp_footer(); ?>

</body>
</html>