<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package NewsBook
 */

get_header();
?>

<div id="main-content">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 content-area">
				<main id="primary" class="site-main">

					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'single' );

						get_template_part( 'template-parts/navigation', 'none' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div>

			<div class="col-md-4 sidebar-area">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

</div><!-- /#main-content -->

<?php
get_footer();
