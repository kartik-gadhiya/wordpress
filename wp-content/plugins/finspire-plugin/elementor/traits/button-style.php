<?php
namespace Finspire\Elementor\Traits;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

trait Trait_Button {

    public function register_button_controls() {

        $this->start_controls_tabs( 'finspire_tabs_btn' );

			$this->start_controls_tab(
				'finspire_tab_btn_normal',
				[
					'label' => __( 'Normal', 'finspire' ),
				]
			);

		
                $this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'btn_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .te-btn',
					]
				);
				$this->add_responsive_control(
					'btn_width_size',
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
							'{{WRAPPER}} .te-btn' => 'width: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'btn_min_width_size',
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
							'{{WRAPPER}} .te-btn' => 'min-width: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'btn_height_size',
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
							'{{WRAPPER}} .te-btn' => 'height: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'btn_padding',
					[
						'label'              => __( 'Padding', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px'],
						'selectors'          => [
							'{{WRAPPER}} .te-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
						],

						'frontend_available' => true,
					]
				);
				$this->add_responsive_control(
					'btn_margin',
					[
						'label'              => __( 'Margin', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px'],
						'selectors'          => [
							'{{WRAPPER}} .te-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
						],

						'frontend_available' => true,
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'btn_border_type',
						'selector' => 
							'{{WRAPPER}} .te-btn',				
						'separator' => 'before',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'border_box_shadow',
						'selector' => 
							'{{WRAPPER}} .te-btn',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_border_radius',
					[
						'label' => esc_html__('Border Radius', 'finspire'),
						'type' => Controls_Manager::DIMENSIONS,
						'separator' => 'before',
						'size_units' => [ 'px', '%'],
						'selectors' => [
							'{{WRAPPER}} .te-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'btn_title_typography',
						'label' => __('Typography', 'finspire'),
						'selector' => 
							'{{WRAPPER}} .te-btn',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_title_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_icon_color',
					[
						'label' => __('Icon Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn i' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_icon_bg_color',
					[
						'label' => __('Icon Background Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn i' => 'background-color: {{VALUE}}',
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
							'{{WRAPPER}} .te-btn i' => 'font-size: {{SIZE}}{{UNIT}};'
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
							'{{WRAPPER}} .te-btn i' => 'width: {{SIZE}}{{UNIT}};'
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
							'{{WRAPPER}} .te-btn i' => 'height: {{SIZE}}{{UNIT}};'
						],
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'finspire_tab_btn_hover',
					[
						'label' => __( 'Hover', 'finspire' ),
					]
				);
                $this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'btn_bgtype_prefix',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .te-btn:hover',
					]
				);
				$this->add_control(
					'btn_border_hover_color',
					[
						'label' => __('Border Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn:hover' => 'border-color: {{VALUE}}'
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_title_hover_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn:hover' => 'color: {{VALUE}};',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_icon_hover_color',
					[
						'label' => __('Icon Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn:hover i' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_icon_bg_hover_color',
					[
						'label' => __('Icon Background Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn:hover i' => 'background-color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();

    }
}
