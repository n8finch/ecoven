<?php
/**
 * World Nomads Calculator Popup Shortcode
 *
 * Displays a World Nomads button, when clicked, displays a popup with the World Nomads calculator
 *
 * @package ecoventura-2013
 * @author  Josh Eaton <josh@josheaton.org>
 * @since 1.0.0
 */

/**
 * Render the [worldnomads-widget] shortcode
 *
 * @since 1.0.0
 */
function eco_world_nomads_widget_shortcode( $atts ) {

	// Enqueue scripts and Add popup to footer
	wp_enqueue_script( 'jquery-ui-dialog' );
	add_action( 'wp_footer', 'eco_insert_world_nomads_popup' );

	extract( shortcode_atts( array(
	// an array of the shortcode's default options
	), $atts, 'worldnomads' )
	);

	$output = '<a href="javascript:void(0);" id="world-nomads"><img src="' . get_stylesheet_directory_uri() . '/images/world-nomads.png" width="203" height="51"></a>';

	return $output;
}
add_shortcode( 'worldnomads-widget', 'eco_world_nomads_widget_shortcode' );


function eco_world_nomads_calculator_shortcode( $atts ) {
	$calculator = eco_get_world_nomads_popup();

	$calculator = str_replace( ' style="display:none;"', '', $calculator );

	$calculator = '<div class="worldnomads-calculator">' . $calculator . '</div>';

	return $calculator;
}
add_shortcode( 'worldnomads-calculator', 'eco_world_nomads_calculator_shortcode' );

/**
 * Output the popup HTML
 */
function eco_insert_world_nomads_popup() {
	echo eco_get_world_nomads_popup();
}

function eco_get_world_nomads_popup() {
	$output = '
	<link rel="stylesheet" type="text/css" href="http://www.worldnomads.com/turnstile/qp/common/styles/styles.min.css">
	<script type="text/javascript" src="http://www.worldnomads.com/turnstile/qp/common/scripts/script.min.js"></script>

	<div id="wn-overlay"></div>
	<div id="wn_calculator" style="display:none;">
		<div id="blue550">
			<script type="text/javascript">
				writeHTML("galap","","English");
			</script>
		</div>
	</div>';

	return $output;
}
