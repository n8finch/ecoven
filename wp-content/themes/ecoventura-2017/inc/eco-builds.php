<?php
/**
 * Gets our posts
 */

// grab content for wherever
function eco_post_pull($type, $count) {

	$args = array(
		'post_type'			=> $type,
		'posts_per_page'	=> $count
		);

	$posts = new WP_Query($args);

	return $posts;

}

/* grab recent press */
function eco_front_press_items() {
	$front = get_option( 'page_on_front' );

	$press_items_max = get_field( '_eco_media_items_count', $front ) ? absint( get_field( '_eco_media_items_count', $front ) ) : 6;

	// get items
	$args = array(
		'fields'			=> 'ids',
		'post_type'			=> 'press',
		'numberposts'		=> $press_items_max,
		'no_found_rows'		=> true, // We don't care about the total results
		'meta_query' => array(
				array(
					'key'     => '_eco_show_on_home',
					'value'   => '1',
					'compare' => '=='
				)
			)
		);

	$press = get_posts( $args );

	foreach ($press as $press_item) :
		// get press data
		$press_item_img     = get_the_post_thumbnail( $press_item, 'media-thumb-mini' );
		$press_item_name    = get_the_title( $press_item );
		$press_item_link    = get_field( '_eco_source_url', $press_item );
		$press_item_content = get_post_field( 'post_content', $press_item, 'display' );

		if ( ! $press_item_link ) {
			$download_file = get_field( '_eco_file_upload', $press_item );
			$press_item_link = esc_url( $download_file['url'] );
		}

		echo '<li class="home-media-item">';
			echo '<a href="'.$press_item_link.'">'.$press_item_img.'</a>';
			echo '<p>';
				echo '<a href="'.$press_item_link.'">'.$press_item_name.' ';
				echo '<span class="press-tagline">'.$press_item_content.'</span></a>';
			echo '</p>';
		echo '</li>';
	endforeach;
}

/**
 * Grab recent guest reviews
 */
function eco_front_reviews() {

	$front = get_option( 'page_on_front' );

	$reviews_max = get_field( '_eco_guest_reviews_count', $front ) ? absint( get_field( '_eco_guest_reviews_count', $front ) ) : 6;

	// get items
	$args = array(
		'fields'			=> 'ids',
		'post_type'			=> 'guest-review',
		'numberposts'		=> $reviews_max,
		'no_found_rows'		=> true, // We don't care about the total results
		'meta_query' => array(
				array(
					'key'     => '_eco_show_on_home',
					'value'   => '1',
					'compare' => '=='
				)
			)
		);

	$reviews = get_posts( $args );

	foreach ($reviews as $review) :
		// get review data
		$review_name    = get_the_title( $review );
		$review_link    = get_post_type_archive_link( 'guest-review' ) . '#'.sanitize_title( $review_name );
		$review_trip    = get_field( '_eco_guests_trip', $review );
		$review_content = get_post_field( 'post_content', $review, 'display' );
		$review_excerpt = wp_trim_words( $review_content, 40, '...' );

		echo '<div class="guest-review">';
			echo '<p>';
				echo $review_excerpt;
			echo '</p>';
			echo '<p>';
				echo '<strong>' . sanitize_text_field($review_name) . '</strong><br>';
				echo '<em>'.sanitize_text_field($review_trip).'</em>';
				echo ' <a class="guest-review-more" href="'.$review_link.'">Read More</a>';
			echo '</p>';
		echo '</div>';
	endforeach;
}

// Home page nav buttons
function eco_build_home_nav() {
	global $post;

	// Get the button titles and links
	$title_1 = get_field( '_eco_home_button_1_title', $post->ID );
	$link_1  = get_field( '_eco_home_button_1_link',  $post->ID );
	$title_2 = get_field( '_eco_home_button_2_title', $post->ID );
	$link_2  = get_field( '_eco_home_button_2_link',  $post->ID );
	$title_3 = get_field( '_eco_home_button_3_title', $post->ID );
	$link_3  = get_field( '_eco_home_button_3_link',  $post->ID );
	$title_4 = get_field( '_eco_home_button_4_title', $post->ID );
	$link_4  = get_field( '_eco_home_button_4_link',  $post->ID );

	// Output the nav
	echo '<li class="one-fourth first"><a class="main-button" href="'.esc_url($link_1).'"><span>'.esc_html($title_1).'</span></a></li>';
	echo '<li class="one-fourth"><a class="main-button" href="'.esc_url($link_2).'"><span>'.esc_html($title_2).'</span></a></li>';
	echo '<li class="one-fourth"><a class="main-button" href="'.esc_url($link_3).'"><span>'.esc_html($title_3).'</span></a></li>';
	echo '<li class="one-fourth"><a class="main-button" href="'.esc_url($link_4).'"><span>'.esc_html($title_4).'</span></a></li>';
}


/**
 * Output an itinerary slideshow
 *
 * @param  string $itinerary [should be 'a' or 'b']
 * @return [type]            [description]
 */
function eco_itinerary_slideshow( $itinerary = 'a', $format = 'slider' ) {

	// TODO: If page path changes, change here!
	$page  = get_page_by_slug( 'itineraries' );

	if ( ! $page )
		return;

	$key    = '_eco_itinerary_'.$itinerary.'_slideshow';
	$id     = 'itinerary-'.$itinerary.'-slider';
	$output = '';

	// Check format
	if ( 'slider' == $format ) :
		// Slideshow
		if( $images = get_field( $key, $page->ID) ):
			$output .= '<div class="underscores_slider itinerary-slider" id="'.$id.'">';
				$output .= '<ul class="slides">';
					foreach ($images as $image) :
						$output .= '<li>';
							$output .= '<img src="' . $image['sizes']['large'] . '" alt="' . $image['title'] . '">';
						$output .= '</li>';
					endforeach;
				$output .= '</ul>';
			$output .= '</div>';
		endif;
	elseif ( 'gallery' == $format ) :
		// Gallery
		if( $image_ids = get_field( $key, $page->ID, false ) ):
			$shortcode = '
			[gallery link="file" columns="4" type="rectangular" ids="' . implode(',', $image_ids) . '"]
			';

			$output = do_shortcode( $shortcode );
		endif;
	endif;

	return $output;
}

function eco_tabbed_menu( $menu ) {
	global $post;

	$days = array( 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' );

	if ( empty( $menu ) )
		return;

	if ( empty( $post ) )
		return;

	echo '<div class="' . $menu . '-menu" id="' . $menu . '-menu">';

	// Get tab menu content
	$menus = array();
	foreach ( $days as $day ) {
		$menus[$menu.'_'.$day] = get_field( '_eco_'.$menu.'_menu_'.$day, $post->ID );
	}

	// Banner
	echo '<div class="menu-banner">';
		$banner = get_field( '_eco_'.$menu.'_menu_banner', $post->ID );
		if ( $banner ) {
			echo '<img src="'. $banner['url'] . '" width="' . $banner['width'] . '" height="' . $banner['height'] . '" alt="' . $banner['alt'] . '">';
		}
		echo '<h3><span>' . get_field( '_eco_'.$menu.'_menu_title', $post->ID ) . '</span></h3>';
	echo '</div>';

	// Tabs
	echo '<ul class="tabs cuisine-tabs '.$menu.'-menu-tabs">';
		foreach ( $days as $day ) {
			echo '<li><a class="'.$day.'" href="#'.$menu.'-'.$day.'">'.ucfirst($day).'</a></li>';
		}
	echo '</ul>';

	// Tab content
	foreach ( $days as $day ) {
		echo '<div class="tab-content '.$day.'" id="'.$menu.'-'.$day.'">';
			if ( $menus[$menu.'_'.$day] )
				echo $menus[$menu.'_'.$day];
		echo '</div>';
	}
	echo '</div>';
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
