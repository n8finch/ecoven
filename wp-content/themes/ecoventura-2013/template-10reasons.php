<?php
/**
 * 10 Reasons to book with Ecoventura
 *
 * Template Name: 10 Reasons
 */

add_action( 'genesis_entry_content', 'eco_10reasons_content' );

function eco_10reasons_content() {
	if ( get_field( '_eco_reason' ) ) {
		echo '<div class="group eco-reasons">';
		$counter = 1;
		while( has_sub_field( '_eco_reason' ) ) {
			$class = '';
			if ( 0 != $counter % 2 ) {
				$class = ' first';
			}
			echo '<div class="one-half eco-reason'.$class.'">';
				$img_array = get_sub_field('_eco_reason_image');
				$title     = get_sub_field('_eco_reason_title');
				$desc      = get_sub_field('_eco_reason_desc');

				$img = wp_get_attachment_image( $img_array['id'], 'reason', false, array( 'class' => 'reason-image') );
				echo $img;
				echo '<h2><span>' . $counter . '.</span> ' . $title . '</h2>';
				echo $desc;
				$counter++;

			echo '</div>';
		}

		echo '</div>';
	}
}

genesis();
