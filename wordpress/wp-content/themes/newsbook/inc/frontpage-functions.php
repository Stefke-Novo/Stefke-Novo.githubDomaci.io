<?php
/**
 * Functions which enhance the theme front page
 *
 * @package NewsBook
 */

if ( ! function_exists( 'newsbook_display_banner_section' ) ) :
	/**
	 * Display banner section.
	 *
	 * @return void
	 */
	function newsbook_display_banner_section() {
		$newsbook_featured_posts_cat      = get_theme_mod( 'newsbook_banner_featured_category', 0 );

		$newsbook_get_banner_featured_posts = new WP_Query(
			array(
				'posts_per_page'      => 5,
				'post_type'           => 'post',
				'ignore_sticky_posts' => true,
				'post_status'         => 'publish',
				'cat'                 => $newsbook_featured_posts_cat,
			)
		);

		if ( $newsbook_get_banner_featured_posts->have_posts() ) {
			?>
			<div class="front-page-banner-section">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="nb-banner-grid">
								<?php
									$post_counter = 1;

									while ( $newsbook_get_banner_featured_posts->have_posts() ) :
										$newsbook_get_banner_featured_posts->the_post();

										if ( $post_counter === 1 ) :
											?>
											<div class="nb-banner-primary-post">
												<?php
												if ( has_post_thumbnail() ) :
													the_post_thumbnail( 'newsbook-featured-image-medium' );
												else :
													?>
													<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default-bg-img.png" alt="<?php the_title_attribute(); ?>">
													<?php
												endif;
												?>
												<a class="theme-overlay-link" href="<?php the_permalink(); ?>"></a>
												<div class="theme-banner-content">
													<h3 class="theme-banner-title">
														<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
													</h3>
													<div class="theme-banner-meta">
													<?php
														newsbook_posted_on();
														newsbook_posted_by();
													?>
													</div>
												</div>
											</div>
											<?php
										else :
											?>
											<div class="nb-banner-secondary-post">
												<?php
												if ( has_post_thumbnail() ) :
													the_post_thumbnail( 'newsbook-featured-image-medium' );
												else :
													?>
													<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/default-bg-img.png" alt="<?php the_title_attribute(); ?>">
													<?php
												endif;
												?>
												<a class="theme-overlay-link" href="<?php the_permalink(); ?>"></a>
												<div class="theme-banner-content">
													<h3 class="theme-banner-title">
														<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
													</h3>
													<div class="theme-banner-meta">
													<?php
														newsbook_posted_on();
														newsbook_posted_by();
													?>
													</div>
												</div>
											</div>
											<?php
										endif;
										$post_counter++;
									endwhile;
									wp_reset_postdata();
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
endif;
