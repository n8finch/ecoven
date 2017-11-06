<?php
/**
 * Functions
 *
 * @package      ecoventura-2017
 * @since        1.0.0
 * @author       Josh Eaton <josh@josheaton.org>
 * @copyright    Copyright (c) 2013, Josh Eaton
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

// Set content width for Jetpack galleries
if ( ! isset( $content_width ) )
    $content_width = 1100;

/**
 * Theme Setup
 * @since 1.0.0
 *
 * This setup function attaches all of the site-wide functions
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */
add_action( 'genesis_setup','child_theme_setup', 15 );
function child_theme_setup() {
	// Start the engine
	require_once( get_template_directory() . '/lib/init.php' );

	// Child theme (do not remove)
	define( 'CHILD_THEME_NAME', 'Ecoventura 2017' );
	define( 'CHILD_THEME_URL', 'http://www.josheaton.org/' );
	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Includes
	require_once( CHILD_DIR . '/inc/eco-functions.php' );
	require_once( CHILD_DIR . '/inc/eco-types.php' );

	// Admin
	require_once( CHILD_DIR . '/inc/admin/admin.php' );

	require_once( CHILD_DIR . '/inc/shortcodes/div-shortcode.php' );
	require_once( CHILD_DIR . '/inc/shortcodes/eco-shortcodes.php' );
	require_once( CHILD_DIR . '/inc/shortcodes/world-nomads.php' );

	require_once( CHILD_DIR . '/inc/post-meta-importer.php' );

	// * Backend *

	// Enable shortcodes in widgets
	add_filter( 'widget_text', 'do_shortcode' );

	// Set default image link type to none
	add_action( 'admin_init', 'eco_default_link_none', 10 );

	// Add menus
	add_action( 'init', 'eco_register_menus' );
	// Move secondary menu to header
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );
	add_action( 'eco_top_bar', 'eco_do_top_bar' );

	// Reduce the secondary navigation menu to one level depth.
	add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
	function genesis_sample_secondary_menu_args( $args ) {

		if ( 'secondary' != $args['theme_location'] ) {
			return $args;
		}

		$args['depth'] = 1;

		return $args;

	}

	// Modify size of the Gravatar in the author box.
	add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
	function genesis_sample_author_box_gravatar( $size ) {
		return 90;
	}

	// Modify size of the Gravatar in the entry comments.
	add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
	function genesis_sample_comments_gravatar( $args ) {

		$args['avatar_size'] = 60;

		return $args;

	}

	/** Unregister layout settings */
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	//* Force full-width-content layout setting
	add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );


	// Image sizes
	add_image_size( 'media-thumb',            52             );
	add_image_size( 'media-thumb-mini',       22             );
	add_image_size( 'reason',                350,  233, true );
	add_image_size( 'gallery-archive-thumb', 345,  230, true );
	add_image_size( 'book-cover',            200,  300, true );
	add_image_size( 'cuisine-gallery',       732, 9999       );
	add_image_size( 'gallery-cropped',       732,  494       );
	add_image_size( 'crew-headshot',         120,   95, true );
	add_image_size( 'partner-logo',          140,  125, true );
	add_image_size( 'itinerary-map-small',   520,  475, true );

	// Modify loop queries
	add_action( 'pre_get_posts', 'eco_modify_queries' );

	// * Frontend *

	//* Add HTML5 markup structure
	// add_theme_support( 'genesis-html5' ); // beta
	// add_theme_support( 'html5' ); // 2.0

	// Add HTML5 markup structure.
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	add_action( 'wp_head', 'eco_favicons', 1 );

	// Add Accessibility support.
	add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

	//* Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for custom header.
	add_theme_support( 'custom-header', array(
		'width'           => 600,
		'height'          => 245,
		'header-selector' => '.site-title a',
		'header-text'     => false,
		'flex-height'     => true,
	) );

	// Enqueue scripts and styles
	add_action( 'wp_enqueue_scripts', 'eco_scripts' );

	// Add support for 3-column footer widgets
	add_theme_support( 'genesis-footer-widgets', 3 );

	// Add top bar
	add_action( 'genesis_before_header', 'eco_do_top_bar', 3 );

	// Add support for custom background.
	add_theme_support( 'custom-background' );

	// Add support for after entry widget.
	add_theme_support( 'genesis-after-entry-widget-area' );

	// Remove Genesis front-end features
	// * Header *
	remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_header', 'genesis_do_nav' );

	// * Sidebars *
	unregister_sidebar( 'header-right' );
	unregister_sidebar( 'sidebar-alt' );

	genesis_register_sidebar( array(
	  'id'			=> 'top-bar-widget-area',
	  'name'			=> __( 'Top Bar Widget Area', 'CHILD_THEME_NAME' ),
	  'description'	=> __( 'This is the Top Bar Widget Area.', 'CHILD_THEME_NAME' ),
  	) );

	//* Customize search form input box text
	add_filter( 'genesis_search_text', 'eco_search_text' );

	// * Footer * Add custom footer outside of wrap
	remove_action( 'genesis_footer', 'genesis_do_footer' );
	remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
	remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

	// * Customize widget titles
	add_filter( 'widget_title', 'eco_add_widget_title_spans' );

	// Remove the edit link
	add_filter( 'genesis_edit_post_link' , '__return_false' );

	// Comment Form args
	add_filter( 'comment_form_defaults', 'eco_comment_form_args' );
}


function eco_scripts() {

	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Playfair+Display|Raleway', array(), CHILD_THEME_VERSION );

	//fonts.googleapis.com/css?family=Playfair+Display+SC|Raleway



	// Styles
	// * colorbox
	// * style.css
	wp_enqueue_style( 'colorbox', get_stylesheet_directory_uri() . '/lib/js/colorbox/colorbox.css', array(), filemtime(get_stylesheet_directory() . '/lib/js/colorbox/colorbox.css'), 'all' );

	// * fitvids
	// * ios orientationchange fix
	// * colorbox
	// * global.js
	wp_enqueue_script( 'fitvids', get_stylesheet_directory_uri() . '/lib/js/_jquery.fitvids.js', array(), filemtime(get_stylesheet_directory() . '/lib/js/_jquery.fitvids.js') );

	wp_enqueue_script( 'ios-bug', get_stylesheet_directory_uri() . '/lib/js/ios-bug.js', array(), filemtime(get_stylesheet_directory() . '/lib/js/ios-bug.js') );

	wp_enqueue_script( 'colorbox', get_stylesheet_directory_uri() . '/lib/js/colorbox/jquery.colorbox.min.js', array('jquery'), filemtime(get_stylesheet_directory() . '/lib/js/colorbox/jquery.colorbox.min.js'), true );

	wp_enqueue_script( 'resp-tables-js', get_stylesheet_directory_uri() . '/lib/js/responsive-tables/responsive-tables.js', array('jquery'), filemtime(get_stylesheet_directory() . '/lib/js/responsive-tables/responsive-tables.js'), true );

	wp_enqueue_script( 'hoverIntent' );

	wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.min.js', array( 'jquery' ), filemtime(get_stylesheet_directory() . '/js/custom.min.js'), true );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);
}

// Define our responsive menu settings.
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

function eco_favicons() {
	?>
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-152.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-144.png">
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-120.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-114.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-72.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-57.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri();?>/images/favicon-144.png">
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-32.png" sizes="32x32">
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-72.png" sizes="72x72">
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-96.png" sizes="96x96">
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-128.png" sizes="128x128">
	<link rel="icon" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon-195.png" sizes="195x195">
	<?php
}

function eco_do_top_bar() { ?>
	<div class="top-bar">
		<?php
		genesis_widget_area( 'top-bar-widget-area', array(
				'before' => '<div class="top-bar-flex">',
				'after' => '</div>',
			) );
		?>
	</div>
	<?php
}

function eco_add_widget_title_spans( $title ) {
	if ( false === strpos( $title, '[span]' ) ) {
		return $title;
	}

	$title = str_replace( '[span]',  '<span>', $title );
	$title = str_replace( '[/span]', '</span>', $title );

	return $title;
}

/**
 * Customize search text
 *
 * @since 1.0.0
 */
function eco_search_text( $text ) {
	return esc_attr( '' );
}

/**
 * Register nav menus
 */
function eco_register_menus() {
	register_nav_menu( 'social-media', _x( 'Social Media', 'nav menu location', 'ecoventura-2017' ) );
}

// add ie conditional html5 shim to header
function add_ie_html5_shim () {
	echo '<!--[if lt IE 9]>';
	echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
	echo '<script src="' . get_stylesheet_directory_uri() . '/lib/js/respond.min.js"></script>';
	echo '<![endif]-->';
}
add_action( 'wp_head', 'add_ie_html5_shim' );


function eco_modify_queries( $query ) {
	if ( is_admin() )
		return;

	// Return 26 posts per page for 'In The Media'
	if ( $query->is_main_query() && $query->is_post_type_archive( 'press' ) ) {
		$query->set( 'posts_per_page', 26 );
	}

	// Return unlimited posts for 'Galleries'
	if ( $query->is_main_query() && $query->is_post_type_archive( 'gallery' ) ) {
		$query->set( 'nopaging', 1 );
	}
}


add_action( 'template_redirect', 'eco_hide_singular_cpts' );

/**
 * Set redirect to hide single posts in certain CPTs.
 *
 */

function eco_hide_singular_cpts() {

	// Redirect single resources to archive page
	if ( is_singular( 'press' ) ) {
		$press_archive = get_post_type_archive_link( 'press' );
		wp_redirect( esc_url_raw( $press_archive ), 301 );
		exit();
	}

	// Redirect single reviews to archive page
	if ( is_singular( 'guest-reviews' ) ) {
		$reviews_archive = get_post_type_archive_link( 'guest-reviews' );
		wp_redirect( esc_url_raw( $reviews_archive ), 301 );
		exit();
	}

}

/**
 * Modify oEmbed sizes since $content_width is set so large for the Jetpack tiled galleries
 *
 * @param  [type] $embed_size [description]
 * @return [type]             [description]
 */
function eco_oembed_defaults( $embed_size ) {
	// Modify embed size for singular galleries
	if ( is_singular( 'gallery' ) ) {
		$embed_size['width']  = 600;
		$embed_size['height'] = 546;
	}
	return $embed_size;
}
add_filter( 'embed_defaults', 'eco_oembed_defaults' );


/**
 * Modify comment form arguments
 *
 * @param  [type] $args [description]
 * @return [type]       [description]
 */
function eco_comment_form_args( $args ) {
	// Remove comment notes after
	$args['comment_notes_after'] = '';

	return $args;
}

/**
 * Add header to blog page
 *
 * @return null
 */
function eco_add_blog_header() {
	// Only display on the blog index
	if ( ! is_home() )
		return;

	?>
	<div class="archive-description">
		<h1 class="archive-title">Blog</h1></div>
	<?php
}
add_action( 'genesis_before_loop', 'eco_add_blog_header' );

function remove_acf_menu() {

	// provide a list of usernames who can edit custom field definitions here
	$admins = array(
		'josh',
	);

	// get the current user
	$current_user = wp_get_current_user();

	// match and remove if needed
	if( !in_array( $current_user->user_login, $admins ) ) {
		remove_menu_page('edit.php?post_type=acf');
	}

}

add_action( 'admin_menu', 'remove_acf_menu', 9999 );


// Add Facebook Retargeting pixel.
add_action( 'wp_head', function() {
?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '370688379967829'); //
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=370688379967829&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
<?php
} );



//* Testimonials in Footer Shortcode
add_shortcode( 'eco_footer_testimonial' , 'eco_footer_testimonials' );

function eco_footer_testimonials() {
	global $post;
	$guestreviews = get_posts( array(
		'posts_per_page' => 1,
		'post_type'        => 'guest-review',
	) );

	if ( $guestreviews ) {
		?>
		<section class="footer-testimonials">
			<h4>Guest Reviews</h4>
		<?php
		    foreach ( $guestreviews as $post ) :

				$post_content = substr( $post->post_content, 0, 200);
				$post_meta = get_post_meta($post->ID)['_eco_guests_trip'][0];

				echo "<p>{$post_content}...</p>";
				echo "<p><em>{$post_meta}</em></p>";
				echo '<a class="button" href="/guest-reviews/">More Reviews</a>';

		    endforeach;
		    wp_reset_postdata();
		?>
		</section>

	<?php }//end if
}


//* Subscribe to our newsletter before footer
add_action( 'genesis_before_footer', 'eco_homepage_subscribe', 1 );
function eco_homepage_subscribe() {
	?>
	<section class="footer-subscribe">
		<div id="mc_embed_signup">
			<form action="//ecoventura.us7.list-manage.com/subscribe/post?u=ee26e36a40b22d13beee2602f&amp;id=0dc4307284" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
			    <div id="mc_embed_signup_scroll">
				<label for="mce-EMAIL"><h3>Subscribe to Our Newsletter</h3></label>
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
