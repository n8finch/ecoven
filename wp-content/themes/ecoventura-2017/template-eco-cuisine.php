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

		<div class="cuisine-our-menus tabs">
			<div class="menu-tabs tab-control">
				<ul class="tab-list">
					<li class="menu-tab tab-item">
						<a href="#main_menu_day_and_menu">
							Main Menu
						</a>
					</li>
					<li class="menu-tab tab-item">
						<a href="#vegetarian_menu_day_and_menu">
							Vegetarian Menu
						</a>
					</li>
					<li class="menu-tab tab-item">
						<a href="#kids_menu_day_and_menu">
							Kids Menu
						</a>
					</li>
				</ul> <!-- tab-list -->
			</div><!-- tab-control -->
			<div class="tab-group">
				<?php
				$menu_tabs = array( 'main_menu_day_and_menu', 'vegetarian_menu_day_and_menu', 'kids_menu_day_and_menu');

				foreach( $menu_tabs as $tab ) {

					$rows = $acf_fields[$tab];
					?>
					<div id="<?php echo esc_attr( $tab ) ; ?>" class="menu-wrapper tab-content tabs">
					<?php
					if($rows) {
						//output the days first
						?>
						<div class="menu-days-wrapper tab-control">
							<ul class="tab-list">
								<?php
								foreach( $rows as $row ) {
									?>
									<li class="tab-item">
										<a href="<?php echo esc_url( '#menu-for-' . $tab . $row['day'] ); ?>">
											<?php echo esc_html( $row['day'] ); ?>
										</a>
									</li>
									<?php
								}
								?>
							</ul>
						</div> <!-- end days wrapper, tab-control -->
						<div class="tab-group">
							<?php
							$menu_counter = 1;
							foreach( $rows as $row ) {
								?>
								<div id="menu-for-<?php echo esc_html( $tab . $row['day'] ); ?>" class="menu-items-wrapper tab-content menu-<?php echo absint ( $menu_counter ); ?>">
									<div class="menu-breakfast">
										<p class="meal-heading"><strong>Breakfast</strong></p>
										<?php echo wp_kses_post( $row['breakfast'] ); ?>
									</div>
									<div class="menu-lunch">
										<p class="meal-heading"><strong>Lunch</strong></p>
										<?php echo wp_kses_post( $row['lunch'] ); ?>
									</div>
									<div class="menu-dinner">
										<p class="meal-heading"><strong>Dinner</strong></p>
										<?php echo wp_kses_post( $row['dinner'] ); ?>
									</div>
								</div>
								<?php
							$menu_counter++;
						} //  ?>
						</div> <!--end tab-group-->
						<?php
					} // end
					?>
				</div> <!-- end menu div -->
					<?php
				}
				?>
			</div> <!-- tab group menus -->
		</div> <!-- tabs -->
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
				<a class="button" href="<?php echo esc_url( $acf_fields['cookbook_button_link'] ); ?>">
					<?php echo esc_html( $acf_fields['cookbook_button_text'] ); ?>
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
		<div class="recipes-wrapper tabs">
			<div class="recipe-links tab-control">
				<ul class="tab-list">
					<?php
					$rows = $acf_fields['recipe_list'];
					$title_counter = 1;
					foreach( $rows as $row ) {
						?>
						<li class="recipe-title tab-item">
							<a href="<?php echo esc_url ( '#recipe-tab' . absint ( $title_counter ) ); ?>">
								<?php echo esc_html( $row['recipe_title'] ); ?>
							</a>
						</li>
						<?php
					$title_counter++;
					}
					?>
				</ul>
			</div> <!-- tab-control -->
			<div class="recipe-content tab-group">
				<?php
				$rows = $acf_fields['recipe_list'];
				$content_counter = 1;
				foreach( $rows as $row ) {
					?>
					<div id="recipe-tab<?php echo $content_counter; ?>" class="recipe-single tab-content"><?php echo wp_kses_post( $row['recipe_content'] ); ?></div>
					<?php
				$content_counter++;
				}
				?>
			</div> <!-- .tab-group -->
		</div> <!-- tabs -->
	</section>
<?php
}

//* Run the Genesis loop
genesis();
