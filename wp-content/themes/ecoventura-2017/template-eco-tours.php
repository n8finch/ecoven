<?php
/**
 * Template Name: Tours
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
	eco_tours_main( $acf_fields);
	eco_tours_list( $acf_fields);
	eco_tours_terms( $acf_fields);

}

function eco_tours_main( $acf_fields ) {
	?>
	<header class="tours-header">
		<h2><?php echo esc_html( get_the_title() ); ?></h2>
	</header>
	<img src="<?php echo esc_url( $acf_fields['tours_main_image'] ); ?>" />
	<section class="tours-main-content">
		<?php echo wp_kses_post( $acf_fields['tours_main_content'] ); ?>
	</section>


	<?php
}

function eco_tours_list( $acf_fields ) {
	?>
	<section class="tours-list-quito">
		<h2>Tours from Quito</h2>
		<?php

		$rows = $acf_fields['tours_from_quito'];
		foreach ( $rows as $row ) {
		?>
		<div class="tours-content">
			<div class="tour-image">
				<img src="<?php echo esc_attr( $row['image'] ); ?>" />
			</div>
			<h2><?php echo esc_html( $row['title'] ) ?></h2>
			<?php echo wp_kses_post( $row['content'] ); ?>
		</div>
		<?php } //end foreach ?>
	</section>

	<section class="tours-list-guayaquil">
		<h2>Tours from Guayaquil</h2>
		<?php

		$rows = $acf_fields['tours_from_guayaquil'];
		foreach ( $rows as $row ) {
		?>
		<div class="tours-content">
			<div class="tour-image">
				<img src="<?php echo esc_url( $row['image'] ); ?>" />
			</div>
			<h2><?php echo esc_html( $row['title'] ) ?></h2>
			<?php echo wp_kses_post( $row['content'] ); ?>
		</div>
		<?php } //end foreach ?>
	</section>


	<?php
}

function eco_tours_terms( $acf_fields ) {
	?>
	<section class="tours-main-content">
		<h2>Terms & Conditions</h2>
		<?php echo wp_kses_post( $acf_fields['terms_and_conditions'] ); ?>
	</section>
	<?php
}


//* Run the Genesis loop
genesis();
