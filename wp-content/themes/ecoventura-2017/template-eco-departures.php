<?php
/**
 * Template Name: Departures
 */

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the default Genesis loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom departues content
add_action( 'genesis_loop', 'eco_departures_content' );

function eco_departures_content() {

	global $post;
	$acf_fields = get_fields( $post->ID );

	//* Add in the sections
	eco_departures_dates( $acf_fields );
	eco_departures_expedition( $acf_fields );
	eco_departures_faqs_terms_conditions( $acf_fields );

}

function eco_departures_dates( $acf_fields ) {
	?>
	<section class="departures-dates">
		<div class="departure-dates-header">
			<h2><?php echo esc_html( $acf_fields['date_field'] ); ?> Departure Dates</h2>
		</div>
		<div class="departure-dates-table-wrap">
			<div id="tabs">
				<ul>
					<li class="departure-table-tabs"
					    data-tab="#tabs-1"><?php echo esc_html( $acf_fields['date_field'] ); ?></li>
					<?php if ( ! empty( $acf_fields['next_year_date'] ) ) : ?>
						<li class="departure-table-tabs"><a href="<?php echo esc_url( $acf_fields['next_year_date_link'] ); ?>"><?php echo esc_html( $acf_fields['next_year_date'] ); ?></a></li>
					<?php endif; ?>
				</ul>

				<div class="departure-table-tab-content tab-open" id="tabs-1">
					<div class="pinned">
						<table class="departures-table">
							<tr>
								<th class="th-dates">Cruise Dates</th>
							</tr>
							<?php
							$rows = $acf_fields['departure_table_values'];
							if ( $rows ) {
								$counter = 0;
								foreach ( $rows as $row ) {
									$row_color_var = $counter % 2;
									echo '<tr class="departure-table-row-' . esc_html( $row_color_var ) . '">';
									echo '<td class="td-departure-dates" data-th="CRUISE DATES">' . esc_html( $row['cruise_dates'] ) . '</td>';
									echo '</tr>';
									$counter ++;
								}
							}
							?>
						</table>
					</div> <!--end pinned class div -->

					<div class="scroll">
						<table class="departures-table scroll">
							<tr>
								<th class="th-dots">Itinerary</th>
								<th class="th-dots">Seasonal</th>
								<th class="th-dots">Peak</th>
								<th class="th-dots">Holiday</th>
								<th class="th-dots">Specialty</th>
								<th>Status</th>
								<th colspan="2">Promotion</th>
								<th class="th-notes">Notes</th>
							</tr>
							<?php

							function eco_get_dot_if_true( $dot_val ) {
								true === $dot_val ? $dot_val = '·' : $dot_val = '';

								return $dot_val;
							}

							function eco_promotion_button( $button_val ) {
								if ( 'Sold Out' === $button_val ) {
									return '<a class="button" href="https://www.origingalapagos.com/" target="_blank">Inquire for Origin</a>';
								}

								if ( 'Available' === $button_val ) {
									return '<a class="button" href="' . esc_url( home_url( '/book-now/' ) ) . '" target="_blank">Inquire</a>';
								}
							}

							$rows = $acf_fields['departure_table_values'];
							if ( $rows ) {
								$counter = 0;
								foreach ( $rows as $row ) {
									$row_color_var = $counter % 2;
									echo '<tr class="departure-table-row-' . esc_attr( $row_color_var ) . '">';
									echo '<td data-th="Itinerary">' . esc_html( $row['itinerary'] ) . '</td>';
									echo '<td class="td-dot" data-th="Seasonal">' . esc_html( eco_get_dot_if_true( $row['seasonal'] ) ) . '</td>';
									echo '<td class="td-dot" data-th="Peak">' . esc_html( eco_get_dot_if_true( $row['peak'] ) ) . '</td>';
									echo '<td class="td-dot" data-th="Holiday">' . esc_html( eco_get_dot_if_true( $row['holiday'] ) ) . '</td>';
									echo '<td class="td-specialty" data-th="Specialty">' . esc_html( $row['specialty'] ) . '</td>';
									echo '<td data-th="STATUS">' . esc_html( $row['status'] ) . '</td>';
									echo '<td class="td-promotion" data-th="Promotion">' . esc_html( $row['promotion'] ) . '</td>';
									echo '<td class="td-inquire" data-th="Promotion">' . eco_promotion_button( $row['status'] ) . '</td>';
									echo '<td class="td-notes" data-th="Notes">' . esc_html( $row['notes'] ) . '</td>';
									echo '</tr>';
									$counter++;
								}
							}
							?>
						</table>
					</div> <!--end scroll class div -->
				</div> <!--end tab div -->
			</div> <!-- end table wrap -->

			<div class="departure-view-iteneraries">
				<a href="#">
					<div id="view-itens">View Itineraries</div>
					<div id="arrow-right"></div>
				</a>
				<a href="<?php echo esc_url( $acf_fields[ 'itinerary_a_link' ] ); ?>">
					<div id="arrow-from-right"></div>
					<div id="iten-a">Itinerary A</div>
				</a>
				<a href="<?php echo esc_url( $acf_fields[ 'itinerary_b_link' ] ); ?>">
					<div id="iten-b">Itinerary B</div>
				</a>
			</div>
	</section>
	<?php
}

function eco_departures_expedition( $acf_fields ) {
	?>
	<section class="departures-expedition">
		<div class="departure-title-div">
			<h2>Ready for the Ultimate Expedition?</h2>
		</div>

		<!-- Add Plan Your Trip box -->
		<div class="book-now-box">
			<a class="button" href="<?php echo esc_url( $acf_fields[ 'book_now_link' ] );?>">Plan Your Trip</a>
		</div>

		<div class="departure-expedition-content-wrap">
			<div class="departure-expedition-content">
				<?php echo wp_kses_post( $acf_fields['editor'] ); ?>
			</div>
		</div>
	</section>
	<?php
}

function eco_departures_faqs_terms_conditions( $acf_fields ) {
	?>
	<section class="departures-faqs-terms-conditions">
		<div class="departure-faq-image"
		     style="background-image: url(<?php echo esc_url($acf_fields['departure_image']); ?>);"/>
		</div>

		<div class="departure-terms-conditions">
			<?php
			$rows = $acf_fields['terms_and_conditions_boxes'];
			if( $rows ) {
				foreach ( $rows as $row ) {
					?>
					<div class="departure-term-condition eco_toggles">
						<h5><?php echo esc_html( $row['header'] );?></h5>
						<p class="departure-term-condition-subhead">
							<b><?php echo esc_html( $row['subheader'] );?></b>
							<br/>
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
