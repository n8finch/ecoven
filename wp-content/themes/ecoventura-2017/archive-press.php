<?php
/**
 * In The Media Archive template
 */

// Force full width content layout
// add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove author gravatar
// remove_action( 'genesis_before_post_title', 'logoco_add_archive_author_gravatar' );

// Remove post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );


// Remove featured image, we are doing it ourselves
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Move post navigation
// remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

// Customize the newer posts link
add_filter ( 'genesis_next_link_text' , 'eco_press_newer_link' );
function eco_press_newer_link ( $text ) {
		return __( 'Next Press Items', 'genesis' ) . ' &raquo;';
}

// Customize the older posts link
add_filter ( 'genesis_prev_link_text' , 'eco_press_older_link' );
function eco_press_older_link ( $text ) {
		return '&laquo; ' . __( 'Previous Press Items', 'genesis' );
}

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
/**
 * Modify post titles
 *
 * Remove the post title link
 */
// add_action( 'genesis_entry_header', 'eco_press_post_title' );
function eco_press_post_title() {
	global $post;
	echo '<h2 class="entry-title">' . get_the_title() . '</h2>';
}

add_filter( 'body_class', 'eco_press_body_class' );
// add classes to body based on custom taxonomy
function eco_press_body_class( $classes ) {
	$classes[] = 'in-the-media';
	return $classes;
}

add_action( 'genesis_before_loop', 'eco_add_press_archive_title' );
/**
 * Add title to top of category archives
 * @since 1.0.0
 */
function eco_add_press_archive_title() {
	if ( is_paged() ) {
		echo '<header class="entry-header">';
			echo '<h1 class="archive-title">In The Media: Page ' . get_query_var( 'paged' ) . '</h1>';
		echo '</header>';
	}
	?>
	<div class="press-wrapper">
	<?php
}

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_press_archive_content' );
/**
 * Project Archive Content
 *
 * @return void
 */
function eco_press_archive_content() {
	global $post;

	$url  = get_field( '_eco_source_url', $post->ID );
	$file = get_field( '_eco_file_upload', $post->ID );
	$icon = wp_get_attachment_image( $file['id'], 'thumbnail', true );

	if ( $url ) {
		echo '<a href="' . esc_url( $url ) . '" target="_blank">';
			echo get_the_post_thumbnail( $post->ID, 'gallery-cropped', array( 'class' => 'press-thumb' ) );
		echo '</a>';
		# code...
	} else {
		echo get_the_post_thumbnail( $post->ID, 'gallery-cropped', array( 'class' => 'press-thumb' ) );
	}
	echo '<div class="press-content">';
		if ( $url ) {
			echo '<a class="press-link" href="' . esc_url( $url ) . '" target="_blank">' . '<span class="press-title">' . get_the_title() . '</span>' . '</a>';
		} else {
			echo '<span class="press-title">' . get_the_title() . '</span>';
		}
		echo '<span class="press-tagline">' . get_the_content() . '</span>';

		if ( $file ) {
			echo '<a class="press-download" href="' . esc_url( $file['url'] ) . '">' . $icon .  __('Download PDF', 'ecoventura-2013') . '</a>';
		}
	echo '</div>';
}

// add_action( 'genesis_after_entry', 'eco_add_press_clear' );
/**
 * Output a clearing div after every 2 posts
 *
 * @return void
 */
function eco_add_press_clear() {
	global $wp_query;
	// Output a clearing div after every 2 posts
	if( 0 != $wp_query->current_post % 2 )
		echo '<div class="group"></div>';
}

add_action( 'genesis_after_loop', 'eco_end_press_wrap' );
/**
 * Testimonial Archive End
 *
 * @return void
 */
function eco_end_press_wrap() {
	?>
	</div><? // END .testimonial-wrapper ?>
	<?php
}

genesis();
