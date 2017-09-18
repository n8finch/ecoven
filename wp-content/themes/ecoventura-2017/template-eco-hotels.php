<?php

//* Template Name: Ecoventura Hotels
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
	eco_hotels_main( $acf_fields);

}

function eco_hotels_main( $acf_fields ) {
	?>
	<header class="hotels-header">
		<h2><?php echo esc_html( get_the_title() ); ?></h2>
	</header>
	<section class="hotels-content">
		<?php echo wp_kses_post( $acf_fields['hotels_main_content'] ); ?>
		<div class="hotels-learn-more-button">
			<a class="button" href="<?php echo esc_url( $acf_fields['hotels_main_button_link'] ); ?>">
				<?php echo esc_html( $acf_fields['hotels_main_button_text'] ); ?>
			</a>
		</div>
	</section>

	<img src="<?php echo esc_attr( $acf_fields['hotels_main_image'] ); ?>" />


	<section class="hotels">
		<div class="hotel-tabs">
			<div class="hotel-tab" data-hotel-tab-id="hotels_in_guayaquil">
				Hotels in Guayaquil
			</div>
			<div class="hotel-tab" data-hotel-tab-id="hotels_in_quito_city">
				Hotels in Quito (City)
			</div>
			<div class="hotel-tab" data-hotel-tab-id="hotels_in_quito_airport">
				Hotels in Quito (Airport)
			</div>
		</div>
		<?php
		$hotel_tabs = array( 'hotels_in_guayaquil', 'hotels_in_quito_city', 'hotels_in_quito_airport');

		foreach( $hotel_tabs as $tab ) {

			$rows = $acf_fields[$tab];
			?>
			<div id="<?php echo $tab; ?>" class="hotel-wrapper">
			<?php
			if($rows) {
				$hotel_counter = 1;
				foreach( $rows as $row ) {
					?>
					<div id="hotel-for-<?php echo esc_html( $tab . $row['name'] ); ?>" class="hotel-items-wrapper hotel-<?php echo $hotel_counter ?>">
						<div class="hotel-image">
							<img src="<?php echo esc_attr( $row['image'] ); ?>" />
						</div>
						<div class="hotel-content">
							<h2><?php echo esc_html( $row['name'] ); ?></h2>
							<?php echo wp_kses_post( $row['description'] ); ?>
						</div>
					</div>
					<?php
				$hotel_counter++;
				}
			}
			?>
		</div> <!-- end hotel div -->
			<?php
		}

		?>
	</section>
<?php
}


//* Run the Genesis loop
genesis();
