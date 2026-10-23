<?php

return array(

    'title'         => esc_html__( 'Body Font Settings', 'finspire' ),
    'id'            => 'body_font_setting',
    'desc'          => '',
    'subsection'    => true,
    'fields'        => array(
        array(
            'id' => 'body_custom_fonts',
            'type' => 'switch',
            'title' => esc_html__('Use Body,Paragraph Custom Font', 'finspire'),
            'desc' => esc_html__('Enable to customize the theme body,p tag font', 'finspire'),
        ),
		array(
            'id' => 'slider_typography',
            'type' => 'typography',
            'title' => esc_html__('Main Slider Font Typography', 'finspire'),
            'google' => true,
            'font-backup' => true,
            'output' => array('p', '.text > p', '.text', '.main-slider .main-slider-content .text p', '.slide-single-fact-counter .outer-box .title p' ),
            'units' => 'px',
            'subtitle' => esc_html__('Apply options to customize the body,paragraph font for the theme', 'finspire'),
            'default' => array(
                'color' => '',
                'font-style' => '',
                'font-family' => '',
                'google' => true,
                'font-size' => '',
                'line-height' => ''
            ),
            'required' => array('body_custom_fonts', '=', true),
        ),
        array(
            'id' => 'body_typography',
            'type' => 'typography',
            'title' => esc_html__('Body Font Typography', 'finspire'),
            'google' => true,
            'font-backup' => true,
            'output' => array('p', '.text > p', '.text', '.main-slider .main-slider-content .text p', '.slide-single-fact-counter .outer-box .title p' ),
            'units' => 'px',
            'subtitle' => esc_html__('Apply options to customize the body,paragraph font for the theme', 'finspire'),
            'default' => array(
                'color' => '',
                'font-style' => '',
                'font-family' => '',
                'google' => true,
                'font-size' => '',
                'line-height' => ''
            ),
            'required' => array('body_custom_fonts', '=', true),
        ),
    ),
);
