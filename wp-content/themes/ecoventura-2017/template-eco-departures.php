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
	eco_departures_dates( $acf_fields );
	eco_departures_expedition( $acf_fields );
	eco_departures_faqs_terms_conditions( $acf_fields );

}

function eco_departures_dates( $acf_fields ) {
	?>
	<section class="departures-dates">
		<div class="departure-dates-header">
			<h2>2017 Departure Dates</h2>
		</div>
		<div class="departure-dates-table-wrap">
			<table class="rwd-table">
			  <tr>
			    <th>Movie Title</th>
			    <th>Genre</th>
			    <th>Year</th>
			    <th>Gross</th>
			  </tr>
			  <tr>
			    <td data-th="Movie Title">Star Wars</td>
			    <td data-th="Genre">Adventure, Sci-fi</td>
			    <td data-th="Year">1977</td>
			    <td data-th="Gross">$460,935,665</td>
			  </tr>
			  <tr>
			    <td data-th="Movie Title">Howard The Duck</td>
			    <td data-th="Genre">"Comedy"</td>
			    <td data-th="Year">1986</td>
			    <td data-th="Gross">$16,295,774</td>
			  </tr>
			  <tr>
			    <td data-th="Movie Title">American Graffiti</td>
			    <td data-th="Genre">Comedy, Drama</td>
			    <td data-th="Year">1973</td>
			    <td data-th="Gross">$115,000,000</td>
			  </tr>
			</table>
		</div>

		<div class="departure-view-iteneraries">
			<a href="">
				<div id="view-itens">VIEW ITENERARIES</div>
				<div id="arrow-right"></div>
			</a>
			<a href="">
				<div id="arrow-from-right"></div>
				<div id="iten-a">ITENERARY A</div>
			</a>
			<a href="">
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
				<h3>FAMILY DEPARTURES</h3>
				<h5></h5>
				<p>Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo. Curabitur eu tellus ut est porttitor varius ut eu tellus. Integer non eros non lorem laoreet tincidunt. Nam ac aliquet eros. Etiam ornare nisi erat, quis mollis elit pretium convallis. Cras gravida ante in eleifend efficitur. Vestibulum a rutrum arcu. Vivamus sodales ornare purus sed luctus.</p>
			</div>
			<div class="departure-expedition-content">
				<h3>7 DAY / 6 NIGHT CRUISE OPTION</h3>
				<h5>SUNDAY TO SATURDAY</h5>
				<p>Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo. Curabitur eu tellus ut est porttitor varius ut eu tellus. Integer non eros non lorem laoreet tincidunt. Nam ac aliquet eros. Etiam ornare nisi erat, quis mollis elit pretium convallis. Cras gravida ante in eleifend efficitur. Vestibulum a rutrum arcu. Vivamus sodales ornare purus sed luctus.</p>
			</div>
		</div>
	</section>
	<?php
}

function eco_departures_faqs_terms_conditions( $acf_fields ) {
	?>
	<section class="departures-faqs-terms-conditions">
		<div>
			<img src="http://ecoven.dev/wp-content/uploads/2017/07/Kicker-Rock-Sunset.jpg" />
		</div>

		<div class="departure-faqs">
			<div class="departure-faq">
				<h3>TWO WEEK ITENERARY BACK TO BACK ON ERIC & LETTY</h3>
				<p>Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo.</p>
			</div>
			<div class="departure-faq">
				<h3>TWO WEEK COMBINATION ERIC & LETTY WITH GALAPAGOS SKY</h3>
				<p>Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo.</p>
			</div>
		</div>

		<div class="departure-terms-conditions">
			<div class="departure-term-condition">
				<h5>TWO WEEK COMBINATION ERIC & LETTY WITH GALAPAGOS SKY</h5>
				<p>Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo. Curabitur eu tellus ut est porttitor varius ut eu tellus. Integer non eros non lorem laoreet tincidunt. Nam ac aliquet eros. Etiam ornare nisi erat, quis mollis elit pretium convallis. Cras gravida ante in eleifend efficitur. Vestibulum a rutrum arcu. Vivamus sodales ornare purus sed luctus.</p>
			</div>
			<div class="departure-term-condition">
				<h5>TWO WEEK COMBINATION ERIC & LETTY WITH GALAPAGOS SKY</h5>
				<p>Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo. Curabitur eu tellus ut est porttitor varius ut eu tellus. Integer non eros non lorem laoreet tincidunt. Nam ac aliquet eros. Etiam ornare nisi erat, quis mollis elit pretium convallis. Cras gravida ante in eleifend efficitur. Vestibulum a rutrum arcu. Vivamus sodales ornare purus sed luctus.</p>
			</div>
			<div class="departure-term-condition">
				<h5>TWO WEEK COMBINATION ERIC & LETTY WITH GALAPAGOS SKY</h5>
				<p>Curabitur nec risus laoreet, suscipit augue non, suscipit metus. Maecenas pellentesque convallis est, at accumsan dui pretium sit amet. Quisque ultricies sapien a laoreet commodo. Curabitur eu tellus ut est porttitor varius ut eu tellus. Integer non eros non lorem laoreet tincidunt. Nam ac aliquet eros. Etiam ornare nisi erat, quis mollis elit pretium convallis. Cras gravida ante in eleifend efficitur. Vestibulum a rutrum arcu. Vivamus sodales ornare purus sed luctus.</p>
			</div>

		</div>
	</section>
	<?php
}

//* Run the Genesis loop
genesis();
