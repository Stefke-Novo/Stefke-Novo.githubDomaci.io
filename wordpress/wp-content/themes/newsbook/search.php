<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title">
								<?php
								/* translators: %s: search query. */
								printf( esc_html__( 'Search Results for: %s', 'newsbook' ), '<span>' . get_search_query() . '</span>' );
								?>
							</h1>
						</header><!-- .page-header -->

						<div class="row row-cols-1 row-cols-sm-2 nb-posts-row ">

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							?>

							<div class="col">
								<?php

								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'search' );

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
