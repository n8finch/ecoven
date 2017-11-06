<?php
/**
 * Guides, Captains and Crew Page
 *
 * Template Name: Crew
 */

// Force full width content layout
// add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', 'eco_crew_body_class' );
// add classes to body based page template
function eco_crew_body_class( $classes ) {
	$classes[] = 'crew';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_crew_post_classes( $classes ) {
	$classes[] = 'crew-content';

	return $classes;
}
add_filter( 'post_class', 'eco_crew_post_classes' );


function eco_crew_display() {
	global $post;

	// Captains
	echo '<h2>Captains</h2>';

	if ( get_field( '_eco_captains' ) ) :
		echo '<div class="group captains">';
		while( has_sub_field( '_eco_captains' ) ) {
			echo '<div class="captain">';
				$img_id    = get_sub_field('_eco_headshot');
				$name      = get_sub_field('_eco_crew_name');
				$title     = get_sub_field('_eco_crew_title');
				$desc      = get_sub_field('_eco_crew_description');

				if ( $img_id ) {
					$img = wp_get_attachment_image( $img_id, 'crew-headshot', false, array( 'class' => 'crew-headshot') );
				} else {
					$img = '&nbsp;';
				}

				echo '<div class="first one-fourth">' . $img . '</div>';
				echo '<div class="three-fourths">';
					echo '<h3>' . $name . '</h3>';
					echo '<h4>' . $title . '</h4>';
					echo $desc;
				echo '</div>';

			echo '</div>';
		}

		echo '</div>';
	endif;

	// Guides
	echo '<h2>Guides</h2>';

	if ( get_field( '_eco_guides' ) ) :
		echo '<div class="group guides">';
		while( has_sub_field( '_eco_guides' ) ) {
			echo '<div class="guide">';
				$img_id    = get_sub_field('_eco_headshot');
				$name      = get_sub_field('_eco_crew_name');
				$title     = get_sub_field('_eco_crew_title');
				$desc      = get_sub_field('_eco_crew_description');

				$img = wp_get_attachment_image( $img_id, 'crew-headshot', false, array( 'class' => 'crew-headshot') );

				echo '<div class="first one-fourth">' . $img . '</div>';
				echo '<div class="three-fourths">';
					echo '<h3>' . $name . '</h3>';
					echo '<h4>' . $title . '</h4>';
					echo $desc;
				echo '</div>';

			echo '</div>';
		}

		echo '</div>';
	endif;

	// Crew
	if ( get_field( '_eco_crew_description_and_image' ) ) :
		echo '<h2>Crew</h2>';
		echo '<div class="group crew-only">';
			the_field( '_eco_crew_description_and_image' );
		echo '</div>';
	endif;


}
add_action( 'genesis_entry_content', 'eco_crew_display' );

genesis();
