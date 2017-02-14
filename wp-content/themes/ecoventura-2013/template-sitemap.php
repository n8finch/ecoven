<?php
/**
 * Sitemap
 *
 * Template Name: Sitemap
 */

add_filter( 'body_class', 'eco_sitemap_body_class' );
// add classes to body based page template
function eco_sitemap_body_class( $classes ) {
	$classes[] = 'sitemap';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_sitemap_post_classes( $classes ) {
	$classes[] = 'sitemap-content';

	return $classes;
}
add_filter( 'post_class', 'eco_sitemap_post_classes' );

add_action( 'genesis_entry_content', 'eco_sitemap_content' );

function eco_sitemap_content() {
	get_template_part( 'inc/sitemap' );
}

genesis();
