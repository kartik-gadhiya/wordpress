<?php
namespace Finspire\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

trait Trait_SubTitle {

    public function register_subtitle_controls() {

        // Color
        $this->add_control(
            'subtitle_color',
            [
                'label'     => esc_html__( 'Color', 'finspire' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .te-subtitle' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle_typography',
                'label'    => __( 'Typography', 'finspire' ),
                'selector' => '{{WRAPPER}} .te-subtitle',
            ]
        );
    }
}
