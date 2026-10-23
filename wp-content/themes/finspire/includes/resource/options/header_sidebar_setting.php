<?php
$styles = [];
foreach(range(1, 28) as $val) {
    $styles[$val] = sprintf(esc_html__('Style %s', 'finspire'), $val);
}

return  array(
    'title'      => esc_html__( 'Header Sidebar Setting', 'finspire' ),
    'id'         => 'header_sidebar_setting',
    'desc'       => '',
    'icon'       => 'el el-wrench',
    'fields'     => array(
       array(
            'id' => 'show_sidebar_info_v1',
            'type' => 'switch',
            'title' => esc_html__('Enable Header Sidebar Info', 'finspire'),
            'default' => false,
        ),
		//Sidebar Logo
		array(
            'id' => 'sidebar_logo_show',
            'type' => 'switch',
            'title' => esc_html__('Enable Light Color Logo', 'finspire'),
            'default' => true,
			'required' => array( 'show_sidebar_info_v1', '=', true ),
        ),
		array(
			'id'       => 'sidebar_logo',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__( 'Light Color Logo Image', 'finspire' ),
			'subtitle' => esc_html__( 'Insert site Light Color logo image', 'finspire' ),
			'required' => array( 'sidebar_logo_show', '=', true ),
		),
		array(
			'id'       => 'sidebar_logo_dimension',
			'type'     => 'dimensions',
			'title'    => esc_html__( 'Light Color Logo Dimentions', 'finspire' ),
			'subtitle' => esc_html__( 'Select Light Color Logo Dimentions', 'finspire' ),
			'units'    => array( 'em', 'px', '%' ),
			'default'  => array( 'Width' => '', 'Height' => '' ),
			'required' => array( 'sidebar_logo_show', '=', true ),
		),
		array(
			'id'      => 'sidebar_form_url_v1',
			'type'    => 'textarea',
			'title'   => __( 'Sidebar Form URL', 'finspire' ),
			'required' => array( 'show_sidebar_info_v1', '=', true ),
		),
		array(
			'id'      => 'header_sidebar_title_v1',
			'type'    => 'text',
			'title'   => __( 'Sidebar Title', 'finspire' ),
			'default' => esc_html__('Sidebar Title', 'finspire'),
			'required' => array( 'show_sidebar_info_v1', '=', true ),
		),
		array(
			'id'      => 'header_sidebar_btn_title_v1',
			'type'    => 'text',
			'title'   => __( 'Sidebar Button Title', 'finspire' ),
			'default' => esc_html__('Appointment', 'finspire'),
			'required' => array( 'show_sidebar_info_v1', '=', true ),
		),
		array(
			'id'      => 'header_sidebar_btn_link_v1',
			'type'    => 'text',
			'title'   => __( 'Sidebar Button Link', 'finspire' ),
			'default' => esc_html__('#', 'finspire'),
			'required' => array( 'show_sidebar_info_v1', '=', true ),
		),
		array(
			'id'      => 'header_sidebar_copyright_v1',
			'type'    => 'textarea',
			'title'   => __( 'Sidebar Copyright Text', 'finspire' ),
			'default' => esc_html__('All Rights Reserved.', 'finspire'),
			'required' => array( 'show_sidebar_info_v1', '=', true ),
		),
		
    ),
);

