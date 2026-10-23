<?php namespace FINSPIREPLUGIN\Element;

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
use \Elementor\Group_Control_Text_Stroke;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Background;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Faqs extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_faqs';
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
		return esc_html__( 'Finspire Faqs', 'finspire' );
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
		return 'eicon-accordion';
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
	use Trait_Background, Trait_Title, Trait_Text;
	protected function register_controls() {
		$this->start_controls_section(
			'faqs',
			[
				'label' => esc_html__( 'Faqs', 'finspire' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'title2',
			[
				'label'       => __( 'FAQs Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your FAQs Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'text2',
			[
				'label'       => __( 'FAQs Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your FAQs Text', 'finspire' ),
			]
		);
		$this->add_control(
			'slide_v2',
			[
				'label'                 => __('Add Accordian Item', 'finspire'),
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ title2 }}}',
				'default' => [
					[
						'title2' => esc_html__( 'Looking for the<br>best employees? We<br>have them.', 'finspire' ),
						'text2' => esc_html__( 'Trouble that are bound to ensue and equal that shrinking.', 'finspire' ),
					],
					[
						'title2' => esc_html__( 'Find the right<br> employer for you<br> to thrive.', 'finspire' ),
						'text2' => esc_html__( 'Some advantage from it? But who has any right to find.', 'finspire' ),
					],
					[
						'title2' => esc_html__( 'End the search<br> for a new job, We<br> are hiring.', 'finspire' ),
						'text2' => esc_html__( 'Some advantage from it? But who has any right to find.', 'finspire' ),
					],
				],
			]
		);
		
		$this->end_controls_section();
		
		//Background Style Start *****************
        $this->start_controls_section(
            'background_style_setting',
            [
                'label' => esc_html__( 'Background Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_background_controls();
        
        $this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Title Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_title_controls();
        
        $this->end_controls_section();
		
		
		
		//text Style Start ****************
        $this->start_controls_section(
            'text_style_setting',
            [
                'label' => esc_html__( 'Text Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_text_controls();
        
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
		
	 ?>

	<ul class="accordion-box accordion-style-one">
		<?php $jk = 1;
			foreach($settings['slide_v2'] as $key => $item): 
		?>
		<li class="accordion block te-bg <?php if($jk == 1) echo 'active-block';?>">
			<?php if($item['title2']) { ?>
			<div class="acc-btn <?php if($jk == 1) echo 'active';?>">
				<div class="icon-box"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-8.png" alt="<?php bloginfo( 'name' ); ?>"></div>
				<h5 class="te-title"><?php echo wp_kses( $item['title2'], true ); ?></h5>
			</div>
			<?php } ?>
			<?php if($item['text2']) { ?>
			<div class="acc-content <?php if($jk == 1) echo 'current';?>">
				<div class="text">
					<p class="te-text"><?php echo wp_kses( $item['text2'], true ); ?></p>
				</div>
			</div>
			<?php } ?>
		</li>
		<?php $jk++; endforeach; ?>
	</ul>

	<?php 
    }
}
		