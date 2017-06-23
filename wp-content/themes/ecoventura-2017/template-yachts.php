<?php
/**
 * Yachts Page
 *
 * Template Name: Yachts
 */

// Force Content Sidebar layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_filter( 'body_class', 'eco_yachts_body_class' );
// add classes to body based page template
function eco_yachts_body_class( $classes ) {
	$classes[] = 'yachts';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_yachts_post_classes( $classes ) {
	$classes[] = 'yachts-content';

	return $classes;
}
add_filter( 'post_class', 'eco_yachts_post_classes' );

function eco_yachts_layout() {
	global $post;
	?>
	<div class="yachts-description">
		<?php the_content(); ?>
	</div>
	<div class="yachts-menu-nav" id="deck-plans">
		<div class="yachts-menu-nav-header">
			<h3>Deck Plans</h3>
		</div>
		<ul class="main-button-nav tabs group">
			<li class="one-third first"><a class="main-button" href="#dolphin-deck-slideshow"><span>Dolphin Deck</span></a></li>
			<li class="one-third"><a class="main-button" href="#booby-deck-slideshow"><span>Booby Deck</span></a></li>
			<li class="one-third"><a class="main-button" href="#iguana-deck-slideshow"><span>Iguana Deck</span></a></li>
		</ul>
	</div>
	<div class="yachts-wrap group">
		<div class="tab-content dolphin-deck-slideshow" id="dolphin-deck-slideshow">
			<?php echo eco_yacht_slideshow( 'dolphin' ); ?>
		</div>
		<div class="tab-content booby-deck-slideshow" id="booby-deck-slideshow">
			<?php echo eco_yacht_slideshow( 'booby' ); ?>
		</div>
		<div class="tab-content iguana-deck-slideshow" id="iguana-deck-slideshow">
			<?php echo eco_yacht_slideshow( 'iguana' ); ?>
		</div>
		<div class="yachts-cabins-content">
			<?php the_field( '_eco_yachts_cabins_content', $post->ID ); ?>
		</div>
	</div>
	<?php
}
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_yachts_layout' );

genesis();
