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
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Links_Menu extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_links_menu';
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
        return esc_html__( 'Finspire Links Menu', 'finspire' );
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
        return 'eicon-button';
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
	use Trait_Title;
    protected function register_controls() {
        $this->start_controls_section(
            'links_menu',
            [
                'label' => esc_html__( 'Links Menu', 'finspire' ),
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
		$repeater = new Repeater();
		$repeater->add_control(
			'btn_title',
			[
				'label'       => __( 'Menu Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Menu Title Here', 'finspire' ),
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
		$repeater->add_control(
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
			'sponsers',
			[
				'label'                 => __('Add Menu Item', 'amcare'),
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ btn_title }}}',
				'default' => [
					[
						'btn_title' => esc_html__( 'Menu Item', 'finspire' ),
					],
					[
						'btn_title' => esc_html__( 'Menu Item', 'finspire' ),
					],
					[
						'btn_title' => esc_html__( 'Menu Item', 'finspire' ),
					],
					[
						'btn_title' => esc_html__( 'Menu Item', 'finspire' ),
					],
					[
						'btn_title' => esc_html__( 'Menu Item', 'finspire' ),
					],
				],
			]
		);
		$this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Menu Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_title_controls();
        
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

	<?php if($settings['layout_control'] == '4') :?>

	<div class="footer-style-four p-0 m-0">
		<div class="links-widget p-0 m-0">
			<ul class="links-list">
				<?php foreach($settings['sponsers'] as $key => $item): 
					$page = $item['link_option'];
					$page_select = $item[ 'page_select' ];
					$ext_url = $item[ 'btn_link' ];

					if( $page == 'page' ){
						$mount_link = get_page_link( $page_select );
					}else{
						$mount_link = $ext_url['url'];
						$target = $ext_url['is_external'] ? ' target="_blank"' : '';
						$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
					}

				?>
				<li><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-right-arrow"></i><span><?php echo wp_kses($item['btn_title'], true); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '3') :?>

	<div class="footer-style-two p-0 m-0">
		<div class="links-widget p-0 m-0">
			<ul class="links-list clearfix">
				<?php foreach($settings['sponsers'] as $key => $item): 
					$page = $item['link_option'];
					$page_select = $item[ 'page_select' ];
					$ext_url = $item[ 'btn_link' ];

					if( $page == 'page' ){
						$mount_link = get_page_link( $page_select );
					}else{
						$mount_link = $ext_url['url'];
						$target = $ext_url['is_external'] ? ' target="_blank"' : '';
						$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
					}

				?>
				<li><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-right-arrow"></i><?php echo wp_kses($item['btn_title'], true); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '2') :?>

	<div class="footer-bottom p-0 m-0">
		<div class="bottom-inner p-0 m-0">
			<ul class="footer-nav">
				<?php foreach($settings['sponsers'] as $key => $item): 
					$page = $item['link_option'];
					$page_select = $item[ 'page_select' ];
					$ext_url = $item[ 'btn_link' ];

					if( $page == 'page' ){
						$mount_link = get_page_link( $page_select );
					}else{
						$mount_link = $ext_url['url'];
						$target = $ext_url['is_external'] ? ' target="_blank"' : '';
						$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
					}

				?>
				<li><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><?php echo wp_kses($item['btn_title'], true); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<?php else : ?>

	<div class="main-footer p-0 m-0">
		<div class="links-widget p-0 m-0">
			<ul class="links-list clearfix">
				<?php foreach($settings['sponsers'] as $key => $item): 
					$page = $item['link_option'];
					$page_select = $item[ 'page_select' ];
					$ext_url = $item[ 'btn_link' ];

					if( $page == 'page' ){
						$mount_link = get_page_link( $page_select );
					}else{
						$mount_link = $ext_url['url'];
						$target = $ext_url['is_external'] ? ' target="_blank"' : '';
						$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
					}

				?>
				<li><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-right-arrow"></i><span><?php echo wp_kses($item['btn_title'], true); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<?php endif; ?>
    <?php
    }
}