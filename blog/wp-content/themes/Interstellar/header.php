<?php global $shortname, $options; ?>
<?php $options = get_option( $shortname . '_options' ); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>	
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="author" content="UFO Themes" />

<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'InterStellar' ), max( $paged, $page ) );

	?></title>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style-ie8.css" />
<![endif]--> 

<?php wp_head(); ?>  
</head>
<body <?php body_class(); ?>>
    <div id="wrapper" class="container">
        <div id="wrap-inside">
	      
	        <div id="header">
	              <!-- Print logo -->            
		       	<h1 class="logo">
				    <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php if ( isset( $options['logo'] ) && '' != $options['logo'] ) : ?>
				    		<img id="logo" src="<?php echo esc_url( $options['logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
				    	<?php else : ?>
				    		<?php bloginfo( 'name' ); ?>
				    	<?php endif; ?>
				    </a>
				</h1>
			
	               <h2 id="tagline"><?php bloginfo('description'); ?></h2>
	                <div id="social"> 
	          		<?php if( isset( $options['facebook'] ) && $options['facebook'] <> '' ) { ?>  
	          				<a href="<?php echo $options['facebook']; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/social/Facebook.png" alt="facebook" /></a>  
					<?php } ?>

	          		<?php if( isset( $options['twitter'] ) && $options['twitter'] <> '' ) { ?>  
	          				<a href="<?php echo $options['twitter']; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/social/Twitter.png" alt="twitter"/></a>
					<?php } ?> 

	          		<?php if( isset( $options['rss'] ) && $options['rss'] <> '' ) { ?>  
	            			<a href="<?php echo $options['rss']; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/social/Feed.png" alt="rss" /></a>
					<?php } ?>

	             	<?php if( isset( $options['youtube'] ) && $options['youtube'] <> '' ) { ?>  
	                		<a href="<?php echo $options['youtube']; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/social/Youtube.png" alt="youtube" /></a>
					<?php } ?> 
	        	</div>  <!--  #social  -->                             
	        </div>  <!--  #header  -->


		 <div id="main-menu-wrap">           
            <?php icore_nav_menu('primary-menu', 'nav sf'); ?>
			<?php echo '<a href="#" id="mobile_nav" class="closed">' . '<span></span>' . esc_html__( 'Menu', 'InterStellar' ) . '</a>'; ?>
            <!--  Print search bar  -->
        	<?php if ( isset($options['search']) && $options['search'] == '1' ) { ?>
	    		  	<div id="searchbar">
	            		<?php get_search_form(); ?>
	        		</div>
	  		<?php } ?>
	
            </div>
	
        <div id="main-content">  
        	<?php if ( is_home() && isset( $options['slider_enabled'] ) && $options['slider_enabled'] == '1' || is_front_page() && isset( $options['slider_enabled'] ) && $options['slider_enabled'] == '1') get_template_part( '/includes/featured'); ?>