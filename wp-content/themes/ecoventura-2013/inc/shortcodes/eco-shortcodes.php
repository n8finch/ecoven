<?php
/**
 * Section shortcode
 *
 * Used on itinerary page for sectioning out itinerary options into accordion-like parts
 * to be manipulated with jQuery
 */

/**
 * Render the [section] shortcode
 *
 * @since 1.0.0
 */
function eco_section_shortcode( $atts, $content = '' ) {

	extract( shortcode_atts( array(
		'title' => 'View More'
	), $atts, 'section' )
	);

	$output = '<h3 class="section-title">' . esc_html($atts['title']) . '</h3>
<div class="section-content">' . do_shortcode($content) . '</div>';

	return $output;
}
add_shortcode( 'section', 'eco_section_shortcode' );

/**
 * Render the [divider] shortcode
 *
 * @since 1.0.0
 */
function eco_divider_shortcode( $atts ) {

	$output = '<hr class="divider">';

	return $output;
}
add_shortcode( 'divider', 'eco_divider_shortcode' );


/**
 * Render the [itinerary-photos] shortcode
 *
 * @since 1.0.0
 */
function eco_itinerary_gallery_shortcode( $atts ) {

	extract( shortcode_atts( array(
		'itinerary' => 'a',
		'format'    => 'slider',
	), $atts, 'itinerary-gallery' )
	);

	$output = eco_itinerary_slideshow( $itinerary, $format );

	return $output;
}
add_shortcode( 'itinerary-gallery', 'eco_itinerary_gallery_shortcode' );


function eco_x_table_image_shortcode( $atts ) {
	$img = '<img src="' . get_stylesheet_directory_uri() . '/images/circle-check.png" width="20" height="20" alt="checkmark" class="table-checkmark">';
	return $img;
}
add_shortcode( 'x', 'eco_x_table_image_shortcode' );
