<?php
/**
 * NewsBook functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NewsBook
 */

if ( ! defined( 'NEWSBOOK_VERSION' ) ) {
	// Theme version.
	$newsbook_theme = wp_get_theme();
	define( 'NEWSBOOK_VERSION', $newsbook_theme->get( 'Version' ) );
}

if ( ! function_exists( 'newsbook_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function newsbook_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on NewsBook, use a find and replace
		 * to change 'newsbook' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'newsbook', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'newsbook' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'newsbook_custom_background_args',
				array(
					'default-color' => 'edf2f7',
					'default-image' => '',
				)
			)
		);

		// Define image sizes for theme.
		add_image_size( 'newsbook-featured-image', 1020, 600, true );
		add_image_size( 'newsbook-featured-image-medium', 500, 300, true );
		add_image_size( 'newsbook-featured-image-small', 150, 120, true );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'newsbook_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function newsbook_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'newsbook_content_width', 1020 );
}
add_action( 'after_setup_theme', 'newsbook_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function newsbook_scripts() {
	wp_enqueue_style( 'newsbook-fonts', '//fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), NEWSBOOK_VERSION );
	wp_enqueue_style( 'bootstrap-5-grid', get_template_directory_uri() . '/css/bootstrap-grid.css', array(), 'v5.0.0-alpha1', 'all' );
	wp_enqueue_style( 'newsbook-style', get_stylesheet_uri(), array(), NEWSBOOK_VERSION );

	wp_enqueue_script( 'newsbook-navigation', get_template_directory_uri() . '/js/navigation.js', array(), NEWSBOOK_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'newsbook_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/header-functions.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/footer-functions.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/frontpage-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add new widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

