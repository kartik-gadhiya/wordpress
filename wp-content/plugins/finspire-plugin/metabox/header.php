<?php

return array(
	'id'     => 'finspire_header_settings',
	'title'  => esc_html__( "Finspire Header Settings", "konia" ),
	'fields' => array(
		array(
			'id'      => 'header_source_type',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Header Source Type', 'finspire' ),
			'options' => array(
				'd' => esc_html__( 'Default', 'finspire' ),
				'e' => esc_html__( 'Elementor', 'finspire' ),
			),
			'default'=> '',
		),
		array(
			'id'       => 'header_new_elementor_template',
			'type'     => 'select',
			'title'    => __( 'Template', 'finspire-plugin' ),
			'data'     => 'posts',
			'args'     => [
				'post_type' => [ 'header' ],
				'posts_per_page' => -1,
				'orderby'  => 'title',
				'order'     => 'DESC'
			],
			'required' => [ 'header_source_type', '=', 'e' ],
		),
		array(
			'id'       => 'header_style_settings',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Choose Header Styles', 'finspire' ),
			'options'  => array(
				'header_v1' => array(
					'alt' => 'Header Style 1',
					'img' => get_template_directory_uri() . '/assets/images/redux/header/header_v1.png',
				),
			),
			'required' => array( array( 'header_source_type', 'equals', 'd' ) ),
			'default' => 'header_v1',
		),
	),
);