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
