<?php
/**
 * Our Cuisine Page
 *
 * Template Name: Our Cuisine
 */

// Force Content Sidebar layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_filter( 'body_class', 'eco_cuisine_body_class' );
// add classes to body based page template
function eco_cuisine_body_class( $classes ) {
	$classes[] = 'our-cuisine';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_cuisine_post_classes( $classes ) {
	$classes[] = 'cuisine-content';

	return $classes;
}
add_filter( 'post_class', 'eco_cuisine_post_classes' );

function eco_cuisine_layout() {
	global $post;
	?>
	<div class="cuisine-wrap group">
		<div class="cuisine-slideshow">
			<?php
			$output = '';
			if( $images = get_field( '_eco_cuisine_gallery', $post->ID) ):
				$output .= '<div class="underscores_slider cuisine-slider" id="cuisine-slider">';
					$output .= '<ul class="slides">';
						foreach ($images as $image) :
							$output .= '<li>';
								$output .= '<img src="' . $image['sizes']['cuisine-gallery'] . '" alt="' . $image['title'] . '">';
								$output .= '<div class="slide-caption">' . $image['caption'] . '</div>';
							$output .= '</li>';
						endforeach;
					$output .= '</ul>';
				$output .= '</div>';
				echo $output;
			endif; ?>
		</div>
	</div>
	<div class="cuisine-description">
		<?php the_content(); ?>
	</div>
	<div class="cuisine-menu-nav">
		<div class="cuisine-menu-nav-header">
			<h3>Our Menu Options</h3>
		</div>
		<ul class="main-button-nav group">
			<li class="one-third first"><a class="main-button" href="#main-menu"><span><?php the_field( '_eco_main_menu_title', $post->ID ); ?></span></a></li>
			<li class="one-third"><a class="main-button" href="#vegetarian-menu"><span><?php the_field( '_eco_vegetarian_menu_title', $post->ID ); ?></span></a></li>
			<li class="one-third"><a class="main-button" href="#kids-menu"><span><?php the_field( '_eco_kids_menu_title', $post->ID ); ?></span></a></li>
		</ul>
		<hr class="divider">
	</div>
	<div class="cuisine-menus">
		<?php eco_tabbed_menu( 'main' ); ?>
		<?php eco_tabbed_menu( 'vegetarian' ); ?>
		<?php eco_tabbed_menu( 'kids' ); ?>
	</div>
	<?php
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_cuisine_layout' );

genesis();
