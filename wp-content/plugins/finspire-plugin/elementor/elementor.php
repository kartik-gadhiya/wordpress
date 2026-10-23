<?php

namespace FINSPIREPLUGIN\Element;


class Elementor {
	static $widgets = array(
		//Headers
		'logo',
		'nav_menu',
		'button',
		'sidebar_icon',
		'nav_toggler',
		'info_box',
		'search_icon',
		
		//Home 01
		'headings',
		'circle_text',
		'author_card',
		'chart_card',
		'about_card',
		'title',
		'texts',
		'service_carousal',
		'chart_box',
		'guide_box',
		'count_box',
		'choose_card',
		'award_box',
		'industries_tabs',
		'process_tabs',
		'portfolio_card',
		'rating_card',
		'testimonial_card',
		'blog_grid',
		
		//Home 02
		'mission_card',
		'asset_card',
		'about_tabs',
		'portfolio_carousal',
		'step_card',
		'client_box',
		'pricing_plan',
		'form',
		
//		//Home 03
		'main_slider',
		'service_card',
		'team_carousal',
		'testimonial_tab',
		'info_card',
		'faqs',
		
		//Home 04
		'sliding_text',
		'float_image',
		
		//Blog
		'sidebar',
		
		//Team
		'team_card',
		
		//Footers
		'logo_widget',
		'links_menu',
		'video_icon',
		'megamenu_card',
		
		
		
	);

	static function init() {
		add_action( 'elementor/init', array( __CLASS__, 'loader' ) );
		add_action( 'elementor/elements/categories_registered', array( __CLASS__, 'register_cats' ) );
	}

	static function loader() {

		foreach ( self::$widgets as $widget ) {

			$file = FINSPIREPLUGIN_PLUGIN_PATH . '/elementor/' . $widget . '.php';
			if ( file_exists( $file ) ) {
				require_once $file;
			}

			add_action( 'elementor/widgets/widgets_registered', array( __CLASS__, 'register' ) );
		}
	}

	static function register( $elemntor ) {
		foreach ( self::$widgets as $widget ) {
			$class = '\\FINSPIREPLUGIN\\Element\\' . ucwords( $widget );

			if ( class_exists( $class ) ) {
				$elemntor->register_widget_type( new $class );
			}
		}
	}

	static function register_cats( $elements_manager ) {

		$elements_manager->add_category(
			'finspire',
			[
				'title' => esc_html__( 'finspire', 'finspire' ),
				'icon'  => 'fa fa-plug',
			]
		);
		$elements_manager->add_category(
			'templatepath',
			[
				'title' => esc_html__( 'Template Path', 'finspire' ),
				'icon'  => 'fa fa-plug',
			]
		);

	}
}

Elementor::init();