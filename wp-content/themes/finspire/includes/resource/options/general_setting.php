<?php
$styles = [];
foreach(range(1, 28) as $val) {
    $styles[$val] = sprintf(esc_html__('Style %s', 'finspire'), $val);
}

return  array(
    'title'      => esc_html__( 'General Setting', 'finspire' ),
    'id'         => 'general_setting',
    'desc'       => '',
    'icon'       => 'el el-wrench',
    'fields'     => array(
        array(
            'id' => 'theme_preloader',
            'type' => 'switch',
            'title' => esc_html__('ON/OFF Preloader', 'finspire'),
            'default' => false,
        ),
		array(
            'id' => 'show_scroltop',
            'type' => 'switch',
            'title' => esc_html__('Hide Scroll To Top', 'finspire'),
            'default' => false,
        ),
    ),
);
