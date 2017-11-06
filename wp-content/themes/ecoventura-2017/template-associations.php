<?php
/**
 * Trade Associations Page
 *
 * Template Name: Trade Associations
 */

// Force Content Sidebar layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_filter( 'body_class', 'eco_associations_body_class' );
// add classes to body based page template
function eco_associations_body_class( $classes ) {
	$classes[] = 'associations';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_associations_post_classes( $classes ) {
	$classes[] = 'associations-content';

	return $classes;
}
add_filter( 'post_class', 'eco_associations_post_classes' );

function eco_associations_layout() {
	global $post;
	?>
	<div class="associations-description">
		<?php the_content(); ?>
	</div>
	<div class="associations-wrap group">
		<?php
		if( get_field( '_eco_associations', $post->ID) ):
			while ( has_sub_field( '_eco_associations' ) ) {
				$title       = get_sub_field( 'title' );
				$image       = get_sub_field( 'image' );
				$description = get_sub_field( 'description' );
				$link        = get_sub_field( 'link' );

				if ( $image ) {
					$img = wp_get_attachment_image( $image, 'partner-logo', false, array( 'class' => 'association-logo') );
					if ( $link )
						$img = '<a href="'.esc_url($link).'">' . $img . '</a>';
				} else {
					$img = '&nbsp;';
				}


				echo '<div class="association" id="' . sanitize_title( $title ) . '">';
					echo '<div class="first one-fourth">' . $img . '</div>';
					echo '<div class="three-fourths">';
						if ( $link ) {
							echo '<h3 class="association-title"><a href="'.esc_url($link).'">' . $title . '</a></h3>';
						} else {
							echo '<h3 class="association-title">' . $title . '</h3>';
						}
						echo '<div class="association-description">' . $description . '</div>';
					echo '</div>';
				echo '</div>';
			}
		endif; ?>
	</div>

	<h2><?php the_field( '_eco_trade_shows_heading', $post->ID ); ?></h2>

	<?php
	if ( get_field( '_eco_trade_shows_content', $post->ID ) ) : ?>
	<div class="trade-shows-description">
		<?php the_field( '_eco_trade_shows_content', $post->ID ); ?>
	</div>
	<?php
	endif; ?>

	<div class="trade-shows-wrap group">
		<?php
		if( get_field( '_eco_trade_shows', $post->ID) ):
			while ( has_sub_field( '_eco_trade_shows' ) ) {
				$title       = get_sub_field( 'title' );
				$image       = get_sub_field( 'image' );
				$description = get_sub_field( 'description' );
				$link        = get_sub_field( 'link' );

				$img = wp_get_attachment_image( $image, 'partner-logo', false, array( 'class' => 'association-logo') );

				if ( $link )
					$img = '<a href="'.esc_url($link).'">' . $img . '</a>';

				echo '<div class="association" id="' . sanitize_title( $title ) . '">';
					echo '<div class="first one-fourth">' . $img . '</div>';
					echo '<div class="three-fourths">';
						if ( $link ) {
							echo '<h3 class="association-title"><a href="'.esc_url($link).'">' . $title . '</a></h3>';
						} else {
							echo '<h3 class="association-title">' . $title . '</h3>';
						}
						echo '<div class="association-description">' . $description . '</div>';
					echo '</div>';
				echo '</div>';
			}
		endif; ?>
	</div>

	<h2><?php the_field( '_eco_representation_heading', $post->ID ); ?></h2>

	<?php
	if ( get_field( '_eco_representation_content', $post->ID ) ) : ?>
	<div class="representations-description">
		<?php the_field( '_eco_representation_content', $post->ID ); ?>
	</div>
	<?php
	endif; ?>

	<div class="representations-wrap group">
		<?php
		if( get_field( '_eco_representations', $post->ID) ):
			while ( has_sub_field( '_eco_representations' ) ) {
				$title       = get_sub_field( 'title' );
				$image       = get_sub_field( 'image' );
				$description = get_sub_field( 'description' );
				$link        = get_sub_field( 'link' );

				$img = wp_get_attachment_image( $image, 'partner-logo', false, array( 'class' => 'association-logo') );

				if ( $link )
					$img = '<a href="'.esc_url($link).'">' . $img . '</a>';

				echo '<div class="association" id="' . sanitize_title( $title ) . '">';
					echo '<div class="first one-fourth">' . $img . '</div>';
					echo '<div class="three-fourths">';
						if ( $link ) {
							echo '<h3 class="association-title"><a href="'.esc_url($link).'">' . $title . '</a></h3>';
						} else {
							echo '<h3 class="association-title">' . $title . '</h3>';
						}
						echo '<div class="association-description">' . $description . '</div>';
					echo '</div>';
				echo '</div>';
			}
		endif; ?>
	</div>
	<?php
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_associations_layout' );

genesis();
