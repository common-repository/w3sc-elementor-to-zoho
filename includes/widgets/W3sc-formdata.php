<?php
// Get Form Input Data

if ( isset( $_POST['purpose'] ) && $_POST['purpose'] == 'w3sc-crm-connect' ) {
	$formdata = sanitize_post( $_POST['data'] );

	// Get Selected modules
	$moduleName = $formdata[0]['value'];

	// Check if selected field empty
	$formdata['']['value']      = '';
	$formdata[ false ]['value'] = '';


	// Get Form field values
	$fieldValues = array();
	foreach ( $formdata as $k => $v ) {
		if ( $k < 1 ) {
			continue;
		}
		$index                 = explode( '__', $v['name'] );
		$index                 = isset( $index[1] ) ? $index[1] : '';
		$fieldValues[ $index ] = $v['value'];
	}


	// Prepare All Data
	$all_data = json_encode(
		array(
			'data' => array( $fieldValues ),
		)
	);


	// Call CRM data insert methods
	if ( $moduleName ) {

		if ( $moduleName == 'Contacts' ) {
			$contact_obj      = new W3sc_Datainsert();
			$send_contactdata = $contact_obj->set_data( $all_data, $moduleName );
		} elseif ( $moduleName == 'Leads' ) {
			$lead_obj      = new W3sc_Datainsert();
			$send_leaddata = $lead_obj->set_data( $all_data, $moduleName );
		}

		if ( $send_contactdata && ! $send_leaddata ) {
			echo 1;
		} elseif ( ! $send_contactdata && $send_leaddata ) {
			echo 2;
		}
	}
}
