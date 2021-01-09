<?php
/**
 * Template to show the front page.
 *
 * @package NewsBook
 */

get_header();
?>

<?php

$newsbook_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

if ( get_theme_mod( 'newsbook_show_banner_section', true ) && 1 === $newsbook_paged ) {
	newsbook_display_banner_section();
}
?>

<div id="main-content">

	<?php
	if ( is_active_sidebar( 'newsbook_frontpage_content_top_section' ) && 1 === $newsbook_paged ) :
		?>
		<div id="content-top-section" class="theme-content-top-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<?php dynamic_sidebar( 'newsbook_frontpage_content_top_section' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	endif;
	?>

	<?php
	$newsbook_sidebar_class = '';
	$newsbook_content_class = '';
	if ( get_theme_mod( 'newsbook_frontpage_sidebar_position', 'right' ) === 'left' ) {
		$newsbook_content_class = 'order-md-2';
		$newsbook_sidebar_class = 'order-md-1';
	}
	?>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 content-area <?php echo esc_html( $newsbook_content_class ); ?>">
				<main id="primary" class="site-main">
					<?php
					if ( ! get_theme_mod( 'newsbook_hide_frontpage_posts_page', false ) ) :
						if ( have_posts() ) :

							if ( is_home() && ! is_front_page() ) :
								?>
								<header>
									<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
								</header>
								<?php
							endif;

							?>

							<div class="row row-cols-1 row-cols-sm-2 nb-posts-row ">

								<?php
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									?>

									<div class="col">
										<?php
										/*
										* Include the Post-Type-specific template for the content.
										* If you want to override this in a child theme, then include a file
										* called content-___.php (where ___ is the Post Type name) and that will be used instead.
										*/
										get_template_part( 'template-parts/content', get_post_type() );

										?>
									</div>

									<?php

								endwhile;
								?>

							</div>

							<?php

							get_template_part( 'template-parts/navigation', 'none' );

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
					endif;
					?>
				</main><!-- #main -->
			</div>

			<?php if ( get_theme_mod( 'newsbook_frontpage_sidebar_position', 'right' ) !== 'hide' ) : ?>
			<div class="col-md-4 sidebar-area <?php echo esc_html( $newsbook_sidebar_class ); ?> ">
				<?php get_sidebar(); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
get_footer();
