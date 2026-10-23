<?php

return array(

    'title'         => esc_html__( 'Mobile Sidebar Settings', 'finspire' ),
    'id'            => 'mobile_setting',
    'desc'          => '',
    'icon'          => 'el el-font',
    'fields'        => array(
        //Mobile Logo
		array(
            'id' => 'mobile_logo_show',
            'type' => 'switch',
            'title' => esc_html__('Enable Mobile View Logo', 'finspire'),
            'default' => true,
        ),
		array(
			'id'       => 'mobile_logo',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Mobile View Logo Image', 'finspire' ),
			'subtitle' => esc_html__( 'Insert site Mobile View logo image', 'finspire' ),
			'required' => array( 'mobile_logo_show', '=', true ),
		),
		array(
			'id'       => 'mobile_logo_dimension',
			'type'     => 'dimensions',
			'title'    => esc_html__( 'Mobile View Logo Dimentions', 'finspire' ),
			'subtitle' => esc_html__( 'Select Mobile View Logo Dimentions', 'finspire' ),
			'units'    => array( 'em', 'px', '%' ),
			'default'  => array( 'Width' => '', 'Height' => '' ),
			'required' => array( 'mobile_logo_show', '=', true ),
		),
		array(
			'id'      => 'mobile_info_title',
			'type'    => 'text',
			'title'   => __( 'Mobile Info Title', 'finspire' ),
			'default' => esc_html__('Contact Info', 'finspire'),
		),
		array(
			'id'      => 'mobile_address',
			'type'    => 'text',
			'title'   => __( 'Mobile Address', 'finspire' ),
			'default' => esc_html__('Chicago 12, Melborne City, USA', 'finspire'),
		),
		array(
			'id'      => 'mobile_phone',
			'type'    => 'text',
			'title'   => __( 'Mobile View Phone Number', 'finspire' ),
			'default' => esc_html__('444-000-777-66', 'finspire'),
		),
		array(
			'id'      => 'mobile_email',
			'type'    => 'text',
			'title'   => __( 'Mobile View Email Address', 'finspire' ),
			'default' => esc_html__('info@example.com', 'finspire'),
		),
		array(
            'id' => 'show_mobile_social',
            'type' => 'switch',
            'title' => esc_html__('Enable Mobile View Social Icons', 'finspire'),
            'default' => true,
        ),
		
    ),
);

