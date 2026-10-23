<?php

return array(
	'title'      => esc_html__( '404 Page Settings', 'finspire' ),
	'id'         => '404_setting',
	'desc'       => '',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'      => '404_source_type',
			'type'    => 'button_set',
			'title'   => esc_html__( '404 Source Type', 'finspire' ),
			'options' => array(
				'd' => esc_html__( 'Default', 'finspire' ),
				'e' => esc_html__( 'Elementor', 'finspire' ),
			),
			'default' => 'd',
		),
		array(
			'id'       => '404_elementor_template',
			'type'     => 'select',
			'title'    => __( 'Template', 'finspire' ),
			'data'     => 'posts',
			'args'     => [
				'post_type' => [ 'elementor_library' ],
			],
			'required' => [ '404_source_type', '=', 'e' ],
		),
		array(
			'id'       => '404_default_st',
			'type'     => 'section',
			'title'    => esc_html__( '404 Default', 'finspire' ),
			'indent'   => true,
			'required' => [ '404_source_type', '=', 'd' ],
		),
		array(
			'id'    => '404_page_title',
			'type'  => 'text',
			'title' => esc_html__( '404 Page Title', 'finspire' ),
			'default'  => esc_html__( '404', 'finspire' ),
			'desc'  => esc_html__( 'Enter 404 section Page Title that you want to show', 'finspire' ),
		),
		array(
			'id'    => '404_page_heading',
			'type'  => 'text',
			'title' => esc_html__( '404 Page Heading', 'finspire' ),
			'default'  => esc_html__( 'Page not found', 'finspire' ),
			'desc'  => esc_html__( 'Enter 404 section Page Heading that you want to show', 'finspire' ),
		),
		array(
			'id'    => '404_page_content',
			'type'  => 'textarea',
			'title' => esc_html__( '404 Page Content', 'finspire' ),
			'default'  => esc_html__( 'Try refining your search or use the navigation below to return to the main home page..', 'finspire' ),
			'desc'  => esc_html__( 'Enter 404 section Page Content that you want to show', 'finspire' ),
		),
		array(
			'id'    => 'back_home_btn',
			'type'  => 'switch',
			'title' => esc_html__( 'Show Button', 'finspire' ),
			'desc'  => esc_html__( 'Enable to show back to home button.', 'finspire' ),
			'default'  => true,
		),
		array(
			'id'       => 'back_home_btn_label',
			'type'     => 'text',
			'title'    => esc_html__( 'Button Label', 'finspire' ),
			'desc'     => esc_html__( 'Enter back to home button label that you want to show.', 'finspire' ),
			'default'  => esc_html__( 'Back to Home Page', 'finspire' ),
			'required' => array( 'back_home_btn', '=', true ),
		),
		
		array(
			'id'     => '404_post_settings_end',
			'type'   => 'section',
			'indent' => false,
		),
	),
);