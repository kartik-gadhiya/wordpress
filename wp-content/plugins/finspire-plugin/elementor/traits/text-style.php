<?php
namespace Finspire\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

trait Trait_Text {

    public function register_text_controls() {

        // Color
        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__( 'Color', 'finspire' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-text' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'label'    => __( 'Typography', 'finspire' ),
                'selector' => '{{WRAPPER}} .te-text',
            ]
        );
		
    }
}
