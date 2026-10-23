<?php

namespace FINSPIREPLUGIN\Element;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use Elementor\Plugin;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
 
class Nav_Menu extends Widget_Base {
	
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	 
	public function get_name() {
		return 'finspire_nav_menu';
	}
	
	/**
	 * Get widget title.
	 * Retrieve button widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	 
	public function get_title() {
		return esc_html__( 'Finspire Nav Menu', 'finspire' );
	}
	
	/**
	 * Get widget icon.
	 * Retrieve button widget icon.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	 
	public function get_icon() {
		return 'eicon-nav-menu';
	}
	
	/**
	 * Get widget categories.
	 * Retrieve the list of categories the button widget belongs to.
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	 
	public function get_categories() {
		return [ 'finspire' ];
	}
	
	/**
	 * Register button widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	 
	
	private function get_available_menus() {

		$menus = wp_get_nav_menus();

		$options = [];
		
		if ( ! empty( $menus ) ) {
			foreach ( $menus as $menu ) {
				$options[ $menu->slug ] = $menu->name;
			}
		}

		return $options;
	}
	
	protected function register_controls() {
		$this->start_controls_section(
			'nav_menu',
			[
				'label' => esc_html__( 'Nav Menu', 'finspire' ),
			]
		);
		$this->add_control(
			'select_menu',
			[
				'label'   => esc_html__( 'Select Menu', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1' => esc_html__( 'Multi Page Menu', 'finspire'),
					'2' => esc_html__( 'One Page Menu', 'finspire'),
				),
			]
		);
		$menus = $this->get_available_menus();
		
		$this->add_control(
            'fetch_menu',
            [
                'label'        => __( 'Select menu', 'finspire' ),
                'type'         => Controls_Manager::SELECT,
                'options'      => $menus,
                'default'      => !empty( $menus ) ? array_keys( $menus )[0] : '',
                'save_default' => true,
                'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'finspire' ), admin_url( 'nav-menus.php' ) ),
            ]
        );
		
		// Flex Direction Control
		$this->add_responsive_control(
			'nav_menu_flex_direction',
			[
				'label'              => __( 'Direction', 'finspire' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'row' => [
						'title' => __( 'Row - Horizontal', 'finspire' ),
						'icon'  => 'eicon-arrow-right',
					],
					'column' => [
						'title' => __( 'Column - Vertical', 'finspire' ),
						'icon'  => 'eicon-arrow-down',
					],
					'row-reverse' => [
						'title' => __( 'Row - Reversed', 'finspire' ),
						'icon'  => 'eicon-arrow-left',
					],
					'column-reverse' => [
						'title' => __( 'Column - Reversed', 'finspire' ),
						'icon'  => 'eicon-arrow-up',
					],
				],
				'default'            => 'row',
				'selectors'          => [
					'{{WRAPPER}} .main-menu .navbar-nav' => 'flex-direction: {{VALUE}};',
				],
				'frontend_available' => true,
			]
		);

		// Justify Content Control (Row)
		$this->add_responsive_control(
			'nav_menu_justify_content_row',
			[
				'label'              => __( 'Justify Content (R)', 'finspire' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'flex-start' => [
						'title' => __( 'Start', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-start-h',
					],
					'center' => [
						'title' => __( 'Center', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-center-h',
					],
					'flex-end' => [
						'title' => __( 'End', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-end-h',
					],
					'space-between' => [
						'title' => __( 'Space Between', 'finspire' ),
						'icon'  => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around' => [
						'title' => __( 'Space Around', 'finspire' ),
						'icon'  => 'eicon-flex eicon-justify-space-around-h',
					],
				],
				'default'            => 'flex-start',
				'selectors'          => [
					'{{WRAPPER}} .main-menu .navbar-nav' => 'justify-content: {{VALUE}};',
				],
				'condition'          => [
					'nav_menu_flex_direction' => ['row', 'row-reverse'],
				],
				'frontend_available' => true,
			]
		);

		// Align Items Control (Row)
		$this->add_responsive_control(
			'nav_menu_align_items_row',
			[
				'label'              => __( 'Align Items (R)', 'finspire' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'flex-start' => [
						'title' => __( 'Start', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-start-v',
					],
					'center' => [
						'title' => __( 'Center', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-center-v',
					],
					'flex-end' => [
						'title' => __( 'End', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-end-v',
					],
				],
				'default'            => 'flex-start',
				'selectors'          => [
					'{{WRAPPER}} .main-menu .navbar-nav' => 'align-items: {{VALUE}};',
				],
				'condition'          => [
					'nav_menu_flex_direction' => ['row', 'row-reverse'],
				],
				'frontend_available' => true,
			]
		);

		// Justify Content Control (Column)
		$this->add_responsive_control(
			'nav_menu_justify_content_column',
			[
				'label'              => __( 'Justify Content (C)', 'finspire' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'flex-start' => [
						'title' => __( 'Start', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-start-v',
					],
					'center' => [
						'title' => __( 'Center', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-center-v',
					],
					'flex-end' => [
						'title' => __( 'End', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-end-v',
					],
					'space-between' => [
						'title' => __( 'Space Between', 'finspire' ),
						'icon'  => 'eicon-flex eicon-justify-space-between-v',
					],
					'space-around' => [
						'title' => __( 'Space Around', 'finspire' ),
						'icon'  => 'eicon-flex eicon-justify-space-around-v',
					],
				],
				'default'            => 'flex-start',
				'selectors'          => [
					'{{WRAPPER}} .main-menu .navbar-nav' => 'justify-content: {{VALUE}};',
				],
				'condition'          => [
					'nav_menu_flex_direction' => ['column', 'column-reverse'],
				],
				'frontend_available' => true,
			]
		);

		// Align Items Control (Column)
		$this->add_responsive_control(
			'nav_menu_align_items_column',
			[
				'label'              => __( 'Align Items (C)', 'finspire' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'flex-start' => [
						'title' => __( 'Start', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-start-h',
					],
					'center' => [
						'title' => __( 'Center', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-center-h',
					],
					'flex-end' => [
						'title' => __( 'End', 'finspire' ),
						'icon'  => 'eicon-flex eicon-align-end-h',
					],
				],
				'default'            => 'flex-start',
				'selectors'          => [
					'{{WRAPPER}} .main-menu .navbar-nav' => 'align-items: {{VALUE}};',
				],
				'condition'          => [
					'nav_menu_flex_direction' => ['column', 'column-reverse'],
				],
				'frontend_available' => true,
			]
		);

		// Gap Control
		$this->add_responsive_control(
			'nav_menu_gap',
			[
				'label'              => __( 'Gap', 'finspire' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => ['px', '%', 'em'],
				'range'              => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%' => [
						'min'  => 0,
						'max'  => 100,
					],
					'em' => [
						'min'  => 0,
						'max'  => 10,
					],
				],
				'default'            => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors'          => [
					'{{WRAPPER}} .main-menu .navbar-nav' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'frontend_available' => true,
			]
		);
		
		$this->end_controls_section();
		
		/******Nav Item Style Tab Start**********/
		$this->start_controls_section(
			'navitem_style',
			[
				'label' => esc_html__('Nav Item Setting', 'finspire'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->start_controls_tabs( 'finspire_tabs_nav' );
		
			$this->start_controls_tab(
				'finspire_tab_nav_normal',
				[
					'label' => __( 'Normal', 'finspire' ),
				]
			);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'navitem_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li > a',				
					]
				);
				$this->add_responsive_control(
					'navitem_margin',
					[
						'label'              => __( 'Spacing', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px', 'em', '%', 'custom' ],
						'selectors'          => [
							'{{WRAPPER}} .main-menu .navbar-nav > li:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
						
						'frontend_available' => true,
					]
				);
				$this->add_responsive_control(
					'navitem_padding',
					[
						'label'      => __( 'Padding', 'finspire' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .main-menu .navigation > li > a' => 
								'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .main-menu .navigation > li:last-child > a' => 
								'padding-right: 0;',
						],
						'frontend_available' => true,
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'navitem_border_type',
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li > a',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'navitem_border_radius',
					[
						'label' => esc_html__('Border Radius', 'finspire'),
						'type' => Controls_Manager::DIMENSIONS,
						'separator' => 'before',
						'size_units' => ['px'],
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'navitem_title_typography',
						'label' => __('Text Typography', 'finspire'),
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li > a',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'navitem_title_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li > a' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'finspire_tab_navitem_hover',
				[
					'label' => __( 'Hover', 'finspire' ),
				]
			);
			
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'navitem_hover_bg_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li:hover > a',				
					]
				);
				$this->add_control(
					'navitem_border_hover_color',
					[
						'label' => __('Border Hover Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li:hover > a' => 'border-color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'navitem_title_hover_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li:hover > a' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			
			$this->end_controls_tab();	
			//Active Tab
			$this->start_controls_tab(
				'finspire_tab_navitem_active',
				[
					'label' => __( 'Active', 'finspire' ),
				]
			);
			
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'navitem_active_bg_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li.current-menu-ancestor > a',				
					]
				);
				$this->add_control(
					'navitem_border_active_color',
					[
						'label' => __('Border Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li.current-menu-ancestor > a' => 'border-color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'navitem_title_active_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li.current-menu-ancestor > a' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			
			$this->end_controls_tab();
		$this->end_controls_tabs();  
		
		$this->end_controls_section();
		
		/******Nav Item Style Tab Start**********/
		$this->start_controls_section(
			'subnavitem_style',
			[
				'label' => esc_html__('Sub Nav Item Setting', 'finspire'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->start_controls_tabs( 'finspire_tabs_subnavitem' );
		
			$this->start_controls_tab(
				'finspire_tab_subnavitem_normal',
				[
					'label' => __( 'Normal', 'finspire' ),
				]
			);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'subnavitem_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li a',				
					]
				);
				$this->add_responsive_control(
					'subnavitem_padding',
					[
						'label'              => __( 'Padding', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px', 'em', '%' ],
						'selectors'          => [
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						
						'frontend_available' => true,
					]
				);
				$this->add_responsive_control(
					'subnavitem_spacing',
					[
						'label'              => __( 'Spacing', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px', 'em', '%' ],
						'selectors'          => [
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						
						'frontend_available' => true,
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'subnavitem_border_type',
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li a',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'subnavitem_border_radius',
					[
						'label' => esc_html__('Border Radius', 'finspire'),
						'type' => Controls_Manager::DIMENSIONS,
						'separator' => 'before',
						'size_units' => ['px'],
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'subnavitem_title_typography',
						'label' => __('Typography', 'finspire'),
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li a',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'subnavitem_title_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li a' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'finspire_tab_navitems_hover',
				[
					'label' => __( 'Hover', 'finspire' ),
				]
			);
			
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'subnavitem_hover_bg_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li:hover a',				
					]
				);
				$this->add_control(
					'subnavitem_border_hover_color',
					[
						'label' => __('Border Hover Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li:hover a' => 'border-color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'subnavitem_title_hover_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li > ul li:hover a' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			
			$this->end_controls_tab();	
		
		$this->end_controls_tabs();  
		
		$this->end_controls_section();
		
		
		/*** zubair start *****/
		/******Nav Item Style Tab Start**********/
		$this->start_controls_section(
			'navicon_style',
			[
				'label' => esc_html__('Nav Icon Setting', 'finspire'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->start_controls_tabs( 'finspire_tabs_navicon' );
		
			$this->start_controls_tab(
				'finspire_tab_navicon_normal',
				[
					'label' => __( 'Normal', 'finspire' ),
				]
			);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'navicon_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children > a:before',				
					]
				);
				$this->add_responsive_control(
					'navicon_padding',
					[
						'label'              => __( 'Padding', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px', 'em', '%' ],
						'selectors'          => [
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children > a:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						
						'frontend_available' => true,
					]
				);
//				
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'navicon_border_type',
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children > a:before',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'navicon_border_radius',
					[
						'label' => esc_html__('Border Radius', 'finspire'),
						'type' => Controls_Manager::DIMENSIONS,
						'separator' => 'before',
						'size_units' => ['px'],
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children > a:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'navicon_title_typography',
						'label' => __('Typography', 'finspire'),
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children > a:before',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'navicon_title_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children > a:before' => 'color: {{VALUE}}',
						],				 
						'separator' => 'before',
					]
				);
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'finspire_tab_navicon_hover',
				[
					'label' => __( 'Hover', 'finspire' ),
				]
			);
			
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'navicon_hover_bg_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children:hover > a:before',				
					]
				);
				$this->add_control(
					'navicon_border_hover_color',
					[
						'label' => __('Border Hover Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children:hover > a:before' => 'border-color: {{VALUE}}',
						],					
						'separator' => 'before',
					]
				);
				$this->add_control(
					'navicon_title_hover_color',
					[
						'label' => __('Hover Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li.menu-item-has-children:hover > a:before' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'navicon_title_active_color',
					[
						'label' => __('Active Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .main-menu .navbar-nav > li.current-menu-ancestor > a:before' => 'color: {{VALUE}} !important;',
						],
						'separator' => 'before',
					]
				);
			
			$this->end_controls_tab();	
		
		/*****Zubiar end******/
		
		$this->end_controls_tabs();  
		
		$this->end_controls_section();
		
    }
	
	
	/**
	 * Render button widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$allowed_tags = wp_kses_allowed_html('post');
		$align_class = $settings[ 'nav_menu_flex_direction' ];
		
		// Return finspire_nav_menu select or not
        if(empty($settings['fetch_menu'])) {
            return;
        }

        $nav_menu = $settings['fetch_menu'];
		
		$wp_nav_menu = wp_nav_menu([
			'menu' => $nav_menu,
			'menu_class' => 'navigation clearfix navbar-nav d-flex',
			'fallback_cb' => '__return_empty_string',
			'container' => '',
			'echo' => false,
			'walker' => new \FINSPIREPLUGIN\Element\Mega_Menu_Walker(),
		]);

		
	?>

	<nav class="main-menu <?php if( $align_class == 'column' || $align_class == 'column-reverse' ) echo 'main-vertical__menu';?> <?php echo ( $settings['select_menu'] === '2' ) ? 'one-page-menu' : 'multi-page-menu'; ?>">
			<?php echo wp_kses( $wp_nav_menu, true ); ?>
	</nav>
    
    <?php 
	}
}