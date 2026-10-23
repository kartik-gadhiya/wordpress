<?php
if ( ! function_exists( "finspire_add_metaboxes" ) ) {
	function finspire_add_metaboxes( $metaboxes ) {
		$directories_array = array(
			'page.php',
		);
		foreach ( $directories_array as $dir ) {
			$metaboxes[] = require_once( FINSPIREPLUGIN_PLUGIN_PATH . '/metabox/' . $dir );
		}

		return $metaboxes;
	}

	add_action( "redux/metaboxes/finspire_options/boxes", "finspire_add_metaboxes" );
}

