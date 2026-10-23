<?php
return array(
	'title'      => 'Finspire Setting',
	'id'         => 'finspire_meta',
	'icon'       => 'el el-cogs',
	'position'   => 'normal',
	'priority'   => 'core',
	'post_types' => array( 'page', 'post', 'product' ),
	'sections'   => array(
		require_once FINSPIREPLUGIN_PLUGIN_PATH . '/metabox/header.php',
		require_once FINSPIREPLUGIN_PLUGIN_PATH . '/metabox/banner.php',
		require_once FINSPIREPLUGIN_PLUGIN_PATH . '/metabox/sidebar.php',
		require_once FINSPIREPLUGIN_PLUGIN_PATH . '/metabox/footer.php',
	),
);