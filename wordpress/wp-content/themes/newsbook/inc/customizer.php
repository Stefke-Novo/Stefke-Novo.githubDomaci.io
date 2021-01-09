<?php
/**
 * NewsBook Theme Customizer
 *
 * @package NewsBook
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function newsbook_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'newsbook_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'newsbook_customize_partial_blogdescription',
			)
		);
	}

	include get_template_directory() . '/inc/customizer/other-functions.php';
	include get_template_directory() . '/inc/class-newsbook-dropdown-category-control.php';
	include get_template_directory() . '/inc/customizer/frontpage-options.php';
	include get_template_directory() . '/inc/customizer/design-options.php';

	$wp_customize->get_section( 'header_image' )->panel        = 'newsbook_header_options';
	$wp_customize->get_section( 'header_image' )->priority     = 999;
	$wp_customize->get_section( 'background_image' )->panel    = 'newsbook_design_options';
	$wp_customize->get_section( 'background_image' )->priority = 999;
	$wp_customize->get_control( 'header_textcolor' )->section  = 'newsbook_color_options_section';
	$wp_customize->get_control( 'background_color' )->section  = 'newsbook_color_options_section';

	// Logo hight setting.
	$wp_customize->add_setting(
		'newsbook_custom_logo_height',
		array(
			'default'           => false,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'newsbook_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'newsbook_custom_logo_height',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Set custom height for Logo', 'newsbook' ),
			'section'  => 'title_tagline',
			'settings' => 'newsbook_custom_logo_height',
			'priority' => 8,
		)
	);
	$wp_customize->add_setting(
		'newsbook_logo_height',
		array(
			'default'           => 60,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'newsbook_logo_height',
		array(
			'label'           => __( 'Enter logo height (in px)', 'newsbook' ),
			'type'            => 'number',
			'section'         => 'title_tagline',
			'setting'         => 'newsbook_logo_height',
			'priority'        => '9',
			'active_callback' => function () {
				if ( get_theme_mod( 'newsbook_custom_logo_height', false ) ) {
					return true;
				}
				return false;
			},
		)
	);

}
add_action( 'customize_register', 'newsbook_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function newsbook_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function newsbook_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function newsbook_customize_preview_js() {
	wp_enqueue_script( 'newsbook-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), NEWSBOOK_VERSION, true );
}
add_action( 'customize_preview_init', 'newsbook_customize_preview_js' );



/**
 * newsbook Custom css for customizer.
 *
 * @return void
 */
function newsbook_styles_method() {
	$newsbook_primary_color = sanitize_hex_color( get_theme_mod( 'newsbook_primary_color', '#0d6efd' ) );
	$newsbook_internal_css  = '';

	if ( '#0d6efd' !== $newsbook_primary_color ) {
		$newsbook_internal_css = "
			a, .widget a:hover, .entry-title a:hover, .cat-links a {
				color: {$newsbook_primary_color};
			}
			a:hover {
				color: {$newsbook_primary_color};
			}
			.widget .widget-title::after, .widget .widgettitle::after,
			.main-navigation a:hover, .main-navigation a:focus, .main-navigation a:active,
			.main-navigation .current_page_item > a, .main-navigation .current-menu-item > a,
			.main-navigation .current_page_ancestor > a, .main-navigation .current-menu-ancestor > a,
			input[type=reset], input[type=button], input[type=submit], button,
			.cat-links a:hover {
				background-color: {$newsbook_primary_color};
			}
			.search-form button.search-icon {
				border-color: {$newsbook_primary_color};
			}
		";
	}

	wp_add_inline_style( 'newsbook-style', $newsbook_internal_css );

}
add_action( 'wp_enqueue_scripts', 'newsbook_styles_method' );



/**
 * Newsbook_custom_logo_css
 *
 * @return void
 */
function newsbook_custom_logo_css() {
	if ( get_theme_mod( 'newsbook_custom_logo_height', false ) ) {
		?>
		<style type="text/css" id="custom-theme-css">
			.custom-logo { height: <?php echo esc_attr( get_theme_mod( 'newsbook_logo_height', '60' ) ); ?>px; width: auto; }
		</style>
		<?php
	}
}
add_action( 'wp_head', 'newsbook_custom_logo_css', 100 );
