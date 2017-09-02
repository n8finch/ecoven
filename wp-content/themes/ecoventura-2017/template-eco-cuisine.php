<?php

//* Template Name: Ecoventura Cuisine
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
	eco_cuisine_header_slider( $acf_fields);
	eco_cuisine_cookbook( $acf_fields);
	eco_cuisine_recipes( $acf_fields);

}

function eco_cuisine_header_slider( $acf_fields ) {
	?>
	<header class="cuisine-header">
		<h2><?php echo esc_html( get_the_title() ); ?></h2>
	</header>
	<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( $acf_fields["cuisine_slider"] ); } ?>
	<section class="cuisine-content">
		<?php echo wp_kses_post( $acf_fields['cuisine_content'] ); ?>

		<div class="cuisine-out-menus">

		</div>
	</section>

<?php
}

function eco_cuisine_cookbook( $acf_fields ) {
	?>
	<section class="our-cookbook">
		<div class="cookbook-wrapper">
			<div class="cookbook-image">
				<img src="<?php echo esc_attr( $acf_fields['cookbook_image'] ); ?>" />
			</div>
			<div class="cookbook-content">
				<h2><?php echo esc_html( $acf_fields['cookbook_title'] ); ?></h2>
				<?php echo wp_kses_post( $acf_fields['cookbook_content'] ); ?>
				<a href="<?php echo esc_url( $acf_fields['cookbook_button_link'] ); ?>">
					<button><?php echo esc_html( $acf_fields['cookbook_button_text'] ); ?></button>
				</a>
			</div>
		</div>
	</section>

<?php
}

function eco_cuisine_recipes ( $acf_fields ) {
?>
	<section class="our-recipes">
		<h2><?php echo esc_html( $acf_fields['cookbook_title'] ); ?></h2>
		<div class="recipes-wrapper">
			<div class="recipe-links">
				<?php
				$rows = $acf_fields['recipe_list'];
				foreach( $rows as $row ) {
					?>
					<div class="recipe-title"><?php echo esc_html( $row['recipe_title'] ); ?></div>
					<?php
				}
				?>
			</div>
			<div class="recipe-content">
				<?php
				$rows = $acf_fields['recipe_list'];
				foreach( $rows as $row ) {
					?>
					<div class="recipe-title"><?php echo wp_kses_post( $row['recipe_content'] ); ?></div>
					<?php
				}
				?>
			</div>
		</div>
	</section>
<?php
}

//* Run the Genesis loop
genesis();
