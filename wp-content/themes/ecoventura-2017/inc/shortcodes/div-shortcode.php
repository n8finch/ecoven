<?php
/* Open Div */
add_shortcode('div', 'be_div_shortcode');
function be_div_shortcode($atts, $content = '') {
	extract(shortcode_atts(array('class' => '', 'id' => '' ), $atts));
	$return = '<div';
	if (!empty($class)) $return .= ' class="'.$class.'"';
	if (!empty($id)) $return .= ' id="'.$id.'"';
	$return .= '>';
	return $return . do_shortcode($content) . '</div>';
}
