<?php
namespace Finspire\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

trait Trait_Title {

    public function register_title_controls() {

        // Color
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Color', 'finspire' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .te-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
		
		// Hover Color
        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'finspire' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-title:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .te-title a:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __( 'Typography', 'finspire' ),
                'selector' => '{{WRAPPER}} .te-title',
            ]
        );
    }
}
