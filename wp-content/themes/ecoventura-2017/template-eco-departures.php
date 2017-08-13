<?php

//* Template Name: Ecoventura Departure
//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the default Genesis loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom homepage content
add_action( 'genesis_loop', 'eco_homepage_content' );

function eco_homepage_content() {

	global $post;
	$acf_fields = get_fields($post->ID);

	//* Add in the sections
	eco_departures_dates( $acf_fields, $depart_year );
	eco_departures_expedition( $acf_fields );
	eco_departures_faqs_terms_conditions( $acf_fields );

}

function eco_departures_dates( $acf_fields , $depart_year) {
	?>
	<section class="departures-dates">
		<div class="departure-dates-header">
			<h2><?php echo esc_html($acf_fields['date_field']); ?> Departure Dates</h2>
		</div>
		<div class="departure-dates-table-wrap">
			<div id="tabs">
				<ul>
					<li class="departure-table-tabs" data-tab="#tabs-1"><?php echo esc_html($acf_fields['date_field']); ?></li>
					<!-- <li class="departure-table-tabs" data-tab="#tabs-2">LETTY</li> -->
				</ul>

		 		<div class="departure-table-tab-content tab-open" id="tabs-1">
					<div class="pinned">
						<table class="departures-table">
							<tr>
								<th class="th-dates">CRUISE DATES</th>
							</tr>
							<?php
							$rows = $acf_fields['departure_table_values'];
							if ( $rows ) {
								$counter = 1;
								foreach ( $rows as $row ) {
									$row_color_var = $couter % 2;
									echo '<tr class="departure-table-row-' . esc_html($row_color_var) . '">';
									echo '<td class="td-departure-dates" data-th="CRUISE DATES">' . esc_html($row['cruise_dates']) . '</td>';
									echo '</tr>';
									$couter++;
								}
							}
							?>
						</table>
					</div> <!--end pinned class div -->

					<div class="scroll">
						<table class="departures-table scroll">
							<tr>
								<th class="th-dots">ITINERARY</th>
								<th class="th-dots">SEASONAL</th>
								<th class="th-dots">PEAK</th>
								<th class="th-dots">HOLIDAY</th>
								<th class="th-dots">FAMILY</th>
								<th>STATUS</th>
								<th colspan="2">PROMOTION</th>
								<th class="th-notes">NOTES</th>
							</tr>
							<?php

							function eco_get_dot_if_true( $dot_val ) {
								true === $dot_val ? $dot_val = '·' : $dot_val = '';
								return $dot_val;
							}

							function eco_promotion_button( $button_val ) {
								if( 'Sold Out' === $button_val ) {
									return '<a href="https://www.origingalapagos.com/" target="_blank"><button>INQUIRE FOR ORIGIN</button></a>';
								}

								if( 'Available' === $button_val ) {
									return '<a href="#" target="_blank"><button>INQUIRE</button></a>';
								}
							}

							$rows = $acf_fields['departure_table_values'];
							if ( $rows ) {
								$counter = 1;
								foreach ( $rows as $row ) {
									$row_color_var = $couter % 2;
									echo '<tr>';
									echo '<td data-th="ITINERARY">' . esc_html( $row['itinerary'] ) . '</td>';
									echo '<td class="td-dot" data-th="SEASONAL">' . esc_html( eco_get_dot_if_true( $row['seasonal'] ) ) . '</td>';
									echo '<td class="td-dot" data-th="PEAK">' . esc_html( eco_get_dot_if_true( $row['peak'] ) ) . '</td>';
									echo '<td class="td-dot" data-th="HOLIDAY">' . esc_html( eco_get_dot_if_true( $row['holiday'] ) ) . '</td>';
									echo '<td class="td-dot" data-th="FAMILY">' . esc_html( eco_get_dot_if_true( $row['family'] ) ) . '</td>';
									echo '<td data-th="STATUS">' . esc_html( $row['status'] ) . '</td>';
									echo '<td class="td-promotion" data-th="PROMOTION">' . esc_html( $row['promotion'] ) . '</td>';
									echo '<td class="td-inquire" data-th="PROMOTION">' . eco_promotion_button( $row['status'] ) . '</td>';
									echo '<td class="td-notes" data-th="NOTES">' . esc_html($row['notes']) . '</td>';
									echo '</tr>';
									$couter++;
								}
							}
							?>
						</table>
					</div> <!--end scroll class div -->
				</div> <!--end tab div -->
				<div class="departure-table-tab-content" id="tabs-2">
					<div class="pinned">
						<table class="departures-table">
							<tr>
								<th class="th-dates">CRUISE DATES</th>
							</tr>
							<tr>
							    <td data-th="CRUISE DATES">April 02-09</td>
							</tr>
							<tr>
							    <td data-th="CRUISE DATES">April 02-09</td>
							</tr>
							<tr>
							    <td data-th="CRUISE DATES">April 02-09</td>
							</tr>
							<tr>
							    <td data-th="CRUISE DATES">April 02-09</td>
							</tr>
							<tr>
							    <td data-th="CRUISE DATES">April 02-09</td>
							</tr>
							<tr>
							    <td data-th="CRUISE DATES">April 02-09</td>
							</tr>
						</table>
					</div> <!--end pinned class div -->

					<div class="scroll">
						<table class="departures-table scroll">
							<tr>
  							  <th class="th-dots">ITINERARY</th>
  							  <th class="th-dots">SEASONAL</th>
  							  <th class="th-dots">PEAK</th>
  							  <th class="th-dots">HOLIDAY</th>
  							  <th class="th-dots">FAMILY</th>
  							  <th>STATUS</th>
  							  <th colspan="2">PROMOTION</th>
  							  <th>NOTES</th>
  						  </tr>
  						  <tr>
  							  <td class="" data-th="ITINERARY">A</td>
  							  <td class="td-dot" data-th="SEASONAL">·</td>
  							  <td class="td-dot" data-th="PEAK"></td>
  							  <td class="td-dot" data-th="HOLIDAY">·</td>
  							  <td class="td-dot" data-th="FAMILY">·</td>
  							  <td data-th="STATUS">UNAVAILABLE</td>
  							  <td class="td-promotion"data-th="PROMOTION">$1,000 off</td>
  							  <td class="td-inquire" data-th="PROMOTION"><a href="https://www.origingalapagos.com/" target="_blank"><button>INQUIRE FOR ORIGIN</button></a></td>
  							  <td class="" data-th="NOTES">Lorum ipsum...</td>
  						  </tr>
  						  <tr>
  							  <td class="" data-th="ITINERARY">B</td>
  							  <td class="td-dot" data-th="SEASONAL">·</td>
  							  <td class="td-dot" data-th="PEAK"></td>
  							  <td class="td-dot" data-th="HOLIDAY">·</td>
  							  <td class="td-dot" data-th="FAMILY">·</td>
  							  <td data-th="STATUS">UNAVAILABLE</td>
  							  <td class="td-promotion"data-th="PROMOTION">$1,000 off</td>
  							  <td class="td-inquire" data-th="PROMOTION"><button>INQUIRE</button></td>
  							  <td class="" data-th="NOTES">Lorum ipsum...</td>
  						  </tr>
  						  <tr>
  							  <td class="" data-th="ITINERARY">B</td>
  							  <td class="td-dot" data-th="SEASONAL">·</td>
  							  <td class="td-dot" data-th="PEAK"></td>
  							  <td class="td-dot" data-th="HOLIDAY">·</td>
  							  <td class="td-dot" data-th="FAMILY">·</td>
  							  <td data-th="STATUS">UNAVAILABLE</td>
  							  <td class="td-promotion"data-th="PROMOTION">$1,000 off</td>
  							  <td class="td-inquire" data-th="PROMOTION"><button>INQUIRE</button></td>
  							  <td class="" data-th="NOTES">Lorum ipsum...</td>
  						  </tr>
  						  <tr>
  							  <td class="" data-th="ITINERARY">A</td>
  							  <td class="td-dot" data-th="SEASONAL">·</td>
  							  <td class="td-dot" data-th="PEAK"></td>
  							  <td class="td-dot" data-th="HOLIDAY">·</td>
  							  <td class="td-dot" data-th="FAMILY">·</td>
  							  <td data-th="STATUS">UNAVAILABLE</td>
  							  <td class="td-promotion"data-th="PROMOTION">$1,000 off</td>
  							  <td class="td-inquire" data-th="PROMOTION"><button>INQUIRE</button></td>
  							  <td class="" data-th="NOTES">Lorum ipsum...</td>
  						  </tr>
  						  <tr>
  							  <td class="" data-th="ITINERARY">B</td>
  							  <td class="td-dot" data-th="SEASONAL">·</td>
  							  <td class="td-dot" data-th="PEAK"></td>
  							  <td class="td-dot" data-th="HOLIDAY">·</td>
  							  <td class="td-dot" data-th="FAMILY">·</td>
  							  <td data-th="STATUS">UNAVAILABLE</td>
  							  <td class="td-promotion"data-th="PROMOTION">$1,000 off</td>
  							  <td class="td-inquire" data-th="PROMOTION"><button>INQUIRE</button></td>
  							  <td class="" data-th="NOTES">Lorum ipsum...</td>
  						  </tr>
  						  <tr>
  							  <td class="" data-th="ITINERARY">A</td>
  							  <td class="td-dot" data-th="SEASONAL">·</td>
  							  <td class="td-dot" data-th="PEAK"></td>
  							  <td class="td-dot" data-th="HOLIDAY">·</td>
  							  <td class="td-dot" data-th="FAMILY">·</td>
  							  <td data-th="STATUS">UNAVAILABLE</td>
  							  <td class="td-promotion"data-th="PROMOTION">$1,000 off</td>
  							  <td class="td-inquire" data-th="PROMOTION"><button>INQUIRE</button></td>
  							  <td class="" data-th="NOTES">Lorum ipsum...</td>
  						  </tr>
						</table>
					</div> <!--end scroll class div -->
				</div> <!--end tab div -->


		</div> <!-- end table wrap -->

		<div class="departure-view-iteneraries">
			<a href="#">
				<div id="view-itens">VIEW ITENERARIES</div>
				<div id="arrow-right"></div>
			</a>
			<a href="<?php echo esc_html($acf_fields[itinerary_a_link]);?>">
				<div id="arrow-from-right"></div>
				<div id="iten-a">ITENERARY A</div>
			</a>
			<a href="<?php echo esc_html($acf_fields[itinerary_b_link]);?>">
				<div id="iten-b">ITENERARY B</div>
			</a>
		</div>
	</section>
	<?php
}

function eco_departures_expedition( $acf_fields ) {
	?>
	<section class="departures-expedition">
		<div class="departure-title-div">
			<h2>READY FOR THE ULTIMATE EXPEDITION?</h2>
		</div>

		<!-- Add Plan Your Trip box -->
		<div class="book-now-box"><a href="#"><button>PLAN YOUR TRIP</button></a></div>

		<div class="departure-expedition-content-wrap">
			<!-- TODO For each content piece, ACF -->
			<div class="departure-expedition-content">
				<?php esc_html($acf_fields['editor']);?>
			</div>
		</div>
	</section>
	<?php
}

function eco_departures_faqs_terms_conditions( $acf_fields ) {
	?>
	<section class="departures-faqs-terms-conditions">
		<div class="departure-faq-image" style="background-image: url(http://ecoven.dev/wp-content/uploads/2017/07/Kicker-Rock-Sunset.jpg);" />
		</div>

		<div class="departure-terms-conditions">
			<div class="departure-term-condition">
				<h5>TERMS AND CONDITIONS</h5>
				<p><b>METHOD OF PAYMENT</b><br/>
					Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo. Curabitur eu tellus ut est porttitor varius ut eu tellus. Integer non eros non lorem laoreet tincidunt. Nam ac aliquet eros. Etiam ornare nisi erat, quis mollis elit pretium convallis. Cras gravida ante in eleifend efficitur. Vestibulum a rutrum arcu. Vivamus sodales ornare purus sed luctus.</p>
			</div>
			<div class="departure-term-condition">
				<h5>INDIVIDUAL BOOKINGS (1 - 5 PASSENGERS)</h5>
				<p><b>METHOD OF PAYMENT</b><br/>
					Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo. Curabitur eu tellus ut est porttitor varius ut eu tellus. Integer non eros non lorem laoreet tincidunt. Nam ac aliquet eros. Etiam ornare nisi erat, quis mollis elit pretium convallis. Cras gravida ante in eleifend efficitur. Vestibulum a rutrum arcu. Vivamus sodales ornare purus sed luctus.</p>
			</div>
			<div class="departure-term-condition">
				<h5>SMALL GROUP BOOKINGS (3 OR MORE EXCLUDING CHARTERS)</h5>
				<p><b>METHOD OF PAYMENT</b><br/>
					Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo. Curabitur eu tellus ut est porttitor varius ut eu tellus. Integer non eros non lorem laoreet tincidunt. Nam ac aliquet eros. Etiam ornare nisi erat, quis mollis elit pretium convallis. Cras gravida ante in eleifend efficitur. Vestibulum a rutrum arcu. Vivamus sodales ornare purus sed luctus.</p>
			</div>

		</div>
	</section>
	<?php
}

//* Run the Genesis loop
genesis();
