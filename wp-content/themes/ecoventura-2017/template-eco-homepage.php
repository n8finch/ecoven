<?php

//* Template Name: Ecoventura Home
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
	eco_homepage_above_fold($acf_fields);
	eco_homepage_page_image_boxes($acf_fields);
	eco_homepage_video($acf_fields);
	eco_homepage_recent_blog_posts();
	eco_homepage_page_as_seen_in_the_media($acf_fields);
	eco_homepage_subscribe($acf_fields);
}

function eco_homepage_above_fold($acf_fields) {
	//* Add Slider
	?>
	<section class="homepage-above-fold">
		<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( $acf_fields["homepage_slider"] ); } ?>


		<!-- Add title div -->

		<div class="homepage-title-div">
			<h2><?php echo $acf_fields["above_the_fold_heading"]; ?></h2>
		</div>

		<!-- Add Plan Your Trip box -->
		<div class="plan-your-trip-box"><span>PLAN YOUR TRIP</span></div>

	</section>
	<?php
}

function eco_homepage_page_image_boxes($acf_fields) {
	?>
	<section class="homepage-page-image-boxes">

		<a href="<?php echo $acf_fields['image_box_1_link'];?>">
			<div class="homepage-page-image-box">
				<img src="<?php echo $acf_fields['image_box_1_image'];?>" />
				<div><?php echo $acf_fields['image_box_1_title'];?></div>
			</div>
		</a>


		<a href="<?php echo $acf_fields['image_box_2_link'];?>">
			<div class="homepage-page-image-box">
				<img src="<?php echo $acf_fields['image_box_2_image'];?>" />
				<div><?php echo $acf_fields['image_box_2_title'];?></div>
			</div>
		</a>


		<a href="<?php echo $acf_fields['image_box_3_link'];?>">
			<div class="homepage-page-image-box">
				<img src="<?php echo $acf_fields['image_box_3_image'];?>" />
				<div><?php echo $acf_fields['image_box_3_title'];?></div>
			</div>
		</a>


		<a href="<?php echo $acf_fields['image_box_4_link'];?>">
			<div class="homepage-page-image-box">
				<img src="<?php echo $acf_fields['image_box_4_image'];?>" />
				<div><?php echo $acf_fields['image_box_4_title'];?></div>
			</div>
		</a>



	</section>
	<?php
}

function eco_homepage_video($acf_fields) {
	//* Add homepage video
	//TODO replace witht the content embed
	?>
	<section class="homepage-video">
		<div>
			<video width="960" autoplay controls muted>
			  <source src="<?php echo $acf_fields['video_embed']; ?>" type="video/mp4">
			  <source src="<?php echo $acf_fields['video_embed']; ?>" type="video/ogg">
			Your browser does not support the video tag.
			</video>
		</div>
	</section>
	<?php
}

function eco_homepage_recent_blog_posts() {
	add_filter( 'get_the_excerpt', 'eco_filter_excerpt_length' );

	global $post;
	$latestposts = get_posts( array(
		'posts_per_page' => 3,
		'post_type'        => 'post',
	) );

	if ( $latestposts ) {
		?>
		<!-- Add Recent Blog Posts box -->

		<section class="homepage-recent-blog-posts">
			<h2>RECENT BLOG POSTS</h2>

			<div class="recent-post-box-container">
				<?php
			    foreach ( $latestposts as $post ) :
			        setup_postdata( $post ); ?>
					<div class="recent-post-box">
						<a href="<?php the_permalink(); ?>">
							<img class="" src="<?php echo the_post_thumbnail_url('reason'); ?>"/>
						</a>
						<h3><?php the_title(); ?></h3>
				        <?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>"><button>READ MORE</button></a>
					</div>

			    <?php
			    endforeach;
			    wp_reset_postdata();
				?>
			</div><!-- end Recent Post Box Container -->
			<a href="/blog"><button>READ MORE ARTICLES</button></a>
		</section>
		<?php
	}
}

function eco_filter_excerpt_length( $excerpt ) {
	//Limit excerpt to 250 characters
	$excerpt = substr( $excerpt, 0, 250 );
	$punc_period = stripos( $excerpt, '.' );
	$punc_exclaim = stripos( $excerpt, '!' );
	$punc_question = stripos( $excerpt, '?' );

	if ( $punc_period ) {
		return substr( $excerpt, 0, $punc_period + 1 );
	}

	if ( $punc_exclaim ) {
		return substr( $excerpt, 0, $punc_exclaim +1 );
	}

	if ( $punc_question ) {
		return substr( $excerpt, 0, $punc_question + 1 );
	}

	// if none of the above were used, just add ...
	return $excerpt . '...';

}



function eco_homepage_page_as_seen_in_the_media($acf_fields) {
	?>
	<section class="homepage-page-as-seen">
		<div class="as-seen-layer-container ">
			<div class="as-seen-logo-container">
				<h2>AS SEEN IN THE MEDIA</h2>

				<a href="<?php echo $acf_fields['media_logo_1_link']; ?>">
					<img src="<?php echo $acf_fields['media_logo_1_image']; ?>" />
				</a>

				<a href="<?php echo $acf_fields['media_logo_2_link']; ?>">
					<img src="<?php echo $acf_fields['media_logo_2_image']; ?>" />
				</a>

				<a href="<?php echo $acf_fields['media_logo_3_link']; ?>">
					<img src="<?php echo $acf_fields['media_logo_3_image']; ?>" />
				</a>

				<a href="<?php echo $acf_fields['media_logo_4_link']; ?>">
					<img src="<?php echo $acf_fields['media_logo_4_image']; ?>" />
				</a>

				<a href="<?php echo $acf_fields['media_logo_5_link']; ?>">
					<img src="<?php echo $acf_fields['media_logo_5_image']; ?>" />
				</a>

				<a href="<?php echo $acf_fields['media_logo_6_link']; ?>">
					<img src="<?php echo $acf_fields['media_logo_6_image']; ?>" />
				</a>

			</div>

			<a href="/in-the-media/"><button>READ ARTICLES</button></a>

		</div>

	</section>
	<?php
}

function eco_homepage_subscribe() {
	?>
	<section class="homepage-subscribe">
		<div id="mc_embed_signup">
			<form action="//ecoventura.us7.list-manage.com/subscribe/post?u=ee26e36a40b22d13beee2602f&amp;id=0dc4307284" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
			    <div id="mc_embed_signup_scroll">
				<label for="mce-EMAIL"><h3>SUBSCRIBE TO OUR NEWSLETTER</h3></label>
				<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email Address" required="">
			    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			    <div style="position: absolute; left: -5000px;"><input type="text" name="b_ee26e36a40b22d13beee2602f_0dc4307284" tabindex="-1" value=""></div>
			    <div class="clear"><input type="submit" value="SIGN UP" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
			    </div>
			</form>
		</div>
	</section>

	<?php
}

//* Run the Genesis loop
genesis();
