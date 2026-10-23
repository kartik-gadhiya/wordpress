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
use Finspire\Elementor\Traits\Trait_Icons;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Image;
use Finspire\Elementor\Traits\Trait_Button;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class About_Tabs extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_about_tabs';
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
        return esc_html__( 'Finspire About Tabs', 'finspire' );
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
	use Trait_Icons, Trait_Title, Trait_Text, Trait_Image, Trait_Button;
    protected function register_controls() {
        $this->start_controls_section(
            'about_tabs',
            [
                'label' => esc_html__( 'About Tabs', 'finspire' ),
            ]
        );
			
		$repeater = new Repeater();
		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Tab Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Tab Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'icons',
			[
				'label' => esc_html__('Enter icons', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-target',
					'library' => 'solid',
				],
			]			
		);
		$repeater->add_control(
			'banner_image',
			[
				'label' => __( 'Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'text',
			[
				'label'       => __( 'Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
			]
		);
		$repeater->add_control(
			'btn_title',
			[
				'label'       => __( 'Button Title', 'finspire' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Button Title', 'finspire' ),
			]
		);
		$repeater->add_control(
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
		$repeater->add_control(
			'link',
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
		$repeater->add_control(
			'page_select',
			[
				'label'   => esc_html__( 'Select Page', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_option' => 'page'
				]
			]
		);	
		
		$this->add_control(
			'slide_v2',
			[
				'label'                 => __('Add Tab Item', 'finspire'),
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'title' => esc_html__( 'Tab Title', 'finspire' ),
						'text' => esc_html__( 'Trouble that are bound to ensue and equal that shrinking from toil and pain.', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Tab Title', 'finspire' ),
						'text' => esc_html__( 'Trouble that are bound to ensue and equal that shrinking from toil and pain.', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Tab Title', 'finspire' ),
						'text' => esc_html__( 'Trouble that are bound to ensue and equal that shrinking from toil and pain.', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
				],
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
		
		
		//Feature List Style Start ***************
        $this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Icon Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_icons_controls();
        
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

	<div class="about-down p-0 m-0">
		<div class="tabs-box p_relative">
			<ul class="tab-btns tab-buttons clearfix centred">
				<?php foreach($settings['slide_v2'] as $key => $item): 
					$tab_id = 'ab-tab-' . $key; // unique ID
				?>
				<li class="tab-btn te-title te-icon <?php if($key == 0) echo 'active-btn';?>" data-tab="#<?php echo esc_attr($tab_id); ?>"><?php echo wp_kses($item['title'], true); ?>
					<?php if( isset( $item['icons']['library'] ) && 'svg' === $item['icons']['library'] ) {?>
						<?php \Elementor\Icons_Manager::render_icon( $item[ 'icons' ] ); ?>
					<?php } else {?>
						<i class="<?php echo esc_attr( $item[ 'icons' ][ 'value' ] );?>"></i>
					<?php };?>
				</li>
				<?php endforeach; ?>
			</ul>
			<div class="tabs-content">
				<?php foreach($settings['slide_v2'] as $key => $item): 
					$tab_id = 'ab-tab-' . $key; // same ID as button
					$page = $item['link_option'];
					$page_select = $item['page_select'];
					$ext_url = $item['link'];

					if( $page == 'page' ){
						$mount_link = get_page_link($page_select);
					} else {
						$mount_link = $ext_url['url'];
						$target = $ext_url['is_external'] ? ' target="_blank"' : '';
						$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
					}
		
					// block_img
					$feature_img  = $item['banner_image'];
					if( !empty($feature_img['id']) ){
						$mount_fimg = wp_get_attachment_url($feature_img['id']);
					} else {
						$mount_fimg = $feature_img['url'];
					}
				?>
				<div class="tab <?php if($key == 0) echo 'active-tab';?>" id="<?php echo esc_attr($tab_id); ?>">
					<div class="row clearfix">
						<div class="col-lg-3 col-md-6 col-sm-12 image-column">
							<div class="image-box">
								<figure class="image"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
							</div>
						</div>
						<?php if($item['text'] || $item['btn_title']) { ?>
						<div class="col-lg-3 col-md-6 col-sm-12 offset-lg-6 text-column">
							<div class="text-box">
								<?php if($item['text']) { ?><p class="te-text"><?php echo wp_kses($item['text'], true); ?></p><?php } ?>
								<?php if($item['btn_title']) { ?>
								<div class="common-link"><a class="te-btn" href="<?php echo esc_url($mount_link); ?>" <?php if($page == 'extranal') echo esc_attr($target); ?> <?php if($page == 'extranal') echo esc_attr($nofollow); ?>><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span><?php echo wp_kses($item['btn_title'], true); ?></span></a></div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

    <?php 
    }
}