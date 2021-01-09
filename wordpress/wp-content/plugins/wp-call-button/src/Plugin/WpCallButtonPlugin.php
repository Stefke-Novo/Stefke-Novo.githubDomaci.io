<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wpbeginner.com
 * @since      1.0.0
 *
 * @package    WpCallButton
 * @subpackage WpCallButton/Plugin
 */
namespace WpCallButton\Plugin;

class WpCallButtonPlugin {

	/**
	 * Holds the plugin name slug.
	 * @var string
	 */
	public $plugin_slug;

	/**
	 * Holds the plugin name.
	 * @var string
	 */
	public $plugin_name;

	/**
	 * Holds the plugin admin object.
	 * @var object
	 */
	public $plugin_admin;

	/**
	 * Holds the plugin settings array.
	 * @var object
	 */
	public $plugin_settings;

	/**
	 * Constructor.
	 */
	function __construct( $name, $slug ) {
		$this->plugin_slug = $slug;
		$this->plugin_name = $name;

		// Setup the plugin administration (for admin screen and settings).
		if ( is_admin() ) {
			new WpCallButtonAdmin( $this->plugin_name, $this->plugin_slug );
		}

		// Get the plugin settings.
		$this->plugin_settings = WpCallButtonHelpers::get_settings();

		// Setup initialization.
		$this->init();
	}

	/**
	 * Register all the necessary actions and perform setup.
	 */
	public function init() {
		// Print the call button in footer.
		add_action( 'wp_footer', [ $this, 'print_call_button' ] );

		// Print the call button styles in header.
		// Note: we could have printed the styles in the body just before
		// printing the call button HTML without worrying about FOUC (as it won't happen)
		// but we will skip it, just because.
		add_action( 'wp_head', [ $this, 'print_call_button_styles' ] );

		// Load text domain.
		add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );

		// Setup the Call button widget.
		add_action( 'widgets_init', [ $this, 'register_widgets' ] );

		// Register the WP Call Button shortcode.
		add_shortcode( 'wp_call_button', [ $this, 'wp_call_button_shortcode_func' ] );

		// Check if Gutenberg available.
		if ( has_action( 'enqueue_block_editor_assets' ) ) {

			// Enqueue the scripts for the custom Call block.
			add_action( 'init', [ $this, 'load_wpcb_block_files' ] );

			// Register the functions for rendering the Call Button dynamic block.
			add_action( 'init', [ $this, 'wp_call_button_block' ] );
		}
	}

	/**
	 * Enqueue guten block script.
	 */
	function load_wpcb_block_files() {
		/*
		 * Data for JavaScript and CSS files.
		 *
		 * This pulls in the data generated by @wordpress/dependency-extraction-webpack-plugin.
		 *
		 * The version hash takes in to account both the JavaScript and CSS files that are generated
		 * so can safely be used for both.
		 */
		$asset_details_path = plugin_dir_path( WP_CALL_BUTTON_FILE ) . 'assets/block/build/index.asset.php';
		// Fallback during development.
		$block_asset_data = [
			'dependencies' => [],
			'version'      => microtime(),
		];
		// Production/after build.
		if ( file_exists( $asset_details_path ) ) {
			$block_asset_data = include $asset_details_path;
		}
		$block_script_deps = $block_asset_data['dependencies'];
		$block_version     = $block_asset_data['version'];

		// Scripts.
		wp_register_script(
			'wp-call-btn-guten-blocks-script',
			plugin_dir_url( WP_CALL_BUTTON_FILE ) . 'assets/block/build/index.js',
			$block_script_deps,
			$block_version,
			true
		);
		wp_localize_script(
			'wp-call-btn-guten-blocks-script',
			'wpcallbtn_block_vars',
			[
				'plugin_name'         => $this->plugin_name,
				'data_call_btn_text'  => $this->plugin_settings['wpcallbtn_button_text'],
				'data_call_btn_phone' => WpCallButtonHelpers::get_phone_image(),
			]
		);

		// Styles.
		wp_register_style(
			'wp-call-btn-guten-blocks-style',
			plugins_url( 'assets/block/build/index.css', WP_CALL_BUTTON_FILE ),
			[],
			$block_version
		);
	}

	/**
	 * Setup a render callback to handle dynamic save / output for the Block.
	 */
	function wp_call_button_block() {
		if ( function_exists( 'register_block_type' ) ) {
			register_block_type(
				'wp-call-button/wp-call-button-block',
				[
					'style'           => 'wp-call-btn-guten-blocks-style',
					'editor_script'   => 'wp-call-btn-guten-blocks-script',
					'render_callback' => [ $this, 'wp_call_btn_dynamic_render_callback' ],
				]
			);
		}
	}

	/**
	 * HTML class attribute for rendering a call button block.
	 *
	 * @param string[] $attrs Attributes used for rendering call button block.
	 * @return string Space seperated list of HTML classes.
	 */
	function html_class_list( $attrs ) {
		$classes = [];

		// Default HTML class.
		$classes[] = 'wp-call-button-block-button';

		if ( $attrs['hide_phone_icon'] === 'yes' ) {
			$classes[] = 'wp-call-button-block-button-no-phone';
		}

		if ( ! empty( $attrs['btn_center_align'] ) && $attrs['btn_center_align'] ) {
			$classes[] = 'wp-call-button-block-button-center';
		}

		if ( ! empty( $attrs['className'] ) && $attrs['className'] ) {
			$classes = array_merge( $classes, explode( ' ', $attrs['className'] ) );
		}

		$classes = apply_filters( 'wp_call_button_block_html_classes', $classes );

		return join( ' ', array_map( 'sanitize_html_class', $classes ) );
	}

	/**
	 * Style attribute used for rendering a call button block.
	 *
	 * @param string[] $attrs Attributes used for rendering call button block.
	 * @return string Call button style attribute.
	 */
	function style_attributes( $attrs ) {
		$styles = [];

		if (
			! empty( $attrs['btn_txt_color'] ) &&
			$attrs['btn_txt_color'] !== '#fff' &&
			$attrs['btn_txt_color'] !== '#ffffff'
		) {
			$styles[] = "color:{$attrs['btn_txt_color']}";
		}

		if (
			! empty( $attrs['btn_color'] ) &&
			$attrs['btn_color'] !== '#269041'
		) {
			$styles[] = "background-color:{$attrs['btn_color']}";
		}

		if (
			! empty( $attrs['btn_font_size'] ) &&
			$attrs['btn_font_size'] !== '16px' &&
			preg_match( '/^[0-9]+[a-zA-Z]{2,}$/', $attrs['btn_font_size'] )
		) {
			$styles[] = "font-size:{$attrs['btn_font_size']}px";
		}

		return esc_attr( join( ';', $styles ) );
	}

	/**
	 * Dynamic render callback for the Call Button Block.
	 */
	function wp_call_btn_dynamic_render_callback( $attributes, $content ) {
		// Read the plugin settings.
		$settings = $this->plugin_settings;

		if (
			empty( $settings['wpcallbtn_phone_num'] )
		) {
			// Do not display disable/invalid button.
			return '';
		}

		// attributes
		$attrs = $attributes;

		// Set defaults from settings.
		if ( empty( $attrs['btn_text'] ) ) {
			$attrs['btn_text'] = $settings['wpcallbtn_button_text'];
		}
		if ( empty( $attrs['btn_color'] ) ) {
			$attrs['btn_color'] = sanitize_hex_color( $settings['wpcallbtn_button_color'] );
		}
		if ( empty( $attrs['btn_txt_color'] ) ) {
			$attrs['btn_txt_color'] = '#fff';
		}
		if ( empty( $attrs['hide_phone_icon'] ) ) {
			$attrs['hide_phone_icon'] = 'no';
		} else {
			if ( $attrs['hide_phone_icon'] ) {
				$attrs['hide_phone_icon'] = 'yes';
			} else {
				$attrs['hide_phone_icon'] = 'no';
			}
		}
		if ( empty( $attrs['btn_font_size'] ) ) {
			$attrs['btn_font_size'] = 16;
		}

		// Get the call button settings.
		$call_button = WpCallButtonHelpers::get_call_button( $settings );

		// Generate the HTML attributes.
		$class_list_safe       = esc_attr( $this->html_class_list( $attrs ) );
		$style_attr_safe       = esc_attr( $this->style_attributes( $attrs ) );
		$telephone_number_safe = esc_attr( $settings['wpcallbtn_phone_num'] );

		// Now create the markup.
		$markup  = "<p class='{$class_list_safe}'>";
		$markup .= "<a class='wp-call-button-in-btn' href='tel:{$telephone_number_safe}' style='{$style_attr_safe}' {$call_button['tracking']}>";

		if ( $attrs['hide_phone_icon'] === 'no' ) {
			$markup .= '<svg x="0px" y="0px" width="459px" height="459px" viewBox="0 0 459 459">
				<path
					d="M91.8,198.9c35.7,71.4,96.9,130.05,168.3,168.3L316.2,311.1c7.649-7.649,17.85-10.199,25.5-5.1c28.05,10.2,58.649,15.3,91.8,15.3c15.3,0,25.5,10.2,25.5,25.5v86.7c0,15.3-10.2,25.5-25.5,25.5C193.8,459,0,265.2,0,25.5C0,10.2,10.2,0,25.5,0h89.25c15.3,0,25.5,10.2,25.5,25.5c0,30.6,5.1,61.2,15.3,91.8c2.55,7.65,0,17.85-5.1,25.5L91.8,198.9z"
				/>
			</svg> '; // Maintain space at end to ensure the SVG doesn't bump up against the text.
		}

		$markup .= esc_html( $attrs['btn_text'] );

		$markup .= '</a>';
		$markup .= '</p>';

		/**
		 * Modify the frontend markup of a call button.
		 *
		 * @param string   Default markup for block editor.
		 * @param string[] Attributes used for displaying the button.
		 */
		return apply_filters( 'wp_call_button_block_markup', $markup, $attrs );
	}

	/**
	 * Register Call button plugin widget.
	 */
	function register_widgets() {
		register_widget( 'WpCallButton\Plugin\WpCallButtonWidget' );
	}

	/**
	 * Function to render the Call button via the shortcode.
	 */
	function wp_call_button_shortcode_func( $atts ) {
		// Read the plugin settings.
		$settings = $this->plugin_settings;

		// Read the attributes and set defaults.
		$attrs = shortcode_atts(
			[
				'btn_text'        => $settings['wpcallbtn_button_text'],
				'btn_color'       => $settings['wpcallbtn_button_color'],
				'hide_phone_icon' => 'false',
			],
			$atts
		);

		// Set defaults from settings.
		if ( empty( $attrs['btn_text'] ) ) {
			$attrs['btn_text'] = $settings['wpcallbtn_button_text'];
		}
		if ( empty( $attrs['btn_color'] ) ) {
			$attrs['btn_color'] = $settings['wpcallbtn_button_color'];
		}
		if ( empty( $attrs['hide_phone_icon'] ) ) {
			$attrs['hide_phone_icon'] = 'no';
		}

		// Get the call button.
		$call_button = WpCallButtonHelpers::get_call_button( $settings );

		// Get the call button text.
		$call_button_text = '<span>' . ( $attrs['hide_phone_icon'] === 'no' ? '<img style="width: 70px; height: 30px; vertical-align: middle; border: 0 !important; box-shadow: none !important; -webkit-box-shadow: none !important;" src="' . WpCallButtonHelpers::get_phone_image() . '" />' : '' ) . esc_html( $attrs['btn_text'] ) . '</span>';

		// Get the google analytics click tracking.
		$click_tracking = $call_button['tracking'];

		// Build the styles for the call button.
		$call_button_markup = 'display: inline-block; box-sizing: border-box; border-radius: 5px;' .
				'color: white !important; width: auto; text-align: center !important; font-size: 24px !important; ' .
			'font-weight: bold !important; ' .
				( $attrs['hide_phone_icon'] === 'no' ? 'padding: 15px 20px 15px 0 !important; ' : 'padding: 15px 20px !important;' ) .
				'text-decoration: none !important;' .
				'background: ' . esc_attr( $attrs['btn_color'] ) . ' !important;';

		// Return the call button.
		return ( $settings['wpcallbtn_button_enabled'] === 'yes' && ! empty( $settings['wpcallbtn_phone_num'] ) ) ? '<a style="' . $call_button_markup . '" class="' . $this->plugin_slug . '-in-btn" href="tel:' . esc_attr( $settings['wpcallbtn_phone_num'] ) . '"' . $click_tracking . '>' . $call_button_text . '</a>' : '';
	}

	/**
	 * Outputs the Call Button Styles on the website
	 */
	public function print_call_button_styles() {

		// Get the call button.
		$call_button = WpCallButtonHelpers::get_call_button( $this->plugin_settings );

		// Get the settings.
		$settings = $call_button['settings'];

		// Proceed if the call button should be shown.
		if ( $call_button['show_call_button'] ) {

			// Build the position style.
			$position = '';
			if ( $settings['wpcallbtn_button_position'] === 'bottom-left' ) {
				$position = ' left: 20px; ';
			} elseif ( $settings['wpcallbtn_button_position'] === 'bottom-right' ) {
				$position = ' right: 20px; ';
			} elseif ( $settings['wpcallbtn_button_position'] === 'bottom-center' ) {
				$position = ' left: 50%; margin-left: -30px; ';
			}

			$call_button_markup = '.' . $this->plugin_slug . '{display: block; position: fixed; text-decoration: none; z-index: 9999999999;' .
			'width: 60px; height: 60px; border-radius: 50%;' .
			'/*transform: scale(0.8);*/ ' . $position;

			// Special case for full width button.
			if ( $settings['wpcallbtn_button_position'] === 'bottom-full' ) {
				$call_button_markup .= 'background: ' . $settings['wpcallbtn_button_color'] . ' !important;' .
					' color: white !important; border-radius: 0; width: 100%; text-align: center !important; font-size: 24px !important; ' .
				' font-weight: bold !important; padding: 17px 0 0 0 !important; text-decoration: none !important;  bottom: 0; ';
			} else {
				$call_button_markup .= ' bottom: 20px; background: url( ' . WpCallButtonHelpers::get_phone_image() . ' ) center/30px 30px no-repeat ' . $settings['wpcallbtn_button_color'] . ' !important;';
			}

			// Finish markup.
			$call_button_markup .= '}';

			// Append media styles if displaying button only for mobile devices.
			if ( $settings['wpcallbtn_button_mobile_only'] === 'yes' ) {
				$call_button_markup = '.' . $this->plugin_slug . '{ display: none; } @media screen and (max-width: 650px) { ' . $call_button_markup . ' }';
			}

			// Print the styles.
			// TODO: Move to CSS file.
			// phpcs:ignore
			echo '<!-- This website uses the ' . $this->plugin_name . ' plugin to generate more leads. --><style type="text/css">' . $call_button_markup . '</style>';
		}
	}

	/**
	 * Outputs the Call Button on the website.
	 */
	public function print_call_button() {
		// Get the settings.
		$settings = $this->plugin_settings;

		// Get the call button.
		$call_button = WpCallButtonHelpers::get_call_button( $settings );

		// Proceed if the call button should be shown.
		if ( $call_button['show_call_button'] ) {

			// Get the google analytics click tracking.
			$click_tracking = $call_button['tracking'];

			// Get the call button text.
			$call_button_text = ( isset( $settings['wpcallbtn_button_position'] ) && $settings['wpcallbtn_button_position'] === 'bottom-full' ) ? '<span>' . esc_html( $settings['wpcallbtn_button_text'] ) . '</span>' : '';

			// Prepend the Call button if the Button style is full width.
			if ( $settings['wpcallbtn_button_position'] === 'bottom-full' ) {
				$call_button_text = '<img style="width: 70px; height: 30px; display: inline; vertical-align: middle; border: 0 !important; box-shadow: none !important; -webkit-box-shadow: none !important;" src="' . WpCallButtonHelpers::get_phone_image() . '" />' . $call_button_text;
			}

			// Build the call button html.
			// phpcs:ignore
			echo '<a class="' . esc_attr( $this->plugin_slug ) . '" href="tel:' . esc_attr( $settings['wpcallbtn_phone_num'] ) . '"' . $click_tracking . '>' . $call_button_text . '</a>';
		}
	}

	/**
	 * Load the text domain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( $this->plugin_slug, false, dirname( plugin_basename( WP_CALL_BUTTON_FILE ) ) . '/languages/' );
	}
}
