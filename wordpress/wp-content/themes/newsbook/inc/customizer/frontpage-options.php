<?php
/**
 * NewsBook Theme Customizer - Frontpage options
 *
 * @package NewsBook
 */

// Add Design Options panel.
$wp_customize->add_panel(
	'newsbook_frontpage_options',
	array(
		'capabitity'  => 'edit_theme_options',
		'description' => __( 'Change the Frontpage Settings', 'newsbook' ),
		'priority'    => 503,
		'title'       => __( 'Frontpage Options', 'newsbook' ),
	)
);

// Add frontpage general section.
$wp_customize->add_section(
	'newsbook_general_section',
	array(
		'title' => __( 'General Options', 'newsbook' ),
		'panel' => 'newsbook_frontpage_options',
	)
);

$wp_customize->add_setting(
	'newsbook_hide_frontpage_posts_page',
	array(
		'default'           => false,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'newsbook_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'newsbook_hide_frontpage_posts_page',
	array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to hide blog posts/static page on front page', 'newsbook' ),
		'section'  => 'newsbook_general_section',
		'settings' => 'newsbook_hide_frontpage_posts_page',
	)
);

$wp_customize->add_setting(
	'newsbook_show_banner_section',
	array(
		'default'           => true,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'newsbook_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	'newsbook_show_banner_section',
	array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to show Banner Section on front page', 'newsbook' ),
		'section'  => 'newsbook_general_section',
		'settings' => 'newsbook_show_banner_section',
	)
);


// Add frontpage banner featured section.
$wp_customize->add_section(
	'newsbook_banner_featured',
	array(
		'title' => __( 'Banner Featured Posts', 'newsbook' ),
		'panel' => 'newsbook_frontpage_options',
	)
);

$wp_customize->add_setting(
	'newsbook_banner_featured_category',
	array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new Newsbook_Dropdown_Category_Control(
		$wp_customize,
		'newsbook_banner_featured_category',
		array(
			'section'     => 'newsbook_banner_featured',
			'label'       => esc_html__( 'Featured Posts Category', 'newsbook' ),
			'description' => esc_html__( 'Select the category that the section will show posts from. If no category is selected, the latest 4 posts will be shown.', 'newsbook' ),
		)
	)
);
