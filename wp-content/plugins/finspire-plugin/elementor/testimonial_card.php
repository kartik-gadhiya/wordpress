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
class Testimonial_Card extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_testimonial_card';
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
		return esc_html__( 'Finspire Testimonial Card', 'finspire' );
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
			'testimonial_card',
			[
				'label' => esc_html__( 'Testimonial Card', 'finspire' ),
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
			'text',
			[
				'label'       => __( 'Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
				'default' => esc_html__( 'Enter your Text Here.', 'finspire' ),
			]
		);
		$this->add_control(
			'block_img',
			[
				'label' => __( 'Author Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'block_img2',
			[
				'label' => __( 'Logo Image', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'rating',
			[
				'label'       => __( 'Rating', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Rating', 'finspire' ),
				'default' => esc_html__( '4.9', 'finspire' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => __( 'Author Name', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Author Name', 'finspire' ),
				'default' => esc_html__( 'Lucas Benjamin', 'finspire' ),
			]
		);
		$this->add_control(
			'designation',
			[
				'label'       => __( 'Designation', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your designation', 'finspire' ),
				'default' => esc_html__( 'Senior Manager, Future Tech', 'finspire' ),
			]
		);
		$this->add_control(
			'r_title',
			[
				'label'       => __( 'Result Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Result Title', 'finspire' ),
				'default' => esc_html__( 'Result:', 'finspire' ),
			]
		);
		$this->add_control(
			'result',
			[
				'label'       => __( 'Result', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Result', 'finspire' ),
				'default' => esc_html__( '+22% Annual Revenue', 'finspire' ),
			]
		);
		
		$this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Author Style Setting', 'finspire' ),
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
                'label' => esc_html__( 'Author Image Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
        $this->end_controls_section();
		
		$this->start_controls_section(
            'subtitle_style_setting',
            [
                'label' => esc_html__( 'Rating Style', 'finspire' ),
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
		
	?>

	<?php if($settings['layout_control'] == '2') : ?>

	<div class="testimonial-style-two p-0 m-0">
		<div class="testimonial-block">
			<div class="testimonial-block-one">
				<div class="icon-box"><i class="flaticon-quotation-mark"></i></div>
				<?php if($settings['text']) { ?><p class="te-text"><?php echo wp_kses($settings['text'], true) ;?></p><?php } ?>
				<div class="author-box">
					<div class="thumb-box">
						<figure class="testimonial-thumb"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
					</div>
					<?php if($settings['rating'] || $settings['title'] || $settings['designation']) { ?>
					<div class="inner">
						<?php if($settings['rating']) { ?><div class="rating"><span class="te-subtitle"><?php echo wp_kses($settings['rating'], true) ;?></span><i class="flaticon-star"></i></div><?php } ?>
						<?php if($settings['title']) { ?><h5 class="te-title"><?php echo wp_kses($settings['title'], true) ;?></h5><?php } ?>
						<?php if($settings['designation']) { ?><span class="designation te-text"><?php echo wp_kses($settings['designation'], true) ;?></span><?php } ?>
					</div>
					<?php } ?>
				</div>
			</div>
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

	<div class="testimonial-block-one">
		<div class="icon-box"><i class="flaticon-quotation-mark"></i></div>
		<?php if($settings['text']) { ?><p class="te-text"><?php echo wp_kses($settings['text'], true) ;?></p><?php } ?>
		<div class="author-box">
			<div class="thumb-box">
				<figure class="testimonial-thumb"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
				<figure class="logo-box"><img src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
			</div>
			<?php if($settings['rating'] || $settings['title'] || $settings['designation']) { ?>
			<div class="inner">
				<?php if($settings['rating']) { ?><div class="rating"><span class="te-subtitle"><?php echo wp_kses($settings['rating'], true) ;?></span><i class="flaticon-star"></i></div><?php } ?>
				<?php if($settings['title']) { ?><h5 class="te-title"><?php echo wp_kses($settings['title'], true) ;?></h5><?php } ?>
				<?php if($settings['designation']) { ?><span class="designation te-text"><?php echo wp_kses($settings['designation'], true) ;?></span><?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php if($settings['r_title'] || $settings['result']) { ?>
		<div class="lower-text te-text"><span><?php echo wp_kses($settings['r_title'], true) ;?></span> <?php echo wp_kses($settings['result'], true) ;?></div>
		<?php } ?>
	</div>

     <?php endif;
	}
}