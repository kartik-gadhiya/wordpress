<?php

return array(
	'id'     => 'finspire_footer_settings',
	'title'  => esc_html__( "Finspire Footer Settings", "konia" ),
	'fields' => array(
		array(
			'id'      => 'footer_source_type',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Footer Source Type', 'finspire' ),
			'options' => array(
				'd'    => esc_html__( 'Default', 'finspire' ),
				'e'    => esc_html__( 'Elementor', 'finspire' ),
			),
			'default' => '',
		),
		array(
			'id'       => 'footer_elementor_template',
			'type'     => 'select',
			'title'    => __( 'Template', 'viral-buzz' ),
			'data'     => 'posts',
			'args'     => [
				'post_type' => [ 'footer' ],
				'posts_per_page'=> -1,
				'orderby'  => 'title',
				'order'     => 'DESC'
			],
			'required' => [ 'footer_source_type', '=', 'e' ],
		),
		array(
			'id'       => 'footer_style_settings',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Choose Footer Styles', 'finspire' ),
			'options'  => array(
				'footer_v1' => array(
					'alt' => 'Footer Style 1',
					'img' => get_template_directory_uri() . '/assets/images/redux/footer/footer_v1.png',
				),
			),
			'required' => array( array( 'footer_source_type', 'equals', 'd' ) ),
			'default' => 'footer_v1',
		),
	),
);