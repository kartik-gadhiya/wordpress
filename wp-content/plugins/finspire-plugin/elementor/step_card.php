<?php
namespace FINSPIREPLUGIN\Element;

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
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Image;
use Finspire\Elementor\Traits\Trait_SubTitle;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Step_Card extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_step_card';
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
		return esc_html__( 'Finspire Step Card', 'finspire' );
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
		return 'eicon-tools';
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
	use Trait_Title, Trait_Text, Trait_Image, Trait_SubTitle;
	protected function register_controls() {
		$this->start_controls_section(
			'step_card',
			[
				'label' => esc_html__( 'Step Card', 'finspire' ),
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
				),
			]
		);
		$this->add_control(
			'block_img',
			[
				'label' => __( 'Shape Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'block_img2',
			[
				'label' => __( 'Step Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'year',
			[
				'label'       => __( 'Year', 'finspire' ),
				'condition' => [ 'layout_control' => ['2'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Year', 'finspire' ),
				'default' => esc_html__( '2025', 'finspire' ),
			]
		);
		$this->add_control(
			'count',
			[
				'label'       => __( 'Count', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Count', 'finspire' ),
				'default' => esc_html__( '1', 'finspire' ),
			]
		);
		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Sub Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Sub Title', 'finspire' ),
				'default' => esc_html__( 'Steps to Stronger Strategy', 'finspire' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Enter your Title', 'finspire' ),
			]
		);
		$this->add_control(
			'text',
			[
				'label'       => __( 'Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
				'default' => esc_html__( 'Enter your Text', 'finspire' ),
			]
		);
		
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
		
		//Image Style Start ***************
        $this->start_controls_section(
            'image_style_setting',
            [
                'label' => esc_html__( 'Image Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
        $this->end_controls_section();
		
		$this->start_controls_section(
            'image2_style_setting',
            [
                'label' => esc_html__( 'Subtitle/Year Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_subtitle_controls();
        
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
		
		// block_img
		$feature_img  = $settings['block_img'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
		
		// block_img 2
		$feature_img2  = $settings['block_img2'];
		if( !empty($feature_img2['id']) ){
			$mount_fimg2 = wp_get_attachment_url($feature_img2['id']);
		} else {
			$mount_fimg2 = $feature_img2['url'];
		}
		
	?>

	<?php if($settings['layout_control'] == '2') : ?>

	<div class="history-page-section p-0 m-0">
		<div class="process-block-one">
			<?php if($settings['block_img']['id']) { ?>
			<div class="shape" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
			<?php } ?>
			<div class="decore"></div>
			<div class="inner-box">
				<div class="bg-layer te-img" style="background-image: url(<?php echo esc_url( $mount_fimg2 );?>);"></div>
				<?php if($settings['year']) { ?>
				<h2 class="te-subtitle"><?php echo wp_kses($settings['year'], true) ;?></h2>
				<?php } ?>
			</div>
			<?php if($settings['text'] || $settings['title']) { ?>
			<div class="lower-box">
				<?php if($settings['title']) { ?><h3 class="te-title"><?php echo wp_kses($settings['title'], true) ;?></h3><?php } ?>
				<?php if($settings['text']) { ?><p class="te-text"><?php echo wp_kses($settings['text'], true) ;?></p><?php } ?>
			</div>
			<?php } ?>
		</div>
	</div>

	<?php else: ?>

	<div class="process-block-one">
		<?php if($settings['block_img']['id']) { ?>
		<div class="shape" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
		<?php } ?>
		<div class="decore"></div>
		<div class="inner-box">
			<div class="bg-layer te-img" style="background-image: url(<?php echo esc_url( $mount_fimg2 );?>);"></div>
			<?php if($settings['count'] || $settings['subtitle']) { ?>
			<h2><?php echo wp_kses($settings['count'], true) ;?> <span class="te-subtitle"><?php echo wp_kses($settings['subtitle'], true) ;?></span></h2>
			<?php } ?>
		</div>
		<?php if($settings['text'] || $settings['title']) { ?>
		<div class="lower-box">
			<?php if($settings['title']) { ?><h3 class="te-title"><?php echo wp_kses($settings['title'], true) ;?></h3><?php } ?>
			<?php if($settings['text']) { ?><p class="te-text"><?php echo wp_kses($settings['text'], true) ;?></p><?php } ?>
		</div>
		<?php } ?>
	</div>

     <?php endif;
	}
}