<?php
/**
 * Theme config file.
 *
 * @package FINSPIRE
 * @author  TonaTheme
 * @version 1.0
 * changed
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Restricted' );
}

$config = array();

$config['default']['finspire_main_header'][] 	= array( 'finspire_main_header_area', 99 );

$config['default']['finspire_main_footer'][] 	= array( 'finspire_main_footer_area', 99 );

$config['default']['finspire_sidebar'][] 	    = array( 'finspire_sidebar', 99 );

$config['default']['finspire_banner'][] 	    = array( 'finspire_banner', 99 );


return $config;
