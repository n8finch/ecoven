<?php
/**
 * Itineraries Page
 *
 * Template Name: Itineraries
 */

// Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', 'eco_itineraries_body_class' );
// add classes to body based page template
function eco_itineraries_body_class( $classes ) {
	$classes[] = 'itineraries';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_itineraries_post_classes( $classes ) {
	$classes[] = 'itineraries-content';

	return $classes;
}
add_filter( 'post_class', 'eco_itineraries_post_classes' );

function eco_itinerary_layout() {
	global $post;
	?>
	<div class="itineraries-wrap group">
		<div class="one-half first itinerary itinerary-a">
			<div class="itinerary-map">
				<?php
				$small_map_a_id    = get_field( '_eco_itinerary_a_small_map' );
				$small_map_a_img   = wp_get_attachment_image( $small_map_a_id, 'itinerary-map-small' );
				$small_map_a_title = get_the_title( $small_map_a_id );
				$large_map_a_id    = get_field( '_eco_itinerary_a_large_map' );
				$large_map_a_src   = wp_get_attachment_image_src( $large_map_a_id, 'full' );
				?>
				<a href="<?php echo $large_map_a_src[0]; ?>" class="small-map" title="<?php echo esc_attr($small_map_a_title); ?>">
					<?php echo $small_map_a_img; ?>
					<span class="map-letter">
					</span>
					<img src="<?php echo get_stylesheet_directory_uri();?>/images/magnifying-glass.png" width="13" height="13" class="magnifying-glass">
				</a>
			</div>
			<?php the_field( '_eco_itinerary_a_content' ); ?>
			<?php // Slideshow ?>
			<?php echo eco_itinerary_slideshow( 'a', 'slider' ); ?>
		</div>
		<div class="one-half itinerary itinerary-b">
			<div class="itinerary-map">
				<?php
				$small_map_b_id    = get_field( '_eco_itinerary_b_small_map' );
				$small_map_b_img   = wp_get_attachment_image( $small_map_b_id, 'itinerary-map-small' );
				$small_map_b_title = get_the_title( $small_map_b_id );
				$large_map_b_id    = get_field( '_eco_itinerary_b_large_map' );
				$large_map_b_src   = wp_get_attachment_image_src( $large_map_b_id, 'full' );
				?>
				<a href="<?php echo $large_map_b_src[0]; ?>" class="small-map" title="<?php echo esc_attr($small_map_b_title); ?>">
					<?php echo $small_map_b_img; ?>
					<span class="map-letter">
					</span>
					<img src="<?php echo get_stylesheet_directory_uri();?>/images/magnifying-glass.png" width="13" height="13" class="magnifying-glass">
				</a>
			</div>
			<?php the_field( '_eco_itinerary_b_content' ); ?>
			<?php // Slideshow ?>
			<?php echo eco_itinerary_slideshow( 'b', 'slider' ); ?>
		</div>
	</div>
	<div class="stipulations">
		<?php the_field( '_eco_itinerary_stipulations' ); ?>
	</div>
	<?php
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_itinerary_layout' );

genesis();
