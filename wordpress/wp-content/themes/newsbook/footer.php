<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewsBook
 */

?>

	<?php do_action( 'newsbook_before_footer' ); ?>
	
	<footer id="colophon" class="site-footer">

		<?php
		if ( get_theme_mod( 'newsbook_main_footer_design', 'design1' ) === 'design1' ) {
			newsbook_display_main_footer_design_1();
		} elseif ( get_theme_mod( 'newsbook_main_footer_design', 'design1' ) === 'design2' ) {
			newsbook_display_main_footer_design_2();
		}
		?>

	</footer><!-- #colophon -->

	<?php do_action( 'newsbook_after_footer' ); ?>
	
</div><!-- #page -->

<?php do_action( 'newsbook_after_page' ); ?>

<?php wp_footer(); ?>

</body>
</html>
