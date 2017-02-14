<?php
/**
 * Affiliations Page
 *
 * Template Name: Affiliations
 */

// Force Content Sidebar layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_filter( 'body_class', 'eco_affiliations_body_class' );
// add classes to body based page template
function eco_affiliations_body_class( $classes ) {
	$classes[] = 'affiliations';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_affiliations_post_classes( $classes ) {
	$classes[] = 'affiliations-content';

	return $classes;
}
add_filter( 'post_class', 'eco_affiliations_post_classes' );

function eco_affiliations_layout() {
	global $post;
	?>
	<div class="affiliations-description">
		<?php the_content(); ?>
	</div>
	<div class="affiliations-wrap group">
		<?php
		if( get_field( '_eco_affiliations', $post->ID) ):
			while ( has_sub_field( '_eco_affiliations' ) ) {
				$title       = get_sub_field( 'title' );
				$image       = get_sub_field( 'image' );
				$link        = get_sub_field('link');
				$description = get_sub_field( 'description' );


				if ( $image ) {
					$img = wp_get_attachment_image( $image, 'partner-logo', false, array( 'class' => 'affiliation-logo') );
					if ( $link )
						$img = '<a href="'.esc_url($link).'">' . $img . '</a>';
				} else {
					$img = '&nbsp;';
				}



				echo '<div class="affiliation" id="' . sanitize_title( $title ) . '">';
					echo '<div class="first one-fourth">' . $img . '</div>';
					echo '<div class="three-fourths">';
						if ( $link ) {
							echo '<h3 class="affiliation-title"><a href="'.esc_url($link).'">' . $title . '</a></h3>';
						} else {
							echo '<h3 class="affiliation-title">' . $title . '</h3>';
						}
						echo '<div class="affiliation-description">' . $description . '</div>';
					echo '</div>';
				echo '</div>';
			}
		endif; ?>
	</div>
	<?php
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_affiliations_layout' );

genesis();
