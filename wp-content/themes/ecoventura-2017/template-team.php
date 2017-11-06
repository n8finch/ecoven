<?php
/**
 * Guides, Captains and Crew Page
 *
 * Template Name: Meet Our Team
 */

// Force full width content layout
// add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', 'eco_our_team_body_class' );
// add classes to body based page template
function eco_our_team_body_class( $classes ) {
	$classes[] = 'our-team';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_our_team_post_classes( $classes ) {
	$classes[] = 'our-team-content';

	return $classes;
}
add_filter( 'post_class', 'eco_our_team_post_classes' );


function eco_team_display() {
	global $post;

	// Guayaquil
	echo '<h2>' . get_field( '_eco_guayaquil_heading', $post->ID ) . '</h2>';

	if ( get_field( '_eco_team_guayaquil' ) ) :
		echo '<div class="group captains">';
		while( has_sub_field( '_eco_team_guayaquil' ) ) {
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

	// Quito
	echo '<h2>' . get_field( '_eco_quito_heading', $post->ID ) . '</h2>';

	if ( get_field( '_eco_team_quito' ) ) :
		echo '<div class="group captains">';
		while( has_sub_field( '_eco_team_quito' ) ) {
			echo '<div class="captain">';
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

	// Galapagos
	echo '<h2>' . get_field( '_eco_galapagos_heading', $post->ID ) . '</h2>';

	if ( get_field( '_eco_team_galapagos' ) ) :
		echo '<div class="group captains">';
		while( has_sub_field( '_eco_team_galapagos' ) ) {
			echo '<div class="captain">';
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

	// Miami
	echo '<h2>' . get_field( '_eco_miami_heading', $post->ID ) . '</h2>';

	if ( get_field( '_eco_team_miami' ) ) :
		echo '<div class="group captains">';
		while( has_sub_field( '_eco_team_miami' ) ) {
			echo '<div class="captain">';
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
}
add_action( 'genesis_entry_content', 'eco_team_display' );

genesis();
