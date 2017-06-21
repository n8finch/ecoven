<?php

//* Template Name: Ecoventura Home
//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the default Genesis loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom homepage content
add_action( 'genesis_loop', 'eco_homepage_content' );

function eco_homepage_content() {

	//* Add in the sections
	eco_homepage_above_fold();
	eco_homepage_page_image_boxes();
	eco_homepage_video();
	eco_homepage_recent_blog_posts();
	eco_homepage_page_as_seen_in_the_media();
	eco_homepage_subscribe();
}

function eco_homepage_above_fold() {
	//TODO get the slider ID
	//* Add Slider
	?>
	<section class="homepage-above-fold">
		<?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '9619' ); } ?>


		<!-- Add title div -->

		<div class="homepage-title-div">
			<h2>EXPEDITION CRUISING IN THE GALLAPAGOS ISLANDS</h2>
		</div>

		<!-- Add Plan Your Trip box -->
		<div class="plan-your-trip-box"><span>PLAN YOUR TRIP</span></div>

	</section>
	<?php
}

function eco_homepage_page_image_boxes() {

	//TODO: replace image links

	?>
	<section class="homepage-page-image-boxes">

		<a href="#">
			<div class="homepage-page-image-box">
				<img src="http://via.placeholder.com/400x300" />
				<div>Rates & Terms</div>
			</div>
		</a>

		<a href="#">
			<div class="homepage-page-image-box">
				<img src="http://via.placeholder.com/400x300" />
				<div>Rates & Terms</div>
			</div>
		</a>

		<a href="#">
			<div class="homepage-page-image-box">
				<img src="http://via.placeholder.com/400x300" />
				<div>Rates & Terms</div>
			</div>
		</a>

		<a href="#">
			<div class="homepage-page-image-box">
				<img src="http://via.placeholder.com/400x300" />
				<div>Rates & Terms</div>
			</div>
		</a>

	</section>
	<?php
}

function eco_homepage_video() {
	//* Add homepage video
	//TODO replace witht the content embed
	?>
	<section class="homepage-video">
		<div>
			<iframe width="900" height="480" src="https://www.youtube.com/embed/j_7f3iisldM?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
		</div>
	</section>
	<?php
}

function eco_homepage_recent_blog_posts() {
	add_filter( 'excerpt_more', 'eco_filter_excerpt_read_more' );

	global $post;
	$latestposts = get_posts( array(
		'posts_per_page' => 3,
		'post_type'        => 'post',
	) );

	if ( $latestposts ) {
		?>
		<section class="homepage-recent-blog-posts">
			<h2>RECENT BLOG POSTS</h2>
		<?php
		    foreach ( $latestposts as $post ) :
		        setup_postdata( $post ); ?>
				<div class="recent-post-box">
					<a href="<?php the_permalink(); ?>">
						<img class="" src="<?php echo the_post_thumbnail_url('reason'); ?>"/>
					</a>
					<h2><?php the_title(); ?></h2>
			        <?php the_excerpt(); ?>
				</div>

		    <?php
		    endforeach;
		    wp_reset_postdata();
			?>
			<a href="/blog"><button>READ MORE ARTICLES</button></a>
		</section>
		<?php
	}
}

function eco_filter_excerpt_read_more( $more ) {
    return '... <a href="'.get_the_permalink().'" rel="nofollow">Read More</a>';
}



function eco_homepage_page_as_seen_in_the_media() {

	//TODO: replace image links

	?>
	<section class="homepage-page-as-seen">
		<div class="as-seen-layer-container ">
			<div class="as-seen-logo-container">
				<h2>AS SEEN IN THE MEDIA</h2>

				<a href="#">
					<img src="http://via.placeholder.com/300x80" />
				</a>
				<a href="#">
					<img src="http://via.placeholder.com/300x80" />
				</a>
				<a href="#">
					<img src="http://via.placeholder.com/300x80" />
				</a>
				<a href="#">
					<img src="http://via.placeholder.com/300x80" />
				</a>
				<a href="#">
					<img src="http://via.placeholder.com/300x80" />
				</a>
				<a href="#">
					<img src="http://via.placeholder.com/300x80" />
				</a>
			</div>

			<button>READ ARTICLES</button>

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
				<label for="mce-EMAIL">SUBSCRIBE TO OUR NEWSLETTER</label>
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
