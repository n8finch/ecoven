<?php
/**
 * Guest Reviews Archive template
 */

// Force full width content layout
// add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove author gravatar
// remove_action( 'genesis_before_post_title', 'logoco_add_archive_author_gravatar' );

// Remove post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Remove featured image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

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
	$classes[] = 'guest-reviews';
	return $classes;
}

add_action( 'genesis_before_loop', 'eco_add_press_archive_title' );
/**
 * Add title to top of category archives
 * @since 1.0.0
 */
function eco_add_press_archive_title() {
	?>
	<div class="reviews-wrapper">
	<?php
}

/**
 * Blog Post Archive Classes
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_reviews_archive_post_classes( $classes ) {
  global $wp_query;
  if( 0 != $wp_query->current_post || 0 != $wp_query->current_post % 2 )
    $classes[] = 'last';

  return $classes;
}
add_filter( 'post_class', 'eco_reviews_archive_post_classes' );

add_filter( 'genesis_attr_entry-content_output', 'eco_add_review_id', 10, 3 );
function eco_add_review_id( $output, $attributes, $context ) {
	global $post;

	// Bail if not a guest review
	if ( 'guest-review' != $post->post_type)
		return $output;

	// Add an id attribute using the post slug
	$attributes['id'] = sanitize_title( $post->post_title );

	// Reset the output
	$output = '';

	// Rebuild the output using the new attributes
	foreach ( $attributes as $key => $value ) {
	    if ( ! $value )
	        continue;
	    $output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
	}

	return $output;
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

	$trip = get_field( '_eco_guests_trip', $post->ID );


	echo '<div class="review-content">';
		the_content();
		echo '<span class="review-name">' . get_the_title() . '</span>';
		echo '<span class="review-trip">' .  sanitize_text_field( $trip ) . '</span>';

	echo '</div>';
}


add_action( 'genesis_after_loop', 'eco_end_reviews_wrap' );
/**
 * Testimonial Archive End
 *
 * @return void
 */
function eco_end_reviews_wrap() {
	?>
	</div><? // END .testimonial-wrapper ?>
	<?php
}


add_action( 'genesis_entry_footer', 'eco_print_divider' );
function eco_print_divider() {
	echo '<hr class="divider">';
}

genesis();
