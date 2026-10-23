<?php
namespace Finspire\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

trait Trait_Form {

    public function register_form_controls() {

        $this->start_controls_tabs( 'finspire_tabs_form' );
		
			$this->start_controls_tab(
				'finspire_tab_form_normal',
				[
					'label' => __( 'Normal', 'finspire' ),
				]
			);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'form_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .te-form input,
							 {{WRAPPER}} .te-form textarea,
							 {{WRAPPER}} .te-form select',				
					]
				);
				$this->add_responsive_control(
					'form_width_size',
					[
						'label' => __( 'Width', 'finspire' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', 'em', '%', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 500,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .te-form input' => 'width: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .te-form textarea' => 'width: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .te-form select' => 'width: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_responsive_control(
					'form_height_size',
					[
						'label' => __( 'Height', 'finspire' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', 'em', '%', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 500,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .te-form input' => 'height: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .te-form textarea' => 'height: {{SIZE}}{{UNIT}};',
							'{{WRAPPER}} .te-form select' => 'height: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_responsive_control(
					'form_spacing',
					[
						'label'              => __( 'Spacing', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px', 'em', '%' ],
						'selectors'          => [
							'{{WRAPPER}} .te-form input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .te-form textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .te-form select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						
						'frontend_available' => true,
					]
				);
				$this->add_responsive_control(
					'form_padding',
					[
						'label'              => __( 'Padding', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px', 'em', '%' ],
						'selectors'          => [
							'{{WRAPPER}} .te-form input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .te-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .te-form select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						
						'frontend_available' => true,
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'form_border_type',
						'selector' => 
							'{{WRAPPER}} .te-form input,
							 {{WRAPPER}} .te-form textarea,
							 {{WRAPPER}} .te-form select',				
						'separator' => 'before',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'form_border_box_shadow',
						'selector' => 
							'{{WRAPPER}} .te-form input,
							 {{WRAPPER}} .te-form textarea,
							 {{WRAPPER}} .te-form select',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_border_radius',
					[
						'label' => esc_html__('Border Radius', 'finspire'),
						'type' => Controls_Manager::DIMENSIONS,
						'separator' => 'before',
						'size_units' => ['px'],
						'selectors' => [
							'{{WRAPPER}} .te-form input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .te-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .te-form select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'form_title_typography',
						'label' => __('Text Typography', 'finspire'),
						'selector' => 
							'{{WRAPPER}} .te-form input,
							 {{WRAPPER}} .te-form textarea,
							 {{WRAPPER}} .te-form select',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_title_color',
					[
						'label' => __('Text Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form input' => 'color: {{VALUE}}',
							'{{WRAPPER}} .te-form textarea' => 'color: {{VALUE}}',
							'{{WRAPPER}} .te-form select' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'form_tab_form_btn_hover',
				[
					'label' => __( 'Hover', 'finspire' ),
				]
			);
			
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'form_hover_bg_bgtype',
						'label' => __( 'Hover Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .te-form input:hover,
							 {{WRAPPER}} .te-form textarea:hover,
							 {{WRAPPER}} .te-form select:hover',				
					]
				);
				$this->add_control(
					'form_border_hover_color',
					[
						'label' => __('Border Hover Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form input:hover' => 'border-color: {{VALUE}}',
							'{{WRAPPER}} .te-form textarea:hover' => 'border-color: {{VALUE}}',
							'{{WRAPPER}} .te-form select:hover' => 'border-color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_title_hover_color',
					[
						'label' => __('Text Hover Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form input:hover' => 'color: {{VALUE}}',
							'{{WRAPPER}} .te-form textarea:hover' => 'color: {{VALUE}}',
							'{{WRAPPER}} .te-form select:hover' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			
			$this->end_controls_tab();
			
		$this->end_controls_tabs(); 
		
		$this->add_control(
			'form_button_styling_heading',
			[
				'label' => __( 'Form Button Styling', 'finspire' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->start_controls_tabs( 'finspire_tabs_form_btn' );

			$this->start_controls_tab(
				'finspire_tab_form_btn_normal',
				[
					'label' => __( 'Normal', 'finspire' ),
				]
			);

		
                $this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'form_btn_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .te-form button',
					]
				);
				$this->add_responsive_control(
					'form_btn_width_size',
					[
						'label' => __( 'Width', 'finspire' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .te-form button' => 'width: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'form_btn_min_width_size',
					[
						'label' => __( 'Min-Width', 'finspire' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .te-form button' => 'min-width: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'form_btn_height_size',
					[
						'label' => __( 'Height', 'finspire' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .te-form button' => 'height: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'form_btn_padding',
					[
						'label'              => __( 'Padding', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px'],
						'selectors'          => [
							'{{WRAPPER}} .te-form button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
						],

						'frontend_available' => true,
					]
				);
				$this->add_responsive_control(
					'form_btn_margin',
					[
						'label'              => __( 'Margin', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px'],
						'selectors'          => [
							'{{WRAPPER}} .te-form button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
						],

						'frontend_available' => true,
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'form_btn_border_type',
						'selector' => 
							'{{WRAPPER}} .te-form button',				
						'separator' => 'before',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'border_box_shadow',
						'selector' => 
							'{{WRAPPER}} .te-form button',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_btn_border_radius',
					[
						'label' => esc_html__('Border Radius', 'finspire'),
						'type' => Controls_Manager::DIMENSIONS,
						'separator' => 'before',
						'size_units' => [ 'px', '%'],
						'selectors' => [
							'{{WRAPPER}} .te-form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'form_btn_title_typography',
						'label' => __('Typography', 'finspire'),
						'selector' => 
							'{{WRAPPER}} .te-form button',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_btn_title_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form button' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_btn_icon_color',
					[
						'label' => __('Icon Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form button i' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_btn_icon_bg_color',
					[
						'label' => __('Icon Background Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form button i' => 'background-color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_responsive_control(
					'icons_size',
					[
						'label' => __( 'Icon Size', 'finspire' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .te-form button i' => 'font-size: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'icon_width_size',
					[
						'label' => __( 'Icon Width', 'finspire' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .te-form button i' => 'width: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'icon_height_size',
					[
						'label' => __( 'Icon Height', 'finspire' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .te-form button i' => 'height: {{SIZE}}{{UNIT}};'
						],
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'finspire_tab_form_btn_hover',
					[
						'label' => __( 'Hover', 'finspire' ),
					]
				);
                $this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'form_btn_bgtype_prefix',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .te-form button:hover',
					]
				);
				$this->add_control(
					'form_btn_border_hover_color',
					[
						'label' => __('Border Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form button:hover' => 'border-color: {{VALUE}}'
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_btn_title_hover_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form button:hover' => 'color: {{VALUE}};',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_btn_icon_hover_color',
					[
						'label' => __('Icon Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form button:hover i' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'form_btn_icon_bg_hover_color',
					[
						'label' => __('Icon Background Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-form button:hover i' => 'background-color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();
		
    }
}
