<?php
/**
 * Gallery Archive Template
 *
 * @since 1.0.0
 */

// Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// Remove post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Remove post title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Remove featured image, we are doing it ourselves
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Remove post navigation
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

/**
 * Gallery Archive Body Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function mxuf_gallery_archive_body_class( $classes ) {
	$classes[] = 'gallery-archive';
	return $classes;
}
add_filter( 'body_class', 'mxuf_gallery_archive_body_class' );

/**
 * Outer Wrap
 *
 * @since 1.0.0
 */
function mxuf_gallery_archive_wrap() {
	echo '<div class="gallery-archive-wrap">';
}
add_action( 'genesis_before_loop', 'mxuf_gallery_archive_wrap', 80 );

/**
 * Outer Wrap Close
 *
 * @since 1.0.0
 */
function mxuf_gallery_archive_wrap_close() {
	echo '</div>';
}
add_action( 'genesis_after_loop', 'mxuf_gallery_archive_wrap_close', 1 );

/**
 * Blog Post Archive Classes
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function mxuf_archive_post_classes( $classes ) {
	global $wp_query;
	$classes[] = 'one-fourth';
	if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 4 )
		$classes[] = 'first';

	return $classes;
}
add_filter( 'post_class', 'mxuf_archive_post_classes' );

/**
 * Project Archive Content
 *
 * @since 1.0.0
 */
function mxuf_blog_post_archive_content() {
	global $post;
	echo '<div class="gallery-archive-container">';
		echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, 'gallery-archive-thumb' ) . '</a>';
		genesis_do_post_title();
	echo '</div>';
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'mxuf_blog_post_archive_content' );

/**
 * Add widget area to Photo Galleries Archive for navigation
 *
 * @since 1.0.0
 * @return [type] [description]
 */
function mxuf_gallery_archive_title() {
	global $post;
	echo '<header class="entry-header">';
		echo '<h1 class="archive-title">' . post_type_archive_title( '', false ) . '</h1>';
	echo '</header>';
}
add_action( 'genesis_before_loop', 'mxuf_gallery_archive_title' );


remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'eco_gallery_photos_loop' );
function eco_gallery_photos_loop() {

	// Set args to only pull photos
	$query_args = array(
		'nopaging'  => 1,
		'tax_query' => array(
			array(
				'taxonomy' => 'gallery-type',
				'field'    => 'slug',
				'terms'    => 'photos',
			),
		),
	);

	genesis_custom_loop( $query_args );
}

add_action( 'genesis_loop', 'eco_gallery_videos_loop' );
function eco_gallery_videos_loop() {

	echo '<header class="entry-header videos-header"><h1 class="videos-title">Videos</h1></header>';

	// Set args to only pull photos
	$query_args = array(
		'nopaging'  => 1,
		'tax_query' => array(
			array(
				'taxonomy' => 'gallery-type',
				'field'    => 'slug',
				'terms'    => 'videos',
			),
		),
	);

	genesis_custom_loop( $query_args );
}

genesis();
