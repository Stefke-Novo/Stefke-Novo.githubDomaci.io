<?php
/**
 * NewsBook Widgets
 *
 * @package NewsBook
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function newsbook_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'newsbook' ),
			'id'            => 'newsbook_sidebar_1',
			'description'   => esc_html__( 'Add widgets here.', 'newsbook' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Header Right', 'newsbook' ),
			'id'            => 'newsbook_header_right',
			'description'   => esc_html__( 'Add widget here to display in header.', 'newsbook' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Front Page: Content Top Section', 'newsbook' ),
			'id'            => 'newsbook_frontpage_content_top_section',
			'description'   => esc_html__( 'Add widgets here to display posts just below the banner section. (This is a full width section without any sidebar.)', 'newsbook' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);

	register_widget( 'newsbook_728x90_advertisement_widget' );
	register_widget( 'newsbook_simple_featured_posts_widget' );
}

add_action( 'widgets_init', 'newsbook_widgets_init' );


/**
 * Add 728-90 adv widget.
 */
require get_template_directory() . '/inc/widgets/class-newsbook-728x90-advertisement-widget.php';

/**
 * Add simple featured posts widget.
 */
require get_template_directory() . '/inc/widgets/class-newsbook-simple-featured-posts-widget.php';


/**
 * Widget assets for image upload
 *
 * @return void
 */
function newsbook_widget_assets() {
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'mfc-media-upload', get_template_directory_uri() . '/js/media-upload.js', array( 'jquery' ), NEWSBOOK_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'newsbook_widget_assets' );
