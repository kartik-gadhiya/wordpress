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
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Image;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Circle_Text extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_circle_text';
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
        return esc_html__( 'Finspire Circle Text', 'finspire' );
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
	use Trait_Title, Trait_Image;
    protected function register_controls() {
        $this->start_controls_section(
            'circle_text',
            [
                'label' => esc_html__( 'Circle Text', 'finspire' ),
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
				),
			]
		);
		$this->add_control(
			'block_img2',
			[
				'label' => esc_html__('Image', 'finspire'),
				'condition' => [ 'layout_control' => ['1', '2'], ],
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Circle Text', 'finspire' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Circle Text', 'finspire' ),
				'default' => esc_html__( 'Add Your Text Here', 'finspire' ),
			]
		);
		$this->add_control(
			'years',
			[
				'label' => esc_html__( 'Years', 'finspire' ),
				'condition' => [ 'layout_control' => ['2', '3'], ],
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Years', 'finspire' ),
				'default' => esc_html__( '14+', 'finspire' ),
			]
		);
		
		$this->end_controls_section();	
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Circle Text Style Setting', 'finspire' ),
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
                'label' => esc_html__( 'Image Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '2'], ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
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

	<?php if($settings['layout_control'] == '3') : ?>

	<div class="about-style-two p-0 m-0">
		<div class="left-content p-0 m-0">
			<div class="rotate-text mb_180">
				<?php if($settings['years']) { ?><h2><?php echo wp_kses($settings['years'], true) ;?></h2><?php };?>
				<?php if($settings['title']) { ?><span id="curve_text_3" class="curve-text te-title"> <?php echo wp_kses($settings['title'], true) ;?></span><?php };?>
			</div>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '2') : 
		// block_img 2
		$feature_img2  = $settings['block_img2'];
		if( !empty($feature_img2['id']) ){
			$mount_fimg2 = wp_get_attachment_url($feature_img2['id']);
		} else {
			$mount_fimg2 = $feature_img2['url'];
		}
	?>

	<div class="about-section p-0 m-0">
		<div class="image-box p-0 m-0">
			<figure class="image"><img class="te-img" src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
			<?php if($settings['years'] || $settings['title']) { ?>
			<div class="rotate-text">
				<?php if($settings['years']) { ?><h2><?php echo wp_kses($settings['years'], true) ;?></h2><?php };?>
				<?php if($settings['title']) { ?><span id="curve_text_2" class="curve-text te-title"> <?php echo wp_kses($settings['title'], true) ;?></span><?php };?>
			</div>
			<?php };?>
		</div>
	</div>

	<?php else: 
		// block_img 2
		$feature_img2  = $settings['block_img2'];
		if( !empty($feature_img2['id']) ){
			$mount_fimg2 = wp_get_attachment_url($feature_img2['id']);
		} else {
			$mount_fimg2 = $feature_img2['url'];
		}
	?>

	<div class="banner-section p-0 m-0">
		<div class="content-box p-0 m-0">
			<div class="lower-box p-0 m-0">
				<ul class="left-column">
					<li><span class="shape"></span></li>
					<li><span class="shape"></span></li>
					<li class="rotate-text">
						<div class="award"><img class="te-img" src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></div>
						<div class="rotate-text-inner">
							<span id="curve_text_1" class="curve-text te-title"><?php echo wp_kses($settings['title'], true) ;?></span>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<?php endif; ?>
    <?php 
    }
}