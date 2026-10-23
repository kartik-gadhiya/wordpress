<?php
namespace Finspire\Elementor\Traits;

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
use \Elementor\Group_Control_Css_Filter;

trait Trait_Image2 {

    public function register_image2_controls() {

        $this->add_responsive_control(
			'width2',
			[
				'label' => esc_html__( 'Width', 'finspire' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .te-img2' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space2',
			[
				'label' => esc_html__( 'Max Width', 'finspire' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .te-img2' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height2',
			[
				'label' => esc_html__( 'Height', 'finspire' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vh' ],

				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .te-img2' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-fit2',
			[
				'label' => esc_html__( 'Object Fit', 'finspire' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'finspire' ),
					'fill' => esc_html__( 'Fill', 'finspire' ),
					'cover' => esc_html__( 'Cover', 'finspire' ),
					'contain' => esc_html__( 'Contain', 'finspire' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .te-img2' => 'object-fit: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'object_position2',
			[
				'label' => esc_html__( 'Image Position', 'finspire' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					''              => esc_html__( 'Default', 'finspire' ),
					'center center' => esc_html__( 'Center Center', 'finspire' ),
					'center top'    => esc_html__( 'Center Top', 'finspire' ),
					'center bottom' => esc_html__( 'Center Bottom', 'finspire' ),
					'left center'   => esc_html__( 'Left Center', 'finspire' ),
					'left top'      => esc_html__( 'Left Top', 'finspire' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'finspire' ),
					'right center'  => esc_html__( 'Right Center', 'finspire' ),
					'right top'     => esc_html__( 'Right Top', 'finspire' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'finspire' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .te-img2' => 'object-position: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_style2',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'image_effects2' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'finspire' ),
			]
		);

		$this->add_control(
			'opacity2',
			[
				'label' => esc_html__( 'Opacity', 'finspire' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .te-img2' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters2',
				'selector' => '{{WRAPPER}} .te-img2',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'finspire' ),
			]
		);

		$this->add_control(
			'opacity_hover2',
			[
				'label' => esc_html__( 'Opacity', 'finspire' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .te-img2' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover2',
				'selector' => '{{WRAPPER}}:hover .te-img2',
			]
		);

		$this->add_control(
			'background_hover_transition2',
			[
				'label' => esc_html__( 'Transition Duration', 'finspire' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .te-img2' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'hover_animation2',
			[
				'label' => esc_html__( 'Hover Animation', 'finspire' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border2',
				'selector' => '{{WRAPPER}} .te-img2',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius2',
			[
				'label' => esc_html__( 'Border Radius', 'finspire' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .te-img2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow2',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .te-img2',
			]
		);
    }
}
