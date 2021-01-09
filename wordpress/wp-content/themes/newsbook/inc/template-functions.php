<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package NewsBook
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function newsbook_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	if ( get_theme_mod( 'newsbook_site_layout', 'wide' ) === 'boxed' ) {
		$classes[] = 'theme-boxed-layout';
	}

	if ( get_theme_mod( 'newsbook_enable_font_smoothing', true ) ) {
		$classes[] = 'antialiased';
	}

	return $classes;
}
add_filter( 'body_class', 'newsbook_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function newsbook_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'newsbook_pingback_header' );

/**
 * Sets the post excerpt length to 40 words.
 *
 * @param  mixed $length Excerpt length.
 * @return number
 */
function newsbook_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}

	return 25;
}
add_filter( 'excerpt_length', 'newsbook_excerpt_length' );
