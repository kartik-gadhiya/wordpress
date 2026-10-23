<?php
namespace Finspire\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

trait Trait_Background{

    public function register_background_controls() {

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_bgtype',
				'label' => __( 'Background', 'finspire' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => 
					'{{WRAPPER}} .te-bg',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bg_border_type',
				'selector' => 
					'{{WRAPPER}} .te-bg',				
				'separator' => 'before',
			]
		);
		$this->add_control(
			'bg_border_radius',
			[
				'label' => esc_html__('Border Radius', 'finspire'),
				'type' => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .te-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
    }
}
