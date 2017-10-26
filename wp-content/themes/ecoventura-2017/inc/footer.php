<?php
/**
 * Footer template
 * @package ecoventura-2017
 * @author Josh Eaton <josh@josheaton.org>
 */

$front = get_option( 'page_on_front' );
?>
<footer class="site-footer">
	<div class="wrap">
		<div class="one-third first footer-left">
			<?php echo get_field( '_eco_footer_left_content', $front ); ?>
		</div>
		<div class="one-third footer-center">
			<div class="footer-logos">

<!--
<?php
				if ( get_field( '_eco_footer_logos', $front ) ) :
					while ( has_sub_field(

'_eco_footer_logos', $front ) ) {
						$image = get_sub_field( 'image' );
						$link  = get_sub_field( 'link' );

						$img = wp_get_attachment_image(

$image, 'footer-logo', false, array( 'class' => 'footer-logo') );

						if ( $link )
							$img = '<a

href="'.esc_url($link).'">' . $img . '</a>';
						echo $img;
					}
				endif;
				?>
                -->

		</div>
			<?php $center = get_field( '_eco_footer_center_content', $front ); ?>
			<p class="footer-links"><?php echo $center; ?><br><a href="http://www.josheaton.org/" target="_blank">designed by Josh Eaton</a> &amp; <a href="http://www.briallendesign.com/" target="_blank">Bri Allen</a></p>
		</div>
		<div class="one-third footer-right">
			<!-- Begin MailChimp Signup Form -->
			<div id="mc_embed_signup">
			<form action="//ecoventura.us7.list-manage.com/subscribe/post?u=ee26e36a40b22d13beee2602f&amp;id=0dc4307284" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			    <div id="mc_embed_signup_scroll">
				<label for="mce-EMAIL">Sign up for our Newsletter</label>
				<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
			    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			    <div style="position: absolute; left: -5000px;"><input type="text" name="b_ee26e36a40b22d13beee2602f_0dc4307284" tabindex="-1" value=""></div>
			    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
			    </div>
			</form>
			</div>
			<!--End mc_embed_signup-->
			<?php if ( has_nav_menu( 'social-media' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'social-media',
						'container'       => 'nav',
						'container_class' => 'menu menu-social-media',
						'menu_id'         => 'menu-social-media-items',
						'menu_class'      => 'menu-items menu-social-media-items',
						'depth'           => 1,
						'fallback_cb'     => '',
					)
				);
			} ?>
			<?php $right = get_field( '_eco_footer_right_content', $front ); ?>
			<p class="contact-info">
				<?php echo $right; ?>
			</p>
		</div>
	</div>
</footer>
