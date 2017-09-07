<?php

//* Template Name: Ecoventura Itinerary Single
//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the default Genesis loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom rates content
add_action( 'genesis_loop', 'eco_rates_content' );

function eco_rates_content() {

	global $post;
	$acf_fields = get_fields( $post->ID );

	//* Add in the sections
	eco_intinerary_single( $acf_fields);
	eco_intinerary_single_highlights( $acf_fields);
	eco_intinerary_single_movie_faqs( $acf_fields);

}

function eco_intinerary_single( $acf_fields ) {
	?>
	<header class="itinerary-header">
		<h2><?php echo esc_html( get_the_title() ); ?></h2>
	</header>
	<section class="itinerary-section">
		<img src="<?php echo esc_attr( $acf_fields['itinerary_image'] ); ?>" />
		<div class="itinerary-content">
			<h2><?php echo esc_html( $acf_fields['itinerary_title'] ); ?></h2>
			<div class="itinerary-boxes">
				<?php
				$rows = $acf_fields['itinerary_agenda'];
				if($rows) {
					$counter = 1;
					foreach ( $rows as $row ) {
						$pop_id = 'itin-agenda-popup';
					?>
						<div class="itinerary-box">
							<h3 class="itinerary-day" data-popup-id="<?php echo esc_html( $pop_id ); ?>"><?php echo esc_html( $row['day'] ); ?></h3>
							<div class="itin-hr-blue"></div>
							<p class="itinerary-descritpion">
								<?php echo $row['day_bullet_points']; ?>
							</p>
							<div id="<?php echo esc_html( $pop_id ); ?>" visibility="hidden" class="itenerary-popup-image" style="background: url('<?php echo esc_attr( $acf_fields['itinerary_popup_image'] );?>'); background-size: cover;">

							</div>
						</div>
					<?php
					} //end foreach
				} //end if ?>


			</div> <!-- end #highlights-boxes -->
			<div class="itinerary-below-content">
				<?php echo wp_kses_post( $acf_fields['itinerary_bottom_text'] ); ?>
			</div>
		</div>
	</section>
	<?php
}

function eco_intinerary_single_highlights( $acf_fields ) {
	?>
	<section class="itinerary-expedition">
		<h2>ready for itineray a? check out the departure dates</h2>
		<div class="book-now-box">
			<a class="button" href="#" data-popup-id="view-dates-popup">VIEW DATES</a>
		</div>
		<div id="view-dates-popup" visibility="hidden" class="itenerary-popup-image" style="background: url('<?php echo esc_attr( $acf_fields['itinerary_cruise_route_popup'] );?>'); background-size: cover;">
	</section>
	<section id="itinerary-highlights">
		<div class="itinerary-highlights">
			<h2>HIGHLIGHTS</h2>
			<div class="highlight-boxes">
				<?php
				$rows = $acf_fields['itinerary_highlights'];
				if($rows) {
					$counter = 1;
					foreach ( $rows as $row ) {
						$pop_id = 'iten-a-popup-' . $counter;
					?>
						<div class="highlight-box">
							<div class="image-container" data-popup-id="<?php echo esc_html( $pop_id ); ?>">
								<img src="<?php echo esc_attr( $row['image'] ); ?>" data-popup-id="<?php echo esc_html( $pop_id ); ?>"/>
							</div>
							<div class="hr-blue"></div>
							<p class="image-subtitle"><?php echo wp_kses_post( $row['image_subtitle'] ); ?></p>

							<div id="<?php echo esc_html( $pop_id ); ?>" visibility="hidden" class="iteneraries-popup">
								<h2><?php echo wp_kses_post( $row['image_subtitle'] ); ?></h2>
								<div class="highlight-popup-flex">
									<div><?php echo wp_kses_post( $row['popup_facts'] ); ?></div>
									<div>
										<img src="<?php echo esc_attr( $row['popup_image'] );?>" />
									</div>
									<div>
										<a class="highlight-popup-button" href="<?php echo esc_url( $row['learn_more_button_link'] );?>">LEARN MORE</a>
									</div>
								</div>

							</div>
						</div>
					<?php
					$counter++;
					} //end foreach
				} //end if ?>


			</div> <!-- end #highlights-boxes -->

		</div>
	</section>
	<section id="itinerary-dropdowns">
		<div class="itinerary-terms-conditions">
			<?php
			$rows = $acf_fields['itinerary_dropdowns'];
			if( $rows ) {
				foreach ( $rows as $row ) {
					?>
					<div class="itinerary-term-condition eco_toggles">
						<h5><?php echo esc_html( $row['header'] );?></h5>
						<p class="itinerary-term-condition-subhead">
							<b><?php echo esc_html( $row['subheader'] );?></b>
						</p>
						<p>
							<?php echo wp_kses_post ( $row['content'] ); ?>
						</p>

					</div>	<?php
				}
				?>
			<?php } //end if( $rows ) ?>
		</div>
	</section>


	<?php
}

function eco_intinerary_single_movie_faqs( $acf_fields ) {
	?>
	<section id="itinerary-movie">
		<div>
			<video width="100%" autoplay muted>
			  <source src="<?php echo esc_attr( $acf_fields['itinerary_movie_url'] ); ?>" type="video/mp4">
			  <source src="<?php echo esc_attr( $acf_fields['itinerary_movie_url'] ); ?>" type="video/ogg">
			Your browser does not support the video tag.
			</video>
		</div>
	</section>
	<section id="itinerary-faqs">
		<div class="itinerary-terms-conditions">
			<?php
			$rows = $acf_fields['itinerary_stipulations_dropdowns'];
			if( $rows ) {
				foreach ( $rows as $row ) {
					?>
					<div class="itinerary-term-condition eco_toggles">
						<h5><?php echo esc_html( $row['header'] );?></h5>
						<p class="itinerary-term-condition-subhead">
							<b><?php echo esc_html( $row['subheader'] );?></b>
						</p>
						<p>
							<?php echo wp_kses_post ( $row['content'] ); ?>
						</p>

					</div>	<?php
				}
				?>
			<?php } //end if( $rows ) ?>
		</div>
	</section>


	<?php
}

//* Run the Genesis loop
genesis();
