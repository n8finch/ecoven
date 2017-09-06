<?php

//* Template Name: Ecoventura Itinerary A/B
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
	eco_intinerary_a( $acf_fields);
	eco_intinerary_b( $acf_fields);

}

function eco_intinerary_a( $acf_fields ) {
	?>
	<header class="itinerary-header">
		<h2><?php echo esc_html( get_the_title() ); ?></h2>
	</header>
	<section class="itinerary-section">
		<img src="<?php echo esc_attr( $acf_fields['itinerary_a_image'] ); ?>" />
		<div class="view-iteneraries">
			<a href="#">
				<div id="view-itens">VIEW ITENERARIES</div>
				<div id="arrow-right"></div>
			</a>
			<a href="<?php echo esc_url( $acf_fields[ 'itinerary_a_link' ] );?>">
				<div id="arrow-from-right"></div>
				<div id="iten-a">ITENERARY A</div>
			</a>
		</div>
		<div class="itinerary-content">
			<?php echo wp_kses_post( $acf_fields['itinerary_a_content'] ); ?>
		</div>
		<div class="itinerary-highlights">
			<h2>HIGHLIGHTS</h2>
			<div class="highlight-boxes">
				<?php
				$rows = $acf_fields['itinerary_a_highlights'];
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
										<a href="<?php echo esc_url( $row['learn_more_button_link'] );?>"><button class="highlight-popup-button">LEARN MORE</button></a>
									</div>
								</div>
							</div>
						</div>
					<?php
					$counter++;
					} //end foreach
				} //end if ?>


			</div>
			<div class="book-now-box">
				<a href="<?php echo esc_url( $acf_fields[ 'itinerary_a_link' ] );?>">
					<button><?php echo esc_html( $acf_fields[ 'itinerary_a_button_text' ] );?></button>
				</a>
			</div>
		</div>
	</section>
	<?php
}

function eco_intinerary_b( $acf_fields ) {
	?>
	<section class="itinerary-section">
		<img src="<?php echo esc_attr( $acf_fields['itinerary_b_image'] ); ?>" />
		<div class="view-iteneraries">
			<a href="#">
				<div id="view-itens">VIEW ITENERARIES</div>
				<div id="arrow-right"></div>
			</a>
			<a href="<?php echo esc_url( $acf_fields[ 'itinerary_b_link' ] );?>">
				<div id="arrow-from-right-b"></div>
				<div id="iten-b">ITENERARY B</div>
			</a>
		</div>
		<div class="itinerary-content">
			<?php echo wp_kses_post( $acf_fields['itinerary_b_content'] ); ?>
		</div>
		<div class="itinerary-highlights">
			<h2>HIGHLIGHTS</h2>
			<div class="highlight-boxes">
				<?php
				$rows = $acf_fields['itinerary_b_highlights'];
				if($rows) {
					$counter = 1;
					foreach ( $rows as $row ) {
						$pop_id = 'iten-b-popup-' . $counter;
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
										<a href="<?php echo esc_url( $row['learn_more_button_link'] );?>"><button class="highlight-popup-button">LEARN MORE</button></a>
									</div>
								</div>
							</div>
						</div>
					<?php
					$counter++;
					} //end foreach
				} //end if ?>


			</div>
			<div class="book-now-box">
				<a href="<?php echo esc_url( $acf_fields[ 'itinerary_b_link' ] );?>">
					<button><?php echo esc_html( $acf_fields[ 'itinerary_b_button_text' ] );?></button>
				</a>
			</div>
		</div>
	</section>
	<?php
}

//* Run the Genesis loop
genesis();
