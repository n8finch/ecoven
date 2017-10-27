<?php
/**
 * Template Name: Hotels
 */

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

	<img src="<?php echo esc_url( $acf_fields['hotels_main_image'] ); ?>" />


	<section class="hotels">

		<div class="tabs">
			<div class="tab-control">
				<ul class="tab-list">
					<li class="tab-item"><a href="#js-tab1">Hotels in Guayaquil</a></li>
					<li class="tab-item"><a href="#js-tab2">Hotels in Quito (City)</a></li>
					<li class="tab-item"><a href="#js-tab3">Hotels in Quito (Airport)</a></li>
				</ul>
			</div><!-- //.tab-control -->

			<div class="tab-group">

				<?php
				$hotel_tabs = array( 'hotels_in_guayaquil', 'hotels_in_quito_city', 'hotels_in_quito_airport');

				$tab_counter = 1;

				foreach( $hotel_tabs as $tab ) {
					$rows = $acf_fields[$tab];
					?>
					<div id="<?php echo 'js-tab' . absint ( $tab_counter ); ?>" class="tab-content">
						<?php
						if($rows) {
							$hotel_counter = 1;
							foreach( $rows as $row ) {
								?>
								<div id="hotel-for-<?php echo esc_attr( $tab . $row['name'] ); ?>" class="hotel-items-wrapper hotel-<?php echo absint( $hotel_counter ) ?>">
									<div class="hotel-image">
										<img src="<?php echo esc_url( $row['image'] ); ?>" />
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
					</div> <!-- end .tab-content div -->
					<?php
					$tab_counter++;
				}
				?>


			</div><!-- //.tab-group -->

		</div><!-- //.tabs -->

	</section>
<?php
}


//* Run the Genesis loop
genesis();
