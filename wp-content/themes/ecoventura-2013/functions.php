<?php
/**
 * Functions
 *
 * @package      ecoventura-2013
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
	define( 'CHILD_THEME_NAME', 'Ecoventura 2013' );
	define( 'CHILD_THEME_URL', 'http://www.josheaton.org/' );
	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Includes
	if ( ! defined( 'WP_LOCAL_DEV' ) || ! WP_LOCAL_DEV ) {
		require_once( CHILD_DIR . '/inc/eco-meta.php' );
	}
	require_once( CHILD_DIR . '/inc/eco-functions.php' );
	require_once( CHILD_DIR . '/inc/eco-types.php' );
	require_once( CHILD_DIR . '/inc/eco-builds.php' );
	require_once( CHILD_DIR . '/inc/shortcodes/world-nomads.php' );
	require_once( CHILD_DIR . '/inc/shortcodes/eco-shortcodes.php' );
	require_once( CHILD_DIR . '/inc/shortcodes/div-shortcode.php' );

	// Admin
	require_once( CHILD_DIR . '/inc/admin/admin.php' );

	// * Backend *

	// Enable shortcodes in widgets
	add_filter( 'widget_text', 'do_shortcode' );

	// Set default image link type to none
	add_action( 'admin_init', 'eco_default_link_none', 10 );

	// Add menus
	add_action( 'init', 'eco_register_menus' );
	// Move secondary menu to header
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );
	add_action( 'eco_top_bar', 'genesis_do_subnav' );

	/** Unregister layout settings */
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// Image sizes
	add_image_size( 'media-thumb',            52             );
	add_image_size( 'media-thumb-mini',       22             );
	add_image_size( 'footer-logo',           100,   54       );
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
	add_theme_support( 'genesis-html5' ); // beta
	add_theme_support( 'html5' ); // 2.0

	add_action( 'wp_head', 'eco_favicons', 1 );

	//* Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// Enqueue scripts and styles
	add_action( 'wp_enqueue_scripts', 'eco_scripts' );

	// Add Google Fonts
	add_action( 'genesis_meta', 'eco_google_fonts', 5 );

	// Add support for 3-column footer widgets
	// add_theme_support( 'genesis-footer-widgets', 3 );

	// Add top bar
	add_action( 'genesis_before_header', 'eco_top_bar', 3 );

	// Add logo to the header
	add_filter( 'genesis_seo_title', 'eco_custom_header_logo', 10, 3 );

	// Remove Genesis front-end features
	// * Header *
	remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_before_header', 'eco_slider_wrap_begin', 5 );
	add_action( 'genesis_header', 'genesis_do_nav' );
	add_action( 'genesis_after_header', 'eco_add_page_banner' );
	add_action( 'genesis_after_header', 'eco_add_waves_shape', 15 );
	add_action( 'genesis_after_header', 'eco_slider_wrap_end', 50 );

	// * Sidebars *
	unregister_sidebar( 'header-right' );
	unregister_sidebar( 'sidebar-alt' );

	//* Customize search form input box text
	add_filter( 'genesis_search_text', 'eco_search_text' );

	// * Footer * Add custom footer outside of wrap
	remove_action( 'genesis_footer', 'genesis_do_footer' );
	remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
	remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
	add_action( 'wp_footer', 'eco_do_footer', 5 );

	// * Customize widget titles
	add_filter( 'widget_title', 'eco_add_widget_title_spans' );

	// Remove the edit link
	add_filter( 'genesis_edit_post_link' , '__return_false' );

	// Comment Form args
	add_filter( 'comment_form_defaults', 'eco_comment_form_args' );
}


function eco_scripts() {
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
	wp_enqueue_script( 'eco-global', get_stylesheet_directory_uri() . '/js/global.min.js', array('jquery','colorbox'), filemtime(get_stylesheet_directory() . '/js/global.min.js'), true );
}

function eco_google_fonts() {
	?>
<script type="text/javascript">
	WebFontConfig = {
		google: { families: [ 'Anton::latin' ] }
	};
	(function() {
		var wf = document.createElement('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(wf, s);
	})(); </script>
	<?php
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

function eco_top_bar() { ?>
	<div class="top-bar">
		<div class="weather-widget">
			<?php echo do_shortcode( '[wunderground caption="" location="GPS" layout="simple" showdata="icon,highlow" todaylabel=""]' ); ?>
		</div>
		<?php do_action( 'eco_top_bar' ); ?>
	</div>
	<?php
}

/**
 * Adds a custom header logo
 *
 * @since 1.0.0
 * @param  string $title  header title
 * @param  string $inside what to put inside the link
 * @param  string $wrap   the tag to wrap it in
 * @return string         new header title
 */
function eco_custom_header_logo( $title, $inside, $wrap ) {
	$inside = sprintf( '<a href="/" title="%s" class="header-logo">
		%s
	</a>', esc_attr( get_bloginfo( 'name' ) ),
	'<img src="' . get_stylesheet_directory_uri() . '/images/logo.png" width="153" height="60">' );

	$title = sprintf( '<%s class="title">%s
		</%s>
	', $wrap, $inside, $wrap );
	$nav_toggle = '<div class="menu-toggle menu-icon">
		<a href="#"><span>Site Menu</span></a>
	</div>';

	return $title . $nav_toggle;
}

function eco_slider_wrap_begin() {
	echo '<div class="header-slider-wrap">';
}

function eco_slider_wrap_end() {
	echo '</div>';
}

function eco_add_waves_shape() {
	echo '<img src="' . get_stylesheet_directory_uri() . '/images/waves.png" width="1280" height="60" class="waves-shape">';
}

function eco_do_footer() {
	get_template_part( 'inc/footer' );
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
	return esc_attr( 'Search...' );
}

/**
 * Register nav menus
 */
function eco_register_menus() {
	register_nav_menu( 'social-media', _x( 'Social Media', 'nav menu location', 'ecoventura-2013' ) );
}


add_filter( 'underscores_slider_slide_content_slides', 'eco_slide_filter', 10, 2 );

function eco_slide_filter( $content, $args ) {
	global $post;

	// Only add caption for home slider
	if ( isset($args['slide_page']) && 'home-slider' == $args['slide_page'] ) {
		$caption = get_field( 'slide_caption', $post->ID );
		if ( $caption ) {
			$content .= '<div class="slide-caption">' . $caption . '</div>';
		}
	}

	return $content;
}


/**
 * Redirect non-admins to the homepage after logging into the site.
 *
 * @since 	1.0
 */
function soi_login_redirect( $redirect_to, $request, $user  ) {
	return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : site_url();
} // end soi_login_redirect
// add_filter( 'login_redirect', 'soi_login_redirect', 10, 3 );

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


add_action( 'template_redirect',              'eco_hide_singular_cpts'                 );

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
 * Add page banner to header
 */
function eco_add_page_banner() {
	// Bail if we're on the front page (slider)
	if ( is_front_page() )
		return;
	global $post;

	if (have_posts()) : the_post();
		$page_banner	= get_field( '_eco_page_banner', $post->ID );
		$banner_url		= !empty($page_banner) ? $page_banner['url'] : get_stylesheet_directory_uri().'/images/galapagos-eric-leon-dormido.jpg';
		?>
		<div class="page-banner">
			<img src="<?php echo $banner_url; ?>" width="1280" height="250" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>">
		</div>
		<?php
		rewind_posts(); // Reset the query
	else:
		$banner_url		= get_stylesheet_directory_uri().'/images/galapagos-eric-leon-dormido.jpg';
		?>
		<div class="page-banner">
			<img src="<?php echo $banner_url; ?>" width="1280" height="250" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>">
		</div>
		<?php
	endif;
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

add_filter( 'wunderground_template_data_simple', 'eco_filter_high_low' );
function eco_filter_high_low( $data ) {
	$data['strings']['high'] = __( '%d&deg;', 'wunderground' );
	$data['strings']['low'] = __( '%d&deg;', 'wunderground' );
	return $data;
}