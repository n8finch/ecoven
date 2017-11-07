<?php
/**
 * Miscellaneous helper functions
 *
 * @package ecoventura-2012
 * @since 1.0.0
 * @author Josh Eaton <josh@josheaton.org>
 */

/**
 * Set default image link to none
 */
function eco_default_link_none() {
	$image_set = get_option( 'image_default_link_type' );

	if ( $image_set !== 'none' ) {
		update_option( 'image_default_link_type', 'none' );
	}
}

/**
 * Lower priority of WordPress SEO metabox
 *
 * @param  [type] $priority [description]
 * @return [type]           [description]
 */
function eco_wpseo_metabox_prio( $priority ) {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'eco_wpseo_metabox_prio' );

function eco_jetpack_gallery_types( $types ) {
	$types['slideshow'] = __( 'Slideshow', 'ecoventura-2017' );

	return $types;
}
add_filter( 'jetpack_gallery_types', 'eco_jetpack_gallery_types' );


add_filter( 'post_gallery', 'eco_gallery_slideshow', 10, 2 );
function eco_gallery_slideshow( $val, $attr ) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	// Only run on slideshow types
	if ( !isset( $attr['type'] ) || 'slideshow' != $attr['type'] ) {
		return '';
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => 'li',
		'icontag'    => 'dt',
		'captiontag' => 'div',
		'columns'    => 3,
		'size'       => 'gallery-cropped',
		'include'    => '',
		'exclude'    => ''
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'dl';
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'dd';
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'dt';

	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} underscores_slider gallery-slideshow'>";
	$output = $gallery_div;

	$output .= '<ul class="slides">';

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
			$image_output = wp_get_attachment_link( $id, $size, false, false );
		elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
			$image_output = wp_get_attachment_image( $id, $size, false );
		else
			$image_output = wp_get_attachment_link( $id, $size, true, false );

		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "$image_output";
		// if ( $captiontag && trim($attachment->post_excerpt) ) {
		// 	$output .= "
		// 		<{$captiontag} class='wp-caption-text gallery-caption'>
		// 		" . wptexturize($attachment->post_excerpt) . "
		// 		</{$captiontag}>";
		// }
		$output .= "</{$itemtag}>";
		// if ( $columns > 0 && ++$i % $columns == 0 )
		// 	$output .= '<br style="clear: both" />';
	}

	$output .= "
			</ul>
		</div>\n";

	// Attempt to disable Jetpack carousel for these sliders
	add_filter( 'jp_carousel_maybe_disable', '__return_true' );

	return $output;
}

/**
 * Utility function to get a post object from a page slug
 *
 * @param  [type] $page_slug [description]
 * @param  [type] $output    [description]
 * @param  string $post_type [description]
 * @return [type]            [description]
 */
function get_page_by_slug( $page_slug, $output = OBJECT, $post_type = 'page' ) {
	global $wpdb;

	$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type ) );

	 if ( $page )
		return get_post($page, $output);

	return null;
}

/**
 * Output a yacht slideshow
 *
 * @param  string $deck [should be 'dolphin', 'booby' or 'iguana']
 * @return [type]            [description]
 */
function eco_yacht_slideshow( $deck = 'dolphin' ) {

	// TODO: If page path changes, change here!
	$page  = get_page_by_slug( 'galapagos-yachts' );

	if ( ! $page )
		return;

	$key    = '_eco_' . $deck . '_deck_images';
	$id     = $deck . '-deck-slider';
	$output = '';

	$deck_overlays = array(
		'booby-deck-b-cabin-bathrooms'    => 'booby-deck-b-cabin.png',
		'booby-deck-b-cabin'              => 'booby-deck-b-cabin-bathrooms.png',
		'booby-deck-bar'                  => 'booby-deck-bar.png',
		'booby-deck-conference-room'      => 'booby-deck-conference-room.png',
		'booby-deck-dining-room'          => 'booby-deck-dining-room.png',
		'booby-deck-galley'               => 'booby-deck-galley.png',
		'dolphin-deck-bridge'             => 'dolphin-deck-bridge.png',
		'dolphin-deck-d1'                 => 'dolphin-deck-d1.png',
		'dolphin-deck-d2'                 => 'dolphin-deck-d2.png',
		'dolphin-deck-d3'                 => 'dolphin-deck-d3.png',
		'dolphin-deck-d4'                 => 'dolphin-deck-d4.png',
		'dolphin-deck-observation-deck'   => 'dolphin-deck-observation-deck.png',
		'dolphin-deck-observation-deck-2' => 'dolphin-deck-observation-deck-2.png',
		'iguana-deck-cabin-17-18'         => 'iguana-deck-cabin-17-18.png',
		'iguana-deck-cabin-19-20'         => 'iguana-deck-cabin-19-20.png',
	);
	$deck_overlay_uri = get_stylesheet_directory_uri() . '/images/deck-images/';

	// Slideshow
	if( get_field( $key, $page->ID) ):
		$output .= '<div class="underscores_slider yacht-slider" id="'.$id.'">';
			$output .= '<ul class="slides">';
			while ( has_sub_field( $key ) ) {
				$deck_photo    = get_sub_field( 'deck_photo' );
				$deck_overlay  = get_sub_field( 'deck_image_overlay' );
				$deck_title    = get_sub_field( 'photo_title' );
				// $photo_caption = get_sub_field( 'photo_caption' );
				$output .= '<li>';
					$output .= '<img src="' . $deck_photo['sizes']['cuisine-gallery'] . '" alt="' . $deck_photo['alt'] . '" title="' . $deck_photo['title'] . '">';
					$output .= '<div class="deck-overlay ' . $deck_overlay . '">';
						$output .= '<div class="deck-photo-title"><span>' . $deck_title . '</span></div>';
					$output .= '</div>';
					// if ( $photo_caption ) {
					// 	$output .= '<div class="slide-caption">' . $photo_caption . '</div>';
					// }
					// $output .= '<img src="' . $deck_overlay_uri . $deck_overlays[$deck_overlay] . '" alt="" class="deck-overlay">';
				$output .= '</li>';
			}
			$output .= '</ul>';
		$output .= '</div>';
		// Carousel navigation
		$output .= '<div class="underscores_slider yacht-slider-nav" id="'.$id.'-nav">';
			$output .= '<ul class="slides">';
			while ( has_sub_field( $key ) ) {
				$deck_photo   = get_sub_field( 'deck_photo' );
				$output .= '<li>';
					$output .= '<img src="' . $deck_photo['sizes']['thumbnail'] . '" alt="' . $deck_photo['title'] . '">';
				$output .= '</li>';
			}
			$output .= '</ul>';
		$output .= '</div>';
	endif;

	return $output;
}
