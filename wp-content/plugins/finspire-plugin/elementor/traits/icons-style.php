<?php
namespace Finspire\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

trait Trait_Icons {

    public function register_icons_controls() {

        $this->start_controls_tabs( 'tabs_icons' );

        /**
         * ======================
         * NORMAL STATE CONTROLS
         * ======================
         */
        $this->start_controls_tab(
            'tab_icons_normal',
            [
                'label' => __( 'Normal', 'finspire' ),
            ]
        );

        // Font Size
        $this->add_responsive_control(
            'icons_size',
            [
                'label' => __( 'Font Size', 'finspire' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 200 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .te-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .te-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Color
        $this->add_control(
            'icons_color',
            [
                'label' => __( 'Color', 'finspire' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .te-icon svg' => 'fill: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        // Background
        $this->add_control(
            'icons_bg_color',
            [
                'label' => __( 'Background Color', 'finspire' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Height
        $this->add_responsive_control(
            'icons_height',
            [
                'label' => __( 'Height', 'finspire' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'custom' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 200 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .te-icon' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Width
        $this->add_responsive_control(
            'icons_width',
            [
                'label' => __( 'Width', 'finspire' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 200 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .te-icon' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icons_border',
                'selector' => '{{WRAPPER}} .te-icon',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'icons_border_radius',
            [
                'label' => __( 'Border Radius', 'finspire' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .te-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding
        $this->add_responsive_control(
            'icons_padding',
            [
                'label' => __( 'Padding', 'finspire' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .te-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icons_box_shadow',
                'selector' => '{{WRAPPER}} .te-icon',
            ]
        );

        // Rotation
        $this->add_control(
            'icons_rotation',
            [
                'label' => __( 'Rotation (deg)', 'finspire' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'range' => [
                    'deg' => [ 'min' => 0, 'max' => 360 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .te-icon' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );

        $this->end_controls_tab();


        /**
         * ======================
         * HOVER STATE CONTROLS
         * ======================
         */
        $this->start_controls_tab(
            'tab_icons_hover',
            [
                'label' => __( 'Hover', 'finspire' ),
            ]
        );

        // Hover color
        $this->add_control(
            'icons_hover_color',
            [
                'label' => __( 'Color', 'finspire' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .te-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // Hover background
        $this->add_control(
            'icons_hover_bg_color',
            [
                'label' => __( 'Background', 'finspire' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-icon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Hover border color
        $this->add_control(
            'icons_hover_border_color',
            [
                'label' => __( 'Border Color', 'finspire' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-icon:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Hover box shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icons_hover_box_shadow',
                'selector' => '{{WRAPPER}} .te-icon:hover',
            ]
        );

        // Transition duration
        $this->add_control(
            'icons_hover_transition',
            [
                'label' => __( 'Transition Duration', 'finspire' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .te-icon' => 'transition-duration: {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
    }
}
