<?php
/**
 * NewsBook Theme Customizer - Design options
 *
 * @package NewsBook
 */

// Add Design Options panel.
$wp_customize->add_panel(
	'newsbook_design_options',
	array(
		'capabitity'  => 'edit_theme_options',
		'description' => __( 'Change the Design Settings', 'newsbook' ),
		'priority'    => 504,
		'title'       => __( 'Design Options', 'newsbook' ),
	)
);

// Add site layout section.
$wp_customize->add_section(
	'newsbook_site_layout_section',
	array(
		'title' => __( 'Site Layout', 'newsbook' ),
		'panel' => 'newsbook_design_options',
	)
);

$wp_customize->add_setting(
	'newsbook_site_layout',
	array(
		'default'           => 'wide',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'newsbook_sanitize_radio',
	)
);
$wp_customize->add_control(
	'newsbook_site_layout',
	array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Site Layout:', 'newsbook' ),
		'section'  => 'newsbook_site_layout_section',
		'settings' => 'newsbook_site_layout',
		'choices'  => array(
			'wide'  => esc_html__( 'Wide Layout', 'newsbook' ),
			'boxed' => esc_html__( 'Boxed Layout', 'newsbook' ),
		),
	)
);


// Add primary color section.
$wp_customize->add_section(
	'newsbook_color_options_section',
	array(
		'title' => __( 'Color Options', 'newsbook' ),
		'panel' => 'newsbook_design_options',
	)
);

$wp_customize->add_setting(
	'newsbook_primary_color',
	array(
		'default'              => '#0d6efd',
		'capability'           => 'edit_theme_options',
		'sanitize_callback'    => 'sanitize_hex_color',
		'sanitize_js_callback' => 'newsbook_color_escaping_option_sanitize',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'newsbook_primary_color',
		array(
			'label'       => esc_html__( 'Select Primary Color:', 'newsbook' ),
			'description' => esc_html__( 'This will reflect in links, buttons and many other places. Choose a color to match your site.', 'newsbook' ),
			'section'     => 'newsbook_color_options_section',
			'settings'    => 'newsbook_primary_color',
			'priority'    => 1,
		)
	)
);

