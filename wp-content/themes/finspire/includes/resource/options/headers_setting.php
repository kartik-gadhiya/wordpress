<?php
return array(
	'title'      => esc_html__( 'Header Setting', 'finspire' ),
	'id'         => 'headers_setting',
	'desc'       => '',
	'subsection' => false,
	'fields'     => array(
		array(
			'id'      => 'header_source_type',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Header Source Type', 'finspire' ),
			'options' => array(
				'd' => esc_html__( 'Default', 'finspire' ),
				'e' => esc_html__( 'Elementor', 'finspire' ),
			),
			'default' => 'd',
		),
		array(
			'id'       => 'header_elementor_template',
			'type'     => 'select',
			'title'    => __( 'Template', 'finspire' ),
			'data'     => 'posts',
			'args'     => [
				'post_type' => [ 'header' ],
				'posts_per_page'	=> -1
			],
			'required' => [ 'header_source_type', '=', 'e' ],
		),
		array(
			'id'       => 'header_style_section_start',
			'type'     => 'section',
			'indent'      => true,
			'title'    => esc_html__( 'Header Settings', 'finspire' ),
			'required' => array( 'header_source_type', '=', 'd' ),
		),

		//Header Settings
		array(
		    'id'       => 'header_style_settings',
		    'type'     => 'image_select',
		    'title'    => esc_html__( 'Choose Header Styles', 'finspire' ),
		    'subtitle' => esc_html__( 'Choose Header Styles', 'finspire' ),
		    'options'  => array(

			    'header_v1'  => array(
				    'alt' => esc_html__( 'Header Style 1', 'finspire' ),
				    'img' => get_template_directory_uri() . '/assets/images/redux/header/header_v1.png',
			    ),
			),
			'required' => array( 'header_source_type', '=', 'd' ),
			'default' => 'header_v1',
	    ),

		/***********************************************************************
								Header Version 1 Start
		************************************************************************/
		//Button Info
		array(
            'id' => 'show_btn',
            'type' => 'switch',
            'title' => esc_html__('ON/OFF Button', 'finspire'),
            'default' => false,
            'required' => array( 'header_style_settings', '=', 'header_v1' ),
        ),
		array(
			'id'      => 'btn_title',
			'type'    => 'text',
			'title'   => __( 'Button Title', 'finspire' ),
			'default' => esc_html__('Get In Touch', 'finspire'),
			'required' => array( 'show_btn', '=', true ),
		),
		array(
			'id'      => 'page_selects',
			'type'    => 'select',
			'title'   => __( 'Select Page', 'finspire' ),
			'default' => esc_html__( 'Contact Us', 'finspire' ),
			'options' => finspire_page_list(),
			'required' => array( 'show_btn', '=', true ),
		),
		array(
            'id' => 'show_header_sidebar_v1',
            'type' => 'switch',
            'title' => esc_html__('ON/OFF Sidebar', 'finspire'),
            'default' => false,
            'required' => array( 'header_style_settings', '=', 'header_v1' ),
        ),
		
		array(
			'id'       => 'header_style_section_end',
			'type'     => 'section',
			'indent'      => false,
			'required' => [ 'header_source_type', '=', 'd' ],
		),
	),
);
