<?php
// Typography Section

$this->start_controls_section(
	'typography_section',
	array(
		'label' => __( 'Typography', 'plugin-name' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	)
);

// Field Title Typography
$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'field_title_typo',
		'label'    => __( 'Field Title', 'w3sc-elementor' ),
		'scheme'   => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
		'selector' => '{{WRAPPER}} .lis-tit',
	)
);

// Button Title Typography
$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	array(
		'name'     => 'button_title_typo',
		'label'    => __( 'Button Title', 'w3sc-elementor' ),
		'scheme'   => Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
		'selector' => '{{WRAPPER}} #w3sc-crm-insert',
	)
);

$this->end_controls_section();
