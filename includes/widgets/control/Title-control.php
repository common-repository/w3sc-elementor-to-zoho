<?php
// Title control section

$this->start_controls_section(
	'title_control_section',
	array(
		'label' => __( 'Title Control', 'plugin-name' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

// Field Title color
$this->add_control(
	'list_color',
	array(
		'label'     => __( 'Title Color', 'w3sc-elementor' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'default'   => '#39b54a',
		'selectors' => array(
			'{{WRAPPER}} .lis-tit' => 'color: {{VALUE}}',
		),
	)
);

// Field title alignment
$this->add_control(
	'text_align',
	array(
		'label'   => __( 'Title Alignment', 'w3sc-elementor' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => array(
			'left'   => array(
				'title' => __( 'Left', 'w3sc-elementor' ),
				'icon'  => 'fa fa-align-left',
			),
			'center' => array(
				'title' => __( 'Center', 'w3sc-elementor' ),
				'icon'  => 'fa fa-align-center',
			),
			'right'  => array(
				'title' => __( 'Right', 'w3sc-elementor' ),
				'icon'  => 'fa fa-align-right',
			),
		),
		'default' => 'left',
		'toggle'  => true,
	)
);

// Add margin to title
$this->add_control(
	'margin',
	array(
		'label'      => __( 'Title Margin', 'w3sc-elementor' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => array( 'px', '%', 'em' ),
		'selectors'  => array(
			'{{WRAPPER}} .lis-tit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		),
	)
);

$this->end_controls_section();
