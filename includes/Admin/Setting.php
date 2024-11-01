<?php

/**
 * Setting Handler class
 */

if ( ! class_exists( 'W3sc_Setting' ) ) {
	class W3sc_Setting {

		/**
		 * Handles the settings page
		 *
		 * @return void
		 */
		public function settings_page() {
			/*echo esc_url(get_site_url()); ?>/wp-admin/admin.php?page=w3sc-elementor*/

			$redirectURLEncoded = urlencode_deep( admin_url( 'edit.php?page=w3sc-elementor' ) );
			$redirectURL        = admin_url( 'edit.php?page=w3sc-elementor' );
			$siteURL            = parse_url( site_url() )['host'];

			$dataSet = new InfosAuth();
			$dataSet->storeInfo( $_POST );
			$zcid       = $dataSet->getInfo( 'w3scelementor_zoho_client_id' );
			$dataCenter = $dataSet->getInfo( 'w3scelementor_zoho_data_center' ); ?>

			<script>
				/*
				* Auth notification Close
				*/

				function myFunction() {
					const element = document.getElementById("demo");
					element.remove();
				}

				/*
				* Remove Authenticate Notification by page reload
				*/
				var removeParams = ['w3scelementorsuccess'];
				const deleteRegex = new RegExp(removeParams.join('=|'));
				const params = location.search.slice(1).split(/[?&]+/);
				let search = []
				for (let i = 0; i < params.length; i++) {
					if (deleteRegex.test(params[i]) === false){ 
						search.push(params[i])
					}
				}
				window.history.replaceState({}, document.title, location.pathname + (search.length ? '?' + search.join('&') : '') + location.hash);
			</script>

			<?php
			// Get Authenticate Success/Failure notification
			$w3ssucc_noti = isset( $_GET['w3scelementorsuccess'] ) ? sanitize_text_field( $_GET['w3scelementorsuccess'] ) : '';
			// $w3ssucc_noti = sanitize_text_field( $w3ssucc_noti );

			if ( $w3ssucc_noti ) {
				if ( $w3ssucc_noti == 1 ) {
					printf( '<div class="notice notice-success is-dismissible"><p>%1$s</p></div>', 'Authenticated Successfully.' );
				} else {
					printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', 'Something went Wrong! Please Try again.' );
				}
			}

			echo '<div>';
			?>

			<?php do_action( '_message_' ); ?>
			<h2>Zoho Auth Settings</h2>
			<hr/>
			<form method="post">
				<table class="zoho-auth-info">
					<tr>
						<td colspan="2"><h3 >Information to create Zoho Client :: </h3></td>
					</tr>
					<tr>
						<td><h4>No Zoho CRM Account?</h4></td>
						<td>
							<a target="_blank" href="https://payments.zoho.com/ResellerCustomerSignUp.do?id=4c1e927246825d26d1b5d89b9b8472de"><b>Create FREE Account!</b></a>
						</td>
					</tr>
					<tr>
						<td><h4>Client Name</h4></td>
						<td><code>W3SC Elementor to Zoho CRM</code></td>
					</tr>        
					<tr>
						<td><h4>Client Domain</h4></td>
						<td><code><?php echo esc_html( $siteURL ); ?></code></td>
					</tr>
					<tr>
						<td><h4>Authorized Redirect URIs</h4></td>
						<td><code><?php echo esc_html( $redirectURL ); ?></code></td>
					</tr>
					<tr>
						<td><h4>Client Type</h4></td>
						<td><code>Web Based</code></td>
					</tr>
					<tr>
						<td colspan="2"><h3>Zoho Credentials :: </h3></td>
					</tr>
					<tr>
						<td><h4>Data Center</h4></td>
						<td>
							<?php
							foreach ( array(
								'zoho.com'    => '.com',
								'zoho.eu'     => '.eu',
								'zoho.com.au' => '.com.au',
								'zoho.in'     => '.in',
							) as $k => $v ) {
								$selected = $dataCenter == $v ? "checked='checked'" : '';
								?>

								<label><input type='radio' name='w3scelementor_zoho_data_center' value='<?php echo esc_html( $v ); ?>' <?php echo esc_html( $selected ); ?>><span style='margin-right:15px;'><?php echo esc_html( $k ); ?></span></label>

							<?php } ?>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<h4 class="zci">Zoho Client ID</h4>
						</td>
						<td>
							<input type="text" name="w3scelementor_zoho_client_id" id="w3scelementor_zoho_client_id" value="<?php echo esc_html( $dataSet->getInfo( 'w3scelementor_zoho_client_id' ) ); ?>">
							<p class="guid">Your Zoho App Client ID. To Generate, Please follow <a href="https://www.zoho.com/crm/help/developer/api/register-client.html" target="_blank">this instructions.</a></p>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<h4 class="zcs">Zoho Client Secret</h4>
						</td>
						<td>
							<input type="password" name="w3scelementor_zoho_client_secret" id="w3scelementor_zoho_client_secret" value="<?php echo esc_html( $dataSet->getInfo( 'w3scelementor_zoho_client_secret' ) ); ?>">
							<p class="guid">Your Zoho App Client Secret. To Generate, Please follow <a href="https://www.zoho.com/crm/help/developer/api/register-client.html" target="_blank">this instructions.</a></p>
						</td>
					</tr>
					<tr>
						<td>
							<h4>Zoho User Email</h4>
						</td>
						<td>
							<input type="email" name="w3scelementor_zoho_user_email" id="w3scelementor_zoho_user_email" value="<?php echo esc_html( $dataSet->getInfo( 'w3scelementor_zoho_user_email' ) ); ?>">
						</td>
					</tr>
					<?php if ( $dataSet->getInfo( 'w3scelementor_zoho_client_id' ) && $dataSet->getInfo( 'w3scelementor_zoho_data_center' ) ) : ?>
					<tr>
						<td>
							<h4>Authorize Zoho Account</h4>
						</td>
						<td>
							<a href="https://accounts.zoho<?php echo esc_html( $dataCenter ); ?>/oauth/v2/auth?scope=ZohoCRM.modules.ALL,ZohoCRM.settings.ALL&client_id=<?php echo esc_html( $zcid ); ?>&response_type=code&access_type=offline&prompt=consent&redirect_uri=<?php echo esc_html( $redirectURLEncoded ); ?>"><b>Grant Access</b></a> <?php w3sc_refreshtoken(); ?>
						</td>
					</tr>
					<?php endif; ?>
					<tr>
						<td colspan="2">
							<div style="margin-top: 20px">
								<button name="store_zoho_info" value="save" class="button button-primary">Save & Bring Grant Access</button>
							</div>
						</td>
					</tr>
				</table>
			</form>
			<?php
			echo '</div>';
		}
	}
}
