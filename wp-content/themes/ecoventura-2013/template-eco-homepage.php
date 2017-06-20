<?php

//* Template Name: Ecoventura Home
//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the default Genesis loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom homepage content
add_action( 'genesis_loop', 'eco_homepage_content' );

function eco_homepage_content() {

	eco_homepage_above_fold();
	eco_homepage_page_image_boxes();
	eco_homepage_video();

}

function eco_homepage_above_fold() {
	//TODO get the slider ID
	//* Add Slider
	?>
	<section class="homepage-above-fold">
		<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '9619' ); } ?>


		<!-- Add title div -->

		<div class="homepage-title-div">
			<h2>EXPEDITION CRUISING IN THE GALLAPAGOS ISLANDS</h2>
		</div>

		<!-- Add Plan Your Trip box -->
		<div class="plan-your-trip-box"><span>PLAN YOUR TRIP</span></div>

	</section>
	<?php
}

function eco_homepage_page_image_boxes() {

	//TODO: replace image links

	?>
	<section class="homepage-page-image-boxes">

		<a href="#">
			<div class="homepage-page-image-box">
				<img src="http://via.placeholder.com/400x300" />
				<div>Rates & Terms</div>
			</div>
		</a>

		<a href="#">
			<div class="homepage-page-image-box">
				<img src="http://via.placeholder.com/400x300" />
				<div>Rates & Terms</div>
			</div>
		</a>

		<a href="#">
			<div class="homepage-page-image-box">
				<img src="http://via.placeholder.com/400x300" />
				<div>Rates & Terms</div>
			</div>
		</a>

		<a href="#">
			<div class="homepage-page-image-box">
				<img src="http://via.placeholder.com/400x300" />
				<div>Rates & Terms</div>
			</div>
		</a>

	</section>
	<?php
}

function eco_homepage_video() {
	//* Add homepage video
	//TODO replace witht the content embed
	?>
	<section class="homepage-video">
		<div>
			<iframe width="900" height="480" src="https://www.youtube.com/embed/j_7f3iisldM?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
		</div>
	</section>
	<?php
}

//* Run the Genesis loop
genesis();
