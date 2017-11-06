<?php
/**
 * Cuzco & Macchu Picchu Page
 *
 * Template Name: Cuzco & Macchu Picchu
 */

// Force Content Sidebar layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_filter( 'body_class', 'eco_cuzco_body_class' );
// add classes to body based page template
function eco_cuzco_body_class( $classes ) {
	$classes[] = 'cuzco';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_cuzco_post_classes( $classes ) {
	$classes[] = 'cuzco-content';

	return $classes;
}
add_filter( 'post_class', 'eco_cuzco_post_classes' );

function eco_cuzco_layout() {
	global $post;
	?>
	<div class="cuzco-description">
		<?php the_content(); ?>
	</div>
	<div class="cuzco-wrap group">
		<h4>First Class</h4>
		<div class="tab-content 6-nights" id="6-night-premium-first-class">
			<?php the_field( '_eco_6_night_content', $post->ID ); ?>
		</div>
		<h4>Luxury Class</h4>
		<div class="tab-content 7-nights" id="7-night-luxury-collection">
			<?php the_field( '_eco_7_night_content', $post->ID ); ?>
		</div>
	</div>
	<div class="cuzco-additional-content">
		<?php the_field( '_eco_cuzco_content', $post->ID ); ?>
	</div>
	<?php
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_cuzco_layout' );

genesis();
