<?php
/**
 * Suggested Reading Page
 *
 * Template Name: Suggested Reading
 */

// Force full width content layout
// add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', 'eco_reading_body_class' );
// add classes to body based page template
function eco_reading_body_class( $classes ) {
	$classes[] = 'suggested-reading';
	return $classes;
}

/**
 * Page Content Class
 *
 * @since 1.0.0
 * @param array $classes
 * @return array
 */
function eco_reading_post_classes( $classes ) {
	$classes[] = 'suggested-reading-content';

	return $classes;
}
add_filter( 'post_class', 'eco_reading_post_classes' );


function eco_suggested_reading() {
	global $post;

	// Books
	// echo '<h2>Books</h2>';

	if ( get_field( '_eco_book_cats' ) ) {
		echo '<div class="group books">';
		while( has_sub_field( '_eco_book_cats' ) ) {
			echo '<h3 class="section-title">' . get_sub_field( '_eco_book_section_title' ) . '</h3>';
			// Check for books
			if ( get_sub_field( '_eco_books' ) ) {
				echo '<div class="section-content">';
				while ( has_sub_field( '_eco_books' ) ) {
					echo '<div class="book group">';
						$img_id = get_sub_field('cover_image');
						$title  = get_sub_field('title');
						$desc   = get_sub_field('description');
						$link   = get_sub_field('link');
						$author = get_sub_field('author');

						if ( $img_id ) {
							$img = wp_get_attachment_image( $img_id, 'book-cover', false, array( 'class' => 'book-cover') );

							if ( $link )
								$img = '<a href="'.esc_url($link).'">' . $img . '</a>';
						} else {
							$img = '&nbsp;';
						}

						echo '<div class="first one-fourth">' . $img . '</div>';
						echo '<div class="three-fourths">';
							if ( $title ) {
								if ( $link ) {
									echo '<h4 class="book-title"><a href="'.esc_url($link).'">' . $title . '</a></h4>';
								} else {
									echo '<h4 class="book-title">' . $title . '</h4>';
								}
							}
							if ( $author ) {
								echo '<div class="book-author">' . $author . '</div>';
							}
							echo '<p class="book-description">' . $desc . '</p>';
						echo '</div>';
					echo '</div>';
				} // has_sub_field( '_eco_books' )
				echo '</div>'; // .section-content
			} // get_sub_field( '_eco_books' )

		} // has_sub_field( '_eco_book_cats' )
		echo '</div>'; // .group.books
	} // get_field( '_eco_book_cats' )

}
add_action( 'genesis_entry_content', 'eco_suggested_reading' );

genesis();
