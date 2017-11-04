<div class="sitemap-list">
	<h2 id="pages">Pages</h2>
	<ul>
		<?php
		// Add pages you'd like to exclude in the exclude here
		wp_list_pages(
			array(
				'exclude' => '20,771',
				'title_li' => '',
			)
		);
		?>
	</ul>

	<h2 id="posts">Posts</h2>
	<ul>
		<?php
		// Add categories you'd like to exclude in the exclude here
		$cats = get_categories('exclude=');
		foreach ($cats as $cat) {
			echo "<li><h3>".$cat->cat_name."</h3>";
			echo "<ul>";
			$args = array(
				'posts_per_page' => -1,
				'cat' => $cat->cat_ID,
			);
			$site_posts = new WP_Query( $args );
			if ( $site_posts->have_posts() ) : while( $site_posts->have_posts() ) : $site_posts->the_post();
				$category = get_the_category();
				// Only display a post link once, even if it's in multiple categories
				if ($category[0]->cat_ID == $cat->cat_ID) {
					echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
				}
			endwhile;endif;
			wp_reset_postdata();
			echo "</ul>";
			echo "</li>";
		}
		?>
	</ul>

	<?php
	foreach( get_post_types( array('public' => true) ) as $post_type ) {
		if ( in_array( $post_type, array('post','page','attachment', 'press', 'guest-review', 'question' ) ) )
			continue;

		$pt = get_post_type_object( $post_type );

		echo '<h2>'.$pt->labels->name.'</h2>';
		echo '<ul>';

		$args = array(
			'posts_per_page' => -1,
			'post_type'      => $post_type,
		);
		$cpts = new WP_Query( $args );
		if ( $cpts->have_posts() ) : while( $cpts->have_posts() ) : $cpts->the_post();
			echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
		endwhile;endif;
		wp_reset_postdata();

		echo '</ul>';
	}
?>
</div>
