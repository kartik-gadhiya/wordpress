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
use Finspire\Elementor\Traits\Trait_Icons;
use Finspire\Elementor\Traits\Trait_Form;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Button;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Image;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Sidebar_Icon extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_sidebar_icon';
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
        return esc_html__( 'Finspire Sidebar Icon', 'finspire' );
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
	use Trait_Background, Trait_Icons, Trait_Title, Trait_Text, Trait_Image, Trait_Form, Trait_Button;
    protected function register_controls() {
        $this->start_controls_section(
            'sidebar_icon',
            [
                'label' => esc_html__( 'Sidebar Icon', 'finspire' ),
            ]
        );
		$this->add_control(
			'icons',
			[
				'label' => esc_html__('Enter Sidebar icons', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-mozy',
					'library' => 'solid',
				],
			]			
		);
		$this->add_control(
			'block_img',
			[
				'label' => __( 'Logo Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
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
				'default' => esc_html__( 'Add your Form Shortcode Here', 'finspire' ),
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
				'default' => esc_html__( 'Add your Heading Here', 'finspire' ),
			]
		);
		$this->add_control(
			'btn_title',
			[
				'label'       => __( 'Button Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Button Title Here', 'finspire' ),
				'default' => esc_html__( 'Appointment', 'finspire' ),
			]
		);	
		$this->add_control(
			'link_option',
			[
				'label'   => esc_html__( 'Select link Option', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'extranal',
				'options' => array(
					'extranal' => esc_html__( 'Extranal ', 'finspire'),
					'page' => esc_html__( 'Page ', 'finspire'),
				),
			]
		);		
		$this->add_control(
			'btn_link',
			[
				'label' => __( 'External Link', 'finspire' ),
				'type' => Controls_Manager::URL,
				'label_block' => true, 
				'placeholder' => __( 'https://your-link.com', 'finspire' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition'   => [
					'link_option' => 'extranal'
				]
			]
		);		
		$this->add_control(
			'page_select',
			[
				'label'   => esc_html__( 'Select Page', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT2,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_option' => 'page'
				]
			]
		);
		$this->add_control(
			'text',
			[
				'label'       => __( 'Copyright Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Copyright Text', 'finspire' ),
				'default' => esc_html__( 'All Rights Reserved.', 'finspire' ),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Sidebar Icons Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_icons_controls();
        
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
                'label' => esc_html__( 'Logo Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
        $this->end_controls_section();
		
		//form Style Start *****************
        $this->start_controls_section(
            'form_style_setting',
            [
                'label' => esc_html__( 'Form Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_form_controls();
        
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
                'label' => esc_html__( 'Button Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_button_controls();
        
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
		
		$page = $settings['link_option'];
		$page_select = $settings[ 'page_select' ];
		$ext_url = $settings[ 'btn_link' ];
		
		if( $page == 'page' ){
			$mount_link = get_page_link( $page_select );
		}else{
			$mount_link = $ext_url['url'];
			$target = $ext_url['is_external'] ? ' target="_blank"' : '';
			$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
		}
		
	?>

	<div class="menu-right-content p-0 m-0">
		<div class="sidebar-toggler te-icon">
			<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
				<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
			<?php } else {?>
				<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
			<?php };?>
		</div>
	</div>
	<div id="sidebar-popup" class="sidebar-popup te-bg">
		<div class="popup-inner">
			<div class="close-popup">X</div>
			<figure class="logo-box">
				<a href="<?php echo esc_url( home_url( '/' ) );?>">
					<img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>" />
				</a>
			</figure>
			<?php if($settings['form_url']) { ?>
			<div class="form-inner te-form">
				<?php echo do_shortcode($settings['form_url']);?>
			</div>
			<?php };?>
			<?php if($settings['heading'] || $settings['btn_title']) { ?>
			<div class="inner-box">
				<div class="icon-box"><i class="flaticon-alarm"></i></div>
				<div class="light-icon"><i class="flaticon-alarm"></i></div>
				<?php if($settings['heading']) { ?><h3 class="te-title"><?php echo wp_kses( $settings[ 'heading' ], true );?></h3><?php };?>
				<?php if($settings['btn_title']) { ?>
				<a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?> class="theme-btn white-bg te-btn"><span><?php echo wp_kses( $settings[ 'btn_title' ], true );?></span></a>
				<?php };?>
			</div>
			<?php };?>
			<?php if($settings['text']) { ?>
			<div class="copyright">
				<p class="te-text"><?php echo wp_kses( $settings[ 'text' ], true );?></p>
			</div>
			<?php };?>
		</div>
	</div>

    <?php 
    }
}