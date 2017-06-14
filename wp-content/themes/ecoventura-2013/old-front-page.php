<?php
/**
 * Front page template
 */

// Remove page title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );


// Add slider
function eco_add_slider() {
	if ( ! function_exists( 'underscores_slider' ) )
		return;

	underscores_slider(
		array(
			'slider_type'   => 'slides',
			'autoslide'     => true,
			'direction_nav' => false,
			),
		array(
			'slide_page'    => 'home-slider',
			)
	);
}
add_action( 'genesis_after_header', 'eco_add_slider' );

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'eco_front_page_content' );

function eco_front_page_content() {
	?>
	<ul class="main-button-nav group">
		<?php eco_build_home_nav(); ?>
	</ul>
	<hr class="divider">
	<div class="entry home-content">
		<?php the_content(); ?>
	</div>
	<div class="home-media-reviews">
		<div class="one-half first">
			<hr class="divider">
			<h2>In the <span>Media</span></h2>
			<ul class="front-in-the-media">
				<?php eco_front_press_items(); ?>
			</ul>
			<a class="in-the-media-more" href="/in-the-media/">Read More</a>
		</div>
		<div class="one-half">
			<hr class="divider">
			<h2>Guest <span>Reviews</span></h2>
			<?php eco_front_reviews(); ?>
		</div>
	</div>
	<?php
}

genesis();
