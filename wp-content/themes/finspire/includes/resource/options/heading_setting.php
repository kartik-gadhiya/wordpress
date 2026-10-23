<?php

return array(

    'title'         => esc_html__( 'Heading Settings', 'finspire' ),
    'id'            => 'heading_setting',
    'desc'          => '',
    'subsection'    => true,
    'fields'        => array(

        array(

            'id' => 'use_custom_heading_style_h1',

            'type' => 'switch',

            'title' => esc_html__('Use H1 Custom Font', 'finspire'),

            'desc' => esc_html__('Enable to customize the theme heading h1 tag font', 'finspire'),

            ),

        array(

            'id' => 'h1_typography',

            'type' => 'typography',

            'title' => esc_html__('H1 Font Typography', 'finspire'),

            'google' => true,

            'font-backup' => true,

            'output' => array('h1', '.sec-title h1' ),

            'units' => 'px',

            'subtitle' => esc_html__('Apply options to customize the h1 heading font for the theme', 'finspire'),

            'default' => array(

                'color' => '',

                'font-style' => '',

                'font-family' => '',

                'google' => true,

                'font-size' => '',

                'line-height' => ''

                ),

                'required' => array('use_custom_heading_style_h1', '=', true),

            ),

        array(

            'id' => 'use_custom_heading_style_h2',

            'type' => 'switch',

            'title' => esc_html__('Use H2 Custom Font', 'finspire'),

            'desc' => esc_html__('Enable to customize the theme heading h2 tag font', 'finspire'),

            ),

        array(

            'id' => 'h2_typography',

            'type' => 'typography',

            'title' => esc_html__('H2 Font Typography', 'finspire'),

            'google' => true,

            'font-backup' => true,

            'output' => array('h2', '.sec-title h2', '.main-slider .main-slider-content .big-title h2' ),

            'units' => 'px',

            'subtitle' => esc_html__('Apply options to customize the h2 heading font for the theme', 'finspire'),

            'default' => array(

                'color' => '',

                'font-style' => '',

                'font-family' => '',

                'google' => true,

                'font-size' => '',

                'line-height' => ''

                ),


            'required' => array('use_custom_heading_style_h2', '=', true),

            ),

        array(

            'id' => 'use_custom_heading_style_h3',

            'type' => 'switch',

            'title' => esc_html__('Use H3 Custom Font', 'finspire'),

            'desc' => esc_html__('Enable to customize the theme heading h3 tag font', 'finspire'),

            ),

        array(

            'id' => 'h3_typography',

            'type' => 'typography',

            'title' => esc_html__('H3 Font Typography', 'finspire'),

            'google' => true,

            'font-backup' => true,

            'output' => array('h3', '.sec-title h3', '.slide-single-fact-counter .outer-box .count-outer span', '.slide-single-fact-counter .outer-box .count-outer .k', '.service-style1__single .title-box h3 a' ),

            'units' => 'px',

            'subtitle' => esc_html__('Apply options to customize the h3 heading  for the theme', 'finspire'),

            'default' => array(

                'color' => '',

                'font-style' => '',

                'font-family' => '',

                'google' => true,

                'font-size' => '',

                'line-height' => ''

                ),


            'required' => array('use_custom_heading_style_h3', '=', true),

            ),

        array(

            'id' => 'use_custom_heading_style_h4',

            'type' => 'switch',

            'title' => esc_html__('Use H4 Custom Font', 'finspire'),

            'desc' => esc_html__('Enable to customize the theme heading h4 tag font', 'finspire'),

            ),

        array(

            'id' => 'h4_typography',

            'type' => 'typography',

            'title' => esc_html__('H4 Font Typography', 'finspire'),

            'google' => true,

            'font-backup' => true,

            'output' => array('h4', '.sec-title h4' ),

            'units' => 'px',

            'subtitle' => esc_html__('Apply options to customize the h4 heading font for the theme', 'finspire'),

            'default' => array(

                'color' => '',

                'font-style' => '',

                'font-family' => '',

                'google' => true,

                'font-size' => '',

                'line-height' => ''

                ),


            'required' => array('use_custom_heading_style_h4', '=', true),

        ),

        array(

            'id' => 'use_custom_heading_style_h5',

            'type' => 'switch',

            'title' => esc_html__('Use H5 Custom Font', 'finspire'),

            'desc' => esc_html__('Enable to customize the theme heading h5 tag font', 'finspire'),

            ),

        array(

            'id' => 'h5_typography',

            'type' => 'typography',

            'title' => esc_html__('H5 Font Typography', 'finspire'),

            'google' => true,

            'font-backup' => true,

            'output' => array('h5', '.sec-title h5' ),

            'units' => 'px',

            'subtitle' => esc_html__('Apply options to customize the h5 heading font for the theme', 'finspire'),

            'default' => array(

                'color' => '',

                'font-style' => '',

                'font-family' => '',

                'google' => true,

                'font-size' => '',

                'line-height' => ''

                ),


            'required' => array('use_custom_heading_style_h5', '=', true),

            ),

        array(

            'id' => 'use_custom_heading_style_h6',

            'type' => 'switch',

            'title' => esc_html__('Use H6 Custom Font', 'finspire'),

            'desc' => esc_html__('Enable to customize the theme heading h6 tag font', 'finspire'),

            ),

        array(

            'id' => 'h6_typography',

            'type' => 'typography',

            'title' => esc_html__('H6 Font Typography', 'finspire'),

            'google' => true,

            'font-backup' => true,

            'output' => array('h6', '.sec-title h6' ),

            'units' => 'px',

            'subtitle' => esc_html__('Apply options to customize the h6 heading font for the theme', 'finspire'),

            'default' => array(

                'color' => '',

                'font-style' => '',

                'font-family' => '',

                'google' => true,

                'font-size' => '',

                'line-height' => ''

                ),


            'required' => array('use_custom_heading_style_h6', '=', true),

            )
    )
);

