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
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Css_Filter;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Background;
use Finspire\Elementor\Traits\Trait_Icons;
use Finspire\Elementor\Traits\Trait_Image;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Nav_Toggler extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_nav_toggler';
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
        return esc_html__( 'Finspire Nav Toggler', 'finspire' );
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
        return 'eicon-apps';
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
    
	private function get_available_mobile_menus() {

		$mobile_menus = wp_get_nav_menus();

		$options = [];
		
		if ( ! empty( $mobile_menus ) ) {
			foreach ( $mobile_menus as $menu ) {
				$options[ $menu->slug ] = $menu->name;
			}
		}

		return $options;
	}
	use Trait_Background, Trait_Icons, Trait_Image;
	protected function register_controls() {
        $this->start_controls_section(
            'nav_toggler',
            [
                'label' => esc_html__( 'Nav Toggler', 'finspire' ),
				'tab' => Controls_Manager::TAB_CONTENT
            ]
        );	
		
		$this->add_control(
			'open_icon',
			[
				'label' => esc_html__('Choose Nav Open Icon', 'buildnox'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-bars',
					'library' => 'solid',
				],
			]			
		);
		
		$this->add_control(
			'close_icon',
			[
				'label' => esc_html__('Choose Nav Close Icon', 'buildnox'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-times',
					'library' => 'solid',
				],
			]			
		);
		
		$mobile_menus = $this->get_available_mobile_menus();
		
		$this->add_control(
            'fetch_mobile_menu',
            [
                'label'        => __( 'Select menu', 'finspire' ),
                'type'         => Controls_Manager::SELECT,
                'options'      => $mobile_menus,
                'default'      => !empty( $mobile_menus ) ? array_keys( $mobile_menus )[0] : '',
                'save_default' => true,
                'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'finspire' ), admin_url( 'nav-menus.php' ) ),
            ]
        );
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'mobile_logo',
			[
				'label' => esc_html__( 'Mobile Logo', 'finspire' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);
		$this->add_control(
			'mobile_logo_image',
			[
				'label' => esc_html__( 'Choose Logo Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
            'menu_transition',
            [
                'label' => esc_html__( 'Transition', 'finspire' ),
				'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
		
		$this->add_control(
			'trans',
			[
				'label'   => esc_html__( 'Choose Transition', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'right' => esc_html__( 'Right', 'finspire' ),
					'left' => esc_html__( 'Left', 'finspire' ),
				],
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
		
		
		//Icon Style Start ***************
        $this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Nav Toggler Style Setting', 'finspire' ),
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
                'label' => esc_html__( 'Logo Style Setting', 'finspire' ),
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
		$feature_img = $settings[ 'mobile_logo_image' ];
		if( $feature_img[ 'id' ] ){
			$mount_fimg = wp_get_attachment_url( $feature_img[ 'id' ] );
		} else {
			$mount_fimg = $feature_img[ 'url' ];
		}
		$open_icon = $settings[ 'open_icon' ];
		$close_icon = $settings[ 'close_icon' ];
		$trans = $settings[ 'trans' ];
		if( $trans === 'left' ){
			$effect = 'left';
		}else {
			$effect = 'right';
		}
		
		// Return finspire_nav_menu select or not
        if(empty($settings['fetch_mobile_menu'])) {
            return;
        }
		$mobile_nav_menu = $settings['fetch_mobile_menu'];
		
		$wp_nav_menu = wp_nav_menu( [
            'menu'        => $mobile_nav_menu,
			'menu_class'  => 'navigation',
			'fallback_cb' => '__return_empty_string',
			'container'   => '',
            'echo'        => false,
			'walker' => new \FINSPIREPLUGIN\Element\Mega_Menu_Walker(),
        ]);
		
	?>

	<div class="mobile-nav-toggler">
		
		<div class="icon-box__toggler-open has-ele-toggler__style te-icon">
			<?php if( ! empty( $open_icon['library'] ) && 'svg' === $open_icon['library'] ):?>
				<?php \Elementor\Icons_Manager::render_icon( $open_icon, [ 'aria-hidden' => 'true' ] );?>
			<?php elseif( ! empty( $open_icon['value'] ) ):?>
				<i class="<?php echo esc_attr( $open_icon[ 'value' ] )?>"></i>
			<?php endif;?>
		</div>
		
	</div>

	<div class="mobile-menu <?php echo esc_attr( $effect );?>">
		<div class="menu-backdrop"></div>
		<div class="close-btn">
			<div class="icon-box__toggler-close has-ele-toggler__style">
				<?php if( ! empty( $close_icon['library'] ) && 'svg' === $close_icon['library'] ):?>
					<?php \Elementor\Icons_Manager::render_icon( $close_icon, [ 'aria-hidden' => 'true' ] );?>
				<?php elseif( ! empty( $close_icon['value'] ) ):?>
					<i class="<?php echo esc_attr( $close_icon[ 'value' ] )?>"></i>
				<?php endif;?>
			</div>
		</div>

		<nav class="menu-box te-bg">
			<div class="nav-logo nav-logo__box">
				<a href="<?php echo esc_url( home_url( '/' ) );?>" class="d-flex align-items-center">
					<img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' );?>">
				</a>
			</div>
			<div class="menu-outer">
				<?php echo wp_kses( $wp_nav_menu, true ); ?>
			</div>
		</nav>
	</div>
    
    <?php
    }
}