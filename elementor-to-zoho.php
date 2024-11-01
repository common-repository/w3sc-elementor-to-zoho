<?php
/**
 * Plugin Name: W3SC Elementor to Zoho CRM
 * Description: Data Insert in Zoho CRM by Elementor.
 * Plugin URI:  https://wordpress.org/plugins/w3sc-elementor-to-zoho/
 * Version:     2.2.0
 * Author:      W3SCloud Technology
 * Author URI:  https://w3scloud.com/
 * Text Domain: w3sc-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if accessed directly.
}

// Include All files
require_once __DIR__ . '/includes/Admin.php';
require_once __DIR__ . '/includes/Installer.php';
require_once __DIR__ . '/includes/Admin/Authdata.php';
require_once __DIR__ . '/includes/Admin/Menu.php';
require_once __DIR__ . '/includes/Admin/Setting.php';
require_once __DIR__ . '/includes/Admin/Tokens.php';
require_once __DIR__ . '/includes/widgets/W3sc-insertinzoho.php';
require_once __DIR__ . '/includes/widgets/W3sc-formdata.php';


/**
 * Main W3sc_elementor_zoho   Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class W3sc_elementor_zoho {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '2.2.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var W3sc_elementor_zoho   The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return W3sc_elementor_zoho   An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		 $this->define_constants();

		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'w3sc_elementor_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'w3sc_load_script' ) );

		// Ajax Call
		add_action( 'wp_head', array( $this, 'apend_into_head' ) );
		add_action( 'wp_ajax_ss_ajax_action', array( $this, 'ajax_actions' ) );
		add_action( 'wp_ajax_nopriv_ss_ajax_action', array( $this, 'ajax_actions' ) );
	}

	// Send from data in console
	function ajax_actions() {
		require_once 'includes/widgets/W3sc-formdata.php';
		wp_die();
	}

	function apend_into_head() {
		echo "<script>var w3sc_ajax_url='" . admin_url( 'admin-ajax.php' ) . "'</script>";
	}

	/**
	 * Define the required plugin constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'W3SC_ELEMENTOR_VERSION', self::VERSION );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'w3sc-elementor' );
	}

	/**
	 * Load CSS & JS Files Admin
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */

	function w3sc_elementor_style() {
		wp_enqueue_style( 'w3sc-admin-style', plugins_url( 'css/admin-style.css', __FILE__ ), false, '1.0.0' );

	}

	/**
	 * Load CSS & JS Files frontend
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	function w3sc_load_script() {
		wp_enqueue_style( 'w3sc-frontend-style', plugins_url( 'css/w3sc-frontend-style.css', __FILE__ ), false, '5.1.3' );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'w3sc-main-js', plugins_url( 'js/w3sc-main-js.js', __FILE__ ), '1.0.0' );

	}

	/**
	 * Do stuff upon plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		$installer = new W3sc_Installer();
		$installer->run();
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_plugins_loaded() {
		if ( is_admin() ) {
			new W3sc_Admin();
		}
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', array( $this, 'init' ) );
		}
	}

	/**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin's minimum requirement.
	 * Checks if the installed PHP version meets the plugin's minimum requirement.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function is_compatible() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return false;
		}

		return true;
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {
		$this->i18n();

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {
		// Include Widget files
		require_once __DIR__ . '/includes/widgets/W3sc-widget.php';

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(
			new \W3sc_oEmbed_Widget()
		);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__(
				'"%1$s" requires "%2$s" to be installed and activated.',
				'w3sc-elementor'
			),
			'<strong>' .
				esc_html__( 'W3sc elementor zoho  ', 'w3sc-elementor' ) .
				'</strong>',
			'<strong>' . esc_html__( 'Elementor', 'w3sc-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__(
				'"%1$s" requires "%2$s" version %3$s or greater.',
				'w3sc-elementor'
			),
			'<strong>' .
				esc_html__( 'W3sc elementor zoho  ', 'w3sc-elementor' ) .
				'</strong>',
			'<strong>' .
				esc_html__( 'Elementor', 'w3sc-elementor' ) .
				'</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__(
				'"%1$s" requires "%2$s" version %3$s or greater.',
				'w3sc-elementor'
			),
			'<strong>' .
				esc_html__( 'W3sc elementor zoho', 'w3sc-elementor' ) .
				'</strong>',
			'<strong>' . esc_html__( 'PHP', 'w3sc-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

W3sc_elementor_zoho::instance();
