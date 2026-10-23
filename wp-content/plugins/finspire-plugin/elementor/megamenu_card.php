<?php
namespace FINSPIREPLUGIN\Element;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Button;
use Finspire\Elementor\Traits\Trait_Button_Two;
use Finspire\Elementor\Traits\Trait_Image;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Megamenu_Card extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_megamenu_card';
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
		return esc_html__( 'Finspire Megamenu Card', 'finspire' );
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
	use Trait_Title, Trait_Image, Trait_Button, Trait_Button_Two;
	protected function register_controls() {
		$this->start_controls_section(
			'megamenu_card',
			[
				'label' => esc_html__( 'Megamenu Card', 'finspire' ),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => __( 'Service Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		
		$this->add_control(
			'block_title',
			[
				'label'       => __( 'Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Add Your Title Here', 'finspire' ),
			]
		);

		$this->add_control(
			'icons',
			[
				'label' => esc_html__('Enter icons', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-two-lines',
					'library' => 'flaticon_finspire',
				],
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
				'placeholder' => __( 'Enter your Button Text', 'finspire' ),
				'default' => esc_html__( 'Multi Page', 'finspire' ),
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
			'icons2',
			[
				'label' => esc_html__('Enter icons', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-two-lines',
					'library' => 'flaticon_finspire',
				],
			]			
		);

		$this->add_control(
			'btn_title2',
			[
				'label'       => __( 'Button Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Button Text', 'finspire' ),
				'default' => esc_html__( 'One Page', 'finspire' ),
			]
		);

		$this->add_control(
			'link_options',
			[
				'label'   => esc_html__( 'Select link Option', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'extranals',
				'options' => array(
					'extranals' => esc_html__( 'Extranal ', 'finspire'),
					'pages' => esc_html__( 'Page ', 'finspire'),
				),
			]
		);		
		$this->add_control(
			'btn_links',
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
					'link_options' => 'extranals'
				]
			]
		);		
		$this->add_control(
			'page_selects',
			[
				'label'   => esc_html__( 'Select Page', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT2,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_options' => 'pages'
				]
			]
		);

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

		//Button Style Start *****************
        $this->start_controls_section(
            'btn_style_setting',
            [
                'label' => esc_html__( 'Button Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_button_controls();
        
        $this->end_controls_section();

		//Button Style Start *****************
        $this->start_controls_section(
            'btn_style_two_setting',
            [
                'label' => esc_html__( 'Button Style Two Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_button_two_controls();
        
        $this->end_controls_section();
		
		//Title Style Start *****************
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

		$pages = $settings['link_options'];
		$page_selects = $settings[ 'page_selects' ];
		$ext_urls = $settings[ 'btn_links' ];
		
		if( $pages == 'pages' ){
			$mount_links = get_page_link( $page_selects );
		}else{
			$mount_links = $ext_urls['url'];
			$targets = $ext_urls['is_external'] ? ' target="_blank"' : '';
			$nofollows = $ext_urls['nofollow'] ? ' rel="nofollow"' : '';
		}
		
		// block_img
		$feature_img  = $settings['image'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
		
	?>

	<div class="megamenu-card">
		<div class="image-box__mg">
			<figure class="image">
				<img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>">
			</figure>
			<div class="link-mg">

				<div class="te-btn-box">
					<a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?> class="theme-btn dark-bg te-btn">
						<div class="icon-box">
							<span class="static-icon">
								<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
									<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
								<?php } else {?>
									<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
								<?php };?>
							</span>
							<span class="overlay-icon">
								<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
									<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
								<?php } else {?>
									<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
								<?php };?>
							</span>
						</div>
						<span class="text"><?php echo wp_kses($settings['btn_title'], true); ?></span>
					</a>
				</div>

				<div class="te-btn-box style_two">
					<a href="<?php echo esc_url( $mount_links );?>" <?php if( $pages == 'extranals' ) echo esc_attr( $targets . $nofollows );?> class="theme-btn theme-bg te-btn-two">
						<div class="icon-box">
							<span class="static-icon">
								<?php if( isset( $settings['icons2']['library'] ) && 'svg' === $settings['icons2']['library'] ) {?>
									<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons2' ] ); ?>
								<?php } else {?>
									<i class="<?php echo esc_attr( $settings[ 'icons2' ][ 'value' ] );?>"></i>
								<?php };?>
							</span>
							<span class="overlay-icon">
								<?php if( isset( $settings['icons2']['library'] ) && 'svg' === $settings['icons2']['library'] ) {?>
									<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons2' ] ); ?>
								<?php } else {?>
									<i class="<?php echo esc_attr( $settings[ 'icons2' ][ 'value' ] );?>"></i>
								<?php };?>
							</span>
						</div>
						<span class="text"><?php echo wp_kses($settings['btn_title2'], true); ?></span>
					</a>
				</div>

			</div>
		</div>
		<?php if($settings['block_title']) { ?>
		<div class="lower-content__mg">
			<?php if($settings['block_title']) { ?>
			<h3 class="te-title"><?php echo wp_kses($settings['block_title'], true) ;?></h3>
			<?php } ?>
		</div>
		<?php } ?>
	</div>

     <?php 
	}
}