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
use \Elementor\Group_Control_Image_Size;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Background;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Button;
use Finspire\Elementor\Traits\Trait_Image;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Guide_Box extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_guide_box';
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
        return esc_html__( 'Finspire Guide Box', 'finspire' );
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
        return 'eicon-icon-box';
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
	use Trait_Background, Trait_Title, Trait_Image, Trait_Button;
    protected function register_controls() {
        $this->start_controls_section(
            'guide_box',
            [
                'label' => esc_html__( 'Guide Box', 'finspire' ),
            ]
        );
		$this->add_control(
			'block_img',
			[
				'label' => __( 'Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'count',
			[
				'label'       => __( 'Count Value', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Count Value', 'finspire' ),
				'default' => esc_html__( '2.6k+', 'finspire' ),
			]
		);
		$this->add_control(
			'heading',
			[
				'label'       => __( 'Heading', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Heading', 'finspire' ),
				'default' => esc_html__( 'Guided businesses in different markets.', 'finspire' ),
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
		
		//Image Style Start ***************
        $this->start_controls_section(
            'image_style_setting',
            [
                'label' => esc_html__( 'Image Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
        $this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Heading Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_title_controls();
        
        $this->end_controls_section();
		
		//Button Style Start ****************
        $this->start_controls_section(
            'button_style_setting',
            [
                'label' => esc_html__( 'Count Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_button_controls();
        
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
		
		// block_img
		$feature_img  = $settings['block_img'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
		
	?>

	<div class="reliable-section p-0 m-0">
		<div class="guided-box">
			<div class="bg-layer te-img" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
			<?php if($settings['count'] || $settings['heading']) { ?>
			<div class="content-box te-bg">
				<?php if($settings['count']) { ?><span class="te-btn"><?php echo wp_kses( $settings[ 'count' ], true );?></span><?php };?>
				<?php if($settings['heading']) { ?><h5 class="te-title"><?php echo wp_kses( $settings[ 'heading' ], true );?></h5><?php };?>
			</div>
			<?php };?>
		</div>
	</div>

    <?php 
    }
}