<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an emendable content into the page, from any given URL.
 *
 * @since 1.0.0
 */


class W3sc_oEmbed_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'zoho crm';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'W3SC Elementor to Zoho', 'plugin-name' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-book';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'basic' );
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// content Section
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'CRM Leads', 'w3sc-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		// Field Title
		$repeater->add_control(
			'list_title',
			array(
				'label'       => __( 'Field Title', 'w3sc-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Title #', 'w3sc-elementor' ),
				'label_block' => true,
			)
		);

		// Field Placeholder
		$repeater->add_control(
			'field_placeholder',
			array(
				'label' => __( 'Placeholder', 'w3sc-elementor' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		// Fetch CRM fields Name
		$access_token = w3sc_accessToken();
		if ( $access_token ) {
			$contactfields = $this->w3sc_crmfields( $access_token, 'Contacts' );
			$leadfields    = $this->w3sc_crmfields( $access_token, 'Leads' );
		}

		if ( $contactfields['fields'] ) {
			foreach ( $contactfields['fields'] as $key => $value ) {
				$name     = $value['api_name'];
				$datatype = $value['data_type'];

				// Check field is lookup or not
				if ( $datatype != 'lookup' && $datatype != 'ownerlookup' ) {
					$namesec                              = $name . '' . '(' . $datatype . ')' . '(' . 'Contact' . ')';
					$contactFields[ 'Contact__' . $name ] = $namesec;
				}
			}
		}

		if ( $leadfields['fields'] ) {
			foreach ( $leadfields['fields'] as $key => $value ) {
				$name     = $value['api_name'];
				$datatype = $value['data_type'];

				// Check field is lookup or not
				if ( $datatype != 'lookup' && $datatype != 'ownerlookup' ) {
					$namesec                        = $name . '' . '(' . $datatype . ')' . '(' . 'Lead' . ')';
					$leadFields[ 'Lead__' . $name ] = $namesec;
				}
			}
		}
		if ( null !== $contactFields && $leadFields ) {
			$crmFields = ( array_merge( $contactFields, $leadFields ) );
		} else {
			$crmFields = '';
		}

		// Select CRM insert fields
		$repeater->add_control(
			'contact_field',
			array(
				'label'   => __( 'Select CRM Field', 'w3sc-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'Name',
				'options' => $crmFields,
			)
		);

		// Select CRM Module
		$this->add_control(
			'lead_contact',
			array(
				'label'   => __( 'Select CRM Module', 'w3sc-elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'Contacts',
				'options' => array(
					'Contacts' => __( 'Contacts', 'w3sc-elementor' ),
					'Leads'    => __( 'Leads', 'w3sc-elementor' ),
				),
			)
		);

		$this->add_control(
			'list',
			array(
				'label'       => __( 'Zoho Fields', 'w3sc-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'list_title' => __( 'Title #', 'w3sc-elementor' ),
					),
				),
				'title_field' => '{{{ list_title }}}',
			)
		);

		$this->end_controls_section();

		// Include Title control file
		require_once 'control/Title-control.php';

		// Include Field control file
		require_once 'control/Field-control.php';

		// Include Button control file
		require_once 'control/Button-control.php';

		// Include Typography control file
		require_once 'control/W3sc-typography.php';

	}



	// Fetch bigin Fields name/type
	function w3sc_crmfields( $access_token, $module ) {
			 $dataSet   = new InfosAuth();
			$dataCenter = $dataSet->getInfo( 'w3scelementor_zoho_data_center' );

			$args = array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $access_token,
				),
			);

			$test         = wp_remote_get( "https://www.zohoapis{$dataCenter}/crm/v2/settings/fields?module={$module}", $args );
			$responceData = json_decode( wp_remote_retrieve_body( $test ), true );
			return $responceData;

	}


	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['list'] ) {

			$index_no = 0;

			?>
			<form action="#" id="w3sc-crm-connect-form" method="post">
			<?php

			// Get Selected CRM Modules
			if ( ( isset( $settings['lead_contact'] ) && $settings['lead_contact'] == 'Contacts' ) ) {
					$module_select = 'Contacts';
			} elseif ( ( isset( $settings['lead_contact'] ) && $settings['lead_contact'] == 'Leads' ) ) {
					$module_select = 'Leads';
			} else {
					$module_select = '';
			}

			// Take hidden fields to detect CRM modules

			?>

			<input type='hidden' name='w3sc-select-contact' value='<?php echo esc_attr( $module_select ); ?>'/>

			<?php
			foreach ( $settings['list'] as $item ) {

				// Get Selected CRM fields
				$selected_crm_fieldname = $settings['list'][ "$index_no" ]['contact_field'];
				?>

				 <label style="text-align: <?php echo esc_attr( $settings['text_align'] ); ?>" class="lis-tit elementor-repeater-item-' .<?php echo esc_attr( $item['_id'] ); ?> . '"> <?php echo esc_attr( $item['list_title'] ); ?></label>

				 <br>
				 <input style="padding-left: 20px;" type="text" class="fld-wid" id="<?php echo $selected_crm_fieldname; ?>" name="<?php echo $selected_crm_fieldname; ?>" placeholder="<?php echo $item['field_placeholder']; ?>" autocomplete="nope" required>
				<br><br>

				<?php
				$index_no++;
			}
		}
		?>
				<input class="btn" type="submit" id="w3sc-crm-insert" value="<?php echo esc_html( $settings['button_title'] ); ?>">
				<p id="w3sc_msg"></p>

		</form>
		<?php
	}


	protected function content_template() {
		?>
		<# if ( settings.list.length ) { #>
		<dl>
			<# _.each( settings.list, function( item ) { #>

				<label class="elementor-repeater-item-{{ item._id }}">{{{ item.list_title }}}</label>

			<# }); #>
			</dl>
		<# } #>
		<?php
	}
}
