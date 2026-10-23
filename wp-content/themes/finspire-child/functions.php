<?php
/**
 * Theme functions and definitions.
 */
function finspire_child_enqueue_styles() {

    if ( SCRIPT_DEBUG ) {
        wp_enqueue_style( 'finspire-style' , get_template_directory_uri() . '/style.css' );
    } else {
        wp_enqueue_style( 'finspire-minified-style' , get_template_directory_uri() . '/style.css' );
    }

    wp_enqueue_style( 'finspire-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'finspire-style' ),
        wp_get_theme()->get('Version')
    );
}

add_action(  'wp_enqueue_scripts', 'finspire_child_enqueue_styles' );