<?php
/**
 * The admin class
 */


if ( ! class_exists( 'W3sc_Admin' ) ) {
	class W3sc_Admin {

		/**
		 * Initialize the class
		 */
		function __construct() {
			$w3sc_setting = new W3sc_Setting();

			new W3sc_Menu( $w3sc_setting );
		}
	}
}
