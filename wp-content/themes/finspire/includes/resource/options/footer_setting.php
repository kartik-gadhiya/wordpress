<?php

return array(
	'title'      => esc_html__( 'Footer Setting', 'finspire' ),
	'id'         => 'footer_setting',
	'desc'       => '',
	'subsection' => false,
	'fields'     => array(
		array(
			'id'      => 'footer_source_type',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Footer Source Type', 'finspire' ),
			'options' => array(
				'd' => esc_html__( 'Default', 'finspire' ),
				'e' => esc_html__( 'Elementor', 'finspire' ),
			),
			'default' => 'd',
		),
		array(
			'id'       => 'footer_elementor_template',
			'type'     => 'select',
			'title'    => __( 'Template', 'finspire' ),
			'data'     => 'posts',
			'args'     => [
				'post_type' => [ 'footer' ],
				'posts_per_page'	=> -1
			],
			'required' => [ 'footer_source_type', '=', 'e' ],
		),
		array(
			'id'       => 'footer_style_section_start',
			'type'     => 'section',
			'indent'      => true,
			'title'    => esc_html__( 'Footer Settings', 'finspire' ),
			'required' => array( 'footer_source_type', '=', 'd' ),
		),
		array(
		    'id'       => 'footer_style_settings',
		    'type'     => 'image_select',
		    'title'    => esc_html__( 'Choose Footer Styles', 'finspire' ),
		    'subtitle' => esc_html__( 'Choose Footer Styles', 'finspire' ),
		    'options'  => array(
			    'footer_v1'  => array(
				    'alt' => esc_html__( 'Footer Style 1', 'finspire' ),
				    'img' => get_template_directory_uri() . '/assets/images/redux/footer/footer_v1.png',
			    ),
			),
			'required' => array( 'footer_source_type', '=', 'd' ),
			'default' => 'footer_v1',
	    ),		
		
		/***********************************************************************
								Footer Version 1 Start
		************************************************************************/
		array(
			'id'       => 'footer_v1_settings_section_start',
			'type'     => 'section',
			'indent'      => true,
			'title'    => esc_html__( 'Footer Style One Settings', 'finspire' ),
			'required' => array( 'footer_style_settings', '=', 'footer_v1' ),
		),
		array(
            'id' => 'show_footer_top',
            'type' => 'switch',
            'title' => esc_html__('Enable/Disable Top Footer', 'finspire'),
            'default' => false,
            'required' => array( 'footer_style_settings', '=', 'footer_v1' ),
        ),
		array(
			'id'       => 'logo_image',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Logo Image', 'finspire' ),
			'subtitle' => esc_html__( 'Insert Logo Image', 'finspire' ),
			'required' => array( 'show_footer_top', '=', true ),
		),
		array(
			'id'      => 'footer_text_v1',
			'type'    => 'textarea',
			'title'   => __( 'Footer Text', 'finspire' ),
			'default' => esc_html__( 'Partnering with you to achieve lasting financial success.', 'finspire' ),
			'required' => array( 'show_footer_top', '=', true ),
		),
		array(
			'id'      => 'footer_link_v1',
			'type'    => 'text',
			'title'   => __( 'Footer Text Link', 'finspire' ),
			'default' => esc_html__( '#', 'finspire' ),
			'required' => array( 'show_footer_top', '=', true ),
		),
		array(
            'id' => 'show_bottom_footer_v1',
            'type' => 'switch',
            'title' => esc_html__('Enable/Disable Bottom Footer', 'finspire'),
            'default' => false,
            'required' => array( 'footer_style_settings', '=', 'footer_v1' ),
        ),
		array(
            'id' => 'show_footer_social_v1',
            'type' => 'switch',
            'title' => esc_html__('Enable/Disable Social Icons', 'finspire'),
            'default' => false,
            'required' => array( 'show_bottom_footer_v1', '=', true ),
        ),
		array(
			'id'      => 'footer_social_title_v1',
			'type'    => 'text',
			'title'   => __( 'Social Icon Title', 'finspire' ),
			'default' => esc_html__( 'Socia Connect', 'finspire' ),
            'required' => array( 'show_footer_social_v1', '=', true ),
		),
		array(
			'id'      => 'footer_copyright_text_v1',
			'type'    => 'textarea',
			'title'   => __( 'Copyright Text', 'finspire' ),
            'default' => esc_html__( 'All Rights Reserved.', 'finspire' ),
            'required' => array( 'show_bottom_footer_v1', '=', true ),
		),
		
		array(
			'id'       => 'footer_default_ed',
			'type'     => 'section',
			'indent'   => false,
			'required' => [ 'footer_source_type', '=', 'd' ],
		),
	),
);
