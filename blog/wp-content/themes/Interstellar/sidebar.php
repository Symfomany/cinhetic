<section id="sidebar">
    <div id="sidebar-top">
    </div> <!-- #sidebar-top  -->
<!--    Start Dynamic Sidebar    -->
<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>	
				<?php dynamic_sidebar( 'sidebar' ); ?>
<?php endif; ?>

    <div class="clear"></div>
    <div id="sidebar-bottom">
    </div> <!-- #sidebar-bottom  -->  
</section> <!-- #sidebar  --> 
