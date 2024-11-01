<?php
/**
 * Installer class
 */
if ( ! class_exists( 'W3sc_Installer' ) ) {
	class W3sc_Installer {

		/**
		 * Run the installer
		 *
		 * @return void
		 */
		public function run() {
			 $this->add_version();
		}

		/**
		 * Add time and version on DB
		 */
		public function add_version() {
			 $installed = get_option( 'w3sc_elementor_installed' );

			if ( ! $installed ) {
				update_option( 'w3sc_elementor_installed', time() );
			}

			update_option( 'w3sc_elementor_version', W3SC_ELEMENTOR_VERSION );
		}
	}
}
