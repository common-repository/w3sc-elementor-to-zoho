<?php

// Button control
$this->start_controls_section(
	'typography_section2',
	array(
		'label' => __( 'Button Control', 'plugin-name' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);


// Submit Button title
$this->add_control(
	'button_title',
	array(
		'label'   => __( 'Title', 'w3sc-elementor' ),
		'type'    => \Elementor\Controls_Manager::TEXT,
		'default' => 'Send',
	)
);

// Submit Button background color
$this->add_control(
	'button_background',
	array(
		'label'     => __( 'Button BG', 'w3sc-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => '#cecece',
		'selectors' => array(
			'{{WRAPPER}} #w3sc-crm-insert' => 'background-color: {{VALUE}}',
		),
	)
);

// Submit Button Text color
$this->add_control(
	'button_text_color',
	array(
		'label'     => __( 'Button Text color', 'w3sc-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => '#424242',
		'selectors' => array(
			'{{WRAPPER}} #w3sc-crm-insert' => 'color: {{VALUE}}',
		),
	)
);

// Button Border control
$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'button-border',
		'selector' => '{{WRAPPER}} #w3sc-crm-insert',
	)
);

// Button Border focus color
$this->add_control(
	'button_border_focus',
	array(
		'label'     => __( 'Button Border Focus', 'w3sc-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => 'Tomato',
		'selectors' => array(
			'{{WRAPPER}} #w3sc-crm-insert' => 'outline-color: {{VALUE}}',
		),
	)
);

// Add margin to Submit Button
$this->add_control(
	'margin-submit',
	array(
		'label'      => __( 'Button Margin', 'w3sc-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} #w3sc-crm-insert' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();
