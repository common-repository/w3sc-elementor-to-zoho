<?php
/**
 * The Menu handler class
 */
if ( ! class_exists( 'W3sc_Menu' ) ) {
	class W3sc_Menu {

		public $w3scmain_setting;

		/**
		 * Initialize the class
		 */
		function __construct( $w3sc_setting ) {
			 $this->w3scmain_setting = $w3sc_setting;

			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		/**
		 * Register admin menu
		 *
		 * @return void
		 */
		public function admin_menu() {
			$parent_slug = 'w3sc-elementor';
			$capability  = 'manage_options';

			add_menu_page( __( 'W3SC Elementor to Zoho', 'w3sc-elementor' ), __( 'Elementor to Zoho', 'w3sc-elementor' ), $capability, $parent_slug, array( $this->w3scmain_setting, 'settings_page' ), 'dashicons-filter' );
			add_submenu_page( $parent_slug, __( 'Integration', 'w3sc-elementor' ), __( 'Integration', 'w3sc-elementor' ), $capability, $parent_slug, array( $this->w3scmain_setting, 'settings_page' ) );
			// add_submenu_page( $parent_slug, __( 'Settings', 'wedevs-academy' ), __( 'Settings', 'wedevs-academy' ), $capability, 'wedevs-academy-settings', [ $this, 'tes_setting' ] );
		}
	}
}
