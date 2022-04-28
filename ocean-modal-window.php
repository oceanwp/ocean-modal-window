<?php
/**
 * Plugin Name:         Ocean Modal Window
 * Plugin URI:          https://oceanwp.org/extension/ocean-modal-window/
 * Description:         Insert any content in a modals and place the open button anywhere to open it.
 * Version:             2.0.5
 * Author:              OceanWP
 * Author URI:          https://oceanwp.org/
 * Requires at least:   5.3
 * Tested up to:        5.9.3
 *
 * Text Domain: ocean-modal-window
 * Domain Path: /languages
 *
 * @package Ocean_Modal_Window
 * @category Core
 * @author OceanWP
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the main instance of Ocean_Modal_Window to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Ocean_Modal_Window
 */
function Ocean_Modal_Window() {
	return Ocean_Modal_Window::instance();
} // End Ocean_Modal_Window()

Ocean_Modal_Window();

/**
 * Main Ocean_Modal_Window Class
 *
 * @class Ocean_Modal_Window
 * @version 1.0.0
 * @since 1.0.0
 * @package Ocean_Modal_Window
 */
final class Ocean_Modal_Window {
	/**
	 * Ocean_Modal_Window The single instance of Ocean_Modal_Window.
	 *
	 * @var     object
	 * @access  private
	 * @since   1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	// Admin - Start
	/**
	 * The admin object.
	 *
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * Constructor function.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct( $widget_areas = array() ) {
		$this->token       = 'ocean-modal-window';
		$this->plugin_url  = plugin_dir_url( __FILE__ );
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->version     = '2.0.5';

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'omw_load_plugin_textdomain' ) );

		add_action( 'init', array( $this, 'omw_setup' ) );

		add_action( 'init', array( $this, 'register_post_type' ), 0 );
	}

	/**
	 * Main Ocean_Modal_Window Instance
	 *
	 * Ensures only one instance of Ocean_Modal_Window is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Ocean_Modal_Window()
	 * @return Main Ocean_Modal_Window instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function omw_load_plugin_textdomain() {
		load_plugin_textdomain( 'ocean-modal-window', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Installation.
	 * Runs on activation. Logs the version number and assigns a notice message to a WordPress option.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install() {
		$this->_log_version_number();
	}

	/**
	 * Log the plugin version number.
	 *
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number() {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	}

	/**
	 * Setup all the things.
	 * Only executes if OceanWP or a child theme using OceanWP as a parent is active and the extension specific filter returns true.
	 *
	 * @return void
	 */
	public function omw_setup() {
		$theme = wp_get_theme();

		if ( 'OceanWP' == $theme->name || 'oceanwp' == $theme->template ) {
			add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 999 );
			add_filter( 'ocean_metaboxes_post_types_scripts', array( $this, 'post_type' ) );
			add_action( 'butterbean_register', array( $this, 'metabox' ), 10, 2 );
			add_action( 'add_meta_boxes_ocean_modal_window', array( $this, 'add_meta_box' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_fonts' ) );
			add_action( 'wp_footer', array( $this, 'modal_display' ) );
			add_filter( 'ocean_head_css', array( $this, 'head_css' ) );

			$capabilities = apply_filters( 'ocean_main_metaboxes_capabilities', 'manage_options' );
			if ( current_user_can( $capabilities ) ) {
				add_action( 'butterbean_register', array( $this, 'new_tab' ), 10, 2 );
			}
		}
	}

	/**
	 * Register custom post type
	 *
	 * @since  1.0.0
	 */
	public static function register_post_type() {
		register_post_type(
			'ocean_modal_window',
			apply_filters(
				'ocean_modal_window_args',
				array(
					'labels'              => array(
						'name'               => esc_html__( 'Modal', 'ocean-modal-window' ),
						'singular_name'      => esc_html__( 'Modal Item', 'ocean-modal-window' ),
						'add_new'            => esc_html__( 'Add New', 'ocean-modal-window' ),
						'add_new_item'       => esc_html__( 'Add New Item', 'ocean-modal-window' ),
						'edit_item'          => esc_html__( 'Edit Item', 'ocean-modal-window' ),
						'new_item'           => esc_html__( 'Add New Item', 'ocean-modal-window' ),
						'view_item'          => esc_html__( 'View Item', 'ocean-modal-window' ),
						'search_items'       => esc_html__( 'Search Items', 'ocean-modal-window' ),
						'not_found'          => esc_html__( 'No Items Found', 'ocean-modal-window' ),
						'not_found_in_trash' => esc_html__( 'No Items Found In Trash', 'ocean-modal-window' ),
					),
					'public'              => false,
					'has_archive'         => false,
					'hierarchical'        => false,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_admin_bar'   => false,
					'show_in_nav_menus'   => false,
					'can_export'          => true,
					'exclude_from_search' => true,
					'publicly_queryable'  => false,
					'capability_type'     => 'page',
					'menu_icon'           => 'dashicons-editor-expand',
					'menu_position'       => 20,
					'supports'            => array( 'title', 'editor' ),
				)
			)
		);
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since  1.0.0
	 */
	public function customize_preview_js() {
		wp_enqueue_script( 'omw-customizer', plugins_url( '/assets/js/customizer.min.js', __FILE__ ), array( 'customize-preview' ), '1.0', true );
		wp_localize_script(
			'omw-customizer',
			'oceanModalWindow',
			array(
				'googleFontsUrl' => '//fonts.googleapis.com',
			)
		);
	}

	/**
	 * Customizer Controls and settings
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @since  1.0.0
	 */
	public function customize_register( $wp_customize ) {

		/**
		 * Panel
		 */
		$panel = 'ocean_modal_window_panel';
		$wp_customize->add_panel(
			$panel,
			array(
				'title'    => esc_html__( 'Modal Window', 'ocean-modal-window' ),
				'priority' => 290,
			)
		);

		/**
		 * Section
		 */
		$wp_customize->add_section(
			'omw_general_section',
			array(
				'title'    => esc_html__( 'General', 'ocean-modal-window' ),
				'priority' => 10,
				'panel'    => $panel,
			)
		);

		/**
		 * Custom Width
		 */
		$wp_customize->add_setting(
			'omw_custom_width',
			array(
				'transport'         => 'postMessage',
				'default'           => '700',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Range_Control(
				$wp_customize,
				'omw_custom_width',
				array(
					'label'       => esc_html__( 'Custom Width (px)', 'ocean-modal-window' ),
					'section'     => 'omw_general_section',
					'settings'    => 'omw_custom_width',
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 200,
						'max'  => 1200,
						'step' => 1,
					),
				)
			)
		);

		/**
		 * Custom Height
		 */
		$wp_customize->add_setting(
			'omw_custom_height',
			array(
				'transport'         => 'postMessage',
				'default'           => '0',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Range_Control(
				$wp_customize,
				'omw_custom_height',
				array(
					'label'       => esc_html__( 'Custom Height (px)', 'ocean-modal-window' ),
					'section'     => 'omw_general_section',
					'settings'    => 'omw_custom_height',
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				)
			)
		);

		/**
		 * Background Image
		 */
		$wp_customize->add_setting(
			'omw_background_image',
			array(
				'transport'         => 'postMessage',
				'default'           => '',
				'sanitize_callback' => 'oceanwp_sanitize_image',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'omw_background_image',
				array(
					'label'    => esc_html__( 'Background Image', 'ocean-modal-window' ),
					'section'  => 'omw_general_section',
					'settings' => 'omw_background_image',
					'priority' => 10,
				)
			)
		);

		/**
		 * Section
		 */
		$wp_customize->add_section(
			'omw_styling_section',
			array(
				'title'    => esc_html__( 'Styling', 'ocean-modal-window' ),
				'priority' => 10,
				'panel'    => $panel,
			)
		);

		/**
		 * Padding
		 */
		$wp_customize->add_setting(
			'omw_padding',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_padding',
				array(
					'label'       => esc_html__( 'Padding', 'ocean-modal-window' ),
					'description' => esc_html__( 'Format: top right bottom left.', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_styling_section',
					'settings'    => 'omw_padding',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Border Width
		 */
		$wp_customize->add_setting(
			'omw_border_width',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_border_width',
				array(
					'label'       => esc_html__( 'Border Width', 'ocean-modal-window' ),
					'description' => esc_html__( 'Format: top right bottom left.', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_styling_section',
					'settings'    => 'omw_border_width',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Border Type
		 */
		$wp_customize->add_setting(
			'omw_border_type',
			array(
				'transport'         => 'postMessage',
				'default'           => 'solid',
				'sanitize_callback' => 'oceanwp_sanitize_select',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_border_type',
				array(
					'label'    => esc_html__( 'Border Type', 'ocean-modal-window' ),
					'type'     => 'select',
					'section'  => 'omw_styling_section',
					'settings' => 'omw_border_type',
					'priority' => 10,
					'choices'  => array(
						'solid'  => esc_html__( 'Solid', 'ocean-modal-window' ),
						'double' => esc_html__( 'Double', 'ocean-modal-window' ),
						'dotted' => esc_html__( 'Dotted', 'ocean-modal-window' ),
						'dashed' => esc_html__( 'Dashed', 'ocean-modal-window' ),
					),
				)
			)
		);

		/**
		 * Border Radius
		 */
		$wp_customize->add_setting(
			'omw_border_radius',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_border_radius',
				array(
					'label'       => esc_html__( 'Border Radius', 'ocean-modal-window' ),
					'description' => esc_html__( 'Format: top right bottom left.', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_styling_section',
					'settings'    => 'omw_border_radius',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Section
		 */
		$wp_customize->add_section(
			'omw_colors_section',
			array(
				'title'    => esc_html__( 'Colors', 'ocean-modal-window' ),
				'priority' => 10,
				'panel'    => $panel,
			)
		);

		/**
		 * Overlay Background Color
		 */
		$wp_customize->add_setting(
			'omw_overlay_bg',
			array(
				'transport'         => 'postMessage',
				'default'           => '#000000',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_overlay_bg',
				array(
					'label'    => esc_html__( 'Overlay Background Color', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_overlay_bg',
					'priority' => 10,
				)
			)
		);

		/**
		 * Overlay Opacity
		 */
		$wp_customize->add_setting(
			'omw_overlay_opacity',
			array(
				'transport'         => 'postMessage',
				'default'           => '0.9',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Range_Control(
				$wp_customize,
				'omw_overlay_opacity',
				array(
					'label'       => esc_html__( 'Overlay Opacity', 'ocean-modal-window' ),
					'section'     => 'omw_colors_section',
					'settings'    => 'omw_overlay_opacity',
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.1,
					),
				)
			)
		);

		/**
		 * Background Color
		 */
		$wp_customize->add_setting(
			'omw_modal_bg',
			array(
				'transport'         => 'postMessage',
				'default'           => '#ffffff',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_modal_bg',
				array(
					'label'    => esc_html__( 'Background Color', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_modal_bg',
					'priority' => 10,
				)
			)
		);

		/**
		 * Border Color
		 */
		$wp_customize->add_setting(
			'omw_modal_border_color',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_modal_border_color',
				array(
					'label'    => esc_html__( 'Border Color', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_modal_border_color',
					'priority' => 10,
				)
			)
		);

		/**
		 * Text Color
		 */
		$wp_customize->add_setting(
			'omw_modal_text_color',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_modal_text_color',
				array(
					'label'    => esc_html__( 'Text Color', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_modal_text_color',
					'priority' => 10,
				)
			)
		);

		/**
		 * Title Color
		 */
		$wp_customize->add_setting(
			'omw_modal_title_color',
			array(
				'transport'         => 'postMessage',
				'default'           => '#333333',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_modal_title_color',
				array(
					'label'    => esc_html__( 'Title Color', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_modal_title_color',
					'priority' => 10,
				)
			)
		);

		/**
		 * Close Button Background
		 */
		$wp_customize->add_setting(
			'omw_modal_close_btn_bg',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_modal_close_btn_bg',
				array(
					'label'    => esc_html__( 'Close Button Background', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_modal_close_btn_bg',
					'priority' => 10,
				)
			)
		);

		/**
		 * Close Button Hover Background
		 */
		$wp_customize->add_setting(
			'omw_modal_close_btn_hover_bg',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_modal_close_btn_hover_bg',
				array(
					'label'    => esc_html__( 'Close Button Hover Background', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_modal_close_btn_hover_bg',
					'priority' => 10,
				)
			)
		);

		/**
		 * Close Button Color
		 */
		$wp_customize->add_setting(
			'omw_modal_close_btn_color',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_modal_close_btn_color',
				array(
					'label'    => esc_html__( 'Close Button Color', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_modal_close_btn_color',
					'priority' => 10,
				)
			)
		);

		/**
		 * Close Button Hover Color
		 */
		$wp_customize->add_setting(
			'omw_modal_close_btn_hover_color',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'omw_modal_close_btn_hover_color',
				array(
					'label'    => esc_html__( 'Close Button Hover Color', 'oceanwp' ),
					'section'  => 'omw_colors_section',
					'settings' => 'omw_modal_close_btn_hover_color',
					'priority' => 10,
				)
			)
		);

		/**
		 * Section
		 */
		$wp_customize->add_section(
			'omw_typography_section',
			array(
				'title'    => esc_html__( 'Typography', 'ocean-modal-window' ),
				'priority' => 10,
				'panel'    => $panel,
			)
		);

		/**
		 * Font Size
		 */
		$wp_customize->add_setting(
			'omw_font_size',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_font_size',
				array(
					'label'       => esc_html__( 'Font Size', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom font size (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_typography_section',
					'settings'    => 'omw_font_size',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Font Family
		 */
		$wp_customize->add_setting(
			'omw_font_family',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Typography_Control(
				$wp_customize,
				'omw_font_family',
				array(
					'label'    => esc_html__( 'Font Family', 'ocean-modal-window' ),
					'type'     => 'select',
					'section'  => 'omw_typography_section',
					'settings' => 'omw_font_family',
					'priority' => 10,
				)
			)
		);

		/**
		 * Font Weight
		 */
		$wp_customize->add_setting(
			'omw_font_weight',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_select',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_font_weight',
				array(
					'label'       => esc_html__( 'Font Weight', 'ocean-modal-window' ),
					'description' => esc_html__( 'Important: Not all fonts support every font weight.', 'ocean-modal-window' ),
					'type'        => 'select',
					'section'     => 'omw_typography_section',
					'settings'    => 'omw_font_weight',
					'priority'    => 10,
					'choices'     => array(
						''    => esc_html__( 'Default', 'ocean-modal-window' ),
						'100' => esc_html__( 'Extra Light: 100', 'ocean-modal-window' ),
						'200' => esc_html__( 'Light: 200', 'ocean-modal-window' ),
						'300' => esc_html__( 'Book: 300', 'ocean-modal-window' ),
						'400' => esc_html__( 'Normal: 400', 'ocean-modal-window' ),
						'600' => esc_html__( 'Semibold: 600', 'ocean-modal-window' ),
						'700' => esc_html__( 'Bold: 700', 'ocean-modal-window' ),
						'800' => esc_html__( 'Extra Bold: 800', 'ocean-modal-window' ),
					),
				)
			)
		);

		/**
		 * Font Style
		 */
		$wp_customize->add_setting(
			'omw_font_style',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_select',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_font_style',
				array(
					'label'       => esc_html__( 'Font Style', 'ocean-modal-window' ),
					'description' => esc_html__( 'Select your custom font style.', 'ocean-modal-window' ),
					'type'        => 'select',
					'section'     => 'omw_typography_section',
					'settings'    => 'omw_font_style',
					'priority'    => 10,
					'choices'     => array(
						''       => esc_html__( 'Default', 'ocean-modal-window' ),
						'normal' => esc_html__( 'Normal', 'ocean-modal-window' ),
						'italic' => esc_html__( 'Italic', 'ocean-modal-window' ),
					),
				)
			)
		);

		/**
		 * Text Transform
		 */
		$wp_customize->add_setting(
			'omw_text_transform',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_select',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_text_transform',
				array(
					'label'       => esc_html__( 'Text Transform', 'ocean-modal-window' ),
					'description' => esc_html__( 'Select your custom text transform.', 'ocean-modal-window' ),
					'type'        => 'select',
					'section'     => 'omw_typography_section',
					'settings'    => 'omw_text_transform',
					'priority'    => 10,
					'choices'     => array(
						''           => esc_html__( 'Default', 'ocean-modal-window' ),
						'capitalize' => esc_html__( 'Capitalize', 'ocean-modal-window' ),
						'lowercase'  => esc_html__( 'Lowercase', 'ocean-modal-window' ),
						'uppercase'  => esc_html__( 'Uppercase', 'ocean-modal-window' ),
					),
				)
			)
		);

		/**
		 * Line Height
		 */
		$wp_customize->add_setting(
			'omw_line_height',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_line_height',
				array(
					'label'       => esc_html__( 'Line Height', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom line height (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_typography_section',
					'settings'    => 'omw_line_height',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Letter Spacing
		 */
		$wp_customize->add_setting(
			'omw_letter_spacing',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_letter_spacing',
				array(
					'label'       => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom letter spacing (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_typography_section',
					'settings'    => 'omw_letter_spacing',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Section
		 */
		$wp_customize->add_section(
			'omw_tablet_device_section',
			array(
				'title'    => esc_html__( 'Tablet Device', 'ocean-modal-window' ),
				'priority' => 10,
				'panel'    => $panel,
			)
		);

		/**
		 * Tablet Custom Width
		 */
		$wp_customize->add_setting(
			'omw_tablet_custom_width',
			array(
				'transport'         => 'postMessage',
				'default'           => '700',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Range_Control(
				$wp_customize,
				'omw_tablet_custom_width',
				array(
					'label'       => esc_html__( 'Custom Width (px)', 'ocean-modal-window' ),
					'section'     => 'omw_tablet_device_section',
					'settings'    => 'omw_tablet_custom_width',
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 200,
						'max'  => 1200,
						'step' => 1,
					),
				)
			)
		);

		/**
		 * Tablet Custom Height
		 */
		$wp_customize->add_setting(
			'omw_tablet_custom_height',
			array(
				'transport'         => 'postMessage',
				'default'           => '0',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Range_Control(
				$wp_customize,
				'omw_tablet_custom_height',
				array(
					'label'       => esc_html__( 'Custom Height (px)', 'ocean-modal-window' ),
					'section'     => 'omw_tablet_device_section',
					'settings'    => 'omw_tablet_custom_height',
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				)
			)
		);

		/**
		 * Tablet Padding
		 */
		$wp_customize->add_setting(
			'omw_tablet_padding',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_tablet_padding',
				array(
					'label'       => esc_html__( 'Padding', 'ocean-modal-window' ),
					'description' => esc_html__( 'Format: top right bottom left.', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_tablet_device_section',
					'settings'    => 'omw_tablet_padding',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Tablet Font Size
		 */
		$wp_customize->add_setting(
			'omw_tablet_font_size',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_tablet_font_size',
				array(
					'label'       => esc_html__( 'Font Size', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom font size (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_tablet_device_section',
					'settings'    => 'omw_tablet_font_size',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Tablet Line Height
		 */
		$wp_customize->add_setting(
			'omw_tablet_line_height',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_tablet_line_height',
				array(
					'label'       => esc_html__( 'Line Height', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom line height (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_tablet_device_section',
					'settings'    => 'omw_tablet_line_height',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Tablet Letter Spacing
		 */
		$wp_customize->add_setting(
			'omw_tablet_letter_spacing',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_tablet_letter_spacing',
				array(
					'label'       => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom letter spacing (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_tablet_device_section',
					'settings'    => 'omw_tablet_letter_spacing',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Section
		 */
		$wp_customize->add_section(
			'omw_mobile_device_section',
			array(
				'title'    => esc_html__( 'Mobile Device', 'ocean-modal-window' ),
				'priority' => 10,
				'panel'    => $panel,
			)
		);

		/**
		 * Mobile Custom Width
		 */
		$wp_customize->add_setting(
			'omw_mobile_custom_width',
			array(
				'transport'         => 'postMessage',
				'default'           => '700',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Range_Control(
				$wp_customize,
				'omw_mobile_custom_width',
				array(
					'label'       => esc_html__( 'Custom Width (px)', 'ocean-modal-window' ),
					'section'     => 'omw_mobile_device_section',
					'settings'    => 'omw_mobile_custom_width',
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 200,
						'max'  => 1200,
						'step' => 1,
					),
				)
			)
		);

		/**
		 * Mobile Custom Height
		 */
		$wp_customize->add_setting(
			'omw_mobile_custom_height',
			array(
				'transport'         => 'postMessage',
				'default'           => '0',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Range_Control(
				$wp_customize,
				'omw_mobile_custom_height',
				array(
					'label'       => esc_html__( 'Custom Height (px)', 'ocean-modal-window' ),
					'section'     => 'omw_mobile_device_section',
					'settings'    => 'omw_mobile_custom_height',
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				)
			)
		);

		/**
		 * Mobile Padding
		 */
		$wp_customize->add_setting(
			'omw_mobile_padding',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_mobile_padding',
				array(
					'label'       => esc_html__( 'Padding', 'ocean-modal-window' ),
					'description' => esc_html__( 'Format: top right bottom left.', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_mobile_device_section',
					'settings'    => 'omw_mobile_padding',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Mobile Font Size
		 */
		$wp_customize->add_setting(
			'omw_mobile_font_size',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_mobile_font_size',
				array(
					'label'       => esc_html__( 'Font Size', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom font size (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_mobile_device_section',
					'settings'    => 'omw_mobile_font_size',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Mobile Line Height
		 */
		$wp_customize->add_setting(
			'omw_mobile_line_height',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_mobile_line_height',
				array(
					'label'       => esc_html__( 'Line Height', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom line height (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_mobile_device_section',
					'settings'    => 'omw_mobile_line_height',
					'priority'    => 10,
				)
			)
		);

		/**
		 * Mobile Letter Spacing
		 */
		$wp_customize->add_setting(
			'omw_mobile_letter_spacing',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'omw_mobile_letter_spacing',
				array(
					'label'       => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
					'description' => esc_html__( 'Enter your custom letter spacing (px - em - rem).', 'ocean-modal-window' ),
					'type'        => 'text',
					'section'     => 'omw_mobile_device_section',
					'settings'    => 'omw_mobile_letter_spacing',
					'priority'    => 10,
				)
			)
		);

	}

	/**
	 * Enqueue scripts.
	 *
	 * @since  1.0.0
	 */
	public function enqueue_scripts() {

		// If Modal Window enabled
		if ( 'disable' === get_post_meta( oceanwp_post_id(), 'omw_enable_modal_window', true ) ) {
			return;
		}

		// Load Vendors Scripts.
		wp_enqueue_style( 'ow-perfect-scrollbar', plugins_url( '/assets/vendors/perfect-scrollbar/perfect-scrollbar.css', __FILE__ ) );
		wp_enqueue_script( 'ow-perfect-scrollbar', plugins_url( '/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js', __FILE__ ), array(), null, true );

		// Load Ocean Modal Window Scripts.
		wp_enqueue_style( 'omw-styles', plugins_url( '/assets/css/style.min.css', __FILE__ ) );
		wp_enqueue_script( 'omw-js-scripts', plugins_url( '/assets/js/modal-window.min.js', __FILE__ ), array( 'oceanwp-main', 'ow-perfect-scrollbar' ), $this->version, true );
	}

	/**
	 * Add post type
	 *
	 * @since 1.0.0
	 */
	public function post_type( $post_type ) {
		$post_type[] = 'ocean_modal_window';
		return $post_type;
	}

	/**
	 * Registration callback
	 *
	 * @since  1.0.0
	 */
	public function metabox( $butterbean, $post_type ) {

		if ( 'ocean_modal_window' !== $post_type ) {
			return;
		}

		// Register managers, sections, controls, and settings here.
		$butterbean->register_manager(
			'oceanwp_mw_settings',
			array(
				'label'     => esc_html__( 'Modal Settings', 'ocean-modal-window' ),
				'post_type' => 'ocean_modal_window',
				'context'   => 'normal',
				'priority'  => 'high',
			)
		);

		$manager = $butterbean->get_manager( 'oceanwp_mw_settings' );

		$manager->register_section(
			'oceanwp_mw_general',
			array(
				'label' => esc_html__( 'General', 'ocean-modal-window' ),
				'icon'  => 'dashicons-admin-tools',
			)
		);

		$manager->register_control(
			'oceanwp_mw_template', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_general',
				'type'        => 'select',
				'label'       => esc_html__( 'Select A Template', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select your template created in Theme Panel > My Library.', 'ocean-modal-window' ),
				'choices'     => $this->helpers( 'template' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_template', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$manager->register_control(
			'oceanwp_mw_title', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_general',
				'type'        => 'buttonset',
				'label'       => esc_html__( 'Display Title', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enable or disable the title.', 'ocean-modal-window' ),
				'choices'     => array(
					'on'  => esc_html__( 'Enable', 'ocean-modal-window' ),
					'off' => esc_html__( 'Disable', 'ocean-modal-window' ),
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_title', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
				'default'           => 'off',
			)
		);

		$manager->register_control(
			'oceanwp_mw_close_btn', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_general',
				'type'        => 'buttonset',
				'label'       => esc_html__( 'Display Close Button', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enable or disable the close button.', 'ocean-modal-window' ),
				'choices'     => array(
					'on'  => esc_html__( 'Enable', 'ocean-modal-window' ),
					'off' => esc_html__( 'Disable', 'ocean-modal-window' ),
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_close_btn', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
				'default'           => 'on',
			)
		);

		$manager->register_control(
			'oceanwp_mw_width', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_general',
				'type'        => 'range',
				'label'       => esc_html__( 'Custom Width', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom width for the modal. Default is 700px.', 'ocean-modal-window' ),
				'attr'        => array(
					'min'  => '200',
					'max'  => '1200',
					'step' => '1',
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_width', // Same as control name.
			array(
				'sanitize_callback' => array( $this, 'sanitize_absint' ),
				'default'           => '700',
			)
		);

		$manager->register_control(
			'oceanwp_mw_height', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_general',
				'type'        => 'range',
				'label'       => esc_html__( 'Custom Height', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom height for the modal. 0 equal auto height.', 'ocean-modal-window' ),
				'attr'        => array(
					'min'  => '0',
					'max'  => '1200',
					'step' => '1',
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_height', // Same as control name.
			array(
				'sanitize_callback' => array( $this, 'sanitize_absint' ),
				'default'           => '0',
			)
		);

		$manager->register_control(
			'oceanwp_mw_background_image', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_general',
				'type'        => 'image',
				'label'       => esc_html__( 'Background Image', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a custom image for your modal.', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_background_image', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$manager->register_section(
			'oceanwp_mw_styling',
			array(
				'label' => esc_html__( 'Styling', 'ocean-modal-window' ),
				'icon'  => 'dashicons-hammer',
			)
		);

		$manager->register_control(
			'oceanwp_mw_padding', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_styling',
				'type'        => 'text',
				'label'       => esc_html__( 'Padding', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom padding for the modal. ex: 20px 30px 20px 30px (Top Right Bottom Left). Default is 50px.', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_padding', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_border', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_styling',
				'type'        => 'text',
				'label'       => esc_html__( 'Border Width', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom border width for the modal. ex: 2px 1px 2px 1px (Top Right Bottom Left). Default is 0.', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_border', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_border_style', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_styling',
				'type'        => 'select',
				'label'       => esc_html__( 'Border Type', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select your border type if a border width is defined.', 'ocean-modal-window' ),
				'choices'     => array(
					'solid'  => esc_html__( 'Solid', 'ocean-modal-window' ),
					'double' => esc_html__( 'Double', 'ocean-modal-window' ),
					'dotted' => esc_html__( 'Dotted', 'ocean-modal-window' ),
					'dashed' => esc_html__( 'Dashed', 'ocean-modal-window' ),
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_border_style', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$manager->register_control(
			'oceanwp_mw_border_radius', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_styling',
				'type'        => 'text',
				'label'       => esc_html__( 'Border Radius', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom border radius for the modal.  ex: 2px 1px 2px 1px (Top Right Bottom Left). Default is 0.', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_border_radius', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_section(
			'oceanwp_mw_colors',
			array(
				'label' => esc_html__( 'Colors', 'ocean-modal-window' ),
				'icon'  => 'dashicons-admin-customizer',
			)
		);

		$manager->register_control(
			'oceanwp_mw_overlay_bg_color', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Overlay Background Color', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code for the modal overlay, ex: #333', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_overlay_bg_color', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
				'default'           => '#000000',
			)
		);

		$manager->register_control(
			'oceanwp_mw_overlay_opacity', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'range',
				'label'       => esc_html__( 'Overlay Opacity', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom opacity for the overlay. Default is 0.9.', 'ocean-modal-window' ),
				'attr'        => array(
					'min'  => '0.1',
					'max'  => '1',
					'step' => '0.1',
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_overlay_opacity', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '0.9',
			)
		);

		$manager->register_control(
			'oceanwp_mw_bg_color', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code for the modal background, ex: #333', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_bg_color', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
				'default'           => '#ffffff',
			)
		);

		$manager->register_control(
			'oceanwp_mw_border_color', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Border Color', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code, ex: #333', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_border_color', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
			)
		);

		$manager->register_control(
			'oceanwp_mw_text_color', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Text Color', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code, ex: #fff', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_text_color', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
			)
		);

		$manager->register_control(
			'oceanwp_mw_title_color', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Title Color', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code, ex: #fff', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_title_color', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
				'default'           => '#333333',
			)
		);

		$manager->register_control(
			'oceanwp_mw_close_btn_bg', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Close Button Background', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code, ex: #fe5252', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_close_btn_bg', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
			)
		);

		$manager->register_control(
			'oceanwp_mw_close_btn_hover_bg', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Close Button Hover Background', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code, ex: #222', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_close_btn_hover_bg', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
			)
		);

		$manager->register_control(
			'oceanwp_mw_close_btn_color', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Close Button Color', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code, ex: #fff', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_close_btn_color', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
			)
		);

		$manager->register_control(
			'oceanwp_mw_close_btn_hover_color', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_colors',
				'type'        => 'color',
				'label'       => esc_html__( 'Close Button Hover Color', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select a hex color code, ex: #fff', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_close_btn_hover_color', // Same as control name.
			array(
				'sanitize_callback' => 'butterbean_maybe_hash_hex_color',
			)
		);

		$manager->register_section(
			'oceanwp_mw_typography',
			array(
				'label' => esc_html__( 'Typography', 'ocean-modal-window' ),
				'icon'  => 'dashicons-edit',
			)
		);

		$manager->register_control(
			'oceanwp_mw_font_size', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_typography',
				'type'        => 'text',
				'label'       => esc_html__( 'Font Size', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom font size (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_font_size', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_font_family', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_typography',
				'type'        => 'select',
				'label'       => esc_html__( 'Font Family', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select your custom font.', 'ocean-modal-window' ),
				'choices'     => $this->helpers( 'typo' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_font_family', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_font_weight', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_typography',
				'type'        => 'select',
				'label'       => esc_html__( 'Font Weight', 'ocean-modal-window' ),
				'description' => esc_html__( 'Important: Not all fonts support every font weight.', 'ocean-modal-window' ),
				'choices'     => array(
					''    => esc_html__( 'Default', 'ocean-modal-window' ),
					'100' => esc_html__( 'Extra Light: 100', 'ocean-modal-window' ),
					'200' => esc_html__( 'Light: 200', 'ocean-modal-window' ),
					'300' => esc_html__( 'Book: 300', 'ocean-modal-window' ),
					'400' => esc_html__( 'Normal: 400', 'ocean-modal-window' ),
					'600' => esc_html__( 'Semibold: 600', 'ocean-modal-window' ),
					'700' => esc_html__( 'Bold: 700', 'ocean-modal-window' ),
					'800' => esc_html__( 'Extra Bold: 800', 'ocean-modal-window' ),
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_font_weight', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$manager->register_control(
			'oceanwp_mw_font_style', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_typography',
				'type'        => 'select',
				'label'       => esc_html__( 'Font Style', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select your custom font style.', 'ocean-modal-window' ),
				'choices'     => array(
					''       => esc_html__( 'Default', 'ocean-modal-window' ),
					'normal' => esc_html__( 'Normal', 'ocean-modal-window' ),
					'italic' => esc_html__( 'Italic', 'ocean-modal-window' ),
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_font_style', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$manager->register_control(
			'oceanwp_mw_text_transform', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_typography',
				'type'        => 'select',
				'label'       => esc_html__( 'Text Transform', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select your custom text transform.', 'ocean-modal-window' ),
				'choices'     => array(
					''           => esc_html__( 'Default', 'ocean-modal-window' ),
					'capitalize' => esc_html__( 'Capitalize', 'ocean-modal-window' ),
					'lowercase'  => esc_html__( 'Lowercase', 'ocean-modal-window' ),
					'uppercase'  => esc_html__( 'Uppercase', 'ocean-modal-window' ),
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_text_transform', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$manager->register_control(
			'oceanwp_mw_line_height', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_typography',
				'type'        => 'text',
				'label'       => esc_html__( 'Line Height', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom line height (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_line_height', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_letter_spacing', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_typography',
				'type'        => 'text',
				'label'       => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom letter spacing (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_letter_spacing', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_section(
			'oceanwp_mw_tablet_device',
			array(
				'label' => esc_html__( 'Tablet Device', 'ocean-modal-window' ),
				'icon'  => 'dashicons-tablet',
			)
		);

		$manager->register_control(
			'oceanwp_mw_tablet_width', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_tablet_device',
				'type'        => 'range',
				'label'       => esc_html__( 'Custom Width', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom width for the modal. Default is 700px.', 'ocean-modal-window' ),
				'attr'        => array(
					'min'  => '200',
					'max'  => '1200',
					'step' => '1',
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_tablet_width', // Same as control name.
			array(
				'sanitize_callback' => array( $this, 'sanitize_absint' ),
				'default'           => '700',
			)
		);

		$manager->register_control(
			'oceanwp_mw_tablet_height', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_tablet_device',
				'type'        => 'range',
				'label'       => esc_html__( 'Custom Height', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom height for the modal. 0 equal auto height.', 'ocean-modal-window' ),
				'attr'        => array(
					'min'  => '0',
					'max'  => '1200',
					'step' => '1',
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_tablet_height', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
				'default'           => '0',
			)
		);

		$manager->register_control(
			'oceanwp_mw_tablet_padding', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_tablet_device',
				'type'        => 'text',
				'label'       => esc_html__( 'Padding', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom padding for the modal. ex: 20px 30px 20px 30px (Top Right Bottom Left). Default is 50px.', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_tablet_padding', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_tablet_font_size', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_tablet_device',
				'type'        => 'text',
				'label'       => esc_html__( 'Font Size', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom font size (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_tablet_font_size', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_tablet_line_height', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_tablet_device',
				'type'        => 'text',
				'label'       => esc_html__( 'Line Height', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom line height (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_tablet_line_height', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_tablet_letter_spacing', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_tablet_device',
				'type'        => 'text',
				'label'       => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom letter spacing (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_tablet_letter_spacing', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_section(
			'oceanwp_mw_mobile_device',
			array(
				'label' => esc_html__( 'Mobile Device', 'ocean-modal-window' ),
				'icon'  => 'dashicons-smartphone',
			)
		);

		$manager->register_control(
			'oceanwp_mw_mobile_width', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_mobile_device',
				'type'        => 'range',
				'label'       => esc_html__( 'Custom Width', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom width for the modal. Default is 700px.', 'ocean-modal-window' ),
				'attr'        => array(
					'min'  => '200',
					'max'  => '1200',
					'step' => '1',
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_mobile_width', // Same as control name.
			array(
				'sanitize_callback' => array( $this, 'sanitize_absint' ),
				'default'           => '700',
			)
		);

		$manager->register_control(
			'oceanwp_mw_mobile_height', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_mobile_device',
				'type'        => 'range',
				'label'       => esc_html__( 'Custom Height', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom height for the modal. 0 equal auto height.', 'ocean-modal-window' ),
				'attr'        => array(
					'min'  => '0',
					'max'  => '1200',
					'step' => '1',
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_mobile_height', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
				'default'           => '0',
			)
		);

		$manager->register_control(
			'oceanwp_mw_mobile_padding', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_mobile_device',
				'type'        => 'text',
				'label'       => esc_html__( 'Padding', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom padding for the modal. ex: 20px 30px 20px 30px (Top Right Bottom Left). Default is 50px.', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_mobile_padding', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_mobile_font_size', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_mobile_device',
				'type'        => 'text',
				'label'       => esc_html__( 'Font Size', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom font size (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_mobile_font_size', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_mobile_line_height', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_mobile_device',
				'type'        => 'text',
				'label'       => esc_html__( 'Line Height', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom line height (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_mobile_line_height', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'oceanwp_mw_mobile_letter_spacing', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_mobile_device',
				'type'        => 'text',
				'label'       => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enter your custom letter spacing (px - em - rem).', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_mobile_letter_spacing', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

	}

	/**
	 * Add new tab in metabox.
	 *
	 * @since  1.0.0
	 */
	public function new_tab( $butterbean, $post_type ) {

		// Gets the manager object we want to add sections to.
		$manager = $butterbean->get_manager( 'oceanwp_mb_settings' );

		$manager->register_section(
			'oceanwp_mb_modal_window',
			array(
				'label' => esc_html__( 'Modal Window', 'ocean-modal-window' ),
				'icon'  => 'dashicons-editor-expand',
			)
		);

		$manager->register_control(
			'omw_enable_modal_window', // Same as setting name.
			array(
				'section'     => 'oceanwp_mb_modal_window',
				'type'        => 'buttonset',
				'label'       => esc_html__( 'Enable Modal Window For This Page', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enable or disable the modal window for this page.', 'ocean-modal-window' ),
				'choices'     => array(
					'enable'  => esc_html__( 'Enable', 'ocean-modal-window' ),
					'disable' => esc_html__( 'Disable', 'ocean-modal-window' ),
				),
			)
		);

		$manager->register_setting(
			'omw_enable_modal_window', // Same as control name.
			array(
				'default'           => 'enable',
				'sanitize_callback' => 'sanitize_key',
			)
		);
	}

	/**
	 * Sanitize function for integers
	 *
	 * @since  1.0.0
	 */
	public function sanitize_absint( $value ) {
		return $value && is_numeric( $value ) ? absint( $value ) : '';
	}

	/**
	 * Helpers
	 *
	 * @since  1.0.0
	 */
	public static function helpers( $return = null ) {

		// Return fonts array
		if ( 'typo' == $return ) {
			$fonts = array( esc_html__( 'Default', 'ocean-modal-window' ) );
			$id    = '';
			// Add custom fonts from child themes
			if ( function_exists( 'ocean_add_custom_fonts' ) ) {
				$get_fonts = ocean_add_custom_fonts();
				if ( $get_fonts && is_array( $get_fonts ) ) {
					foreach ( $get_fonts as $font ) {
						$fonts[ $font ] = $font;
					}
				}
			}

			// Get Standard font options
			if ( $std_fonts = oceanwp_standard_fonts() ) {
				foreach ( $std_fonts as $font ) {
					$fonts[ $font ] = $font;
				}
			}

			// Google font options
			if ( $google_fonts = oceanwp_google_fonts_array() ) {
				foreach ( $google_fonts as $font ) {
					$fonts[ $font ] = $font;
				}
			}

			return $fonts;
		}

		// Return template array
		elseif ( 'template' == $return ) {
			$templates     = array( esc_html__( 'Default', 'ocean-modal-window' ) );
			$get_templates = get_posts(
				array(
					'post_type'   => 'oceanwp_library',
					'numberposts' => -1,
					'post_status' => 'publish',
				)
			);

			if ( ! empty( $get_templates ) ) {
				foreach ( $get_templates as $template ) {
					$templates[ $template->ID ] = $template->post_title;
				}
			}

			return $templates;
		}

	}

	/**
	 * Display open modal link in metabox
	 *
	 * @since  1.0.0
	 */
	public function add_meta_box( $post ) {

		add_meta_box(
			'oceanwp-mw-open-link-metabox',
			esc_html__( 'Modal Link', 'ocean-modal-window' ),
			array( $this, 'display_meta_box' ),
			'ocean_modal_window',
			'side',
			'low'
		);

	}

	/**
	 * Display modal ID
	 *
	 * @since  1.0.0
	 */
	public function display_meta_box( $post ) { ?>

		<p><?php esc_html_e( 'This is the ID, class and the full link to open your modal.', 'ocean-modal-window' ); ?></p>

		<h4 style="margin-bottom:5px;"><?php esc_html_e( 'Modal ID:', 'ocean-modal-window' ); ?></h4>
		<input type="text" class="widefat" value='#omw-<?php echo $post->ID; ?>' readonly />

		<h4 style="margin-bottom:5px;"><?php esc_html_e( 'Link Class:', 'ocean-modal-window' ); ?></h4>
		<input type="text" class="widefat" value='omw-open-modal' readonly />

		<h4 style="margin-bottom:5px;"><?php esc_html_e( 'Full Link:', 'ocean-modal-window' ); ?></h4>
		<input type="text" class="widefat" value='<a href="#omw-<?php echo $post->ID; ?>" class="omw-open-modal">Open Modal</a>' readonly />

		<?php
	}

	/**
	 * Loads Google fonts
	 *
	 * @since  1.0.0
	 */
	public function load_fonts() {

		$query = new WP_Query(
			array(
				'post_type'      => 'ocean_modal_window',
				'posts_per_page' => -1,
			)
		);

		if ( $query->have_posts() ) :

			while ( $query->have_posts() ) :
				$query->the_post();

				// Get fonts
				$fonts = array();
				$val   = get_theme_mod( 'omw_font_family' );
				if ( $meta = get_post_meta( get_the_ID(), 'oceanwp_mw_font_family', true ) ) {
					$val = $meta;
				}

				// If there is a value lets do something
				if ( $val ) {

					// Sanitize
					$val = str_replace( '"', '', $val );

					$fonts[] = $val;

				}

				// Loop through and enqueue fonts
				if ( ! empty( $fonts ) && is_array( $fonts ) ) {
					foreach ( $fonts as $font ) {
						oceanwp_enqueue_google_font( $font );
					}
				}

			endwhile;

			wp_reset_postdata();

		endif;

	}

	/**
	 * Display the modal in the footer
	 *
	 * @since  1.0.0
	 */
	public function modal_display() {

		// If Modal Window enabled
		if ( 'disable' === get_post_meta( oceanwp_post_id(), 'omw_enable_modal_window', true ) ) {
			return;
		}

		$query = new WP_Query(
			array(
				'post_type'      => 'ocean_modal_window',
				'posts_per_page' => -1,
			)
		);

		if ( $query->have_posts() ) :

			while ( $query->have_posts() ) :
				$query->the_post();

				// Get the template
				$templates = get_post_meta( get_the_ID(), 'oceanwp_mw_template', true );
				$templates = $templates ? $templates : '';

				// Vars
				$title     = get_post_meta( get_the_ID(), 'oceanwp_mw_title', true );
				$title     = $title ? $title : 'off';
				$close_btn = get_post_meta( get_the_ID(), 'oceanwp_mw_close_btn', true );
				$close_btn = $close_btn ? $close_btn : 'on';
				?>

				<div id="omw-<?php echo esc_attr( get_the_ID() ); ?>" class="omw-modal">

					<?php
					// Title
					if ( 'on' == $title ) {
						?>
						<h2 class="omw-modal-title"><?php the_title(); ?></h2>
						<?php
					}

					// Close button
					if ( 'on' == $close_btn ) {
						?>
						<a href="#" class="omw-close-modal"></a>
					<?php } ?>

					<div class="omw-modal-inner clr">
						<?php
						// Display content
						if ( ! empty( $templates ) ) {
							include $this->plugin_path . 'template/template.php';
						} else {
							the_content();
						}
						?>
					 </div>

				</div>

				<?php
				// Styling vars
				$modal_width           = get_post_meta( get_the_ID(), 'oceanwp_mw_width', true );
				$modal_height          = get_post_meta( get_the_ID(), 'oceanwp_mw_height', true );
				$modal_img             = get_post_meta( get_the_ID(), 'oceanwp_mw_background_image', true );
				$modal_padding         = get_post_meta( get_the_ID(), 'oceanwp_mw_padding', true );
				$modal_border          = get_post_meta( get_the_ID(), 'oceanwp_mw_border', true );
				$modal_border_style    = get_post_meta( get_the_ID(), 'oceanwp_mw_border_style', true );
				$modal_border_color    = get_post_meta( get_the_ID(), 'oceanwp_mw_border_color', true );
				$modal_border_radius   = get_post_meta( get_the_ID(), 'oceanwp_mw_border_radius', true );
				$overlay_bg            = get_post_meta( get_the_ID(), 'oceanwp_mw_overlay_bg_color', true );
				$overlay_opacity       = get_post_meta( get_the_ID(), 'oceanwp_mw_overlay_opacity', true );
				$modal_bg              = get_post_meta( get_the_ID(), 'oceanwp_mw_bg_color', true );
				$modal_color           = get_post_meta( get_the_ID(), 'oceanwp_mw_text_color', true );
				$title_color           = get_post_meta( get_the_ID(), 'oceanwp_mw_title_color', true );
				$close_btn_bg          = get_post_meta( get_the_ID(), 'oceanwp_mw_close_btn_bg', true );
				$close_btn_hover_bg    = get_post_meta( get_the_ID(), 'oceanwp_mw_close_btn_hover_bg', true );
				$close_btn_color       = get_post_meta( get_the_ID(), 'oceanwp_mw_close_btn_color', true );
				$close_btn_hover_color = get_post_meta( get_the_ID(), 'oceanwp_mw_close_btn_hover_color', true );
				$font_size             = get_post_meta( get_the_ID(), 'oceanwp_mw_font_size', true );
				$font_family           = get_post_meta( get_the_ID(), 'oceanwp_mw_font_family', true );
				$font_weight           = get_post_meta( get_the_ID(), 'oceanwp_mw_font_weight', true );
				$font_style            = get_post_meta( get_the_ID(), 'oceanwp_mw_font_style', true );
				$text_transform        = get_post_meta( get_the_ID(), 'oceanwp_mw_text_transform', true );
				$line_height           = get_post_meta( get_the_ID(), 'oceanwp_mw_line_height', true );
				$letter_spacing        = get_post_meta( get_the_ID(), 'oceanwp_mw_letter_spacing', true );

				// Responsive
				$tablet_modal_width    = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_width', true );
				$tablet_modal_height   = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_height', true );
				$tablet_modal_padding  = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_padding', true );
				$tablet_font_size      = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_font_size', true );
				$tablet_line_height    = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_line_height', true );
				$tablet_letter_spacing = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_letter_spacing', true );
				$mobile_modal_width    = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_width', true );
				$mobile_modal_height   = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_height', true );
				$mobile_modal_padding  = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_padding', true );
				$mobile_font_size      = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_font_size', true );
				$mobile_line_height    = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_line_height', true );
				$mobile_letter_spacing = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_letter_spacing', true );

				// Define css var
				$css         = '';
				$main_css    = '';
				$typo_css    = '';
				$overlay_css = '';
				$tablet_css  = '';
				$mobile_css  = '';

				// Add modal width
				if ( ! empty( $modal_width ) && '700' != $modal_width ) {
					$main_css .= 'width:' . $modal_width . 'px;';
				}

				// Add modal height
				if ( ! empty( $modal_height ) && '0' != $modal_height ) {
					$main_css .= 'height:' . $modal_height . 'px;';
				}

				// Add modal background image
				if ( ! empty( $modal_img ) ) {

					// Generate image URL from ID
					if ( is_numeric( $modal_img ) ) {
						$modal_img = wp_get_attachment_image_src( $modal_img, 'full' );
						$modal_img = $modal_img[0];
					}

					$modal_img = $modal_img ? $modal_img : null;

					$main_css .= 'background-image: url(' . $modal_img . '); background-position: center center; background-repeat: no-repeat; background-size: cover;';
				}

				// Add modal padding
				if ( ! empty( $modal_padding ) ) {
					$main_css .= 'padding:' . $modal_padding . ';';
				}

				// Add modal border
				if ( ! empty( $modal_border ) ) {

					// Add modal border width
					$main_css .= 'border-width:' . $modal_border . ';';

					// Add modal border style if border is defined
					if ( ! empty( $modal_border_style ) ) {
						$main_css .= 'border-style:' . $modal_border_style . ';';
					}

					// Add modal border color if border is defined
					if ( ! empty( $modal_border_color ) ) {
						$main_css .= 'border-color:' . $modal_border_color . ';';
					}
				}

				// Add modal border radius
				if ( ! empty( $modal_border_radius ) ) {
					$main_css .= 'border-radius:' . $modal_border_radius . ';';
				}

				// Add modal background
				if ( ! empty( $modal_bg ) && '#ffffff' != $modal_bg ) {
					$main_css .= 'background-color:' . $modal_bg . ';';
				}

				// Add modal text color
				if ( ! empty( $modal_color ) ) {
					$main_css .= 'color:' . $modal_color . ';';
				}

				// Main css
				if ( ! empty( $modal_width ) && '700' != $modal_width
					|| ! empty( $modal_height ) && '0' != $modal_height
					|| ! empty( $modal_img )
					|| ! empty( $modal_padding )
					|| ! empty( $modal_border )
					|| ! empty( $modal_border ) && ! empty( $modal_border_style )
					|| ! empty( $modal_border ) && ! empty( $modal_border_color )
					|| ! empty( $modal_border_radius )
					|| ! empty( $modal_bg ) && '#ffffff' != $modal_bg
					|| ! empty( $modal_color ) ) {
					$css .= '#omw-' . esc_attr( get_the_ID() ) . '{' . $main_css . '}';
				}

				// Add modal font size
				if ( ! empty( $font_size ) ) {
					$typo_css .= 'font-size:' . $font_size . ';';
				}

				// Add modal font family
				if ( ! empty( $font_family ) ) {
					$typo_css .= 'font-family:' . $font_family . ';';
				}

				// Add modal font weight
				if ( ! empty( $font_weight ) ) {
					$typo_css .= 'font-weight:' . $font_weight . ';';
				}

				// Add modal font style
				if ( ! empty( $font_style ) ) {
					$typo_css .= 'font-style:' . $font_style . ';';
				}

				// Add modal text transform
				if ( ! empty( $text_transform ) ) {
					$typo_css .= 'text-transform:' . $text_transform . ';';
				}

				// Add modal line height
				if ( ! empty( $line_height ) ) {
					$typo_css .= 'line-height:' . $line_height . ';';
				}

				// Add modal letter spacing
				if ( ! empty( $letter_spacing ) ) {
					$typo_css .= 'letter-spacing:' . $letter_spacing . ';';
				}

				// Typography css
				if ( ! empty( $font_size )
					|| ! empty( $font_family )
					|| ! empty( $font_weight )
					|| ! empty( $font_style )
					|| ! empty( $text_transform )
					|| ! empty( $line_height )
					|| ! empty( $letter_spacing ) ) {
					$css .= '#omw-' . esc_attr( get_the_ID() ) . '{' . $typo_css . '}';
				}

				// Add overlay background
				if ( ! empty( $overlay_bg ) && '#000000' != $overlay_bg ) {
					$overlay_css .= 'background-color:' . $overlay_bg . ';';
				}

				// Add overlay opacity
				if ( ! empty( $overlay_opacity ) && '0.9' != $overlay_opacity ) {
					$overlay_css .= 'opacity:' . $overlay_opacity . ';';
				}

				// Overlay css
				if ( ! empty( $overlay_bg ) && '#000000' != $overlay_bg
					|| ! empty( $overlay_opacity ) && '0.9' != $overlay_opacity ) {
					$css .= 'body.omw-' . esc_attr( get_the_ID() ) . ' .omw-modal-overlay{' . $overlay_css . '}';
				}

				// Add title color
				if ( ! empty( $title_color ) && '#333333' != $title_color ) {
					$css .= '#omw-' . esc_attr( get_the_ID() ) . ' h2{color:' . $title_color . ';}';
				}

				// Add close button background color
				if ( ! empty( $close_btn_bg ) ) {
					$css .= '#omw-' . esc_attr( get_the_ID() ) . ' .omw-close-modal{background-color:' . $close_btn_bg . ';}';
				}

				// Add close button hover background color
				if ( ! empty( $close_btn_hover_bg ) ) {
					$css .= '#omw-' . esc_attr( get_the_ID() ) . ' .omw-close-modal:hover{background-color:' . $close_btn_hover_bg . ';}';
				}

				// Add close button color
				if ( ! empty( $close_btn_color ) ) {
					$css .= '#omw-' . esc_attr( get_the_ID() ) . ' .omw-close-modal:before,#omw-' . esc_attr( get_the_ID() ) . ' .omw-close-modal:after{background-color:' . $close_btn_color . ';}';
				}

				// Add close button hover color
				if ( ! empty( $close_btn_hover_color ) ) {
					$css .= '#omw-' . esc_attr( get_the_ID() ) . ' .omw-close-modal:hover:before,#omw-' . esc_attr( get_the_ID() ) . ' .omw-close-modal:hover:after{background-color:' . $close_btn_hover_color . ';}';
				}

				// Tablet modal width
				if ( ! empty( $tablet_modal_width ) && '700' != $tablet_modal_width ) {
					$tablet_css .= 'width:' . $tablet_modal_width . 'px;';
				}

				// Tablet modal height
				if ( ! empty( $tablet_modal_height ) && '0' != $tablet_modal_height ) {
					$tablet_css .= 'height:' . $tablet_modal_height . 'px;';
				}

				// Tablet modal padding
				if ( ! empty( $tablet_modal_padding ) ) {
					$tablet_css .= 'padding:' . $tablet_modal_padding . ';';
				}

				// Tablet modal font size
				if ( ! empty( $tablet_font_size ) ) {
					$tablet_css .= 'font-size:' . $tablet_font_size . ';';
				}

				// Tablet modal line height
				if ( ! empty( $tablet_line_height ) ) {
					$tablet_css .= 'line-height:' . $tablet_line_height . ';';
				}

				// Tablet modal letter spacing
				if ( ! empty( $tablet_letter_spacing ) ) {
					$tablet_css .= 'letter-spacing:' . $tablet_letter_spacing . ';';
				}

				// Responsive tablet
				if ( ! empty( $tablet_modal_width ) && '700' != $tablet_modal_width
					|| ! empty( $tablet_modal_height ) && '0' != $tablet_modal_height
					|| ! empty( $tablet_modal_padding )
					|| ! empty( $tablet_font_size )
					|| ! empty( $tablet_line_height )
					|| ! empty( $tablet_letter_spacing ) ) {
					$css .= '@media (max-width: 1023px) {#omw-' . esc_attr( get_the_ID() ) . '{' . $tablet_css . '}}';
				}

				// Mobile modal width
				if ( ! empty( $mobile_modal_width ) && '700' != $mobile_modal_width ) {
					$mobile_css .= 'width:' . $mobile_modal_width . 'px;';
				}

				// Mobile modal height
				if ( ! empty( $mobile_modal_height ) && '0' != $mobile_modal_height ) {
					$mobile_css .= 'height:' . $mobile_modal_height . 'px;';
				}

				// Mobile modal padding
				if ( ! empty( $mobile_modal_padding ) ) {
					$mobile_css .= 'padding:' . $mobile_modal_padding . ';';
				}

				// Mobile modal font size
				if ( ! empty( $mobile_font_size ) ) {
					$mobile_css .= 'font-size:' . $mobile_font_size . ';';
				}

				// Mobile modal line height
				if ( ! empty( $mobile_line_height ) ) {
					$mobile_css .= 'line-height:' . $mobile_line_height . ';';
				}

				// Mobile modal letter spacing
				if ( ! empty( $mobile_letter_spacing ) ) {
					$mobile_css .= 'letter-spacing:' . $mobile_letter_spacing . ';';
				}

				// Responsive mobile
				if ( ! empty( $mobile_modal_width ) && '700' != $mobile_modal_width
					|| ! empty( $mobile_modal_height ) && '0' != $mobile_modal_height
					|| ! empty( $mobile_modal_padding )
					|| ! empty( $mobile_font_size )
					|| ! empty( $mobile_line_height )
					|| ! empty( $mobile_letter_spacing ) ) {
					$css .= '@media (max-width: 767px) {#omw-' . esc_attr( get_the_ID() ) . '{' . $mobile_css . '}}';
				}

				if ( ! empty( $css ) ) {
					?>

					<style type="text/css"><?php echo wp_strip_all_tags( oceanwp_minify_css( $css ) ); ?></style>

					<?php
				}

			endwhile;

			// Overlay
			?>
			<div class="omw-modal-overlay"></div>

			<?php
			wp_reset_postdata();

		endif;

	}

	/**
	 * Add css in head tag.
	 *
	 * @since  1.0.0
	 */
	public function head_css( $output ) {

		// Styling vars
		$modal_width           = get_theme_mod( 'omw_custom_width', '700' );
		$modal_height          = get_theme_mod( 'omw_custom_height', '0' );
		$modal_img             = get_theme_mod( 'omw_background_image' );
		$modal_padding         = get_theme_mod( 'omw_padding' );
		$modal_border          = get_theme_mod( 'omw_border_width' );
		$modal_border_style    = get_theme_mod( 'omw_border_type' );
		$modal_border_color    = get_theme_mod( 'omw_modal_border_color' );
		$modal_border_radius   = get_theme_mod( 'omw_border_radius' );
		$overlay_bg            = get_theme_mod( 'omw_overlay_bg', '#000000' );
		$overlay_opacity       = get_theme_mod( 'omw_overlay_opacity', '0.9' );
		$modal_bg              = get_theme_mod( 'omw_modal_bg', '#ffffff' );
		$modal_color           = get_theme_mod( 'omw_modal_text_color' );
		$title_color           = get_theme_mod( 'omw_modal_title_color', '#333333' );
		$close_btn_bg          = get_theme_mod( 'omw_modal_close_btn_bg' );
		$close_btn_hover_bg    = get_theme_mod( 'omw_modal_close_btn_hover_bg' );
		$close_btn_color       = get_theme_mod( 'omw_modal_close_btn_color' );
		$close_btn_hover_color = get_theme_mod( 'omw_modal_close_btn_hover_color' );
		$font_size             = get_theme_mod( 'omw_font_size' );
		$font_family           = get_theme_mod( 'omw_font_family' );
		$font_weight           = get_theme_mod( 'omw_font_weight' );
		$font_style            = get_theme_mod( 'omw_font_style' );
		$text_transform        = get_theme_mod( 'omw_text_transform' );
		$line_height           = get_theme_mod( 'omw_line_height' );
		$letter_spacing        = get_theme_mod( 'omw_letter_spacing' );

		// Responsive
		$tablet_modal_width    = get_theme_mod( 'omw_tablet_custom_width', '700' );
		$tablet_modal_height   = get_theme_mod( 'omw_tablet_custom_height', '0' );
		$tablet_modal_padding  = get_theme_mod( 'omw_tablet_padding' );
		$tablet_font_size      = get_theme_mod( 'omw_tablet_font_size' );
		$tablet_line_height    = get_theme_mod( 'omw_tablet_line_height' );
		$tablet_letter_spacing = get_theme_mod( 'omw_tablet_letter_spacing' );
		$mobile_modal_width    = get_theme_mod( 'omw_mobile_custom_width', '700' );
		$mobile_modal_height   = get_theme_mod( 'omw_mobile_custom_height', '0' );
		$mobile_modal_padding  = get_theme_mod( 'omw_mobile_padding' );
		$mobile_font_size      = get_theme_mod( 'omw_mobile_font_size' );
		$mobile_line_height    = get_theme_mod( 'omw_mobile_line_height' );
		$mobile_letter_spacing = get_theme_mod( 'omw_mobile_letter_spacing' );

		// Define css var
		$css         = '';
		$main_css    = '';
		$typo_css    = '';
		$overlay_css = '';
		$tablet_css  = '';
		$mobile_css  = '';

		// Add modal width
		if ( ! empty( $modal_width ) && '700' != $modal_width ) {
			$main_css .= 'width:' . $modal_width . 'px;';
		}

		// Add modal height
		if ( ! empty( $modal_height ) && '0' != $modal_height ) {
			$main_css .= 'height:' . $modal_height . 'px;';
		}

		// Add modal background image
		if ( ! empty( $modal_img ) ) {

			// Generate image URL from ID
			if ( is_numeric( $modal_img ) ) {
				$modal_img = wp_get_attachment_image_src( $modal_img, 'full' );
				$modal_img = $modal_img[0];
			}

			$modal_img = $modal_img ? $modal_img : null;

			$main_css .= 'background-image: url(' . $modal_img . '); background-position: center center; background-repeat: no-repeat; background-size: cover;';
		}

		// Add modal padding
		if ( ! empty( $modal_padding ) ) {
			$main_css .= 'padding:' . $modal_padding . ';';
		}

		// Add modal border
		if ( ! empty( $modal_border ) ) {

			// Add modal border width
			$main_css .= 'border-width:' . $modal_border . ';';

			// Add modal border style if border is defined
			if ( ! empty( $modal_border_style ) ) {
				$main_css .= 'border-style:' . $modal_border_style . ';';
			}

			// Add modal border color if border is defined
			if ( ! empty( $modal_border_color ) ) {
				$main_css .= 'border-color:' . $modal_border_color . ';';
			}
		}

		// Add modal border radius
		if ( ! empty( $modal_border_radius ) ) {
			$main_css .= 'border-radius:' . $modal_border_radius . ';';
		}

		// Add modal background
		if ( ! empty( $modal_bg ) && '#ffffff' != $modal_bg ) {
			$main_css .= 'background-color:' . $modal_bg . ';';
		}

		// Add modal text color
		if ( ! empty( $modal_color ) ) {
			$main_css .= 'color:' . $modal_color . ';';
		}

		// Main css
		if ( ! empty( $modal_width ) && '700' != $modal_width
			|| ! empty( $modal_height ) && '0' != $modal_height
			|| ! empty( $modal_img )
			|| ! empty( $modal_padding )
			|| ! empty( $modal_border )
			|| ! empty( $modal_border ) && ! empty( $modal_border_style )
			|| ! empty( $modal_border ) && ! empty( $modal_border_color )
			|| ! empty( $modal_border_radius )
			|| ! empty( $modal_bg ) && '#ffffff' != $modal_bg
			|| ! empty( $modal_color ) ) {
			$css .= '.omw-modal{' . $main_css . '}';
		}

		// Add modal font size
		if ( ! empty( $font_size ) ) {
			$typo_css .= 'font-size:' . $font_size . ';';
		}

		// Add modal font family
		if ( ! empty( $font_family ) ) {
			$typo_css .= 'font-family:' . $font_family . ';';
		}

		// Add modal font weight
		if ( ! empty( $font_weight ) ) {
			$typo_css .= 'font-weight:' . $font_weight . ';';
		}

		// Add modal font style
		if ( ! empty( $font_style ) ) {
			$typo_css .= 'font-style:' . $font_style . ';';
		}

		// Add modal text transform
		if ( ! empty( $text_transform ) ) {
			$typo_css .= 'text-transform:' . $text_transform . ';';
		}

		// Add modal line height
		if ( ! empty( $line_height ) ) {
			$typo_css .= 'line-height:' . $line_height . ';';
		}

		// Add modal letter spacing
		if ( ! empty( $letter_spacing ) ) {
			$typo_css .= 'letter-spacing:' . $letter_spacing . ';';
		}

		// Typography css
		if ( ! empty( $font_size )
			|| ! empty( $font_family )
			|| ! empty( $font_weight )
			|| ! empty( $font_style )
			|| ! empty( $text_transform )
			|| ! empty( $line_height )
			|| ! empty( $letter_spacing ) ) {
			$css .= '.omw-modal{' . $typo_css . '}';
		}

		// Add overlay background
		if ( ! empty( $overlay_bg ) && '#000000' != $overlay_bg ) {
			$overlay_css .= 'background-color:' . $overlay_bg . ';';
		}

		// Add overlay opacity
		if ( ! empty( $overlay_opacity ) && '0.9' != $overlay_opacity ) {
			$overlay_css .= 'opacity:' . $overlay_opacity . ';';
		}

		// Overlay css
		if ( ! empty( $overlay_bg ) && '#000000' != $overlay_bg
			|| ! empty( $overlay_opacity ) && '0.9' != $overlay_opacity ) {
			$css .= '.omw-modal-overlay{' . $overlay_css . '}';
		}

		// Add title color
		if ( ! empty( $title_color ) && '#333333' != $title_color ) {
			$css .= '.omw-modal h2{color:' . $title_color . ';}';
		}

		// Add close button background color
		if ( ! empty( $close_btn_bg ) ) {
			$css .= '.omw-modal .omw-close-modal{background-color:' . $close_btn_bg . ';}';
		}

		// Add close button hover background color
		if ( ! empty( $close_btn_hover_bg ) ) {
			$css .= '.omw-modal .omw-close-modal:hover{background-color:' . $close_btn_hover_bg . ';}';
		}

		// Add close button color
		if ( ! empty( $close_btn_color ) ) {
			$css .= '.omw-modal .omw-close-modal:before,.omw-modal .omw-close-modal:after{background-color:' . $close_btn_color . ';}';
		}

		// Add close button hover color
		if ( ! empty( $close_btn_hover_color ) ) {
			$css .= '.omw-modal .omw-close-modal:hover:before,.omw-modal .omw-close-modal:hover:after{background-color:' . $close_btn_hover_color . ';}';
		}

		// Tablet modal width
		if ( ! empty( $tablet_modal_width ) && '700' != $tablet_modal_width ) {
			$tablet_css .= 'width:' . $tablet_modal_width . 'px;';
		}

		// Tablet modal height
		if ( ! empty( $tablet_modal_height ) && '0' != $tablet_modal_height ) {
			$tablet_css .= 'height:' . $tablet_modal_height . 'px;';
		}

		// Tablet modal padding
		if ( ! empty( $tablet_modal_padding ) ) {
			$tablet_css .= 'padding:' . $tablet_modal_padding . ';';
		}

		// Tablet modal font size
		if ( ! empty( $tablet_font_size ) ) {
			$tablet_css .= 'font-size:' . $tablet_font_size . ';';
		}

		// Tablet modal line height
		if ( ! empty( $tablet_line_height ) ) {
			$tablet_css .= 'line-height:' . $tablet_line_height . ';';
		}

		// Tablet modal letter spacing
		if ( ! empty( $tablet_letter_spacing ) ) {
			$tablet_css .= 'letter-spacing:' . $tablet_letter_spacing . ';';
		}

		// Responsive tablet
		if ( ! empty( $tablet_modal_width ) && '700' != $tablet_modal_width
			|| ! empty( $tablet_modal_height ) && '0' != $tablet_modal_height
			|| ! empty( $tablet_modal_padding )
			|| ! empty( $tablet_font_size )
			|| ! empty( $tablet_line_height )
			|| ! empty( $tablet_letter_spacing ) ) {
			$css .= '@media (max-width: 1023px) {.omw-modal{' . $tablet_css . '}}';
		}

		// Mobile modal width
		if ( ! empty( $mobile_modal_width ) && '700' != $mobile_modal_width ) {
			$mobile_css .= 'width:' . $mobile_modal_width . 'px;';
		}

		// Mobile modal height
		if ( ! empty( $mobile_modal_height ) && '0' != $mobile_modal_height ) {
			$mobile_css .= 'height:' . $mobile_modal_height . 'px;';
		}

		// Mobile modal padding
		if ( ! empty( $mobile_modal_padding ) ) {
			$mobile_css .= 'padding:' . $mobile_modal_padding . ';';
		}

		// Mobile modal font size
		if ( ! empty( $mobile_font_size ) ) {
			$mobile_css .= 'font-size:' . $mobile_font_size . ';';
		}

		// Mobile modal line height
		if ( ! empty( $mobile_line_height ) ) {
			$mobile_css .= 'line-height:' . $mobile_line_height . ';';
		}

		// Mobile modal letter spacing
		if ( ! empty( $mobile_letter_spacing ) ) {
			$mobile_css .= 'letter-spacing:' . $mobile_letter_spacing . ';';
		}

		// Responsive mobile
		if ( ! empty( $mobile_modal_width ) && '700' != $mobile_modal_width
			|| ! empty( $mobile_modal_height ) && '0' != $mobile_modal_height
			|| ! empty( $mobile_modal_padding )
			|| ! empty( $mobile_font_size )
			|| ! empty( $mobile_line_height )
			|| ! empty( $mobile_letter_spacing ) ) {
			$css .= '@media (max-width: 767px) {.omw-modal{' . $mobile_css . '}}';
		}

		// Return CSS
		if ( ! empty( $css ) ) {
			$output .= '/* Modals CSS */' . $css;
		}

		// Return output css
		return $output;

	}

} // End Class

// --------------------------------------------------------------------------------
// region Freemius
// --------------------------------------------------------------------------------

if ( ! function_exists( 'ocean_modal_window_fs' ) ) {
	// Create a helper function for easy SDK access.
	function ocean_modal_window_fs() {
		global $ocean_modal_window_fs;

		if ( ! isset( $ocean_modal_window_fs ) ) {
			$ocean_modal_window_fs = OceanWP_EDD_Addon_Migration::instance( 'ocean_modal_window_fs' )->init_sdk(
				array(
					'id'              => '3814',
					'slug'            => 'ocean-modal-window',
					'public_key'      => 'pk_7e254472063a1abd3b7e342930210',
					'is_premium'      => false,
					'is_premium_only' => false,
					'has_paid_plans'  => false,
				)
			);
		}

		return $ocean_modal_window_fs;
	}

	function ocean_modal_window_fs_addon_init() {
		if ( class_exists( 'Ocean_Extra' ) ) {
			OceanWP_EDD_Addon_Migration::instance( 'ocean_modal_window_fs' )->init();
		}
	}

	if ( 0 == did_action( 'owp_fs_loaded' ) ) {
		// Init add-on only after parent theme was loaded.
		add_action( 'owp_fs_loaded', 'ocean_modal_window_fs_addon_init', 15 );
	} else {
		if ( class_exists( 'Ocean_Extra' ) ) {
			/**
			 * This makes sure that if the theme was already loaded
			 * before the plugin, it will run Freemius right away.
			 *
			 * This is crucial for the plugin's activation hook.
			 */
			ocean_modal_window_fs_addon_init();
		}
	}
}

// endregion
