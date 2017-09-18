<?php

add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the default Genesis loop
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );


// Add custom rates content
add_action( 'genesis_before_loop', 'eco_rates_content_header' );

function eco_rates_content_header() {
	?>
	<header class="content-header">
		<h2><?php echo esc_html( get_the_title() ); ?></h2>
	</header>
	<?php
}

genesis();
