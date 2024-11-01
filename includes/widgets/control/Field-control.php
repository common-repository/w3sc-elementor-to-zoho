<?php

// Input field control
$this->start_controls_section(
	'field_control_section',
	array(
		'label' => __( 'Field Control', 'plugin-name' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

// Field background color
$this->add_control(
	'background_color',
	array(
		'label'     => __( 'Field Background Color', 'w3sc-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => '#424242',
		'selectors' => array(
			'{{WRAPPER}} .fld-wid' => 'background-color: {{VALUE}}',
		),
	)
);

// Field Text color
$this->add_control(
	'field_text_color',
	array(
		'label'     => __( 'Field Text Color', 'w3sc-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => '#fff',
		'selectors' => array(
			'{{WRAPPER}} .fld-wid' => 'color: {{VALUE}}',
		),
	)
);

// Field Placeholder Text color
$this->add_control(
	'placeholder_text_color',
	array(
		'label'     => __( 'Placeholder Text Color', 'w3sc-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		// 'default' => '#fff',
		'selectors' => array(
			'{{WRAPPER}} .fld-wid::placeholder' => 'color: {{VALUE}}',
		),
	)
);

// Field box shadow
$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	array(
		'name'     => 'box_shadow',
		'label'    => __( 'Field Box Shadow', 'w3sc-elementor' ),
		'selector' => '{{WRAPPER}} .fld-wid',
	)
);

// Field and title width control

$this->add_control(
	'width',
	array(
		'label'      => __( 'Field Width', 'w3sc-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 5,
			),
			'%'  => array(
				'min' => 0,
				'max' => 100,
			),
		),
		'default'    => array(
			'unit' => 'px',
			'size' => 500,
		),
		'selectors'  => array(
			'{{WRAPPER}} .fld-wid,.lis-tit' => 'width: {{SIZE}}{{UNIT}};',
		),
	)
);

// Field height control

$this->add_control(
	'height',
	array(
		'label'      => __( 'Field Height', 'w3sc-elementor' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => array( 'px', '%' ),
		'range'      => array(
			'px' => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 5,
			),
			'%'  => array(
				'min' => 0,
				'max' => 100,
			),
		),
		'default'    => array(
			'unit' => 'px',
			'size' => 50,
		),
		'selectors'  => array(
			'{{WRAPPER}} .fld-wid' => 'height: {{SIZE}}{{UNIT}};',
		),
	)
);

// Add margin to input field
$this->add_control(
	'input-margin',
	array(
		'label'      => __( 'Field Margin', 'w3sc-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .fld-wid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

// Field Border control
$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	array(
		'name'     => 'border',
		'selector' => '{{WRAPPER}} .fld-wid',
	)
);

// Border focus color
$this->add_control(
	'border_focus_color',
	array(
		'label'     => __( 'Border Focus Color', 'w3sc-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => 'Tomato',
		'selectors' => array(
			'{{WRAPPER}} .fld-wid:focus' => 'outline-color: {{VALUE}}',
		),
	)
);

// Field border radius
$this->add_control(
	'radius',
	array(
		'label'      => __( 'Border Radius', 'w3sc-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .fld-wid' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();
