<?php
namespace Finspire\Elementor\Traits;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

trait Trait_Button_Two {

    public function register_button_two_controls() {

        $this->start_controls_tabs( 'finspire_tabs_btn' );

			$this->start_controls_tab(
				'finspire_tab_btn_two_normal',
				[
					'label' => __( 'Normal', 'finspire' ),
				]
			);

		
                $this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'btn_two_bgtype',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .te-btn-two',
					]
				);
				$this->add_responsive_control(
					'btn_two_width_size',
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
							'{{WRAPPER}} .te-btn-two' => 'width: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'btn_two_min_width_size',
					[
						'label' => __( 'Min Width', 'finspire' ),
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
							'{{WRAPPER}} .te-btn-two' => 'min-width: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'btn_two_height_size',
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
							'{{WRAPPER}} .te-btn-two' => 'height: {{SIZE}}{{UNIT}};'
						],
					]
				);
				$this->add_responsive_control(
					'btn_two_padding',
					[
						'label'              => __( 'Padding', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px'],
						'selectors'          => [
							'{{WRAPPER}} .te-btn-two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
						],

						'frontend_available' => true,
					]
				);
				$this->add_responsive_control(
					'btn_two_margin',
					[
						'label'              => __( 'Margin', 'finspire' ),
						'type'               => Controls_Manager::DIMENSIONS,
						'size_units'         => [ 'px'],
						'selectors'          => [
							'{{WRAPPER}} .te-btn-two' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
						],

						'frontend_available' => true,
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'btn_two_border_type',
						'selector' => 
							'{{WRAPPER}} .te-btn-two',				
						'separator' => 'before',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'border_box_shadow',
						'selector' => 
							'{{WRAPPER}} .te-btn-two',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_two_border_radius',
					[
						'label' => esc_html__('Border Radius', 'finspire'),
						'type' => Controls_Manager::DIMENSIONS,
						'separator' => 'before',
						'size_units' => [ 'px', '%'],
						'selectors' => [
							'{{WRAPPER}} .te-btn-two' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'btn_two_title_typography',
						'label' => __('Typography', 'finspire'),
						'selector' => 
							'{{WRAPPER}} .te-btn-two',				
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_two_title_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn-two' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_two_icon_color',
					[
						'label' => __('Icon Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn-two i' => 'color: {{VALUE}}',
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
							'{{WRAPPER}} .te-btn-two i' => 'font-size: {{SIZE}}{{UNIT}};'
						],
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'finspire_tab_btn_two_two_hover',
					[
						'label' => __( 'Hover', 'finspire' ),
					]
				);
                $this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'btn_two_bgtype_prefix',
						'label' => __( 'Background', 'finspire' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => 
							'{{WRAPPER}} .te-btn-two:hover',
					]
				);
				$this->add_control(
					'btn_two_border_hover_color',
					[
						'label' => __('Border Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn-two:hover' => 'border-color: {{VALUE}}'
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_two_title_hover_color',
					[
						'label' => __('Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn-two:hover' => 'color: {{VALUE}};',
						],
						'separator' => 'before',
					]
				);
				$this->add_control(
					'btn_two_icon_hover_color',
					[
						'label' => __('Icon Color', 'finspire'),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .te-btn-two:hover i' => 'color: {{VALUE}}',
						],
						'separator' => 'before',
					]
				);
			$this->end_controls_tab();
		$this->end_controls_tabs();

    }
}
