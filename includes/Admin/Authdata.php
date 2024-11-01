<?php
class InfosAuth {

	private $infos = array(
		'w3scelementor_zoho_data_center'   => '',
		'w3scelementor_zoho_client_id'     => '',
		'w3scelementor_zoho_client_secret' => '',
		'w3scelementor_zoho_user_email'    => '',
		'zoho_redirect_url'                => '',
		'zoho_api_base_url'                => '',
		'zoho_account_url'                 => '',
		'zoho_authorised'                  => '',
		'time'                             => '',
	);

	function __construct() {
		$this->setAll();
		$this->infos['time'] = time(); // this field no need. only for make unique
	}

	public function setInfo( $key, $val ) {
		if ( array_key_exists( $key, $this->infos ) ) {
			$this->infos[ $key ] = $val;
		}
		return $this;
	}

	public function getInfo( $key ) {
		return $this->infos[ $key ] ?? '';
	}

	public function storeInfo( $data = null ) {
		if ( isset( $data['store_zoho_info'] ) ) {
			$this->setInfo( 'w3scelementor_zoho_data_center', sanitize_text_field( $data['w3scelementor_zoho_data_center'] ) );
			$this->setInfo( 'w3scelementor_zoho_client_id', sanitize_text_field( $data['w3scelementor_zoho_client_id'] ) );
			$this->setInfo( 'w3scelementor_zoho_client_secret', sanitize_text_field( $data['w3scelementor_zoho_client_secret'] ) );
			$this->setInfo( 'w3scelementor_zoho_user_email', sanitize_text_field( $data['w3scelementor_zoho_user_email'] ) );
			$store = update_option( 'w3scelementor_zoho_auth_infos', $this->infos );
			$this->message( $store );
		} else {
			$this->setAll();
			update_option( 'w3scelementor_zoho_auth_infos', $this->infos );
		}
	}

	private function setAll() {
		 $infos = get_option( 'w3scelementor_zoho_auth_infos' );

		$infos = is_array( $infos ) ? $infos : array();

		$this->infos = array_merge( $this->infos, $infos );
		if ( $infos ) {
			foreach ( $infos as $k => $v ) {
				if ( ! $this->infos[ $k ] ) {
					$this->infos[ $k ] = $v;
				}
			}
		}
	}

	public function message( $true ) {
		$message = '';
		$class   = '';

		if ( $true ) {
			$message = 'Settings saved.';
			$class   = 'notice-success';
		} else {
			$message = 'Something Wrong';
			$class   = 'notice-error';
		}
		$notice  = '';
		$notice .= "<div class='notice is-dismissible $class'>";
		$notice .= "<p><strong>$message</strong></p>";
		$notice .= "<button type='button' class='notice-dismiss' onClick=\"this.closest('.notice').outerHTML='' \"></button>";
		$notice .= '</div>';

		add_action(
			'_message_',
			function () use ( $notice ) {
				echo _e( $notice );
			}
		);
	}
}
