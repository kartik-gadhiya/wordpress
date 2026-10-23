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
use Finspire\Elementor\Traits\Trait_Button;
use Finspire\Elementor\Traits\Trait_Image;
use Finspire\Elementor\Traits\Trait_Icons;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Team_Card extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_team_card';
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
		return esc_html__( 'Finspire Team Card', 'finspire' );
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
	use Trait_Icons, Trait_Title, Trait_Image, Trait_Button;
	protected function register_controls() {
		$this->start_controls_section(
			'team_card',
			[
				'label' => esc_html__( 'Team Card', 'finspire' ),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => __( 'Team Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'block_title',
			[
				'label'       => __( 'Member Name', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Name', 'finspire' ),
				'default' => esc_html__( 'John Doe', 'finspire' ),
			]
		);		
		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Designation', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Designation', 'finspire' ),
				'default' => esc_html__( 'Trip Planner', 'finspire' ),
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
		
		$repeater = new Repeater();		
		$repeater->add_control(
			'icons',
			[
				'label' => esc_html__('Enter The icons', 'immigratie'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'icon-12',
					'library' => 'solid',
				],
			]			
		);
		$repeater->add_control(
			'image_link',
			[
				'label' => __( 'Icon Link', 'finspire' ),
				'type' => Controls_Manager::URL,
				'label_block' => true, 				
				'placeholder' => __( 'https://your-link.com', 'finspire' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'sponsers',
			[
				'label'                 => __('Add Social Icon', 'finspire'),
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
			]
		);
		$this->end_controls_section();
		
		//Title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Designation Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_title_controls();
        
        $this->end_controls_section();
		
		//Text Style Start *****************
        $this->start_controls_section(
            'text_style_setting',
            [
                'label' => esc_html__( 'Member Name Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_button_controls();
        
        $this->end_controls_section();
		
		//Banner Image Style Start ***************
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
		
		//Social Icon Style Start ***************
        $this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Icons Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_icons_controls();
        
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
		
		// block_img
		$feature_img  = $settings['image'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
		
	?>

	<div class="team-block-one centred">
		<div class="link"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i></a></div>
		<div class="image-box">
			<figure class="image"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
			<ul class="social-links">
				<?php foreach($settings['sponsers'] as $key => $item): ?>
				<li>
					<a class="te-icon" href="<?php echo esc_url($item['image_link']['url']); ?>">
					<?php if( isset( $item['icons']['library'] ) && 'svg' === $item['icons']['library'] ) {?>
					<?php \Elementor\Icons_Manager::render_icon( $item[ 'icons' ] ); ?>
					<?php } else {?>
						<i class="<?php echo esc_attr( $item[ 'icons' ][ 'value' ] );?>"></i>
					<?php };?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php if($settings['subtitle'] || $settings['block_title']) { ?>
		<div class="lower-content">
			<?php if($settings['subtitle']) { ?><span class="designation te-title"><?php echo wp_kses($settings['subtitle'], true) ;?></span><?php } ?>
			<?php if($settings['block_title']) { ?>
			<h5><a class="te-btn" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><?php echo wp_kses($settings['block_title'], true) ;?></a></h5>
			<?php } ?>
		</div>
		<?php } ?>
	</div>

     <?php 
	}
}