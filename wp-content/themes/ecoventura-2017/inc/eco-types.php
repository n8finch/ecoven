<?php
/**
 * Register Custom Taxonomies and Post Types
 *
 * ==Post Types:==
 * Guest Review
 * In the Media
 * Galleries
 *
 * ==Taxonomies:==
 *
 */

add_action( 'init', '_eco_register_post_types' );
function _eco_register_post_types() {
	/*****************************************************
	 * Post Types
	 *****************************************************
	 */

	// Guest Review CPT
	register_post_type( 'guest-review',
		array(
			'labels' => array(
				'name'                  => __( 'Guest Reviews' ),
				'singular_name'         => __( 'Guest Review' ),
				'all_items'             => __( 'Guest Reviews' ),
				'add_new_item'          => __( 'Add New Guest Review' ),
				'edit_item'             => __( 'Edit Guest Review' ),
				'new_item'              => __( 'New Guest Review' ),
				'view_item'             => __( 'View Guest Review' ),
				'search_items'          => __( 'Search Guest Reviews' ),
				'not_found'             => __( 'No Guest Reviews found' ),
				'not_found_in_trash'    => __( 'No Guest Reviews found in Trash' ),
				'parent_item_colon'     => '',
				'menu_name'             => __( 'Guest Reviews' ),
			),
			'public'                    => true,
			'publicly_queryable'        => true,
			'show_ui'                   => true,
			'exclude_from_search'       => false,
			'menu_position'             => null,
			'show_in_nav_menus'         => false,
			'hierarchical'              => false,
			'capability_type'           => 'post',
			'menu_icon'                 => get_stylesheet_directory_uri() . '/inc/admin/img/menu-testimonial.png',
			'query_var'                 => true,
			'rewrite'                   => array( 'slug' => 'guest-reviews', 'with_front' => false ),
			'has_archive'               => 'guest-reviews',
			'supports'                  => array( 'title', 'editor', 'excerpt', 'genesis-cpt-archives-settings' ),
			'taxonomies'                => array(
											),
		)
	);

	// Press CPT
	register_post_type( 'press',
		array(
			'labels' => array(
				'name'                  => __( 'Press Items' ),
				'singular_name'         => __( 'Press Item' ),
				'all_items'             => __( 'Press Items' ),
				'add_new_item'          => __( 'Add New Press Item' ),
				'edit_item'             => __( 'Edit Press Item' ),
				'new_item'              => __( 'New Press Item' ),
				'view_item'             => __( 'View Press Item' ),
				'search_items'          => __( 'Search Press Items' ),
				'not_found'             => __( 'No Press Items found' ),
				'not_found_in_trash'    => __( 'No Press Items found in Trash' ),
				'parent_item_colon'     => '',
				'menu_name'             => __( 'In the Media' ),
			),
			'public'                    => true,
			'publicly_queryable'        => true,
			'show_ui'                   => true,
			'exclude_from_search'       => false,
			'menu_position'             => null,
			'show_in_nav_menus'         => false,
			'hierarchical'              => false,
			'capability_type'           => 'post',
			'menu_icon'                 => get_stylesheet_directory_uri() . '/inc/admin/img/menu-in-the-media.png',
			'query_var'                 => true,
			'rewrite'                   => array( 'slug' => 'in-the-media', 'with_front' => false ),
			'has_archive'               => 'in-the-media',
			'supports'                  => array( 'title', 'editor', 'thumbnail', 'revisions', 'genesis-cpt-archives-settings' ),
			'taxonomies'                => array(
												'press-type',
											),
		)
	);

	// Gallery
	register_post_type( 'gallery',
		array(
			'labels' => array(
				'name'                  => 'Photo Galleries',
				'singular_name'         => 'Gallery',
				'add_new'               => 'Add New',
				'add_new_item'          => 'Add New Gallery',
				'edit_item'             => 'Edit Gallery',
				'new_item'              => 'New Gallery',
				'view_item'             => 'View Gallery',
				'search_items'          => 'Search Galleries',
				'not_found'             => 'No Gallery found',
				'not_found_in_trash'    => 'No galleries found in trash',
				'parent_item_colon'     => '',
				'menu_name'             => 'Galleries'
			),
			'public'                    => true,
			'publicly_queryable'        => true,
			'show_ui'                   => true,
			'show_in_menu'              => true,
			'query_var'                 => true,
			'rewrite'                   => array(
											'slug'       => 'gallery',
											'with_front' => false
			),
			'has_archive'               => 'galleries',
			'capability_type'           => 'post',
			'hierarchical'              => false,
			'menu_position'             => null,
			'menu_icon'                 => get_stylesheet_directory_uri() . '/inc/admin/img/menu-galleries.png',
			'supports'                  => array('title','editor','thumbnail','revisions', 'genesis-cpt-archives-settings')
		)
	);

	/*****************************************************
	 * Taxonomies
	 *****************************************************
	 */

	/* Gallery Type */
	register_taxonomy(
		'gallery-type',
		array(
			'gallery',
		),
		array(
			'labels' => array(
				'name'              => __( 'Gallery Type',          'ecoventura-2013' ),
				'singular_name'     => __( 'Gallery Type',          'ecoventura-2013' ),
				'search_items'      => __( 'Search Gallery Types', 'ecoventura-2013' ),
				'all_items'         => __( 'All Gallery Types',    'ecoventura-2013' ),
				'parent_item'       => __( 'Parent Gallery Type',   'ecoventura-2013' ),
				'parent_item_colon' => __( 'Parent Gallery Type:',  'ecoventura-2013' ),
				'edit_item'         => __( 'Edit Gallery Type',     'ecoventura-2013' ),
				'update_item'       => __( 'Update Gallery Type',   'ecoventura-2013' ),
				'add_new_item'      => __( 'Add New Gallery Type',  'ecoventura-2013' ),
				'new_item_name'     => __( 'New Gallery Type Name', 'ecoventura-2013' ),
				'menu_name'         => __( 'Gallery Types',        'ecoventura-2013' )
			),
			'hierarchical'        => false,
			'show_ui'             => true,
			'query_var'           => true,
			'show_admin_column'   => true,
			'show_in_nav_menus'   => false,
			'rewrite'             => array( 'slug' => 'gallery-type', 'with_front' => false ),
		)
	);

}

/**
 * Flush rewrite rules for custom post types on theme activation
 */
function eco_flush_rewrite_rules() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'eco_flush_rewrite_rules' );
