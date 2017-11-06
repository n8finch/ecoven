<?php
/**
 * Downloads Page
 *
 * Template Name: Downloads
 */

// Force Content Sidebar layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_filter( 'body_class', 'eco_downloads_body_class' );
// add classes to body based page template
function eco_downloads_body_class( $classes ) {
	$classes[] = 'downloads';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_downloads_post_classes( $classes ) {
	$classes[] = 'downloads-content';

	return $classes;
}
add_filter( 'post_class', 'eco_downloads_post_classes' );

function eco_downloads_layout() {
	global $post;
	?>
	<div class="downloads-description">
		<?php the_content(); ?>
	</div>
	<div class="downloads-wrap group">
		<?php
		if( get_field( '_eco_downloads', $post->ID) ):
			while ( has_sub_field( '_eco_downloads' ) ) {
				$title       = get_sub_field( 'title' );
				$image       = get_sub_field( 'image' );
				$description = get_sub_field( 'description' );
				$link        = get_sub_field( 'link' );


				if ( $image ) {
					$img = wp_get_attachment_image( $image, 'partner-logo', false, array( 'class' => 'download-image') );
					if ( $link )
						$img = '<a href="'.esc_url($link).'">' . $img . '</a>';
				} else {
					$img = '&nbsp;';
				}


				echo '<div class="download" id="' . sanitize_title( $title ) . '">';
					echo '<div class="first one-fourth">' . $img . '</div>';
					echo '<div class="three-fourths">';
						if ( $link ) {
							echo '<h3 class="download-title"><a href="'.esc_url($link).'">' . $title . '</a></h3>';
						} else {
							echo '<h3 class="download-title">' . $title . '</h3>';
						}
						echo '<div class="download-description">' . $description . '</div>';
					echo '</div>';
				echo '</div>';
			}
		endif; ?>
	</div>
	<?php
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_downloads_layout' );

genesis();
