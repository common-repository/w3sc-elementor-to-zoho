<?php

if ( ! class_exists( 'W3sc_Datainsert' ) ) {
	class W3sc_Datainsert {

		// Properties
		public $data;
		public $module;

		// Methods
		function set_data( $secldata, $seclmodule ) {
			$this->data   = $secldata;
			$this->module = $seclmodule;

			$access_token = w3sc_accessToken();
			$fields       = $this->data;

			$dataSet    = new InfosAuth();
			$dataCenter = $dataSet->getInfo( 'w3scelementor_zoho_data_center' );

			$args = array(
				'body'    => $fields,
				'headers' => array(
					'Authorization' => 'Bearer ' . $access_token,
				),
			);

			$test         = wp_remote_post( "https://www.zohoapis{$dataCenter}/crm/v2/{$this->module}", $args );
			$responceData = json_decode( wp_remote_retrieve_body( $test ), true );

			if ( isset( $responceData['data'] ) && isset( $responceData['data'][0] ) && isset( $responceData['data'][0]['code'] ) && strtolower( $responceData['data'][0]['code'] ) == 'success' ) {
				return true;
			}
		}
	}
}
