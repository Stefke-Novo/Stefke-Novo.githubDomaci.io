<?php
/**
 * Functions which enhance the theme header
 *
 * @package NewsBook
 */

if ( ! function_exists( 'newsbook_display_main_header_design_1' ) ) :
	/**
	 * Display header design 1.
	 *
	 * @return void
	 */
	function newsbook_display_main_header_design_1() {
		?>
		<header id="masthead" class="site-header">
			<div class="main-header-bar nb-header-design-1">
				<div class="container">
					<div class="row align-items-center site-header-row">
						<div class="col-md-4">
							<div class="site-branding">
								<?php
								the_custom_logo();
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$newsbook_description = get_bloginfo( 'description', 'display' );
								if ( $newsbook_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo $newsbook_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
								<?php endif; ?>
							</div><!-- .site-branding -->
						</div>

						<div class="col-md-8">
							<?php
							if ( is_active_sidebar( 'newsbook_header_right' ) ) {
								?>
								<div class="header-right-widgets">
									<?php
									dynamic_sidebar( 'newsbook_header_right' );
									?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->

		<div class="main-header-nav-bar nb-header-design-1">
			<div class="container">
				<div class="row align-items-center primary-nav-row">
					<div class="col-md-12">
						<nav id="site-navigation" class="main-navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'newsbook' ); ?></button>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
								)
							);
							?>
						</nav><!-- #site-navigation -->
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- /.main-header-nav-bar -->
		<?php
	}
endif;
