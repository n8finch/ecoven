<?php
/**
 * Awards & Accolades Page
 *
 * Template Name: Awards & Accolades
 */

// Force Content Sidebar layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_filter( 'body_class', 'eco_awards_body_class' );
// add classes to body based page template
function eco_awards_body_class( $classes ) {
	$classes[] = 'awards';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_awards_post_classes( $classes ) {
	$classes[] = 'awards-content';

	return $classes;
}
add_filter( 'post_class', 'eco_awards_post_classes' );

function eco_awards_layout() {
	global $post;
	?>
	<div class="awards-description">
		<?php the_content(); ?>
	</div>
	<div class="awards-wrap group">
		<?php
		if( get_field( '_eco_awards', $post->ID) ):
			while ( has_sub_field( '_eco_awards' ) ) {
				$title       = get_sub_field( 'title' );
				$image       = get_sub_field( 'image' );
				$description = get_sub_field( 'description' );


				if ( $image ) {
					$img = wp_get_attachment_image( $image, 'partner-logo', false, array( 'class' => 'award-logo') );
				} else {
					$img = '&nbsp;';
				}

				echo '<div class="award" id="' . sanitize_title( $title ) . '">';
					echo '<div class="first one-fourth">' . $img . '</div>';
					echo '<div class="three-fourths">';
						echo '<h3>' . $title . '</h3>';
						echo '<div class="award-description">' . $description . '</div>';
					echo '</div>';
				echo '</div>';
			}
		endif; ?>
	</div>
	<?php
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_awards_layout' );

genesis();
