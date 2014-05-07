<?php global $options; ?>

		</div> <!-- #main-content  --> 
	</div>  <!-- #wrap-inside  -->
    <?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
		<footer id="footer">
			<div id="footer-inside">
				<div id="footer-widgets">	
					<?php dynamic_sidebar( 'footer-sidebar' ); ?>
			    </div> <!-- #footer-widgets --> 
			</div> <!-- #footer-inside --> 
			<div class="clear"></div>
		</footer> <!--  #footer  -->
	<?php endif; ?>
	<span class="ufo-themes">
	<a href="http://www.ufothemes.com">Premium Wordpress Themes</a> by UFO Themes
	</span>
	<div id="copyright">             
    	<div id="copy-text" >WordPress theme by UFO themes</div>
	</div> <!-- #copyright  -->

</div> <!-- #wrapper  -->
<?php wp_footer(); ?>
 
</body>
</html>