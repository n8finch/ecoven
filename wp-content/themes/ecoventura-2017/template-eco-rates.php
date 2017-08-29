<?php

//* Template Name: Ecoventura Rates
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
	eco_rates_dates( $acf_fields, $depart_year );
	eco_rates_expedition( $acf_fields );
	eco_rates_sub_content( $acf_fields );
	eco_rates_charter_rates( $acf_fields );
	eco_rates_popup( $acf_fields );

}

function eco_rates_dates( $acf_fields, $depart_year ) {
	?>
	<section class="rates-dates">
		<div class="rate-dates-header">
			<h2><?php echo esc_html( $acf_fields['date_field'] ); ?> Rates</h2>
		</div>
		<div class="rate-dates-table-wrap">
			<div id="tabs">
				<ul>
					<li class="rate-table-tabs"
					    data-tab="#tabs-1">M/Y ERIC & LETTY</li>
					<!-- <li class="rate-table-tabs" data-tab="#tabs-2">LETTY</li> -->
				</ul>

				<div class="rate-table-tab-content tab-open" id="tabs-1">
					<div class="pinned">
						<table class="rates-table">
							<tr>
								<th class="">DECK</th>
							</tr>
							<?php
							$rows = $acf_fields['rates_table_values'];
							if ( $rows ) {
								$counter = 0;
								foreach ( $rows as $row ) {
									$row_color_var = $counter % 2;
									echo '<tr class="rate-table-row-' . esc_html( $row_color_var ) . '">';
									echo '<td id="' . esc_html( $row['deck'] ) . '" class="td-rate-decks" data-th="DECK">' . esc_html( $row['deck'] ) . '</td>';
									echo '</tr>';
									$counter ++;
								}
							}
							?>
						</table>
					</div> <!--end pinned class div -->

					<div class="scroll">
						<table class="rates-table scroll">
							<tr>
								<th class="">DOUBLE</th>
								<th class="">TRIPLE</th>
								<th class="">SINGLE</th>
							</tr>

							<?php

							$rows = $acf_fields['rates_table_values'];
							if ( $rows ) {
								$counter = 0;
								foreach ( $rows as $row ) {
									$row_color_var = $couter % 2;
									echo '<tr class="rate-table-row-' . esc_html( $row_color_var ) . '">';
									echo '<td>' . esc_html( $row['double'] ) . '</td>';
									echo '<td>' . esc_html( $row['triple'] ) . '</td>';
									echo '<td>' . esc_html( $row['single'] ) . '</td>';
									echo '</tr>';
									$couter ++;
								}
							}
							?>
						</table>
					</div> <!--end scroll class div -->
				</div> <!--end tab div -->
			</div> <!-- end table wrap -->

	</section>
	<?php
}

function eco_rates_expedition( $acf_fields ) {
	?>
	<section class="rates-expedition">
		<div class="rate-title-div">
			<h2>READY FOR THE ULTIMATE EXPEDITION?</h2>
		</div>

		<!-- Add Plan Your Trip box -->
		<div class="book-now-box">
			<a href="<?php echo esc_url( $acf_fields[ 'book_now_link' ] );?>">
				<button>PLAN YOUR TRIP</button>
			</a>
		</div>

		<div class="rate-expedition-content-wrap">
			<div class="rate-expedition-content">
				<?php echo wp_kses_post( $acf_fields['rates_main_content'] ); ?>
			</div>
		</div>
	</section>
	<?php
}

function eco_rates_sub_content( $acf_fields ) {
	?>
	<section class="rates-sub-content">
		<div class="rate-main-image"
			 style="background-image: url(<?php echo esc_html( $acf_fields[ 'rates_main_image' ] ); ?>);"/>
		</div>
		<div class="rate-sub-content-wrap">
			<div class="rate-sub-content">
				<?php echo wp_kses_post( $acf_fields['rates_sub_content'] ); ?>
			</div>
			<div class="book-now-box">
				<a href="<?php echo esc_url( $acf_fields[ 'book_now_link' ] );?>">
					<button>PLAN YOUR TRIP</button>
				</a>
			</div>
		</div>
	</section>

	<?php
}


function eco_rates_charter_rates( $acf_fields ) {
	?>
	<section class="rates-charter-content">
		<div class="rates-charter-content-wrap">
			<h2>Charter Rates</h2>
			<div class="table-container">
				<div class="pinned">
					<table class="charter-rates-table">
						<tr>
							<th class="">SEASON</th>
						</tr>
						<?php
						$rows = $acf_fields['charter_rates_table'];
						if ( $rows ) {
							$counter = 0;
							foreach ( $rows as $row ) {
								$row_color_var = $counter % 2;
								echo '<tr class="rate-table-row-' . esc_html( $row_color_var ) . '">';
								echo '<td class="td-rate-decks" data-th="CRUISE DATES">' . esc_html( $row['season'] ) . '</td>';
								echo '</tr>';
								$counter ++;
							}
						}
						?>
					</table>
				</div> <!--end pinned class div -->

				<div class="scroll">
					<table class="charter-rates-table scroll">
						<tr>
							<th class="">2017 RATE</th>
							<th class="">2018 RATE</th>
						</tr>

						<?php

						$rows = $acf_fields['charter_rates_table'];
						if ( $rows ) {
							$counter = 0;
							foreach ( $rows as $row ) {
								$row_color_var = $couter % 2;
								echo '<tr class="rate-table-row-' . esc_html( $row_color_var ) . '">';
								echo '<td>' . esc_html( $row['2017_rate'] ) . '</td>';
								echo '<td>' . esc_html( $row['2018_rate'] ) . '</td>';
								echo '</tr>';
								$couter ++;
							}
						}
						?>
					</table>
				</div> <!--end scroll class div -->
			</div>

			<p><em><?php echo esc_html( $acf_fields['charter_below_table_text'] )?></em></p>

			<h2>Charter Terms</h2>


			<div class="rate-charter-terms">
				<?php echo wp_kses_post( $acf_fields['charter_terms'] ); ?>
			</div>
		</div>
	</section>

	<?php
}

function eco_rates_popup( $acf_fields ) {
	?>

	<?php

	$rows = $acf_fields['rates_table_values'];
	if ( $rows ) {
		foreach ( $rows as $row ) {

			$deck_id = strtolower( str_replace( ' ', '-', $row['deck'] ) );
			?>
			<div id="<?php echo esc_html( $deck_id ); ?>" visibility="hidden" class="rates-popup">
				<img src="<?php echo esc_attr( $row['deck_image'] );?>" />
				<p><?php echo esc_html( $row['deck_bullet_description'] ); ?></p>
			</div>
			<?php
		}
	}

}
//* Run the Genesis loop
genesis();
