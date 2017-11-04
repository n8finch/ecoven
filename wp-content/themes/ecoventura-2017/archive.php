<?php

add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the default Genesis loop
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

genesis();
