<?php
/**
 * Admin functions
 *
 * @since        1.0.0
 * @package      ecoventura-2017
 */

/**
 * Enqueue admin scripts
 *
 * @return null
 */
function eco_admin_scripts() {
	wp_enqueue_style( 'eco-admin', get_stylesheet_directory_uri() . '/inc/admin/css/eco-admin.css', array(), null, 'all' );
}
add_action( 'admin_enqueue_scripts', 'eco_admin_scripts' );

/**
 * Register a new meta box to the post / page edit screen, so that the user can
 * set layout options on a per-post or per-page basis.
 *
 * @category Genesis
 * @package Admin
 * @subpackage Inpost-Metaboxes
 *
 * @since 0.2.2
 *
 * @see genesis_inpost_layout_box() Generates the content in the boxes
 *
 * @return null Returns null if Genesis layouts are not supported
 */
function be_reposition_inpost_layout_box() {

	if ( ! current_theme_supports( 'genesis-inpost-layouts' ) )
		return;

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-layouts' ) )
			add_meta_box( 'genesis_inpost_layout_box', __( 'Layout Settings', 'genesis' ), 'genesis_inpost_layout_box', $type, 'normal', 'default' );
	}

}
remove_action( 'admin_menu', 'genesis_add_inpost_layout_box' );
add_action( 'admin_menu', 'be_reposition_inpost_layout_box' );


function eco_press_item_register_columns( $columns ) {

	// remove publish date first
	// unset($columns['date']);
	unset( $columns['wpseo-score'] );
	unset( $columns['wpseo-title'] );
	unset( $columns['wpseo-metadesc'] );
	unset( $columns['wpseo-focuskw'] );

	$columns['show-on'] = __( 'Show on Home?' );

	return $columns;
}

function eco_press_item_display_columns( $column, $post_id ) {

	switch ( $column ) {
		case 'show-on':
			$show_on   = get_post_meta( $post_id, '_eco_show_on_home', true );
			if ( !empty($show_on) && '1' == $show_on ) :
				echo 'X';
			else:
				echo '&nbsp;';
			endif;

			break;
		// end all case breaks
		}
}


function eco_press_sortable_columns( $columns ) {

	$columns['show-on'] = 'show-on';

	return $columns;
}

add_filter ( 'manage_edit-press_columns',   'eco_press_item_register_columns' );
add_action ( 'manage_posts_custom_column',  'eco_press_item_display_columns', 10, 2 );
add_filter ( 'manage_edit-guest-review_columns',   'eco_press_item_register_columns' );
add_filter ( 'manage_edit-press_sortable_columns', 'eco_press_sortable_columns' );
add_filter ( 'manage_edit-guest-review_sortable_columns', 'eco_press_sortable_columns' );

/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'eco_press_load' );

function eco_press_load() {
	add_filter( 'request', 'eco_sort_press' );
}

/* Sorts the press. */
function eco_sort_press( $vars ) {

	/* Check if we're viewing the 'press' post type. */
	if ( isset( $vars['post_type'] ) && ( 'press' == $vars['post_type'] || 'guest-review' == $vars['post_type'] ) ) {

		/* Check if 'orderby' is set to 'show-on'. */
		if ( isset( $vars['orderby'] ) && 'show-on' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_eco_show_on_home',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}

