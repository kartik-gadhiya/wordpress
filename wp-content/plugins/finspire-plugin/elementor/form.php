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
use \Elementor\Group_Control_Text_Stroke;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Form;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Form extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_form';
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
        return esc_html__( 'Finspire Form', 'finspire' );
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
	use Trait_Form;
    protected function register_controls() {
        $this->start_controls_section(
            'form',
            [
                'label' => esc_html__( 'Form', 'finspire' ),
            ]
        );
		$this->add_control(
			'layout_control',
			[
				'label'   => esc_html__( 'Layout Style', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1' => esc_html__( 'Style One ', 'finspire'),
					'2' => esc_html__( 'Style Two ', 'finspire'),
					'3' => esc_html__( 'Style Three ', 'finspire'),
					'4' => esc_html__( 'Style Four ', 'finspire'),
				),
			]
		);
		$this->add_control(
			'form_url',
			[
				'label'       => __( 'Form Shortcode', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Form Shortcode', 'finspire' ),
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Form Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_form_controls();
        
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

	<?php if($settings['layout_control'] == '4') : ?>

	<div class="footer-style-three p-0 m-0">
		<div class="newsletter-widget te-form p-0 m-0">
			<?php echo do_shortcode($settings['form_url']);?>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '3') : ?>

	<div class="main-footer p-0 m-0">
		<div class="links-widget p-0 m-0">
			<div class="subscribe-box te-form p-0 m-0">
				<?php echo do_shortcode($settings['form_url']);?>
			</div>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '2') : ?>

	<div class="team-details p-0 m-0">
		<div class="contact-box te-form p-0 m-0">
			<?php echo do_shortcode($settings['form_url']);?>
		</div>
	</div>

	<?php else: ?>

	<div class="contact-form te-form">
		<?php echo do_shortcode($settings['form_url']);?>
	</div>
    
    <?php endif;
	}
}