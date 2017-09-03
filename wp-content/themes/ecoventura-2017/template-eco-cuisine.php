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

		<div class="cuisine-our-menus">
			<div class="menu-tabs">
				<div class="menu-tab" data-menu-tab-id="main_menu_day_and_menu">
					MAIN MENU
				</div>
				<div class="menu-tab" data-menu-tab-id="vegetarian_menu_day_and_menu">
					VEGETARIAN MENU
				</div>
				<div class="menu-tab" data-menu-tab-id="kids_menu_day_and_menu">
					KIDS MENU
				</div>
			</div>
			<?php
			$menu_tabs = array( 'main_menu_day_and_menu', 'vegetarian_menu_day_and_menu', 'kids_menu_day_and_menu');

			foreach( $menu_tabs as $tab ) {

				$rows = $acf_fields[$tab];
				?>
				<div id="<?php echo $tab; ?>" class="menu-wrapper">
				<?php
				if($rows) {
					//output the datys first
					?>
					<div class="menu-days-wrapper">
						<?php
						foreach( $rows as $row ) {
							?>
							<span data-menu-day-id="menu-for-<?php echo esc_html( $tab . $row['day'] ); ?>"><?php echo esc_html( $row['day'] ); ?></span>
							<?php
						}
						?>
					</div> <!-- end days wrapper -->
					<?php
					$menu_counter = 1;
					foreach( $rows as $row ) {
						?>
						<div id="menu-for-<?php echo esc_html( $tab . $row['day'] ); ?>" class="menu-items-wrapper menu-<?php echo $menu_counter ?>">
							<div class="menu-breakfast">
								<p><strong>BREAKFAST</strong></p>
								<?php echo wp_kses_post( $row['breakfast'] ); ?>
							</div>
							<div class="menu-lunch">
								<p><strong>LUNCH</strong></p>
								<?php echo wp_kses_post( $row['lunch'] ); ?>
							</div>
							<div class="menu-dinner">
								<p><strong>DINNER</strong></p>
								<?php echo wp_kses_post( $row['dinner'] ); ?>
							</div>
						</div>
						<?php
					$menu_counter++;
					}
				}
				?>
			</div> <!-- end menu div -->
				<?php
			}

			?>
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
				$title_counter = 1;
				foreach( $rows as $row ) {
					?>
					<div data-recipe-id="recipe-content-<?php echo $title_counter; ?>" class="recipe-title"><?php echo esc_html( $row['recipe_title'] ); ?></div>
					<?php
				$title_counter++;
				}
				?>
			</div>
			<div class="recipe-content">
				<?php
				$rows = $acf_fields['recipe_list'];
				$content_counter = 1;
				foreach( $rows as $row ) {
					?>
					<div id="recipe-content-<?php echo $content_counter; ?>" class="recipe-single"><?php echo wp_kses_post( $row['recipe_content'] ); ?></div>
					<?php
				$content_counter++;
				}
				?>
			</div>
		</div>
	</section>
<?php
}

//* Run the Genesis loop
genesis();
