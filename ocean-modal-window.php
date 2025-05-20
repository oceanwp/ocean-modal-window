<?php
/**
 * Plugin Name:         Ocean Modal Window
 * Plugin URI:          https://oceanwp.org/extension/ocean-modal-window/
 * Description:         Create the good kind of popups with ease. Display any content in a modal, anywhere on your website.
 * Version:             2.3.2
 * Author:              OceanWP
 * Author URI:          https://oceanwp.org/
 * Requires at least:   5.6
 * Tested up to:        6.8
 *
 * Text Domain: ocean-modal-window
 * Domain Path: /languages
 *
 * @package Ocean_Modal_Window
 * @category Core
 * @author OceanWP
 */

// Exit if accessed directly.
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

	/**
	 * The plugin url.
	 *
	 * @var     string
	 * @access  public
	 */
	public $plugin_url;

	/**
	 * The plugin path.
	 *
	 * @var     string
	 * @access  public
	 */
	public $plugin_path;

	/**
	 * The plugin data.
	 *
	 * @var     array
	 * @access  public
	 */
	public $plugin_data;

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
		$this->plugin_data = get_file_data( __FILE__, array( 'Version' => 'Version' ), false );
		$this->version     = $this->plugin_data['Version'];

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'omw_load_plugin_textdomain' ) );

		add_action( 'init', array( $this, 'omw_setup' ) );

		add_action( 'init', array( $this, 'register_post_type' ), 0 );

		add_filter( 'oceanwp_theme_strings', array( $this, 'register_omw_strings' ) );
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
			add_filter( 'ocean_customize_options_data', array( $this, 'register_customize_options') );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 999 );
			add_filter( 'ocean_metaboxes_post_types_scripts', array( $this, 'post_type' ) );
			add_action( 'butterbean_register', array( $this, 'metabox' ), 10, 2 );
			add_action( 'add_meta_boxes_ocean_modal_window', array( $this, 'add_meta_box' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_fonts' ) );
			add_action( 'wp_ajax_get_mw_conditional_rules', array( $this, 'omw_conditional_rules_callback' ) );
			add_action( 'wp_footer', array( $this, 'modal_display' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mw_enqueue_admin_assets' ) );
			add_action( 'save_post', array( $this, 'save_mw_conditions_rules' ), 200 );
			add_filter( 'ocean_head_css', array( $this, 'head_css' ) );
			add_filter( 'oe_theme_panels', array( $this, 'oe_theme_panels' ) );
			add_filter( 'ocean_post_setting_meta', array( $this, 'omw_post_meta_args' ) );
			$capabilities = apply_filters( 'ocean_main_metaboxes_capabilities', 'manage_options' );
			if ( current_user_can( $capabilities ) ) {
				add_action( 'butterbean_register', array( $this, 'new_tab' ), 10, 2 );
				add_action( 'enqueue_block_editor_assets', array( $this, 'metabox_assets' ) );
			}

			$theme_version = $theme->version;

			$current_theme_version = $theme_version;

			if ( get_template_directory() == get_stylesheet_directory() ) {
				$current_theme_version  = $theme_version;
			} else {
				$parent = wp_get_theme()->parent();
				if ( ! empty( $parent) ) {
					$current_theme_version = $parent->Version;
				}
			}

			if ( version_compare( $current_theme_version, '3.6.1', '<=' ) ) {

				$is_ocean_extra_active = class_exists( 'Ocean_Extra' );
				$is_ocean_extra_version_valid = defined( 'OE_VERSION' ) && version_compare( OE_VERSION, '2.3.1', '<=' );

				if ( ! $is_ocean_extra_active || $is_ocean_extra_version_valid ) {
					include_once $this->plugin_path . '/includes/update-message.php';
				}
			}
		}
	}

	/**
	 * Register custom post type
	 *
	 * @since  1.0.0
	 */
	public function register_post_type() {
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
					'show_in_rest'        => true,
					'can_export'          => true,
					'exclude_from_search' => true,
					'publicly_queryable'  => false,
					'capability_type'     => 'page',
					'menu_icon'           => 'dashicons-editor-expand',
					'menu_position'       => 20,
					'supports'            => array( 'title', 'editor', 'custom-fields' ),
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
	}

	/**
	 * Add hook scripts
	 *
	 * @since  2.1.0
	 */
	public function mw_enqueue_admin_assets( $hook ) {
		$screen = get_current_screen();

		if ( ( $hook == 'edit.php' || $hook == 'post.php' || $hook == 'post-new.php' ) && $screen->post_type == 'ocean_modal_window' ) {

			wp_enqueue_script( 'omw-script', plugins_url( '/assets/js/metabox.min.js', __FILE__ ), array( 'jquery', 'wp-util' ), $this->version, true );

			wp_enqueue_style( 'omw-style', plugins_url( '/assets/css/metabox.min.css', __FILE__ ) );

		}
	}

	/**
	 * Added localize in customizer js
	 */
	public function register_customize_options($options) {

		if ( OCEAN_EXTRA_ACTIVE
			&& class_exists( 'Ocean_Extra_Theme_Panel' ) ) {

			if ( empty( Ocean_Extra_Theme_Panel::get_setting( 'ocean_modal_window_panel' ) ) ) {
				return $options;
			}

		}

		include_once $this->plugin_path . '/includes/options.php';

		$options['ocean_modal_window_settings'] = omw_customizer_options();

		return $options;
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since  1.0.0
	 */
	public function enqueue_scripts() {

		$meta_modal = get_post_meta( oceanwp_post_id(), 'omw_enable_modal_window', true );

		// If Modal Window disabled
		if ( 'disable' === $meta_modal ) {
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
			'oceanwp_mw_title_tag', // Same as setting name.
			array(
				'section'     => 'oceanwp_mw_general',
				'type'        => 'select',
				'label'       => esc_html__( 'Title Tag', 'ocean-modal-window' ),
				'description' => esc_html__( 'Select title tag for this modal.', 'ocean-modal-window' ),
				'choices'     => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'p'    => 'p',
					'span' => 'span',
					'div'  => 'div'
				),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_title_tag', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
				'default'           => 'h2',
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
			'oceanwp_mw_cond_logic',
			array(
				'section'     => 'oceanwp_mw_general',
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Conditional Logic', 'ocean-modal-window' ),
				'description' => esc_html__( 'Enable Conditional Logic for this Modal.', 'ocean-modal-window' ),
			)
		);

		$manager->register_setting(
			'oceanwp_mw_cond_logic',
			array(
				'sanitize_callback' => 'butterbean_validate_boolean',
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
	* Sanitize function for decimal
	*/
	public function omw_sanitize_decimal( $value ) {
		if (is_numeric($value)) {
			return round((float) $value, 2);
		} else {
			return '';
		}
	}

	/**
	* Sanitize function for array
	*/
	public function omw_sanitize_array($meta_value) {
		if (!is_array($meta_value)) {
			return array();
		}

		foreach ($meta_value as $key => $value) {
			$meta_value[$key] = wp_kses_post($value);
		}

		return $meta_value;
	}


	/**
	 * Post setting arguments
	 */
	public function omw_post_meta_args( $defaults ) {

		$defaults['omw_enable_modal_window'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => '',
			'value'  => 'enable',
			'sanitize' => 'sanitize_key'
		);

		$defaults['oceanwp_mw_template'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key'
		);

		$defaults['oceanwp_mw_title'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 'off',
			'sanitize' => 'sanitize_key'
		);

		$defaults['oceanwp_mw_title_tag'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 'h2',
			'sanitize' => 'sanitize_key'
		);

		$defaults['oceanwp_mw_close_btn'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 'on',
			'sanitize' => 'sanitize_key'
		);

		$defaults['oceanwp_mw_cond_logic'] = array(
			'type'   => 'boolean',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => false
		);

		$defaults['oceanwp_mw_width'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 700,
			'sanitize' => 'sanitize_absint'
		);

		$defaults['oceanwp_mw_tablet_width'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 700,
			'sanitize' => 'sanitize_absint'
		);

		$defaults['oceanwp_mw_mobile_width'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 700,
			'sanitize' => 'sanitize_absint'
		);

		$defaults['oceanwp_mw_height'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint'
		);

		$defaults['oceanwp_mw_tablet_height'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint'
		);

		$defaults['oceanwp_mw_mobile_height'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint'
		);

		$defaults['oceanwp_mw_background_image'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint'
		);

		$defaults['oceanwp_mw_padding'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_tablet_padding'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_mobile_padding'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_border'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_border_style'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_border_radius'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_overlay_bg_color'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '#000000',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_overlay_opacity'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0.9,
			'sanitize' => array( $this, 'omw_sanitize_decimal' ),
		);

		$defaults['oceanwp_mw_bg_color'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '#ffffff',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_border_color'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_text_color'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_title_color'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '#333333',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_close_btn_bg'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_close_btn_hover_bg'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_close_btn_color'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_close_btn_hover_color'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'wp_kses_post',
		);

		$defaults['oceanwp_mw_font_family'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_text_field',
		);

		$defaults['oceanwp_mw_font_size'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_tablet_font_size'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_mobile_font_size'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_font_size_unit'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 'px',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_font_weight'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_text_field',
		);

		$defaults['oceanwp_mw_font_weight_tablet'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_text_field',
		);

		$defaults['oceanwp_mw_font_weight_mobile'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_text_field',
		);

		$defaults['oceanwp_mw_font_subset'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_text_field',
		);

		$defaults['oceanwp_mw_text_transform'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_text_transform_tablet'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_text_transform_mobile'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['oceanwp_mw_line_height'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_tablet_line_height'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_mobile_line_height'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_line_height_unit'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key'
		);

		$defaults['oceanwp_mw_letter_spacing'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_tablet_letter_spacing'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_mobile_letter_spacing'] = array(
			'type'   => 'number',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => 0,
			'sanitize' => 'sanitize_absint',
		);

		$defaults['oceanwp_mw_letter_spacing_unit'] = array(
			'type'   => 'string',
			'single' => true,
			'rest'   => true,
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => 'sanitize_key',
		);

		$defaults['mw_display_on'] = array(
			'type'   => 'array',
			'single' => true,
			'rest'   => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'string'
					)
				)
			),
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => array( $this, 'omw_sanitize_array' ),
		);

		$defaults['mw_hide_on'] = array(
			'type'   => 'array',
			'single' => true,
			'rest'   => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'string'
					)
				)
			),
			'subType' => 'ocean_modal_window',
			'value'  => '',
			'sanitize' => array( $this, 'omw_sanitize_array' ),
		);

		return apply_filters( 'omw_post_meta_args', $defaults );
	}

	/**
	 * Enqueque Editor Scripts
	 */
	public function metabox_assets() {

		$uri   = $this->plugin_url . 'assets/dist/';
		$asset = require $this->plugin_path . 'assets/dist/modal-settings.asset.php';
		$deps  = $asset['dependencies'];
		array_push( $deps, 'updates' );

		wp_register_script(
			'omw-meta-modal-settings',
			$uri . 'modal-settings.js',
			$deps,
			filemtime( $this->plugin_path . 'assets/dist/modal-settings.js' ),
			true
		);

		wp_enqueue_script( 'omw-meta-modal-settings' );

		wp_enqueue_style(
			'omw-meta-modal-settings',
			$uri . 'style-modal-settings.css',
			array( 'wp-components' ),
			filemtime( $this->plugin_path . 'assets/dist/style-modal-settings.css' )
		);

		if ( function_exists( 'oe_check_post_types_settings' ) ) {
			if ( false === oe_check_post_types_settings() ) {
				return;
			}
		} else {
			return;
		}

		$asset = require $this->plugin_path . 'assets/dist/metabox.asset.php';
		$deps  = $asset['dependencies'];
		array_push( $deps, 'updates' );

		wp_register_script(
			'omw-metabox-settings',
			$uri . 'metabox.js',
			$deps,
			filemtime( $this->plugin_path . 'assets/dist/metabox.js' ),
			true
		);

		wp_enqueue_script( 'omw-metabox-settings' );

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'omw-metabox-settings', 'ocean-modal-window' );
		}
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
	 * Ajax function to add conditional rules section.
	 *
	 * @since  2.1.0
	 */
	public function omw_conditional_rules_callback() {
		$activeCond = boolval( $_POST['activeCond'] );
		$mwId       = intval( $_POST['mwId'] );

		// get conditional logic section \\\
		// Hide on selected options
		$hide_on = ! empty( get_post_meta( $mwId, 'mw_hide_on', true ) ) && $activeCond ? get_post_meta( $mwId, 'mw_hide_on', true ) : '';

		// Display on selected options
		$display_on = ! empty( get_post_meta( $mwId, 'mw_display_on', true ) ) && $activeCond ? get_post_meta( $mwId, 'mw_display_on', true ) : '';

		$condHTML  = '';
		$condHTML .= '<div class="options options-cond boxes"';
		if ( ! $activeCond ) {
			$condHTML .= ' style="display: none"';
		}
		$condHTML .= '>';
		$condHTML .= '<div class="condition-container dispaly-on container-wrap">';
		$condHTML .= '<div class="display-on-fields display-on-field">';
		if ( empty( $display_on ) ) {
			$condHTML .= '<div class="dispaly-on field-wrap">';
			$condHTML .= $this->get_conditional_select_for_mw( 'mw_display_on', esc_html__( 'Show on', 'ocean-modal-window' ), false );
			$condHTML .= '</div>';
		}
		if ( ! empty( $display_on ) ) {
			foreach ( $display_on as $index => $dis_on ) {
				$condHTML .= '<div class="dispaly-on field-wrap">';
				$condHTML .= $this->get_conditional_select_for_mw( 'mw_display_on', esc_html__( 'Show on', 'ocean-modal-window' ), true, $dis_on, $index );
				$condHTML .= '</div>';
			}
		}
		$condHTML .= '</div>';
		$condHTML .= '<button type="button" class="display-on-add omw-btn" onClick="add_mw_display_on();"; >' . esc_html__( 'Add new row', 'ocean-modal-window' ) . '</button>';
		$condHTML .= '</div>';
		$condHTML .= '<script type="text/html" id="tmpl-dispaly-on-field">';
		$condHTML .= '<div class="dispaly-on field-wrap">';
		$condHTML .= $this->get_conditional_select_for_mw( 'mw_display_on', esc_html__( 'Show on', 'ocean-modal-window' ), true );
		$condHTML .= '</div>';
		$condHTML .= '</script>';
		$condHTML .= '<div class="condition-container hide-on container-wrap">';
		$condHTML .= '<div class="hide-on-fields hide-on-field">';
		if ( empty( $hide_on ) ) {
			$condHTML .= '<div class="hide-on field-wrap">';
			$condHTML .= $this->get_conditional_select_for_mw( 'mw_hide_on', esc_html__( 'Hide on', 'ocean-modal-window' ), false );
			$condHTML .= '</div>';
		}

		if ( ! empty( $hide_on ) ) {
			foreach ( $hide_on as $index => $hid_on ) {
				$condHTML .= '<div class="hide-on field-wrap">';
				$condHTML .= $this->get_conditional_select_for_mw( 'mw_hide_on', esc_html__( 'Hide on', 'ocean-modal-window' ), true, $hid_on, $index );
				$condHTML .= '</div>';
			}
		}
		$condHTML .= '</div>';
		$condHTML .= '<button type="button" class="hide-on-add omw-btn" onClick="add_mw_hide_on();"; >' . esc_html__( 'Add new row', 'ocean-modal-window' ) . '</button>';
		$condHTML .= '</div>';

		$condHTML .= '<script type="text/html" id="tmpl-hide-on-field">';
		$condHTML .= '<div class="hide-on field-wrap">';
		$condHTML .= $this->get_conditional_select_for_mw( 'mw_hide_on', esc_html__( 'Hide on', 'ocean-modal-window' ), true );
		$condHTML .= '</div>';
		$condHTML .= '</script>';
		$condHTML .= '</div>';

		print_r(
			json_encode(
				array(
					'status'    => true,
					'condHTML'  => $condHTML,
				)
			)
		);

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	/**
	 * Get the conditional select.
	 *
	 * @since  2.1.0
	 */
	public function get_conditional_select_for_mw( $condition_type, $label, $template = false, $selected_value = '', $show_remove_btn = true ) {
		ob_start(); ?>

		<div class="label-wrap div-wrap">
			<span class="condition-arrow"></span>
			<label for="omw_rules[<?php echo $condition_type; ?>][]"><?php esc_html_e( $label, 'ocean-modal-window' ); ?></label>
		</div>

		<div class="select-wrap div-wrap">
			<select name="omw_rules[<?php echo $condition_type; ?>][]" class="omw-select">

				<option value="0"><?php esc_html_e( 'Please Select', 'ocean-modal-window' ); ?></option>

				<optgroup label="Pages"></optgroup>
				<?php
				$pg_templates = $this->omw_get_page_templates();
				foreach ( $pg_templates['pages'] as $pg_funcs => $pg_template ) :
					?>
					<option value="<?php echo $pg_funcs; ?>" <?php selected( $selected_value, $pg_funcs ); ?>>
						<?php echo $pg_template; ?>
					</option>
				<?php endforeach; ?>

				<?php if ( isset( $pg_templates['shop'] ) ) : ?>
					<optgroup label="Shop"></optgroup>
					<?php
					foreach ( $pg_templates['shop'] as $pg_funcs => $pg_template ) :
						?>
						<option value="<?php echo $pg_funcs; ?>" <?php selected( $selected_value, $pg_funcs ); ?>>
							<?php echo $pg_template; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>

				<optgroup label="Other"></optgroup>
				<?php
				foreach ( $pg_templates['others'] as $pg_funcs => $pg_template ) :
					?>
					<option value="<?php echo $pg_funcs; ?>" <?php selected( $selected_value, $pg_funcs ); ?>>
						<?php echo $pg_template; ?>
					</option>
				<?php endforeach; ?>

			</select>
		</div>

		<?php
		if ( $condition_type == 'mw_display_on' && $template && $show_remove_btn ) :
			?>
			<div class="close-wrap div-wrap"><span class="dashicons dashicons-dismiss display-on-remove"></span></div>
			<?php
		endif;
		?>
		<?php
		if ( $condition_type == 'mw_hide_on' && $template && $show_remove_btn ) :
			?>
			<div class="close-wrap div-wrap"><span class="dashicons dashicons-dismiss hide-on-remove"></span></div>
			<?php
		endif;

		return ob_get_clean();
	}

	/**
	 * Return WooCommerce specific pages
	 *
	 * @since  2.1.0
	 */
	public function omw_get_woocommerce_pages() {

		$shop_page_id = get_option( 'woocommerce_shop_page_id' );
		if ( $shop_page_id ) {
			$pg_templates['is_shop()'] = get_the_title( $shop_page_id );
		}

		$pg_templates['is_product_category()'] = esc_html__( 'Product Category', 'ocean-modal-window' );

		$pg_templates['is_product_tag()'] = esc_html__( 'Product Tag', 'ocean-modal-window' );

		$pg_templates['is_product()'] = esc_html__( 'Single Product', 'ocean-modal-window' );

		$shop_page_id = get_option( 'woocommerce_cart_page_id' );
		if ( $shop_page_id ) {
			$pg_templates[ 'is_page(' . $shop_page_id . ')' ] = get_the_title( $shop_page_id );
		}

		$shop_page_id = get_option( 'woocommerce_checkout_page_id' );
		if ( $shop_page_id ) {
			$pg_templates[ 'is_page(' . $shop_page_id . ')' ] = get_the_title( $shop_page_id );
		}

		$shop_page_id = get_option( 'woocommerce_pay_page_id' );
		if ( $shop_page_id ) {
			$pg_templates[ 'is_page(' . $shop_page_id . ')' ] = get_the_title( $shop_page_id );
		}

		$shop_page_id = get_option( 'woocommerce_thanks_page_id' );
		if ( $shop_page_id ) {
			$pg_templates[ 'is_page(' . $shop_page_id . ')' ] = get_the_title( $shop_page_id );
		}

		$shop_page_id = get_option( 'woocommerce_myaccount_page_id' );
		if ( $shop_page_id ) {
			$pg_templates[ 'is_page(' . $shop_page_id . ')' ] = get_the_title( $shop_page_id );
		}

		$shop_page_id = get_option( 'woocommerce_edit_address_page_id' );
		if ( $shop_page_id ) {
			$pg_templates[ 'is_page(' . $shop_page_id . ')' ] = get_the_title( $shop_page_id );
		}

		$shop_page_id = get_option( 'woocommerce_view_order_page_id' );
		if ( $shop_page_id ) {
			$pg_templates[ 'is_page(' . $shop_page_id . ')' ] = get_the_title( $shop_page_id );
		}

		$shop_page_id = get_option( 'woocommerce_terms_page_id' );
		if ( $shop_page_id ) {
			$pg_templates[ 'is_page(' . $shop_page_id . ')' ] = get_the_title( $shop_page_id );
		}

		return $pg_templates;
	}

	/**
	 * Get Templates
	 *
	 * @since  2.1.0
	 */
	public function omw_get_page_templates() {
		$pg_templates['pages'] = array(
			'is_page()'       => esc_html__( 'All Pages', 'ocean-modal-window' ),
			'is_home()'       => esc_html__( 'Home Page ( is_home() )', 'ocean-modal-window' ),
			'is_front_page()' => esc_html__( 'Front Page ( is_front_page() )', 'ocean-modal-window' ),
		);

		$pages = get_pages();

		if ( ! empty( $pages ) ) {
			foreach ( $pages as $page ) {
				$pg_templates['pages'][ 'is_page(' . $page->ID . ')' ] = $page->post_title;
			}
		}
		$pg_templates['others'] = array(
			'is_single()'          => esc_html__( 'Single Post', 'ocean-modal-window' ),
			'is_category()'        => esc_html__( 'Category Page', 'ocean-modal-window' ),
			'is_archive()'         => esc_html__( 'Archive Page', 'ocean-modal-window' ),
			'is_user_logged_in()'  => esc_html__( 'Logged In User', 'ocean-modal-window' ),
			'!is_user_logged_in()' => esc_html__( 'Logged Out User', 'ocean-modal-window' ),
		);

		// Getting Wocommerce specidic pages
		if ( class_exists( 'WooCommerce' ) ) {
			$pg_templates['shop'] = $this->omw_get_woocommerce_pages();
		}

		return $pg_templates;
	}

	/**
	 * Save conditional rules added to modal window.
	 */
	public function save_mw_conditions_rules( $mw_id ) {
		$post_type = get_post_type( $mw_id );

		if ( 'ocean_modal_window' != $post_type ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// check if elementor
		$elementor = false;
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' ) {
			$elementor = true;
		}

		if ( isset( $_POST['butterbean_oceanwp_mw_settings_setting_oceanwp_mw_cond_logic'] ) && $_POST['butterbean_oceanwp_mw_settings_setting_oceanwp_mw_cond_logic'] ) {
			$display = array();
			$hide    = array();

			if ( isset( $_POST['omw_rules']['mw_display_on'] ) ) {
				foreach ( $_POST['omw_rules']['mw_display_on'] as $key => $displayCond ) {
					if ( $displayCond != '0' ) {
						$display[] = $displayCond;
					}
				}
			}

			if ( isset( $_POST['omw_rules']['mw_hide_on'] ) ) {
				foreach ( $_POST['omw_rules']['mw_hide_on'] as $key => $hideCond ) {
					if ( $hideCond != '0' ) {
						$hide[] = $hideCond;
					}
				}
			}

			update_post_meta( $mw_id, 'mw_display_on', $display );
			update_post_meta( $mw_id, 'mw_hide_on', $hide );
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
	 * Register translation strings
	 *
	 * @param string $strings   Plugin strings.
	 */
	public static function register_omw_strings( $strings ) {

		$strings['omw-close-button-anchor'] = apply_filters( 'omw_close_button_anchor',_x( 'modal-window-close', 'Used for creation of SEO friendly anchor links. Do not use spaces or pound keys.', 'ocean-modal-window' ) );

		return $strings;

	}

	/**
	 * Return SEO-friendly (crawlable) and accessibility-friendly (not redundant) links
	 *
	 * @since 2.2.1
	 */
	public function omw_get_site_name_anchors( $content = '' ) {
		$result     = '';
		$site_url   = esc_url( home_url( '/#' ) );

		if ( $content && ! is_customize_preview() ) {
			$result = $site_url . $content;
		} else {
			$result = '#';
		}

		$result = apply_filters( 'omw_get_site_name_anchors', $result );

		return $result;
	}

	/**
	 * Display the modal in the footer
	 *
	 * @since  1.0.0
	 */
	public function modal_display() {

		if (is_admin()) {
			return;
		}

		$meta_modal = get_post_meta( oceanwp_post_id(), 'omw_enable_modal_window', true );

		// If Modal Window disabled
		if ( 'disable' === $meta_modal ) {
			return;
		}

		$query = new WP_Query(
			array(
				'post_type'      => 'ocean_modal_window',
				'posts_per_page' => -1,
			)
		);

		$status = true;

		// SEO link txt.
		$anchorlink_text = esc_html( oceanwp_theme_strings( 'omw-close-button-anchor', false ) );

		if ( $query->have_posts() ) :

			while ( $query->have_posts() ) :
				$query->the_post();

				// Get the template
				$templates = get_post_meta( get_the_ID(), 'oceanwp_mw_template', true );
				$templates = $templates ? $templates : '';

				// Vars
				$title     = get_post_meta( get_the_ID(), 'oceanwp_mw_title', true );
				$title     = $title ? $title : 'off';
				$title_tag = get_post_meta( get_the_ID(), 'oceanwp_mw_title_tag', true );
				$title_tag = $title_tag ? $title_tag : 'h2';
				$close_btn = get_post_meta( get_the_ID(), 'oceanwp_mw_close_btn', true );
				$close_btn = $close_btn ? $close_btn : 'on';

				$display_conds = get_post_meta( get_the_ID(), 'mw_display_on', true );
				$hide_conds    = get_post_meta( get_the_ID(), 'mw_hide_on', true );

				if ( ! empty( $display_conds ) && is_array( $display_conds ) ) {
					$display_pages_cond  = implode( ' || ', $display_conds );
					$is_template_matched = eval( "return $display_pages_cond;" );
					if ( ! $is_template_matched ) {
						$status = false;
					}
				}

				if ( ! empty( $hide_conds ) && is_array( $hide_conds ) ) {
					$hidden_pages_cond   = implode( ' || ', $hide_conds );
					$is_template_matched = eval( "return $hidden_pages_cond;" );

					if ( $is_template_matched ) {
						$status = false;
					}
				}

				if ( $status === false ) {
					continue;
				}

				?>

				<div id="omw-<?php echo esc_attr( get_the_ID() ); ?>" class="omw-modal">

					<?php
					// Title
					if ( 'on' == $title ) {
						?>
						<<?php echo esc_attr( $title_tag ); ?> class="omw-modal-title"><?php the_title(); ?></<?php echo esc_attr( $title_tag ); ?>>
						<?php
					}

					// Close button
					if ( 'on' == $close_btn ) {
						?>
						<a href="<?php echo esc_url( $this->omw_get_site_name_anchors( $anchorlink_text ) ); ?>" class="omw-close-modal"></a>
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
				$font_size_unit        = get_post_meta( get_the_ID(), 'oceanwp_mw_font_size_unit', true );
				$font_family           = get_post_meta( get_the_ID(), 'oceanwp_mw_font_family', true );
				$font_weight           = get_post_meta( get_the_ID(), 'oceanwp_mw_font_weight', true );
				$text_transform        = get_post_meta( get_the_ID(), 'oceanwp_mw_text_transform', true );
				$line_height           = get_post_meta( get_the_ID(), 'oceanwp_mw_line_height', true );
				$line_height_unit      = get_post_meta( get_the_ID(), 'oceanwp_mw_line_height_unit', true );
				$letter_spacing        = get_post_meta( get_the_ID(), 'oceanwp_mw_letter_spacing', true );
				$letter_spacing_unit   = get_post_meta( get_the_ID(), 'oceanwp_mw_letter_spacing_unit', true );

				// Responsive
				$tablet_modal_width    = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_width', true );
				$tablet_modal_height   = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_height', true );
				$tablet_modal_padding  = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_padding', true );
				$tablet_font_size      = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_font_size', true );
				$tablet_font_weight    = get_post_meta( get_the_ID(), 'oceanwp_mw_font_weight_tablet', true );
				$tablet_text_transform = get_post_meta( get_the_ID(), 'oceanwp_mw_text_transform_tablet', true );
				$tablet_line_height    = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_line_height', true );
				$tablet_letter_spacing = get_post_meta( get_the_ID(), 'oceanwp_mw_tablet_letter_spacing', true );
				$mobile_modal_width    = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_width', true );
				$mobile_modal_height   = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_height', true );
				$mobile_modal_padding  = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_padding', true );
				$mobile_font_size      = get_post_meta( get_the_ID(), 'oceanwp_mw_mobile_font_size', true );
				$tablet_font_weight    = get_post_meta( get_the_ID(), 'oceanwp_mw_font_weight_mobile'. true );
				$mobile_text_transform = get_post_meta( get_the_ID(), 'oceanwp_mw_text_transform_mobile', true );
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
				if ( ! empty( $font_size && '0' != $font_size ) ) {
					$typo_css .= 'font-size:' . $font_size . $font_size_unit . ';';
				}

				// Add modal font family
				if ( ! empty( $font_family ) ) {
					$typo_css .= 'font-family:' . $font_family . ';';
				}

				// Add modal font weight
				if ( ! empty( $font_weight ) ) {
					$typo_css .= 'font-weight:' . $font_weight . ';';
				}

				// Add modal text transform
				if ( ! empty( $text_transform ) ) {
					$typo_css .= 'text-transform:' . $text_transform . ';';
				}

				// Add modal line height
				if ( ! empty( $line_height && '0' != $line_height ) ) {
					$typo_css .= 'line-height:' . $line_height . $line_height_unit . ';';
				}

				// Add modal letter spacing
				if ( ! empty( $letter_spacing && '0' != $letter_spacing ) ) {
					$typo_css .= 'letter-spacing:' . $letter_spacing . $letter_spacing_unit . ';';
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
					$overlay_css .= 'background-color:' . $overlay_bg . '!important;';
				}

				// Add overlay opacity
				if ( ! empty( $overlay_opacity ) && '0.9' != $overlay_opacity ) {
					$overlay_css .= 'opacity:' . $overlay_opacity . ' !important;';
				}

				// Overlay css
				if ( ! empty( $overlay_bg ) && '#000000' != $overlay_bg
					|| ! empty( $overlay_opacity ) && '0.9' != $overlay_opacity ) {
					$css .= 'body.omw-' . esc_attr( get_the_ID() ) . ' .omw-modal-overlay{' . $overlay_css . '}';
				}

				// Add title color
				if ( ! empty( $title_color ) && '#333333' != $title_color ) {
					$css .= '#omw-' . esc_attr( get_the_ID() ) . ' .omw-modal-title{color:' . $title_color . ';}';
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
				if ( ! empty( $tablet_font_size && '0' != $tablet_font_size ) ) {
					$tablet_css .= 'font-size:' . $tablet_font_size . $font_size_unit . ';';
				}

				// Tablet modal text transform
				if ( ! empty( $tablet_text_transform ) ) {
					$tablet_css .= 'text-transform:' . $tablet_text_transform . ';';
				}

				// Tablet modal line height
				if ( ! empty( $tablet_line_height && '0' != $tablet_line_height ) ) {
					$tablet_css .= 'line-height:' . $tablet_line_height . $line_height_unit . ';';
				}

				// Tablet modal letter spacing
				if ( ! empty( $tablet_letter_spacing && '0' != $tablet_letter_spacing ) ) {
					$tablet_css .= 'letter-spacing:' . $tablet_letter_spacing . $letter_spacing_unit . ';';
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
				if ( ! empty( $mobile_font_size ) && '0' != $mobile_font_size ) {
					$mobile_css .= 'font-size:' . $mobile_font_size . $font_size_unit . ';';
				}

				// Mobile modal text transform
				if ( ! empty( $mobile_text_transform ) ) {
					$mobile_css .= 'text-transform:' . $mobile_text_transform . ';';
				}

				// Mobile modal line height
				if ( ! empty( $mobile_line_height ) && '0' != $mobile_line_height ) {
					$mobile_css .= 'line-height:' . $mobile_line_height . $line_height_unit . ';';
				}

				// Mobile modal letter spacing
				if ( ! empty( $mobile_letter_spacing ) && '0' != $mobile_letter_spacing ) {
					$mobile_css .= 'letter-spacing:' . $mobile_letter_spacing . $letter_spacing_unit . ';';
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
		$modal_width_unit      = get_theme_mod( 'omw_custom_width_unit', 'px' );
		$modal_height          = get_theme_mod( 'omw_custom_height', '0' );
		$modal_height_unit     = get_theme_mod( 'omw_custom_height_unit', 'px' );
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
		if ( ! empty( $modal_width ) && 700 != $modal_width ) {
			$main_css .= 'width:' . $modal_width . $modal_width_unit . ';';
		}

		// Add modal height
		if ( ! empty( $modal_height ) && 0 != $modal_height ) {
			$main_css .= 'height:' . $modal_height . $modal_height_unit . ';';
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
			$css .= '.omw-modal .omw-modal-title{color:' . $title_color . ';}';
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

	/**
	 * Add modal window switcher.
	 *
	 * @since  1.0.0
	 */
	public function oe_theme_panels( $panels ) {

		$panels['ocean_modal_window_panel'] = [
			'label' => esc_html__( 'Modal Window', 'ocean-modal-window' ),
		];

		// Return panels list
		return $panels;
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