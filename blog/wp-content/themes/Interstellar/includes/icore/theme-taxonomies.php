<?php

/*-----------------------------------------------------------------------------------*/
/* Register Theme Taxonomies */
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'ps_portfolio_create_type' );

function ps_portfolio_create_type() {

	register_post_type('portfolio',
		array(
			'labels' => array(
				'name'						=> __('Portfolios','InterStellar'),
				'singular_name' 			=> __('Portfolio','InterStellar'),
				'add_new'					=> __('Add New', 'InterStellar'),
				'add_new_item'				=> __('Add Portfolio', 'InterStellar'),
				'new_item'					=> __('Add Portfolio', 'InterStellar'),
				'view_item'					=> __('View Portfolio', 'InterStellar'),
				'search_items' 				=> __('Search Portfolio', 'InterStellar'),
				'edit_item' 				=> __('Edit Portfolio', 'InterStellar'),
				'all_items'					=> __('All Portfolios', 'InterStellar'),
				'not_found'					=> __('No Portfolios found', 'InterStellar'),
				'not_found_in_trash'		=> __('No Portfolios found in Trash', 'InterStellar')
			),
			'taxonomies'	=> array('pcategory', 'ptag'),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array( 'slug' => 'portfolio', 'with_front' => false ),
			'query_var' => true,
			'supports' => array('title','revisions','thumbnail','author','editor','post-formats', 'excerpt'),
			'menu_position' => 5,
			'has_archive' => true
		)
	);
}

/*-----------------------------------------------------------------------------------*/
/* Register taxonomy for new post type */
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'ps_portfolio_taxonomy', 0 );

function ps_portfolio_taxonomy() {
	// Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name', 'InterStellar' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name', 'InterStellar' ),
    'search_items' =>  __( 'Search Categories', 'InterStellar' ),
    'all_items' => __( 'All Categories', 'InterStellar' ),
    'parent_item' => __( 'Parent Category', 'InterStellar' ),
    'parent_item_colon' => __( 'Parent Category:', 'InterStellar' ),
    'edit_item' => __( 'Edit Category', 'InterStellar' ),
    'update_item' => __( 'Update Category', 'InterStellar' ),
    'add_new_item' => __( 'Add New Category', 'InterStellar' ),
    'new_item_name' => __( 'New Category Name', 'InterStellar' ),
    'menu_name' => __( 'Categories', 'InterStellar' )
  );
	register_taxonomy('pcategory','portfolio',array(
				'hierarchical' => true,
				'labels' => $labels,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'pcategory' )
	));
}

add_action( 'init', 'ps_portfolio_tags', 1 );

function ps_portfolio_tags() {
	register_taxonomy( 'ptag', 'portfolio', array(
				'hierarchical' => false,
				'update_count_callback' => '_update_post_term_count',
				'label' => __('Tags', 'InterStellar'),
				'query_var' => true,
				'rewrite' => array( 'slug' => 'ptags' )
	)) ;
}

// Flush rewrite rules for custom post type and taxonomies added in theme
function icore_flush_rewrite_rules() {
    global $pagenow, $wp_rewrite;

    if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        $wp_rewrite->flush_rules();
}

add_action( 'load-themes.php', 'icore_flush_rewrite_rules' );

?>