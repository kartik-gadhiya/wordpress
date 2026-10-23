<?php
return array(
	'title'      => esc_html__( 'Favicon Setting', 'finspire' ),
	'id'         => 'logo_setting',
	'desc'       => '',
	'subsection' => false,
	'fields'     => array(
		array(
			'id'       => 'image_favicon',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Favicon', 'finspire' ),
			'subtitle' => esc_html__( 'Insert site favicon image', 'finspire' ),
		),	
		
		//Home One Logo
		array(
            'id' => 'show_dark_logo',
            'type' => 'switch',
            'title' => esc_html__('Enable Dark Logo', 'finspire'),
            'default' => true,
        ),
		array(
			'id'       => 'dark_logo',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Dark Logo Image', 'finspire' ),
			'subtitle' => esc_html__( 'Insert site dark logo image', 'finspire' ),
			'required' => array( 'show_dark_logo', '=', true ),
		),
		array(
			'id'       => 'dark_logo_dimension',
			'type'     => 'dimensions',
			'title'    => esc_html__( 'Dark Logo Dimentions', 'finspire' ),
			'subtitle' => esc_html__( 'Select Dark Logo Dimentions', 'finspire' ),
			'units'    => array( 'em', 'px', '%' ),
			'default'  => array( 'Width' => '', 'Height' => '' ),
			'required' => array( 'show_dark_logo', '=', true ),
		),
		
		array(
			'id'       => 'logo_settings_section_end',
			'type'     => 'section',
			'indent'      => false,
		),
	),
);
